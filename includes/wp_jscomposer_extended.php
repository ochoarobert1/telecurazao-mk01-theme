<?php
class VCExtendAddonClass {

    function __construct() {
        // HOOK FOR VC
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // CREATING SHORTCODE
        add_shortcode( 'telecurazao_product_grid', array( $this, 'render_telecurazao_product_grid' ) );

        // CREATING SHORTCODE
        add_shortcode( 'telecurazao_media_grid', array( $this, 'render_telecurazao_media_grid' ) );

        // Register CSS and JS
        //add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );

    }

    public function integrateWithVC() {
        // Check if WPBakery Page Builder is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Extend WPBakery Page Builder is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        $categories_array = array();
        $categories = get_categories(array('taxonomy' => 'product_cat',));
        foreach( $categories as $category ) {
            $categories_array[$category->name] = $category->term_id;
        }

        /* WPBakery Logic Script */
        vc_map( array(
            'name' => __('Telecuracao Custom Product Grid', 'telecurazao'),
            'description' => __('Shortcode for custom product grid', 'telecurazao'),
            'base' => 'telecurazao_product_grid',
            'class' => '',
            'controls' => 'full',
            'icon' => get_template_directory_uri() . '/images/logo-small.png',
            'category' => __('Content', 'js_composer'),

            //'admin_enqueue_js' => get_template_directory_uri() . '/js/wp_composer_extended.js',
            //'admin_enqueue_css' =>  get_template_directory_uri() . '/css/wp_composer_extended.css',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'class' => '',
                    'heading' => __('Product Quantity', 'telecurazao'),
                    'param_name' => 'entry_quantity',
                    'admin_label' => true,
                    'value' => 0    ,
                    'description' => __('Insert quantity of products on the grid.', 'telecurazao')
                ),
                array(
                    'type'        => 'checkbox',
                    'heading'     => __('Category / Categories', 'usaveganmag'),
                    'description' => __('Select Category which this section will be configured', 'telecurazao'),
                    'param_name'  => 'category_selection',
                    'admin_label' => true,
                    'value'       => $categories_array,
                    'std'         => ' ',
                )
            )
        ) );
    }

    /* Shortcode logic how it should be rendered */
    public function render_telecurazao_product_grid( $atts, $content = null ) {
        $output = '';

            extract( shortcode_atts( array( 'entry_quantity' => 'entry_quantity', 'category_selection' => 'category_selection' ), $atts ) );
            if ($entry_quantity == '') { $entry_quantity == -1; }
            $output .= '<div class="container"><div class="row"><div class="custom-product-grid-container col-12">';
            if ($category_selection == '') {
                $product_args = array('post_type' => 'product', 'posts_per_page' => $entry_quantity, 'order' => 'ASC', 'orderby' => 'meta_value_num', 'meta_key' => 'menu_order');
            } else {
                $product_args = array('post_type' => 'product', 'posts_per_page' => $entry_quantity, 'order' => 'ASC', 'orderby' => 'meta_value_num', 'meta_key' => 'menu_order', 'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field'    => 'id', 'terms'    => $category_selection, ), ),);
            }
            $products_array = new WP_Query($product_args);
            if ($products_array->have_posts()) :
            $output .= '<div class="row align-items-center justify-content-center">';
            $i = 1;
            while ($products_array->have_posts()) : $products_array->the_post();
            $output .= '<div class="custom-product-item col">';
            $output .= '<a href="'.get_permalink() .'" title="'. get_the_title() .'"><img src="'. get_the_post_thumbnail_url(get_the_ID(), 'catalog_img').'" class="img-fluid"/></a>';
            $output .= '</div>';
            $i++;
            if ($i > 5) {
                $output .= '<div class="w-100"></div>';
                $i = 1;
            }
            endwhile;
            $output .= '</div>';
            endif;
            wp_reset_query();
            $output .= '</div></div></div>';

        return $output;
    }


    /* Load plugin css and javascript files which you may need on front end of your site */
    //    public function loadCssAndJs() {
    //        wp_register_style( 'telecurazao_style', plugins_url('assets/telecurazao.css', __FILE__) );
    //        wp_enqueue_style( 'telecurazao_style' );
    //
    //        // If you need any javascript files on front end, here is how you can load them.
    //        //wp_enqueue_script( 'telecurazao_js', plugins_url('assets/telecurazao.js', __FILE__), array('jquery') );
    //    }
}

// Finally initialize code
new VCExtendAddonClass();
