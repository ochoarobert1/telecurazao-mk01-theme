<?php

/* --------------------------------------------------------------
    ENQUEUE AND REGISTER CSS
-------------------------------------------------------------- */

require_once('includes/wp_enqueue_styles.php');

/* --------------------------------------------------------------
    ENQUEUE AND REGISTER JS
-------------------------------------------------------------- */

if (!is_admin()) add_action('wp_enqueue_scripts', 'my_jquery_enqueue');
function my_jquery_enqueue() {
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
    if ($_SERVER['REMOTE_ADDR'] == '::1') {
        /*- JQUERY ON LOCAL  -*/
        wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', false, '3.3.1', false);
        /*- JQUERY MIGRATE ON LOCAL  -*/
        wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate.min.js',  array('jquery'), '3.0.1', false);
    } else {
        /*- JQUERY ON WEB  -*/
        wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, '3.3.1', false);
        /*- JQUERY MIGRATE ON WEB  -*/
        wp_register_script( 'jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.1.min.js', array('jquery'), '3.0.1', true);
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-migrate');
}

/* NOW ALL THE JS FILES */
require_once('includes/wp_enqueue_scripts.php');

/* --------------------------------------------------------------
    ADD CUSTOM WALKER BOOTSTRAP
-------------------------------------------------------------- */

// WALKER COMPLETO TOMADO DESDE EL NAVBAR COLLAPSE
require_once('includes/class-wp-bootstrap-navwalker.php');

/* --------------------------------------------------------------
    ADD CUSTOM WORDPRESS FUNCTIONS
-------------------------------------------------------------- */

require_once('includes/wp_custom_functions.php');

/* --------------------------------------------------------------
    ADD REQUIRED WORDPRESS PLUGINS
-------------------------------------------------------------- */

require_once('includes/class-tgm-plugin-activation.php');
require_once('includes/class-required-plugins.php');

/* --------------------------------------------------------------
    ADD CUSTOM WOOCOMMERCE OVERRIDES
-------------------------------------------------------------- */

require_once('includes/wp_woocommerce_functions.php');

/* --------------------------------------------------------------
    ADD THEME SUPPORT
-------------------------------------------------------------- */

load_theme_textdomain( 'telecurazao', get_template_directory() . '/languages' );
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio' ));
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'menus' );
add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
add_theme_support( 'custom-background',
                  array(
                      'default-image' => '',    // background image default
                      'default-color' => '',    // background color default (dont add the #)
                      'wp-head-callback' => '_custom_background_cb',
                      'admin-head-callback' => '',
                      'admin-preview-callback' => ''
                  )
                 );

/* --------------------------------------------------------------
    ADD NAV MENUS LOCATIONS
-------------------------------------------------------------- */

register_nav_menus( array(
    'header_menu' => __( 'Menu Header - Principal', 'telecurazao' ),
    'footer_menu' => __( 'Menu Footer - Principal', 'telecurazao' ),
) );

/* --------------------------------------------------------------
    ADD DYNAMIC SIDEBAR SUPPORT
-------------------------------------------------------------- */

add_action( 'widgets_init', 'telecurazao_widgets_init' );
function telecurazao_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Sidebar Principal', 'telecurazao' ),
        'id' => 'main_sidebar',
        'description' => __( 'Estos widgets seran vistos en las entradas y páginas del sitio', 'telecurazao' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

    //    register_sidebar( array(
    //        'name' => __( 'Shop Sidebar', 'telecurazao' ),
    //        'id' => 'shop_sidebar',
    //        'description' => __( 'Estos widgets seran vistos en Tienda y Categorias de Producto', 'telecurazao' ),
    //        'before_widget' => '<li id='%1$s' class='widget %2$s'>',
    //        'after_widget'  => '</li>',
    //        'before_title'  => '<h2 class='widgettitle'>',
    //        'after_title'   => '</h2>',
    //    ) );
}

/* --------------------------------------------------------------
    CUSTOM ADMIN LOGIN
-------------------------------------------------------------- */

function custom_admin_styles() {
    $version_remove = NULL;
    wp_register_style('wp-admin-style', get_template_directory_uri() . '/css/custom-wordpress-admin-style.css', false, $version_remove, 'all');
    wp_enqueue_style('wp-admin-style');
}
add_action('login_head', 'custom_admin_styles');
add_action('admin_init', 'custom_admin_styles');


function dashboard_footer() {
    echo '<span id="footer-thankyou">';
    _e ('Gracias por crear con ', 'telecurazao' );
    echo '<a href="http://wordpress.org/" target="_blank">WordPress.</a> - ';
    _e ('Tema desarrollado por ', 'telecurazao' );
    echo '<a href="http://robertochoa.com.ve/?utm_source=footer_admin&utm_medium=link&utm_content=telecurazao" target="_blank">Robert Ochoa</a></span>';
}
add_filter('admin_footer_text', 'dashboard_footer');

/* --------------------------------------------------------------
    ADD CUSTOM METABOX
-------------------------------------------------------------- */

require_once('includes/wp_custom_metabox.php');

/* --------------------------------------------------------------
    ADD CUSTOM POST TYPE
-------------------------------------------------------------- */

require_once('includes/wp_custom_post_type.php');

/* --------------------------------------------------------------
    ADD CUSTOM THEME CONTROLS
-------------------------------------------------------------- */

require_once('includes/wp_custom_theme_control.php');

/* --------------------------------------------------------------
    ADD CUSTOM IMAGE SIZE
-------------------------------------------------------------- */
if ( function_exists('add_theme_support') ) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size( 9999, 400, true);
}
if ( function_exists('add_image_size') ) {
    add_image_size('avatar', 100, 100, true);
    add_image_size('blog_img', 276, 217, true);
    add_image_size('single_img', 636, 297, true );
    add_image_size('catalog_img', 186, 248, true);
}

/* --------------------------------------------------------------
    ADD CUSTOM FUNCTIONS FOR CONSTRUCTOR
-------------------------------------------------------------- */

if( class_exists( 'Vc_Manager' ) ) {
    require_once('includes/wp_jscomposer_extended.php');
}

/* --------------------------------------------------------------
    ADD CUSTOM AJAX HANDLER
-------------------------------------------------------------- */

add_action( 'wp_ajax_md_support_save','md_support_save' );
add_action( 'wp_ajax_nopriv_md_support_save','md_support_save' );


function md_support_save(){
    $support_title = !empty($_POST['supporttitle']) ?
        $_POST['supporttitle'] : 'Support Title';

    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    // echo $_FILES["upload"]["name"];
    $uploadedfile = $_FILES['file'];
    $upload_overrides = array('test_form' => false);
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        echo $movefile['url'];
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        echo $movefile['error'];
    }
    die();
}

add_filter( 'manage_product_posts_columns', 'add_columns' );
/**
 * Add columns to management page
 *
 * @param array $columns
 *
 * @return array
 */
function add_columns( $columns )
{
    $columns['menu_order'] = 'Menu Order';
    return $columns;
}

add_action( 'manage_product_posts_custom_column', 'columns_content', 10, 2 );

/**
 * Set content for columns in management page
 *
 * @param string $column_name
 * @param int $post_id
 *
 * @return void
 */
function columns_content( $column_name, $post_id )
{
    if ( 'menu_order' != $column_name )
    {
        return;
    }
    $menu_order = get_post_meta( $post_id, 'menu_order', true );
    echo $menu_order;
}

add_action( 'quick_edit_custom_box', 'quick_edit_add', 10, 2 );

/**
 * Add Headline news checkbox to quick edit screen
 *
 * @param string $column_name Custom column name, used to check
 * @param string $post_type
 *
 * @return void
 */
function quick_edit_add( $column_name, $post_type )
{
    if ( 'menu_order' != $column_name )
    {
        return;
    }

    $data = get_post_meta( $post->ID, 'menu_order', true );
    $data = empty( $data ) ? 0 : $data;

    echo '<fieldset class="inline-edit-col-center inline-edit-categories"><div class="inline-edit-col"><label><span class="title">Menu Order</span><span class="input-text-wrap"><input type="number" name="menu_order" class="menu_order ptitle" value="'.$data.'"/></span></label></div></fieldset>';
}





add_action( 'save_post', 'save_quick_edit_data' );

/**
 * Save quick edit data
 *
 * @param int $post_id
 *
 * @return void|int
 */
function save_quick_edit_data( $post_id )
{
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    {
        return $post_id;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) || 'product' != $_POST['post_type'] )
    {
        return $post_id;
    }

    $data = empty( $_POST['menu_order'] ) ? 0 : $_POST['menu_order'];
    update_post_meta( $post_id, 'menu_order', $data );
}

add_action( 'admin_footer', 'quick_edit_javascript' );

/**
 * Write javascript function to set checked to headline news checkbox
 *
 * @return void
 */
function quick_edit_javascript()
{
    global $current_screen;
    if ( 'product' != $current_screen->post_type )
    {
        return;
    }
?>
<script type="text/javascript">
    function checked_headline_news(fieldValue) {
        inlineEditPost.revert();
        jQuery('.menu_order').val(fieldValue);
    }

</script>
<?php
}

add_filter( 'post_row_actions', 'expand_quick_edit_link', 10, 2 );

/**
 * Pass headline news value to checked_headline_news javascript function
 *
 * @param array $actions
 * @param array $post
 *
 * @return array
 */
function expand_quick_edit_link( $actions, $post )
{
    global $current_screen;

    if ( 'product' != $current_screen->post_type )
    {
        return $actions;
    }

    $data                               = get_post_meta( $post->ID, 'menu_order', true );
    $data                               = empty( $data ) ? 0 : $data;
    $actions['inline hide-if-no-js']    = '<a href="#" class="editinline" title="';
    $actions['inline hide-if-no-js']    .= esc_attr( 'Edit this item inline' ) . '"';
    $actions['inline hide-if-no-js']    .= " onclick=\"checked_headline_news('{$data}')\" >";
    $actions['inline hide-if-no-js']    .= 'Quick Edit';
    $actions['inline hide-if-no-js']    .= '</a>';

    return $actions;
}

add_filter('pre_get_posts', 'pre_get_posts_hook' );

function pre_get_posts_hook($wp_query) {
    if (!is_admin()) {
        if ( is_archive('product') && $wp_query->is_main_query() ) { //edited this line
            $wp_query->set( 'orderby', 'meta_value_num' );
            $wp_query->set( 'meta_key', 'menu_order' );
            $wp_query->set( 'order', 'ASC' );
            return $wp_query;
        }
    }
}


function add_footer_script () {
    $options = get_theme_mod('telecuracao_custom_script');
    echo $options['adsense'];
}

add_action('wp_footer', 'add_footer_script');

add_action('admin_enqueue_scripts', 'telecuracao_shop_order_scripts', 99);

function telecuracao_shop_order_scripts() {
    $version_remove = NULL;
    global $post_type;
    if( 'shop_order' == $post_type ) {
        wp_register_script('admin-functions', get_template_directory_uri() . '/js/admin-functions.js', array('jquery'), $version_remove, true);
        wp_enqueue_script('admin-functions');

        wp_localize_script('admin-functions', 'custom_admin_url', array(
            'custom_ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}

add_action('wp_ajax_ajax_generate_json_file', 'ajax_generate_json_file_handler');

function ajax_generate_json_file_handler() {
    $order_id = $_POST['order_id'];
    $order = wc_get_order( $order_id );

    $order_data = $order->get_data(); // The Order data

    $order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
    $order_discount_total = $order_data['discount_total'];
    $order_total = $order_data['cart_tax'];
    $order_total_tax = $order_data['total_tax'];
    $order_billing_first_name = $order_data['billing']['first_name'];
    $order_billing_last_name = $order_data['billing']['last_name'];
    $order_billing_email = $order_data['billing']['email'];
    $tax_id = get_post_meta($order_id, 'tax_id', true);


    foreach ($order->get_items() as $item_key => $item ):

    $item_id = $item->get_id();

    $item_data    = $item->get_data();

//    var_dump($item_data);

    $product_name = $item_data['name'];
    $product_id   = $item_data['product_id'];
    $quantity     = $item_data['quantity'];
    $line_total        = $item_data['total'];

    $product        = $item->get_product(); // Get the WC_Product object
    $product_sku    = $product->get_sku();

    endforeach;

    $json_generate = array(
        'COD_CIA' => 1,
        'PRODUCTO' => $product_name,
        'FECHA_INSERCION' => $order_date_created,
        'NO_PAUTA' => '0',
        'BRUTO' => $line_total,
        'DESCUENTO_MONTO' => $order_discount_total,
        'SUBTOTAL' => $order_total,
        'ITBMS' => '0',
        'TOTAL' => $order_total_tax,
        'RUC_CLIENTE' => $tax_id,
        'NOMBRE_CLIENTE' => $order_billing_first_name . ' ' . $order_billing_last_name,
        'TOT_PAUTAS' => $quantity,
        'detalle' => array(
            'TIPO' => 'P',
            'COD_PROGRAMA' => $product_id,
            'COD_PAQUETE' => null,
            'VERSION_PAQUETE' => null,
            'COD_PROD_C' => $product_name,
            'COD_CUNA' => $product_id,
            'DESCRIPCION_CUNA' => $product_name,
            'DURACION' => '30',
            'FECHA_REAL' => '2019/12/19',
            'CANTIDAD' => $quantity,
            'MONTOTARIFA' => $line_total,
            'DESCUENTO_MONTO' => '0',
            'RENGLON' => '1',
            'USUARIO_APROBACION' => $order_billing_first_name . ' ' . $order_billing_last_name,
            'USUARIO_CORREO' => $order_billing_email,
            'COMENTARIOS' => null
        )
    );

    $json_encoded = json_encode($json_generate);

    echo $json_encoded;

    wp_die();
}
