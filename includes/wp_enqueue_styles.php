<?php
function telecurazao_load_css() {
    $version_remove = NULL;
    if (!is_admin()){
        if ($_SERVER['REMOTE_ADDR'] == '::1') {

            /*- BOOTSTRAP CORE ON LOCAL -*/
            wp_register_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4.1.0', 'all');
            wp_enqueue_style('bootstrap-css');

            /*- ANIMATE CSS ON LOCAL -*/
            wp_register_style('animate-css', get_template_directory_uri() . '/css/animate.css', false, '3.5.2', 'all');
            wp_enqueue_style('animate-css');

            /*- FONT AWESOME ON LOCAL -*/
            wp_register_style('fontawesome-css', get_template_directory_uri() . '/css/font-awesome.min.css', false, '4.7.0', 'all');
            wp_enqueue_style('fontawesome-css');

            /*- FLICKITY ON LOCAL -*/
            //wp_register_style('flickity-css', get_template_directory_uri() . '/css/flickity.min.css', false, '2.1.1', 'all');
            //wp_enqueue_style('flickity-css');

            /*- OWL ON LOCAL -*/
            //wp_register_style('owl-css', get_template_directory_uri() . '/css/owl.carousel.min.css', false, '2.3.4', 'all');
            //wp_enqueue_style('owl-css');

            /*- OWL ON LOCAL - NORMAL THEME -*/
            //wp_register_style('owltheme-css', get_template_directory_uri() . '/css/owl.theme.default.min.css', false, '2.3.4', 'all');
            //wp_enqueue_style('owltheme-css');

            /*- AOS ON LOCAL -*/
            wp_register_style('aos-css', get_template_directory_uri() . '/css/aos.css', false, '3.0.0', 'all');
            wp_enqueue_style('aos-css');


        } else {

            /*- BOOTSTRAP CORE -*/
            wp_register_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css', false, '4.1.0', 'all');
            wp_enqueue_style('bootstrap-css');

            /*- ANIMATE CSS -*/
            wp_register_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css', false, '3.5.2', 'all');
            wp_enqueue_style('animate-css');

            /*- FONT AWESOME -*/
            wp_register_style('fontawesome-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0', 'all');
            wp_enqueue_style('fontawesome-css');

            /*- FLICKITY -*/
            //wp_register_style('flickity-css', 'https://cdnjs.cloudflare.com/ajax/libs/flickity/2.1.1/flickity.min.css', false, '2.1.1', 'all');
            //wp_enqueue_style('flickity-css');

            /*- OWL -*/
            //wp_register_style('owl-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', false, '2.3.4', 'all');
            //wp_enqueue_style('owl-css');

            /*- OWL - THEME DEFAULT -*/
            //wp_register_style('owltheme-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', false, '2.3.4', 'all');
            //wp_enqueue_style('owltheme-css');

            /*- AOS -*/
            wp_register_style('aos-css', 'https://unpkg.com/aos@next/dist/aos.css', false, '3.0.0', 'all');
            wp_enqueue_style('aos-css');
        }

        /*- GOOGLE FONTS -*/
        wp_register_style('google-fonts', 'https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,800,900', false, $version_remove, 'all');
        wp_enqueue_style('google-fonts');

        /*- MAIN STYLE -*/
        wp_register_style('bootstrap-datpicker-main', get_template_directory_uri() . '/css/bootstrap-datepicker.min.css', false, $version_remove, 'all');
        wp_enqueue_style('bootstrap-datpicker-main');

        /*- MAIN STYLE -*/
        wp_register_style('bootstrap-datpicker-standalone', get_template_directory_uri() . '/css/bootstrap-datepicker.standalone.min.css', false, $version_remove, 'all');
        wp_enqueue_style('bootstrap-datpicker-standalone');

        /*- MAIN STYLE -*/
        wp_register_style('main-style', get_template_directory_uri() . '/css/telecurazao-style.css', false, $version_remove, 'all');
        wp_enqueue_style('main-style');

        /*- MAIN MEDIAQUERIES -*/
        wp_register_style('main-mediaqueries', get_template_directory_uri() . '/css/telecurazao-mediaqueries.css', array('main-style'), $version_remove, 'all');
        wp_enqueue_style('main-mediaqueries');

        /*- WORDPRESS STYLE -*/
        wp_register_style('wp-initial-style', get_template_directory_uri() . '/style.css', false, $version_remove, 'all');
        wp_enqueue_style('wp-initial-style');
    }
}

add_action('wp_enqueue_scripts', 'telecurazao_load_css');
