<?php
/**
 *
 * SmartHead child theme functions and definitions
 *
 * @package SmartHead
 * @author  AncoraThemes
 * @license GNU General Public License
 *
 * @link http://smarthead.ancorathemes.com/
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */


function smarthead_child_scripts() {
    wp_enqueue_style( 'smarthead-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'smarthead_child_scripts' );

function force_hide_breadcrumbs() {
    echo '<style>.sc_layouts_title_breadcrumbs { display: none !important; }</style>';
}

/* Modify the read more link on the_excerpt() */

function et_excerpt_length($length) {
    return 220;
}
add_filter('excerpt_length', 'et_excerpt_length');

/* Add a link  to the end of our excerpt contained in a div for styling purposes and to break to a new line on the page.*/

function et_excerpt_more($more) {
    global $post;
    return '<div class="view-full-post"><a href="'. get_permalink($post->ID) . '" class="view-full-post-btn">View Full Post</a></div>;';
}
add_filter('excerpt_more', 'et_excerpt_more');

function extensive_english_date( $atts ) {
    return get_field("intensive_english_course_start_date",219);
}
add_shortcode( 'extensive_english_date_shortcode', 'extensive_english_date');

function extensive_english_dates( $atts ) {
    return get_field("intensive_english_course_start_dates",219);
}
add_shortcode( 'extensive_english_dates_shortcode', 'extensive_english_dates');

function summer_intensive_english_date( $atts ) {
    return get_field("summer_intensive_english_course_start_date",219);
}
add_shortcode( 'summer_intensive_english_date_shortcode', 'summer_intensive_english_date');

function summer_intensive_english_dates( $atts ) {
    return get_field("summer_intensive_english_course_start_dates",219);
}
add_shortcode( 'summer_intensive_english_dates_shortcode', 'summer_intensive_english_dates');

function evening_english_date( $atts ) {
    return get_field("evening_course_start_date",219);
}
add_shortcode( 'evening_english_date_shortcode', 'evening_english_date');

function evening_english_dates_a( $atts ) {
    return get_field("evening_course_start_dates_a",219);
}
add_shortcode( 'evening_english_dates_a_shortcode', 'evening_english_dates_a');

function evening_online_english_date( $atts ) {
    return get_field("evening_online_course_start_date",219);
}
add_shortcode( 'evening_online_english_date_shortcode', 'evening_online_english_date');

function evening_online_english_dates( $atts ) {
    return get_field("evening_online_course_start_dates",219);
}
add_shortcode( 'evening_online_english_dates_shortcode', 'evening_online_english_dates');


function business_english_date( $atts ) {
    return get_field("business_english_course_start_date",219);
}
add_shortcode( 'business_english_date_shortcode', 'business_english_date');

function business_english_dates( $atts ) {
    return get_field("business_english_course_start_dates",219);
}
add_shortcode( 'business_english_dates_shortcode', 'business_english_dates');

function advanced_english_course_date( $atts ) {
    return get_field("advanced_english_course_date",219);
}
add_shortcode( 'advanced_english_course_date_shortcode', 'advanced_english_course_date');

function advanced_english_course_dates( $atts ) {
    return get_field("advanced_english_course_dates",219);
}
add_shortcode( 'advanced_english_course_dates_shortcode', 'advanced_english_course_dates');

function english_beginners_course_date( $atts ) {
    return get_field("english_beginners_course_start_date",219);
}
add_shortcode( 'english_beginners_date_shortcode', 'english_beginners_course_date');

function english_beginners_course_dates( $atts ) {
    return get_field("english_beginners_course_start_dates",219);
}
add_shortcode( 'english_beginners_dates_shortcode', 'english_beginners_course_dates');

function next_open_day_description_shortcode() {
    return get_field("next_open_day_description", 219);
}
add_shortcode('next_open_day_description', 'next_open_day_description_shortcode');

function join_us_link_shortcode() {
    return get_field("join_us_link", 219);
    
}
add_shortcode('join_us_link', 'join_us_link_shortcode');
function online_evening_course_start_dates_shortcode() {
    return get_field("online_evening_course_start_dates", 219);
}
add_shortcode('online_evening_course_start_dates', 'online_evening_course_start_dates_shortcode');

add_shortcode('join_us_link', 'join_us_link_shortcode');
function online_evening_course_start_date_shortcode() {
    return get_field("online_evening_course_start_date", 219);
}
add_shortcode('online_evening_course_start_date', 'online_evening_course_start_date_shortcode');

function next_open_day_title_shortcode() {
    return get_field("next_open_day_title", 219);
}

add_shortcode('next_open_day_title', 'next_open_day_title_shortcode');

function next_open_day_date_shortcode() {
    return get_field("next_open_day_date", 219);
    
}
add_shortcode('next_open_day_date', 'next_open_day_date_shortcode');

function ielts_english_course_date( $atts ) {
    return get_field("ielts_english_course_start_date",219);
}
add_shortcode( 'ielts_preparation_date_shortcode', 'ielts_english_course_date');

function ielts_english_course_dates( $atts ) {
    return get_field("ielts_english_course_start_dates",219);
}
add_shortcode( 'ielts_preparation_dates_shortcode', 'ielts_english_course_dates');

function saturday_english_course_date( $atts ) {
    return get_field("saturday_english_course_start_date",219);
}
add_shortcode( 'saturday_english_date_shortcode', 'saturday_english_course_date');

function saturday_english_course_dates( $atts ) {
    return get_field("saturday_english_course_start_dates",219);
}
add_shortcode( 'saturday_english_dates_shortcode', 'saturday_english_course_dates');

function morning_english_course_date( $atts ) {
    return get_field("morning_course_start_date",219);
}
add_shortcode( 'morning_english_date_shortcode', 'morning_english_course_date');

function morning_english_course_dates( $atts ) {
    return get_field("morning_course_start_dates",219);
}
add_shortcode( 'morning_english_dates_shortcode', 'morning_english_course_dates');


add_filter('the_content', 'do_shortcode');

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});

// Removes Order Notes Title - Additional Information & Notes Field
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );



// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );

function remove_order_notes( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

// Remove existing Google Fonts
function remove_google_fonts() {
    wp_dequeue_style('google-fonts'); // Common handle name
    // You might need to check your theme's specific handle
}
add_action('wp_enqueue_scripts', 'remove_google_fonts', 100);

// Add optimized Google Fonts
function add_optimized_google_fonts() {
    // Preconnect for faster loading
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // Optimized font loading
    wp_enqueue_style(
        'google-fonts-optimized',
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;1,400;1,700&family=Titillium+Web:wght@400;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'add_optimized_google_fonts');
add_action('wp_head', function() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}, 1);

/**
 * Removes theme editor.
 */
function wpdocs_remove_menus(){
	$user_id = get_current_user_id();
	if ($user_id != 16 ){
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
  		remove_submenu_page( 'plugins.php', 'plugin-editor.php' );	
	}
   	
}
add_action( 'admin_menu', 'wpdocs_remove_menus', 999 );

function admin_page_theme_editor_manipulation(){
	global $pagenow;
	// echo $pagenow;
	$user_id = get_current_user_id();

	if ($user_id != 16) {
		if ($pagenow == 'theme-editor.php' || $pagenow == 'plugin-editor.php') {
			wp_redirect( admin_url( '/?action=editor-restricted-access' ) );
	        exit;
		}
	}
	
}

add_action('admin_init', 'admin_page_theme_editor_manipulation');

function file_editor_restricted_notice() {
	global $pagenow;
	$user_id = get_current_user_id();
	
	if ($user_id != 16) {
		if ($pagenow == 'index.php' && $_REQUEST['action'] == 'editor-restricted-access') {
		    ?>
		    <div class="error notice is-dismissible">
		        <p><?php _e( 'Access to file editors has been restricted!, please contact your web developer.', 'mixtree-child' ); ?></p>
		    </div>
		    <?php
		}
	}

}
add_action( 'admin_notices', 'file_editor_restricted_notice' );

/**
 * Whello dashboard
 */

if ( ! defined( '_WT_DIR' ) ) {
  define( '_WT_DIR', get_stylesheet_directory() );
}

if ( ! defined( '_WT_DIR_URI' ) ) {
  define( '_WT_DIR_URI', get_stylesheet_directory_uri() );
}


require _WT_DIR . '/admin/whello-admin.php';

// Add to your theme's functions.php file
function mixtree_comprehensive_schema() {
    if (is_front_page()) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": ["LanguageSchool", "EducationalOrganization", "LocalBusiness"],
            "name": "MixTree Languages",
            "description": "English language school in Amsterdam offering small group courses with CELTA-certified teachers since 2015",
            "url": "<?php echo home_url(); ?>",
            "logo": "<?php echo home_url(); ?>/wp-content/uploads/logo.png",
            "image": [
                "<?php echo home_url(); ?>/wp-content/uploads/amsterdam-english-classes.jpg",
                "<?php echo home_url(); ?>/wp-content/uploads/celta-teachers.jpg"
            ],
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Eerste Weteringplantsoen 2c",
                "addressLocality": "Amsterdam",
                "addressRegion": "North Holland", 
                "postalCode": "1017 SJ",
                "addressCountry": "NL"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "52.35981924525704",
                "longitude": "4.889443538405737"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "00310207861981",
                "email": "info@mixtreelang.nl",
                "contactType": "customer service",
                "availableLanguage": ["English", "Dutch","Italian", "Spanish","French","Russian", "Portuguese"]
            },
            "foundingDate": "2015",
            "numberOfEmployees": "5-10",
            "priceRange": "€€",
            "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
            "currenciesAccepted": "EUR",
            "openingHours": [
                "Mo-Fr 09:00-18:00"
            ],
            "serviceArea": {
                "@type": "GeoCircle",
                "geoMidpoint": {
                    "@type": "GeoCoordinates",
                    "latitude": "52.3676",
                    "longitude": "4.9041"
                },
                "geoRadius": "25000"
            },
            "areaServed": ["Amsterdam", "Netherlands"],
            "knowsLanguage": ["en", "nl","fr", "it","sp"],
            "hasCredential": [
                {
                    "@type": "EducationalOccupationalCredential",
                    "credentialCategory": "CELTA",
                    "recognizedBy": "Cambridge English"
                },
                {
                    "@type": "EducationalOccupationalCredential", 
                    "credentialCategory": "TESOL"
                }
            ],
            "makesOffer": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Course",
                        "name": "Small Group English Classes",
                        "description": "Intensive English courses with max 8 students per class",
                        "provider": {
                            "@type": "LanguageSchool",
                            "name": "MixTree Languages"
                        }
                    },
                    "priceRange": "€€"
                },
                {
    "@type": "Offer",
    "itemOffered": {
        "@type": "Event",
        "name": "English Conversation Meetups",
        "description": "Weekly social events for English practice and networking",
        "startDate": "<?php echo date('Y-m-d', strtotime('next Wednesday')); ?>T13:00:00+01:00",
        "endDate": "<?php echo date('Y-m-d', strtotime('next Wednesday')); ?>T15:00:00+01:00",
        "location": {
            "@type": "Place",
            "name": "MixTree Languages",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Eerste Weteringplantsoen 2c",
                "addressLocality": "Amsterdam",
                "postalCode": "1017 SJ",
                "addressCountry": "NL"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "52.3676",
                "longitude": "4.9041"
            }
        },
        "organizer": {
            "@type": "Organization",
            "name": "MixTree Languages",
            "url": "<?php echo home_url(); ?>"
        },
        "eventStatus": "https://schema.org/EventScheduled",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "frequency": "P1W",
        "repeatFrequency": "Weekly",
        "dayOfWeek": "Wednesday",
        "isAccessibleForFree": true,
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "EUR",
            "availability": "https://schema.org/InStock"
        }
    }
}
            ],
            "sameAs": [
                "https://www.facebook.com/MixTreeLanguages",
                "https://www.instagram.com/mixtree.lang",
                "https://www.linkedin.com/company/mixtreelanguages"
            ],
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "reviewCount": "255",
                "bestRating": "5"
            }
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'mixtree_comprehensive_schema', 99);

// Individual course schemas for specific pages
function mixtree_individual_course_schema() {
    
    // Intensive English Course Page
    if (is_page('intensive-english-course')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "Intensive English Courses",
            "description": "Intensive English language courses with CELTA-certified teachers in Amsterdam. Small groups, 40 hours over 4 weeks.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "INTENSIVE_ENGLISH",
            "educationalLevel": "A2-B2",
            "coursePrerequisites": "Free level test",
            "timeRequired": "40 hours over 4 weeks",
            "courseMode": "in-person",
            "location": {
                "@type": "Place",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "52.3676",
                    "longitude": "4.9041"
                }
            },
            "offers": {
                "@type": "Offer",
                "price": "640",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
    
    // Morning English Course Page
    elseif (is_page('morning-english-courses')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "Morning English Courses",
            "description": "Morning English language courses with small groups in Amsterdam. 30 hours over 6 weeks with CELTA-certified teachers.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "MORNING_ENGLISH",
            "educationalLevel": "A2-B2",
            "coursePrerequisites": "Free level test",
            "timeRequired": "30 hours over 6 weeks",
            "courseMode": "in-person",
            "location": {
                "@type": "Place",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "52.3676",
                    "longitude": "4.9041"
                }
            },
            "offers": {
                "@type": "Offer",
                "price": "525",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
    
    // English for Beginners Page
    elseif (is_page('english-for-beginners')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "English for Beginners",
            "description": "English courses for complete beginners in Amsterdam. No previous English knowledge required. 24 hours over 6 weeks.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "BEGINNER_ENGLISH",
            "educationalLevel": "A1",
            "coursePrerequisites": "Free level test",
            "timeRequired": "24 hours over 6 weeks",
            "courseMode": "in-person",
            "location": {
                "@type": "Place",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": "52.3676",
                    "longitude": "4.9041"
                }
            },
            "offers": {
                "@type": "Offer",
                "price": "445",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
    
    // Online Evening English courses Page
    elseif (is_page('online-evening-english-courses')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "Online Evening English Courses",
            "description": "Online Evening English language courses with small groups. 24 hours over 6 weeks with CELTA-certified teachers.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "EVENING_ONLINE",
            "educationalLevel": "A2-C1",
            "coursePrerequisites": "Free level test",
            "timeRequired": "24 hours over 6 weeks",
            "courseMode": "online",
            "offers": {
                "@type": "Offer",
                "price": "385",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
    
    // C1 Advanced English Courses
    elseif (is_page('c1-advanced-english-course')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "C1 Advanced English Courses",
            "description": "Advanced Online English language courses with CELTA-certified teachers. Small groups, 24 hours over 6 weeks.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "C1_ADVANCED_ONLINE",
            "educationalLevel": "C1",
            "coursePrerequisites": "Free level test",
            "timeRequired": "24 hours over 6 weeks",
            "courseMode": "online",
            "offers": {
                "@type": "Offer",
                "price": "385",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
    
    // Business English Course Page
    elseif (is_page('business-english')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "Business English Course",
            "description": "Do you want to communicate more confidently with international colleagues and clients? Would you like to professionalize your CV, emails and networking skills? Discover the interactive Business English Course at MixTree Languages.",
            "provider": {
                "@type": "EducationalOrganization",
                "name": "MixTree Languages",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Eerste Weteringplantsoen 2c",
                    "addressLocality": "Amsterdam",
                    "postalCode": "1017 SJ",
                    "addressCountry": "NL"
                },
                "telephone": "+31 (0) 20 78 61 981"
            },
            "courseCode": "BUSINESS_ENGLISH",
            "educationalLevel": "B1-C1",
            "coursePrerequisites": "Free level test",
            "timeRequired": "24 hours over 6 weeks",
            "courseMode": "online",
            "offers": {
                "@type": "Offer",
                "price": "385",
                "priceCurrency": "EUR",
                "availability": "https://schema.org/InStock",
                "validFrom": "<?php echo date('Y-m-d'); ?>",
                "url": "<?php echo get_permalink(); ?>"
            },
            "instructor": {
                "@type": "Organization",
                "name": "CELTA and TESOL-certified teachers"
            }
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'mixtree_individual_course_schema', 100);

// Course catalog page schema
function mixtree_course_catalog_schema() {
    // Replace with your actual catalog page slug
    if (is_page('course-schedule')) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "name": "English Courses in Amsterdam - MixTree Languages",
            "description": "Complete list of English language courses offered by MixTree Languages in Amsterdam",
            "numberOfItems": 6,
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item": {
                        "@type": "Course",
                        "name": "Intensive English Courses",
                        "description": "40 hours over 4 weeks, small groups, A2-B2 levels",
                        "url": "<?php echo home_url(); ?>/english-course/intensive-english-course/",
                        "courseMode": "in-person",
                        "offers": {
                            "@type": "Offer",
                            "price": "640",
                            "priceCurrency": "EUR"
                        }
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item": {
                        "@type": "Course",
                        "name": "Morning English Courses",
                        "description": "30 hours over 6 weeks, small groups, A2-B2 levels",
                        "url": "<?php echo home_url(); ?>/english-course/morning-english-courses/",
                        "courseMode": "in-person",
                        "offers": {
                            "@type": "Offer",
                            "price": "525",
                            "priceCurrency": "EUR"
                        }
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item": {
                        "@type": "Course",
                        "name": "English for Beginners",
                        "description": "24 hours over 6 weeks, no prerequisites, A1 level",
                        "url": "<?php echo home_url(); ?>/english-course/english-for-beginners/",
                        "courseMode": "in-person",
                        "offers": {
                            "@type": "Offer",
                            "price": "445",
                            "priceCurrency": "EUR"
                        }
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item": {
                        "@type": "Course",
                        "name": "Online Evening English Courses",
                        "description": "24 hours over 6 weeks, online format, A2-C1 levels",
                        "url": "<?php echo home_url(); ?>/english-course/online-evening-english-courses/",
                        "courseMode": "online",
                        "offers": {
                            "@type": "Offer",
                            "price": "385",
                            "priceCurrency": "EUR"
                        }
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 5,
                    "item": {
                        "@type": "Course",
                        "name": "C1 Advanced English Courses",
                        "description": "24 hours over 6 weeks, advanced level, C1",
                        "url": "<?php echo home_url(); ?>/english-course/c1-advanced-english-course/",
                        "courseMode": "online",
                        "offers": {
                            "@type": "Offer",
                            "price": "385",
                            "priceCurrency": "EUR"
                        }
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 6,
                    "item": {
                        "@type": "Course",
                        "name": "Business English Course",
                        "description": "24 hours over 6 weeks, professional English, B1-C1 levels",
                        "url": "<?php echo home_url(); ?>/english-course/business-english/",
                        "courseMode": "online",
                        "offers": {
                            "@type": "Offer",
                            "price": "385",
                            "priceCurrency": "EUR"
                        }
                    }
                }
            ]
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'mixtree_course_catalog_schema', 101);

/**
 * Mixtree Languages Courses API - WordPress AJAX Implementation
 * Add this code to your theme's functions.php file
 */

function mixtree_courses_ajax_handler() {
    // Course data array - all 168 courses
    $courses = [
    [
        'name' => 'B2 INTENSIVE - AUCKLAND - 09.03.2026 - R3',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Mar 9',
        'endDate' => 'Apr 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Mar 9, Mar 10, Mar 12, Mar 13, Mar 16, Mar 17, Mar 19, Mar 20, Mar 23, Mar 24, Mar 26, Mar 27, Mar 30, Mar 31, Apr 2, Apr 3',
        'startMonth' => 'March 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - AUCKLAND - 09.03.2026 - R3',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Mar 9',
        'endDate' => 'Apr 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Mar 9, Mar 10, Mar 12, Mar 13, Mar 16, Mar 17, Mar 19, Mar 20, Mar 23, Mar 24, Mar 26, Mar 27, Mar 30, Mar 31, Apr 2, Apr 3',
        'startMonth' => 'March 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - AUCKLAND - 09.03.2026 - R3',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Mar 9',
        'endDate' => 'Apr 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Mar 9, Mar 10, Mar 12, Mar 13, Mar 16, Mar 17, Mar 19, Mar 20, Mar 23, Mar 24, Mar 26, Mar 27, Mar 30, Mar 31, Apr 2, Apr 3',
        'startMonth' => 'March 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - FIFE - 06.04.2026 - R3',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Apr 6',
        'endDate' => 'May 13',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Apr 6, Apr 8, Apr 13, Apr 15, Apr 20, Apr 22, Apr 27, Apr 29, May 4, May 6, May 11, May 13',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - FIFE - 06.04.2026 - R3',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Apr 7',
        'endDate' => 'May 13',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'Apr 7, Apr 8, Apr 13, Apr 15, Apr 20, Apr 22, Apr 28, Apr 29, May 4, May 6, May 11, May 13',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - FIFE - 06.04.2026 - R3',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Apr 7',
        'endDate' => 'May 13',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Apr 7, Apr 8, Apr 13, Apr 15, Apr 20, Apr 22, Apr 27, Apr 28, Apr 29, May 4, May 6, May 11, May 13',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - FIFE - 07.04.2026 - R3',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Apr 7',
        'endDate' => 'May 15',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Apr 7, Apr 10, Apr 14, Apr 17, Apr 21, Apr 24, Apr 28, May 1, May 5, May 8, May 12, May 15',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - FIFE - 07.04.2026 - R3',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Apr 7',
        'endDate' => 'May 14',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Apr 7, Apr 9, Apr 14, Apr 16, Apr 21, Apr 23, Apr 28, Apr 30, May 5, May 7, May 12, May 14',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - FIFE - 07.04.2026 - R3',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Apr 7',
        'endDate' => 'May 14',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Apr 7, Apr 9, Apr 14, Apr 16, Apr 21, Apr 23, Apr 28, Apr 30, May 5, May 7, May 12, May 14',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - FIFE - 07.04.2026 - R3',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Apr 7',
        'endDate' => 'May 14',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Apr 7, Apr 9, Apr 14, Apr 16, Apr 21, Apr 23, Apr 28, Apr 30, May 5, May 7, May 12, May 14',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - BOSTON - 06.04.2026 - R4',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Apr 7',
        'endDate' => 'May 1',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Apr 7, Apr 8, Apr 9, Apr 10, Apr 13, Apr 14, Apr 16, Apr 17, Apr 20, Apr 21, Apr 23, Apr 24, Apr 28, Apr 29, Apr 30, May 1',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - BOSTON - 06.04.2026 - R4',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Apr 7',
        'endDate' => 'May 1',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Apr 7, Apr 8, Apr 9, Apr 10, Apr 13, Apr 14, Apr 16, Apr 17, Apr 20, Apr 21, Apr 23, Apr 24, Apr 28, Apr 29, Apr 30, May 1',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - BOSTON - 06.04.2026 - R4',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Apr 7',
        'endDate' => 'May 1',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Apr 7, Apr 8, Apr 9, Apr 10, Apr 13, Apr 14, Apr 16, Apr 17, Apr 20, Apr 21, Apr 23, Apr 24, Apr 28, Apr 29, Apr 30, May 1',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - FIFE - 06.04.2026 - R3',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Apr 8',
        'endDate' => 'May 14',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '09:30-12:00',
        'dates' => 'Apr 8, Apr 9, Apr 13, Apr 16, Apr 20, Apr 23, Apr 29, Apr 30, May 4, May 7, May 11, May 14',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - FIFE - 06.04.2026 - R3',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'FIFE',
        'hours' => '24 hours/5 weeks',
        'price' => '€385',
        'startDate' => 'Apr 8',
        'endDate' => 'May 13',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Apr 8, Apr 10, Apr 13, Apr 15, Apr 20, Apr 22, Apr 27, Apr 29, May 1, May 4, May 6, May 11, May 13',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - FIFE - 08.04.2026 - R3',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Apr 8',
        'endDate' => 'May 15',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Apr 8, Apr 10, Apr 15, Apr 17, Apr 22, Apr 24, Apr 29, May 1, May 6, May 8, May 13, May 15',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - EDMONTON - 06.04.2026 - R3',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/5 weeks',
        'price' => '€445',
        'startDate' => 'Apr 8',
        'endDate' => 'May 13',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'Apr 8, Apr 10, Apr 13, Apr 15, Apr 20, Apr 22, Apr 29, May 1, May 4, May 6, May 11, May 13',
        'startMonth' => 'April 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - CAPE TOWN - 11.05.2026 - R5',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'May 11',
        'endDate' => 'Jun 5',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'May 11, May 12, May 14, May 15, May 18, May 19, May 21, May 22, May 25, May 26, May 28, May 29, Jun 1, Jun 2, Jun 4, Jun 5',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - CAPE TOWN - 11.05.2026 - R5',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'May 11',
        'endDate' => 'Jun 5',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'May 11, May 12, May 14, May 15, May 18, May 19, May 21, May 22, May 25, May 26, May 28, May 29, Jun 1, Jun 2, Jun 4, Jun 5',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - CAPE TOWN - 11.05.2026 - R5',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'May 11',
        'endDate' => 'Jun 5',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'May 11, May 12, May 14, May 15, May 18, May 19, May 21, May 22, May 25, May 26, May 28, May 29, Jun 1, Jun 2, Jun 4, Jun 5',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - DUBLIN - 25.05.2026 - R4',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'May 25',
        'endDate' => 'Jul 2',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'May 25, May 28, Jun 1, Jun 4, Jun 8, Jun 11, Jun 15, Jun 18, Jun 22, Jun 25, Jun 29, Jul 2',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - DUBLIN - 25.05.2026 - R4',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'May 25',
        'endDate' => 'Jul 1',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'May 25, May 27, Jun 1, Jun 3, Jun 8, Jun 10, Jun 15, Jun 17, Jun 22, Jun 24, Jun 29, Jul 1',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - DUBLIN - 25.05.2026 - R4',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'May 25',
        'endDate' => 'Jul 1',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'May 25, May 27, Jun 1, Jun 3, Jun 8, Jun 10, Jun 15, Jun 17, Jun 22, Jun 24, Jun 29, Jul 1',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - DUBLIN - 25.05.2026 - R4',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'May 25',
        'endDate' => 'Jul 1',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'May 25, May 27, Jun 1, Jun 3, Jun 8, Jun 10, Jun 15, Jun 17, Jun 22, Jun 24, Jun 29, Jul 1',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - DUBLIN - 25.05.2026 - R4',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'May 25',
        'endDate' => 'Jul 1',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'May 25, May 27, Jun 1, Jun 3, Jun 8, Jun 10, Jun 15, Jun 17, Jun 22, Jun 24, Jun 29, Jul 1',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - DUBLIN - 25.05.2026 - R4',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€445',
        'startDate' => 'May 25',
        'endDate' => 'Jul 1',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'May 25, May 27, Jun 1, Jun 3, Jun 8, Jun 10, Jun 15, Jun 17, Jun 22, Jun 24, Jun 29, Jul 1',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - DUBLIN - 26.05.2026 - R4',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'May 26',
        'endDate' => 'Jul 3',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'May 26, May 29, Jun 2, Jun 5, Jun 9, Jun 12, Jun 16, Jun 19, Jun 23, Jun 26, Jun 30, Jul 3',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - DUBLIN - 26.05.2026 - R4',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'May 26',
        'endDate' => 'Jul 2',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'May 26, May 28, Jun 2, Jun 4, Jun 9, Jun 11, Jun 16, Jun 18, Jun 23, Jun 25, Jun 30, Jul 2',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - DUBLIN - 26.05.2026 - R4',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'May 26',
        'endDate' => 'Jul 2',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'May 26, May 28, Jun 2, Jun 4, Jun 9, Jun 11, Jun 16, Jun 18, Jun 23, Jun 25, Jun 30, Jul 2',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - DUBLIN - 26.05.2026 - R4',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'May 26',
        'endDate' => 'Jul 2',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'May 26, May 28, Jun 2, Jun 4, Jun 9, Jun 11, Jun 16, Jun 18, Jun 23, Jun 25, Jun 30, Jul 2',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - DUBLIN - 27.05.2026 - R4',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'May 27',
        'endDate' => 'Jul 3',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'May 27, May 29, Jun 3, Jun 5, Jun 10, Jun 12, Jun 17, Jun 19, Jun 24, Jun 26, Jul 1, Jul 3',
        'startMonth' => 'May 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - AUCKLAND - 08.06.2026 - R6',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jun 8',
        'endDate' => 'Jul 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Jun 8, Jun 9, Jun 11, Jun 12, Jun 15, Jun 16, Jun 18, Jun 19, Jun 22, Jun 23, Jun 25, Jun 26, Jun 29, Jun 30, Jul 2, Jul 3',
        'startMonth' => 'June 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - AUCKLAND - 08.06.2026 - R6',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jun 8',
        'endDate' => 'Jul 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Jun 8, Jun 9, Jun 11, Jun 12, Jun 15, Jun 16, Jun 18, Jun 19, Jun 22, Jun 23, Jun 25, Jun 26, Jun 29, Jun 30, Jul 2, Jul 3',
        'startMonth' => 'June 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - AUCKLAND - 08.06.2026 - R6',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jun 8',
        'endDate' => 'Jul 3',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Jun 8, Jun 9, Jun 11, Jun 12, Jun 15, Jun 16, Jun 18, Jun 19, Jun 22, Jun 23, Jun 25, Jun 26, Jun 29, Jun 30, Jul 2, Jul 3',
        'startMonth' => 'June 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - EDMONTON - 06.07.2026 - R5',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 13',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Jul 6, Jul 9, Jul 13, Jul 16, Jul 20, Jul 23, Jul 27, Jul 30, Aug 3, Aug 6, Aug 10, Aug 13',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - EDMONTON - 06.07.2026 - R5',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - EDMONTON - 06.07.2026 - R5',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - EDMONTON - 06.07.2026 - R5',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - EDMONTON - 06.07.2026 - R5',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - EDMONTON - 06.07.2026 - R5',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - EDMONTON - 06.07.2026 - R5',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€445',
        'startDate' => 'Jul 6',
        'endDate' => 'Aug 12',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'Jul 6, Jul 8, Jul 13, Jul 15, Jul 20, Jul 22, Jul 27, Jul 29, Aug 3, Aug 5, Aug 10, Aug 12',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - BOSTON - 06.07.2026 - R7',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jul 6',
        'endDate' => 'Jul 31',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Jul 6, Jul 7, Jul 9, Jul 10, Jul 13, Jul 14, Jul 16, Jul 17, Jul 20, Jul 21, Jul 23, Jul 24, Jul 27, Jul 28, Jul 30, Jul 31',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - BOSTON - 06.07.2026 - R7',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jul 6',
        'endDate' => 'Jul 31',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Jul 6, Jul 7, Jul 9, Jul 10, Jul 13, Jul 14, Jul 16, Jul 17, Jul 20, Jul 21, Jul 23, Jul 24, Jul 27, Jul 28, Jul 30, Jul 31',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - BOSTON - 06.07.2026 - R7',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Jul 6',
        'endDate' => 'Jul 31',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Jul 6, Jul 7, Jul 9, Jul 10, Jul 13, Jul 14, Jul 16, Jul 17, Jul 20, Jul 21, Jul 23, Jul 24, Jul 27, Jul 28, Jul 30, Jul 31',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - EDMONTON - 07.07.2026 - R5',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Jul 7',
        'endDate' => 'Aug 14',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Jul 7, Jul 10, Jul 14, Jul 17, Jul 21, Jul 24, Jul 28, Jul 31, Aug 4, Aug 7, Aug 11, Aug 14',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - EDMONTON - 07.07.2026 - R5',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Jul 7',
        'endDate' => 'Aug 13',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Jul 7, Jul 9, Jul 14, Jul 16, Jul 21, Jul 23, Jul 28, Jul 30, Aug 4, Aug 6, Aug 11, Aug 13',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - EDMONTON - 07.07.2026 - R5',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Jul 7',
        'endDate' => 'Aug 13',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Jul 7, Jul 9, Jul 14, Jul 16, Jul 21, Jul 23, Jul 28, Jul 30, Aug 4, Aug 6, Aug 11, Aug 13',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - EDMONTON - 08.07.2026 - R5',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Jul 8',
        'endDate' => 'Aug 14',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Jul 8, Jul 10, Jul 15, Jul 17, Jul 22, Jul 24, Jul 29, Jul 31, Aug 5, Aug 7, Aug 12, Aug 14',
        'startMonth' => 'July 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - CAPE TOWN - 03.08.2026 - R8',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 3',
        'endDate' => 'Aug 28',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Aug 3, Aug 4, Aug 6, Aug 7, Aug 10, Aug 11, Aug 13, Aug 14, Aug 17, Aug 18, Aug 20, Aug 21, Aug 24, Aug 25, Aug 27, Aug 28',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - CAPE TOWN - 03.08.2026 - R8',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 3',
        'endDate' => 'Aug 28',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Aug 3, Aug 4, Aug 6, Aug 7, Aug 10, Aug 11, Aug 13, Aug 14, Aug 17, Aug 18, Aug 20, Aug 21, Aug 24, Aug 25, Aug 27, Aug 28',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - CAPE TOWN - 03.08.2026 - R8',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 3',
        'endDate' => 'Aug 28',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Aug 3, Aug 4, Aug 6, Aug 7, Aug 10, Aug 11, Aug 13, Aug 14, Aug 17, Aug 18, Aug 20, Aug 21, Aug 24, Aug 25, Aug 27, Aug 28',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - FIFE - 17.08.2026 - R6',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 24',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Aug 17, Aug 20, Aug 24, Aug 27, Aug 31, Sep 3, Sep 7, Sep 10, Sep 14, Sep 17, Sep 21, Sep 24',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - FIFE - 17.08.2026 - R6',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 23',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'Aug 17, Aug 19, Aug 24, Aug 26, Aug 31, Sep 2, Sep 7, Sep 9, Sep 14, Sep 16, Sep 21, Sep 23',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - FIFE - 17.08.2026 - R6',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 23',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Aug 17, Aug 19, Aug 24, Aug 26, Aug 31, Sep 2, Sep 7, Sep 9, Sep 14, Sep 16, Sep 21, Sep 23',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - FIFE - 17.08.2026 - R6',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 23',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Aug 17, Aug 19, Aug 24, Aug 26, Aug 31, Sep 2, Sep 7, Sep 9, Sep 14, Sep 16, Sep 21, Sep 23',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - FIFE - 17.08.2026 - R6',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 23',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Aug 17, Aug 19, Aug 24, Aug 26, Aug 31, Sep 2, Sep 7, Sep 9, Sep 14, Sep 16, Sep 21, Sep 23',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - DUBLIN - 17.08.2026 - R6',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€445',
        'startDate' => 'Aug 17',
        'endDate' => 'Sep 23',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'Aug 17, Aug 19, Aug 24, Aug 26, Aug 31, Sep 2, Sep 7, Sep 9, Sep 14, Sep 16, Sep 21, Sep 23',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - FIFE - 18.08.2026 - R6',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Aug 18',
        'endDate' => 'Sep 25',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Aug 18, Aug 21, Aug 25, Aug 28, Sep 1, Sep 4, Sep 8, Sep 11, Sep 15, Sep 18, Sep 22, Sep 25',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - FIFE - 18.08.2026 - R6',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Aug 18',
        'endDate' => 'Sep 24',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Aug 18, Aug 20, Aug 25, Aug 27, Sep 1, Sep 3, Sep 8, Sep 10, Sep 15, Sep 17, Sep 22, Sep 24',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - FIFE - 18.08.2026 - R6',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Aug 18',
        'endDate' => 'Sep 24',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Aug 18, Aug 20, Aug 25, Aug 27, Sep 1, Sep 3, Sep 8, Sep 10, Sep 15, Sep 17, Sep 22, Sep 24',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - FIFE - 18.08.2026 - R6',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'FIFE',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Aug 18',
        'endDate' => 'Sep 24',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Aug 18, Aug 20, Aug 25, Aug 27, Sep 1, Sep 3, Sep 8, Sep 10, Sep 15, Sep 17, Sep 22, Sep 24',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - FIFE - 19.08.2026 - R6',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'FIFE',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Aug 19',
        'endDate' => 'Sep 25',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Aug 19, Aug 21, Aug 26, Aug 28, Sep 2, Sep 4, Sep 9, Sep 11, Sep 16, Sep 18, Sep 23, Sep 25',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - AUCKLAND - 31.08.2026 - R9',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 31',
        'endDate' => 'Sep 25',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Aug 31, Sep 1, Sep 3, Sep 4, Sep 7, Sep 8, Sep 10, Sep 11, Sep 14, Sep 15, Sep 17, Sep 18, Sep 21, Sep 22, Sep 24, Sep 25',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - AUCKLAND - 31.08.2026 - R9',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 31',
        'endDate' => 'Sep 25',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Aug 31, Sep 1, Sep 3, Sep 4, Sep 7, Sep 8, Sep 10, Sep 11, Sep 14, Sep 15, Sep 17, Sep 18, Sep 21, Sep 22, Sep 24, Sep 25',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - AUCKLAND - 31.08.2026 - R9',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Aug 31',
        'endDate' => 'Sep 25',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Aug 31, Sep 1, Sep 3, Sep 4, Sep 7, Sep 8, Sep 10, Sep 11, Sep 14, Sep 15, Sep 17, Sep 18, Sep 21, Sep 22, Sep 24, Sep 25',
        'startMonth' => 'August 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - DUBLIN - 28.09.2026 - R7',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 5',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Sep 28, Oct 1, Oct 5, Oct 8, Oct 12, Oct 15, Oct 19, Oct 22, Oct 26, Oct 29, Nov 2, Nov 5',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - DUBLIN - 28.09.2026 - R7',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 4',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'Sep 28, Sep 30, Oct 5, Oct 7, Oct 12, Oct 14, Oct 19, Oct 21, Oct 26, Oct 28, Nov 2, Nov 4',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - DUBLIN - 28.09.2026 - R7',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€360',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 4',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Sep 28, Sep 30, Oct 5, Oct 7, Oct 12, Oct 14, Oct 19, Oct 21, Oct 26, Oct 28, Nov 2, Nov 4',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - DUBLIN - 28.09.2026 - R7',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 4',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Sep 28, Sep 30, Oct 5, Oct 7, Oct 12, Oct 14, Oct 19, Oct 21, Oct 26, Oct 28, Nov 2, Nov 4',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - DUBLIN - 28.09.2026 - R7',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 4',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Sep 28, Sep 30, Oct 5, Oct 7, Oct 12, Oct 14, Oct 19, Oct 21, Oct 26, Oct 28, Nov 2, Nov 4',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - EDMONTON - 28.09.2026 - R7',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€445',
        'startDate' => 'Sep 28',
        'endDate' => 'Nov 4',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'Sep 28, Sep 30, Oct 5, Oct 7, Oct 12, Oct 14, Oct 19, Oct 21, Oct 26, Oct 28, Nov 2, Nov 4',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - BOSTON - 28.09.2026 - R10',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Sep 28',
        'endDate' => 'Oct 23',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Sep 28, Sep 29, Oct 1, Oct 2, Oct 5, Oct 6, Oct 8, Oct 9, Oct 12, Oct 13, Oct 15, Oct 16, Oct 19, Oct 20, Oct 22, Oct 23',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - BOSTON - 28.09.2026 - R10',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Sep 28',
        'endDate' => 'Oct 23',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Sep 28, Sep 29, Oct 1, Oct 2, Oct 5, Oct 6, Oct 8, Oct 9, Oct 12, Oct 13, Oct 15, Oct 16, Oct 19, Oct 20, Oct 22, Oct 23',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - BOSTON - 28.09.2026 - R10',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'BOSTON',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Sep 28',
        'endDate' => 'Oct 23',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Sep 28, Sep 29, Oct 1, Oct 2, Oct 5, Oct 6, Oct 8, Oct 9, Oct 12, Oct 13, Oct 15, Oct 16, Oct 19, Oct 20, Oct 22, Oct 23',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - DUBLIN - 29.09.2026 - R7',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Sep 29',
        'endDate' => 'Nov 6',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Sep 29, Oct 2, Oct 6, Oct 9, Oct 13, Oct 16, Oct 20, Oct 23, Oct 27, Oct 30, Nov 3, Nov 6',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - DUBLIN - 29.09.2026 - R7',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Sep 29',
        'endDate' => 'Nov 5',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Sep 29, Oct 1, Oct 6, Oct 8, Oct 13, Oct 15, Oct 20, Oct 22, Oct 27, Oct 29, Nov 3, Nov 5',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - DUBLIN - 29.09.2026 - R7',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Sep 29',
        'endDate' => 'Nov 5',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Sep 29, Oct 1, Oct 6, Oct 8, Oct 13, Oct 15, Oct 20, Oct 22, Oct 27, Oct 29, Nov 3, Nov 5',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - DUBLIN - 29.09.2026 - R7',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Sep 29',
        'endDate' => 'Nov 5',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Sep 29, Oct 1, Oct 6, Oct 8, Oct 13, Oct 15, Oct 20, Oct 22, Oct 27, Oct 29, Nov 3, Nov 5',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - DUBLIN - 30.09.2026 - R7',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'DUBLIN',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Sep 30',
        'endDate' => 'Nov 6',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Sep 30, Oct 2, Oct 7, Oct 9, Oct 14, Oct 16, Oct 21, Oct 23, Oct 28, Oct 30, Nov 4, Nov 6',
        'startMonth' => 'September 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 INTENSIVE - CAPE TOWN - 26.10.2026 - R11',
        'type' => 'INTENSIVE',
        'level' => 'B2',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Oct 26',
        'endDate' => 'Nov 20',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Oct 26, Oct 27, Oct 29, Oct 30, Nov 2, Nov 3, Nov 5, Nov 6, Nov 9, Nov 10, Nov 12, Nov 13, Nov 16, Nov 17, Nov 19, Nov 20',
        'startMonth' => 'October 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - CAPE TOWN - 26.10.2026 - R11',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Oct 26',
        'endDate' => 'Nov 20',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Oct 26, Oct 27, Oct 29, Oct 30, Nov 2, Nov 3, Nov 5, Nov 6, Nov 9, Nov 10, Nov 12, Nov 13, Nov 16, Nov 17, Nov 19, Nov 20',
        'startMonth' => 'October 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - CAPE TOWN - 26.10.2026 - R11',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'CAPE TOWN',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Oct 26',
        'endDate' => 'Nov 20',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '15:30-18:00',
        'dates' => 'Oct 26, Oct 27, Oct 29, Oct 30, Nov 2, Nov 3, Nov 5, Nov 6, Nov 9, Nov 10, Nov 12, Nov 13, Nov 16, Nov 17, Nov 19, Nov 20',
        'startMonth' => 'October 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 MORNING - EDMONTON - 04.11.2026 - R8',
        'type' => 'MORNING',
        'level' => 'B1',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Nov 4',
        'endDate' => 'Dec 11',
        'year' => '2026',
        'days' => 'Wed, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Nov 4, Nov 6, Nov 11, Nov 13, Nov 18, Nov 20, Nov 25, Nov 27, Dec 2, Dec 4, Dec 9, Dec 11',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 MORNING - EDMONTON - 09.11.2026 - R8',
        'type' => 'MORNING',
        'level' => 'B2',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 17',
        'year' => '2026',
        'days' => 'Mon, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Nov 9, Nov 12, Nov 16, Nov 19, Nov 23, Nov 26, Nov 30, Dec 3, Dec 7, Dec 10, Dec 14, Dec 17',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 ELEM MORNING - EDMONTON - 09.11.2026 - R8',
        'type' => 'MORNING',
        'level' => 'A2 ELEMENTARY',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 16',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '9:30-12:00',
        'dates' => 'Nov 9, Nov 11, Nov 16, Nov 18, Nov 23, Nov 25, Nov 30, Dec 2, Dec 7, Dec 9, Dec 14, Dec 16',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 EVE ONLINE - EDMONTON - 09.11.2026 - R8',
        'type' => 'EVENING',
        'level' => 'B1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 16',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Nov 9, Nov 11, Nov 16, Nov 18, Nov 23, Nov 25, Nov 30, Dec 2, Dec 7, Dec 9, Dec 14, Dec 16',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B2 EVE ONLINE - EDMONTON - 09.11.2026 - R8',
        'type' => 'EVENING',
        'level' => 'B2',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 16',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Nov 9, Nov 11, Nov 16, Nov 18, Nov 23, Nov 25, Nov 30, Dec 2, Dec 7, Dec 9, Dec 14, Dec 16',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'BUSINESS EVE ONLINE - EDMONTON - 09.11.2026 - R8',
        'type' => 'EVENING',
        'level' => 'BUSINESS',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 16',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '19:00-21:00',
        'dates' => 'Nov 9, Nov 11, Nov 16, Nov 18, Nov 23, Nov 25, Nov 30, Dec 2, Dec 7, Dec 9, Dec 14, Dec 16',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A1 BEGINNER - DUBLIN - 09.11.2026 - R8',
        'type' => 'BEGINNER',
        'level' => 'A1',
        'programme' => 'DUBLIN',
        'hours' => '24 hours/6 weeks',
        'price' => '€445',
        'startDate' => 'Nov 9',
        'endDate' => 'Dec 16',
        'year' => '2026',
        'days' => 'Mon, Wed',
        'times' => '15:30-17:30',
        'dates' => 'Nov 9, Nov 11, Nov 16, Nov 18, Nov 23, Nov 25, Nov 30, Dec 2, Dec 7, Dec 9, Dec 14, Dec 16',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 MORNING - EDMONTON - 10.11.2026 - R8',
        'type' => 'MORNING',
        'level' => 'C1',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Nov 10',
        'endDate' => 'Dec 18',
        'year' => '2026',
        'days' => 'Tue, Fri',
        'times' => '9:30-12:00',
        'dates' => 'Nov 10, Nov 13, Nov 17, Nov 20, Nov 24, Nov 27, Dec 1, Dec 4, Dec 8, Dec 11, Dec 15, Dec 18',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT EVE ONLINE - EDMONTON - 10.11.2026 - R8',
        'type' => 'EVENING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Nov 10',
        'endDate' => 'Dec 17',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Nov 10, Nov 12, Nov 17, Nov 19, Nov 24, Nov 26, Dec 1, Dec 3, Dec 8, Dec 10, Dec 15, Dec 17',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 PRE-INT MORNING - EDMONTON - 10.11.2026 - R8',
        'type' => 'MORNING',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'EDMONTON',
        'hours' => '30 hours/6 weeks',
        'price' => '€525',
        'startDate' => 'Nov 10',
        'endDate' => 'Dec 17',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '9:30-12:00',
        'dates' => 'Nov 10, Nov 12, Nov 17, Nov 19, Nov 24, Nov 26, Dec 1, Dec 3, Dec 8, Dec 10, Dec 15, Dec 17',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'C1 EVE ONLINE - EDMONTON - 10.11.2026 - R8',
        'type' => 'EVENING',
        'level' => 'C1',
        'programme' => 'EDMONTON',
        'hours' => '24 hours/6 weeks',
        'price' => '€385',
        'startDate' => 'Nov 10',
        'endDate' => 'Dec 17',
        'year' => '2026',
        'days' => 'Tue, Thurs',
        'times' => '19:00-21:00',
        'dates' => 'Nov 10, Nov 12, Nov 17, Nov 19, Nov 24, Nov 26, Dec 1, Dec 3, Dec 8, Dec 10, Dec 15, Dec 17',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'A2 INTENSIVE - AUCKLAND - 23.11.2026 - R12',
        'type' => 'INTENSIVE',
        'level' => 'A2 PRE-INTERMEDIATE',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Nov 23',
        'endDate' => 'Dec 18',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Nov 23, Nov 24, Nov 26, Nov 27, Nov 30, Dec 1, Dec 3, Dec 4, Dec 7, Dec 8, Dec 10, Dec 11, Dec 14, Dec 15, Dec 17, Dec 18',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ],
    [
        'name' => 'B1 INTENSIVE - AUCKLAND - 23.11.2026 - R12',
        'type' => 'INTENSIVE',
        'level' => 'B1',
        'programme' => 'AUCKLAND',
        'hours' => '40 hours/4 weeks',
        'price' => '€640',
        'startDate' => 'Nov 23',
        'endDate' => 'Dec 18',
        'year' => '2026',
        'days' => 'Mon, Tue, Thurs, Fri',
        'times' => '12:30-15:00',
        'dates' => 'Nov 23, Nov 24, Nov 26, Nov 27, Nov 30, Dec 1, Dec 3, Dec 4, Dec 7, Dec 8, Dec 10, Dec 11, Dec 14, Dec 15, Dec 17, Dec 18',
        'startMonth' => 'November 2026',
        'registrationLink' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
    ]
];

    // Optional: Filter out expired courses based on current date
    $current_date = new DateTime();
    $active_courses = array_filter($courses, function($course) use ($current_date) {
        // Convert course end date to DateTime for comparison
        $end_date = DateTime::createFromFormat('M j', $course['endDate']);
        if ($end_date) {
            $end_date->setDate($course['year'], $end_date->format('m'), $end_date->format('d'));
            return $end_date >= $current_date;
        }
        return true; // Include course if date parsing fails
    });

    // Prepare response
    $response = [
        'success' => true,
        'total_courses' => count($active_courses),
        'generated_date' => current_time('c'), // WordPress current time in ISO 8601 format
        'api_version' => '1.0',
        'courses' => array_values($active_courses) // Reset array keys
    ];

    // Send JSON response
    wp_send_json_success($response);
}

// Register AJAX actions
// For logged-in users
add_action('wp_ajax_mixtree_courses', 'mixtree_courses_ajax_handler');
// For non-logged-in users (public access)
add_action('wp_ajax_nopriv_mixtree_courses', 'mixtree_courses_ajax_handler');

// Optional: Add admin notice for debugging
function mixtree_courses_admin_notice() {
    if (current_user_can('administrator')) {
        echo '<div class="notice notice-info"><p>';
        echo 'Mixtree Courses API is active. Test URL: <code>' . admin_url('admin-ajax.php?action=mixtree_courses') . '</code>';
        echo '</p></div>';
    }
}
// Uncomment the next line to show admin notice for testing
// add_action('admin_notices', 'mixtree_courses_admin_notice');

// More comprehensive WooCommerce removal
add_action('wp_enqueue_scripts', 'completely_disable_woocommerce', 99);
function completely_disable_woocommerce() {
    if (function_exists('is_woocommerce')) {
        // Dequeue ALL WooCommerce styles
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('wc-blocks-vendors-style');
        
        // Dequeue ALL WooCommerce scripts (including the ones you're seeing)
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('wc-add-to-cart-js'); // This one was missing
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('wc-order-attribution');
        wp_dequeue_script('sourcebuster-js');
        wp_dequeue_script('jquery-blockui'); // WooCommerce uses this
        wp_dequeue_script('vc_woocommerce-add-to-cart-js'); // Visual Composer WooCommerce script
        
        // Remove WooCommerce inline scripts
        wp_deregister_script('wc-add-to-cart-js');
        wp_deregister_script('vc_woocommerce-add-to-cart-js');
    }
}

// Disable WooCommerce styles completely
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Remove WooCommerce body class
add_filter('body_class', 'remove_woocommerce_body_class');
function remove_woocommerce_body_class($classes) {
    $woo_classes = array('woocommerce', 'woocommerce-js', 'woocommerce-page');
    $classes = array_diff($classes, $woo_classes);
    return $classes;
}

// Remove WooCommerce generator and other meta
remove_action('wp_head', 'wc_generator_tag');
remove_action('wp_head', 'woocommerce_demo_store');

// Disable WooCommerce widgets
add_action('widgets_init', 'disable_woocommerce_widgets', 99);
function disable_woocommerce_widgets() {
    unregister_widget('WC_Widget_Cart');
    unregister_widget('WC_Widget_Layered_Nav');
    unregister_widget('WC_Widget_Layered_Nav_Filters');
    unregister_widget('WC_Widget_Price_Filter');
    unregister_widget('WC_Widget_Product_Categories');
    unregister_widget('WC_Widget_Product_Search');
    unregister_widget('WC_Widget_Product_Tag_Cloud');
    unregister_widget('WC_Widget_Products');
    unregister_widget('WC_Widget_Rating_Filter');
    unregister_widget('WC_Widget_Recent_Reviews');
    unregister_widget('WC_Widget_Recently_Viewed');
    unregister_widget('WC_Widget_Top_Rated_Products');
}

// Disable WooCommerce styles completely
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Centralized URL management
function mixtree_urls($type) {
    $urls = array(
        'level_check' => 'https://mixtreelang.nl/free-english-level-check/',
        'contact' => 'https://mixtreelang.nl/contact-form-request-for-information-english-courses-mixtree-languages/',
        'enrollment' => 'https://mixtreelang.nl/free-english-level-check-enrolment/',
        'intensive' => 'https://mixtreelang.nl/english-course/intensive-english-course/',
        'morning' => 'https://mixtreelang.nl/english-course/morning-english-courses/',
        'beginners' => 'https://mixtreelang.nl/english-course/english-for-beginners/'
    );
    
    return isset($urls[$type]) ? $urls[$type] : '';
}

// Create shortcodes for each
add_shortcode('level_check_url', function() { return mixtree_urls('level_check'); });
add_shortcode('contact_url', function() { return mixtree_urls('contact'); });
add_shortcode('enrollment_url', function() { return mixtree_urls('enrollment'); });
add_shortcode('intensive_url', function() { return mixtree_urls('intensive'); });
add_shortcode('morning_url', function() { return mixtree_urls('morning'); });
add_shortcode('beginners_url', function() { return mixtree_urls('beginners'); });

// Centralized Course Price Management
function mixtree_course_prices($course = '') {
    $prices = array(
        'evening_online' => 385,
        'beginner' => 445,
        'morning' => 525,
        'intensive' => 640
    );
    
    return isset($prices[$course]) ? $prices[$course] : '';
}

// Individual price shortcodes (just numbers)
add_shortcode('price_evening', function() { return mixtree_course_prices('evening_online'); });
add_shortcode('price_beginner', function() { return mixtree_course_prices('beginner'); });
add_shortcode('price_morning', function() { return mixtree_course_prices('morning'); });
add_shortcode('price_intensive', function() { return mixtree_course_prices('intensive'); });

// Formatted price shortcodes (with € symbol)
add_shortcode('price_evening_formatted', function() { return '€' . mixtree_course_prices('evening_online'); });
add_shortcode('price_beginner_formatted', function() { return '€' . mixtree_course_prices('beginner'); });
add_shortcode('price_morning_formatted', function() { return '€' . mixtree_course_prices('morning'); });
add_shortcode('price_intensive_formatted', function() { return '€' . mixtree_course_prices('intensive'); });