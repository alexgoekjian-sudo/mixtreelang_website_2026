<?php
/**
 * MixTree Languages — universal form handler.
 *
 * Replaces Contact Form 7 + CF7 to Webhook + Redirection for CF7.
 *
 * Field names mirror the legacy CF7 form so existing integrations / CRM
 * column mappings keep working:
 *   first-name, last-name, email, phone, question
 *   utm_source, utm_medium, utm_campaign, utm_term, utm_content
 *   traffic_type, landing_page
 *
 * Spam: honeypot field `website` (must be empty). reCAPTCHA can be added later.
 *
 * On success:
 *   - emails info@mixtreelang.nl
 *   - POSTs JSON to the configured webhook (CRM)
 *   - 302 redirects to /thank-you/
 */

declare(strict_types=1);

const TO_EMAIL       = 'info@mixtreelang.nl';
const FROM_EMAIL     = 'no-reply@mixtreelang.nl';
const WEBHOOK_URL    = 'https://mixtreelangdb.nl/webhooks/contact-form';
const ALLOWED_HOSTS  = ['mixtreelang.nl', 'www.mixtreelang.nl', 'staging.mixtreelang.nl'];
const RATE_LIMIT_DIR = __DIR__ . '/.rate';
const RATE_LIMIT_WINDOW = 60;
const RATE_LIMIT_MAX    = 5;

function fail(int $code, string $msg): never {
    http_response_code($code);
    header('Content-Type: text/plain; charset=utf-8');
    echo $msg;
    exit;
}
function clean(string $v): string {
    return trim(filter_var($v, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));
}
function check_origin(): void {
    $ref = parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_HOST) ?? '';
    if (!in_array($ref, ALLOWED_HOSTS, true)) fail(403, 'Forbidden origin');
}
function check_rate(): void {
    if (!is_dir(RATE_LIMIT_DIR)) @mkdir(RATE_LIMIT_DIR, 0700, true);
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0';
    $key = RATE_LIMIT_DIR . '/' . preg_replace('/[^a-f0-9:.]/i', '', $ip);
    $now = time();
    $hits = [];
    if (is_file($key)) {
        $hits = array_filter(
            explode("\n", trim((string)file_get_contents($key))),
            static fn($t) => $t !== '' && ((int)$t) > $now - RATE_LIMIT_WINDOW
        );
    }
    if (count($hits) >= RATE_LIMIT_MAX) fail(429, 'Too many requests');
    $hits[] = (string)$now;
    @file_put_contents($key, implode("\n", $hits), LOCK_EX);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail(405, 'Method not allowed');
check_origin();
check_rate();

// Honeypot — silently accept
if (!empty($_POST['website'] ?? '')) {
    header('Location: /thank-you/');
    exit;
}

// Form router (default: contact)
$form = clean((string)($_POST['form'] ?? 'contact'));
if (!in_array($form, ['contact', 'newsletter', 'enrolment'], true)) {
    fail(400, 'Unknown form');
}

// Common fields (CF7-compatible names)
$first    = clean((string)($_POST['first-name'] ?? ''));
$last     = clean((string)($_POST['last-name']  ?? ''));
$email    = clean((string)($_POST['email']      ?? ''));
$phone    = clean((string)($_POST['phone']      ?? ''));
$question = clean((string)($_POST['question']   ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) fail(400, 'Invalid email');
if ($form !== 'newsletter' && ($first === '' || $last === '')) fail(400, 'Missing name');

// Tracking metadata (forwarded to CRM)
$utm = [
    'utm_source'   => clean((string)($_POST['utm_source']   ?? '')),
    'utm_medium'   => clean((string)($_POST['utm_medium']   ?? '')),
    'utm_campaign' => clean((string)($_POST['utm_campaign'] ?? '')),
    'utm_term'     => clean((string)($_POST['utm_term']     ?? '')),
    'utm_content'  => clean((string)($_POST['utm_content']  ?? '')),
    'traffic_type' => clean((string)($_POST['traffic_type'] ?? '')),
    'landing_page' => clean((string)($_POST['landing_page'] ?? '')),
];

$pageUrl  = $_SERVER['HTTP_REFERER'] ?? '';
$remoteIp = $_SERVER['REMOTE_ADDR']   ?? '';

// ---- Email (matches legacy CF7 mail body) ----
$subject = "MixTree contact: $first $last";
$body = implode("\n", [
    "From: $first $last <$email>",
    "Phone: $phone",
    '',
    'Message:',
    $question,
    '',
    "Form is located in this url: $pageUrl",
    "Remote IP: $remoteIp",
    '',
    '-- Tracking --',
    "utm_source:   {$utm['utm_source']}",
    "utm_medium:   {$utm['utm_medium']}",
    "utm_campaign: {$utm['utm_campaign']}",
    "utm_term:     {$utm['utm_term']}",
    "utm_content:  {$utm['utm_content']}",
    "traffic_type: {$utm['traffic_type']}",
    "landing_page: {$utm['landing_page']}",
]);
$headers = [
    'From: MixTree Website <' . FROM_EMAIL . '>',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . PHP_VERSION,
    'Content-Type: text/plain; charset=UTF-8',
];
$mailOk = @mail(TO_EMAIL, $subject, $body, implode("\r\n", $headers));

// ---- Webhook (CRM) ----
$payload = array_merge([
    'form'        => $form,
    'first_name'  => $first,
    'last_name'   => $last,
    'email'       => $email,
    'phone'       => $phone,
    'question'    => $question,
    'page_url'    => $pageUrl,
    'remote_ip'   => $remoteIp,
    'received_at' => gmdate('c'),
], $utm);

$ch = curl_init(WEBHOOK_URL);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 6,
    CURLOPT_CONNECTTIMEOUT => 3,
]);
@curl_exec($ch);
$webhookCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// If both the email and the webhook fail, surface an error so the user retries.
if (!$mailOk && ($webhookCode < 200 || $webhookCode >= 300)) {
    fail(500, 'Submission failed — please email info@mixtreelang.nl');
}

header('Location: /thank-you/');
