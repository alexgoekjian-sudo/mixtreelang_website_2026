<#
.SYNOPSIS
  Build the Astro site and deploy it to a Cloud86-hosted subdomain via scp.

.DESCRIPTION
  Two targets:
    - staging  -> dev.mixtreelang.nl  (sets MTL_STAGING=1 so robots.txt blocks indexing)
    - prod     -> httpdocs            (production)

  Why scp + tar instead of rsync/sftp:
    Cloud86 chrootsh + CageFS blocks the SFTP subsystem and breaks rsync over ssh
    in non-interactive shells. Plain `scp -O` (legacy SCP protocol) works because
    it uses the SSH exec channel.

.EXAMPLE
  ./deploy.ps1 staging
  ./deploy.ps1 prod
  ./deploy.ps1 staging -SkipBuild   # re-upload current dist
#>
[CmdletBinding()]
param(
  [Parameter(Position = 0)]
  [ValidateSet('staging', 'prod')]
  [string]$Target = 'staging',

  [switch]$SkipBuild,
  [switch]$SkipLinkCheck
)

$ErrorActionPreference = 'Stop'

# ---- Config -----------------------------------------------------------------
$Host_       = 'mixtreelang.nl'
$User        = 'xrwugyjy'
$RemoteRoots = @{
  staging = 'dev.mixtreelang.nl'
  prod    = 'httpdocs'   # adjust if production docroot differs
}
$RemoteRoot = $RemoteRoots[$Target]
$SiteDir    = Join-Path $PSScriptRoot 'site'
$DistDir    = Join-Path $SiteDir 'dist'
$TarFile    = Join-Path $env:TEMP "mtl_dist_$(Get-Date -Format yyyyMMdd_HHmmss).tar.gz"

Write-Host "==> Target:    $Target -> ${User}@${Host_}:${RemoteRoot}/" -ForegroundColor Cyan
Write-Host "==> Site dir:  $SiteDir" -ForegroundColor Cyan

# ---- 1. Build ---------------------------------------------------------------
if (-not $SkipBuild) {
  Push-Location $SiteDir
  try {
    if ($Target -eq 'staging') {
      Write-Host "==> Building (MTL_STAGING=1)..." -ForegroundColor Cyan
      $env:MTL_STAGING = '1'
    } else {
      Write-Host "==> Building (production)..." -ForegroundColor Cyan
      Remove-Item env:MTL_STAGING -ErrorAction SilentlyContinue
    }
    npm run build
    if ($LASTEXITCODE -ne 0) { throw "npm run build failed" }

    if (-not $SkipLinkCheck) {
      Write-Host "==> Verifying links..." -ForegroundColor Cyan
      npm run links:check
      if ($LASTEXITCODE -ne 0) { throw "npm run links:check failed" }
    }
  } finally {
    Remove-Item env:MTL_STAGING -ErrorAction SilentlyContinue
    Pop-Location
  }
} else {
  Write-Host "==> Skipping build (using existing dist/)" -ForegroundColor Yellow
}

if (-not (Test-Path $DistDir)) { throw "dist/ not found at $DistDir" }

# ---- 2. Tar dist/ -----------------------------------------------------------
Write-Host "==> Packaging dist/ -> $TarFile" -ForegroundColor Cyan
# Use Windows 10+ built-in bsdtar (works with .tar.gz). -C so paths are relative.
tar -czf $TarFile -C $DistDir .
if ($LASTEXITCODE -ne 0) { throw "tar failed" }
$tarSize = [math]::Round((Get-Item $TarFile).Length / 1MB, 2)
Write-Host "    -> $tarSize MB" -ForegroundColor DarkGray

# ---- 3. Upload via scp ------------------------------------------------------
Write-Host "==> Uploading via scp (will prompt for password)..." -ForegroundColor Cyan
$remoteTar = "_deploy_upload.tar.gz"
scp -O $TarFile "${User}@${Host_}:$remoteTar"
if ($LASTEXITCODE -ne 0) { throw "scp upload failed" }

# ---- 4. Extract on server ---------------------------------------------------
Write-Host "==> Extracting on server (will prompt for password)..." -ForegroundColor Cyan
# Use a staging dir + atomic swap to minimize downtime.
$remoteCmd = @"
set -e
mkdir -p '$RemoteRoot'
TMPDIR=`$(mktemp -d "$RemoteRoot/.deploy_XXXXXX")
tar -xzf '$remoteTar' -C "`$TMPDIR"
# Move new files into place; --delete-equivalent semantics via rsync if available, else cp -a then prune
# Simpler: rsync local copy from TMPDIR to RemoteRoot with --delete (rsync DOES work in same-host shell).
rsync -a --delete --exclude='.cagefs' --exclude='.cl.selector' --exclude='cgi-bin' "`$TMPDIR/" "$RemoteRoot/"
rm -rf "`$TMPDIR" '$remoteTar'
echo DEPLOY_OK
"@
ssh "${User}@${Host_}" $remoteCmd
if ($LASTEXITCODE -ne 0) { throw "remote extract failed" }

# ---- 5. Cleanup -------------------------------------------------------------
Remove-Item $TarFile -Force -ErrorAction SilentlyContinue

$url = if ($Target -eq 'staging') { 'https://dev.mixtreelang.nl/' } else { 'https://mixtreelang.nl/' }
Write-Host ""
Write-Host "==> Done. Visit $url" -ForegroundColor Green
