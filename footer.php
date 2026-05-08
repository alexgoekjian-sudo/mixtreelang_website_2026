<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage SMARTHEAD
 * @since SMARTHEAD 1.0
 */
?>
<?php

						// Widgets area inside page content
						smarthead_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					smarthead_create_widgets_area('widgets_below_page');

					$smarthead_body_style = smarthead_get_theme_option('body_style');
					if ($smarthead_body_style != 'fullscreen') {
						?> </div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$smarthead_footer_style = smarthead_get_theme_option("footer_style");
			if (strpos($smarthead_footer_style, 'footer-custom-')===0) $smarthead_footer_style = 'footer-custom';
			get_template_part( "templates/{$smarthead_footer_style}");
			?>
		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (smarthead_is_on(smarthead_get_theme_option('debug_mode')) && file_exists(smarthead_get_file_dir('images/makeup.jpg'))) { ?>
		<img src="<?php echo esc_url(smarthead_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>
	
<!-- sticky sidebar -->
<script type="text/javascript">	
function sticky_relocate() {
    var window_top = jQuery(window).scrollTop();
	if( jQuery(".edited-end-fixed").length ){
		var footer_top = jQuery(".edited-end-fixed").offset().top;
	}

	if( jQuery('.edited-content-middle').length ){
		var div_top = jQuery('.edited-content-middle').offset().top;
	}
    
    
    var div_height = jQuery(".column-right-mix").height();
    
    var padding = 20; 
    
    if (window_top + div_height > footer_top - padding)
        jQuery('.column-right-mix').css({top: (window_top + div_height - footer_top + padding) * -1})
    else if (window_top > div_top) {
        jQuery('.column-right-mix').addClass('stick');
        jQuery('.column-right-mix').css({top: 0})
    } else {
        jQuery('.column-right-mix').removeClass('stick');
    }
}

jQuery(function () {
    jQuery(window).scroll(sticky_relocate);
    sticky_relocate();
});
</script>

<?php if(is_home() || is_front_page()){
?>
<script type="text/javascript">
	var image = new Image();
	image.src = "https://youtube.com/favicon.ico";
	if (image.height > 0) {
		console.log('berhasil');
	    // The user can access youtube
	} else {
		
		jQuery('.youtube-error').css({'display':'block'});
		jQuery('.vc_row.wpb_row.vc_row-fluid.homepage-slider.vc_row-has-fill.vc_row-no-padding.vc_video-bg-container').css({'height':'0'});
		// console.log('error');
	    // The user can't access youtube
	}
	jQuery(".contacts_logo").after("<a target='_blank' href='https://g.page/mixtree-languages?share' style='color:#ffa401;text-decoration:underline;'>View Map</a>");
	
</script>
<?php } ?>
	<!-- -->

</body>
</html>