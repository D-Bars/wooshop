<?php

// https://woocommerce.com/document/woocommerce-theme-developer-handbook/#section-5
// https://codex.wordpress.org/Theme_Customization_API
// https://woocommerce.com/document/woocommerce-shortcodes/#products

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'wooeshop', get_template_directory() . '/languages' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnail' );

	register_nav_menus(
		array(
			'header-menu' => __( 'Header menu', 'wooeshop' ),
		)
	);
} );

add_action( 'wp_enqueue_scripts', function () {

	wp_enqueue_style( 'wooeshop-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap' );
	wp_enqueue_style( 'wooeshop-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' );
	wp_enqueue_style( 'wooeshop-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' );
	wp_enqueue_style( 'wooeshop-fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css' );
	wp_enqueue_style( 'wooeshop-owlcarousel', get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.css' );
	wp_enqueue_style( 'wooeshop-owlcarousel-theme', get_template_directory_uri() . '/assets/owlcarousel/owl.theme.default.min.css' );
	wp_enqueue_style( 'wooeshop-main', get_template_directory_uri() . '/assets/css/main.css' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'wooeshop-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array(), false, true );
	wp_enqueue_script( 'wooeshop-owlcarousel', get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.js', array(), false, true );
	wp_enqueue_script( 'wooeshop-fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array(), false, true);
	wp_enqueue_script( 'wooeshop-main', get_template_directory_uri() . '/assets/js/main.js', array(), false, true );

	wp_localize_script( 'wooeshop-main','wooeshop_wishlist_object',array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('wooeshop_wishlist_nonce')
	) );

} );

add_action( 'wp_ajax_wooeshop_wishlist_action', 'wooeshop_wishlist_action_cb' );
add_action( 'wp_ajax_nopriv_wooeshop_wishlist_action', 'wooeshop_wishlist_action_cb' );
function wooeshop_wishlist_action_cb (){
	$product_id = (int) $_POST['product_id'];
	$product = wc_get_product($product_id);

	if( ! isset($_POST['nonce']) ){
		echo json_encode( [ 'status' => 'error', 'answer' => __('Security error1', 'wooeshop') ] );
		wp_die();
	}

	if( ! wp_verify_nonce( $_POST['nonce'], 'wooeshop_wishlist_nonce' ) ){
		echo json_encode( [ 'status' => 'error', 'answer' => __('Security error2', 'wooeshop') ] );
		wp_die();
	}

	if( ! $product || $product->get_status() != 'publish'){
		echo json_encode( [ 'status' => 'error', 'answer' => __('Error product', 'wooeshop') ] );
		wp_die();
	}

	$wishlist = wooeshop_get_wishlist();
	wooeshop_dump($wishlist);

	if ( false !== ($key = array_search( $product_id, $wishlist ))){
		unset( $wishlist[$key] );
		$answer = json_encode(['status' => 'success', 'answer' => __('The product has been removed from wishlist', 'wooeshop')]);
	}else{
		if( count($wishlist) >= 4 ){
			array_shift($wishlist);
		}
		$wishlist[] = $product_id;
		$answer = json_encode(['status' => 'success', 'answer' => __('The product has been added to wishlist', 'wooeshop')]);
	}
	$wishlist = implode(',', $wishlist);
	setcookie('wooeshop_wishlist', $wishlist, time() + 3600 * 24 * 30, '/');

	wp_die();
}

function wooeshop_get_wishlist(){
	$wishlist = isset($_COOKIE['wooeshop_wishlist']) ? $_COOKIE['wooeshop_wishlist'] : [];
	if($wishlist){
		$wishlist = explode(',', $wishlist);
	}
	return $wishlist;
}

function wooeshop_in_wishlist($product_id){
	$wishlist = wooeshop_get_wishlist();
	return false !== array_search( $product_id, $wishlist );
}

function wooeshop_dump( $data ) {
	echo "<pre>" . print_r( $data, 1 ) . "</pre>";
}

require_once get_template_directory() . '/incs/woocommerce-hooks.php';
require_once get_template_directory() . '/incs/class-wooeshop-header-menu.php';
require_once get_template_directory() . '/incs/customizer.php';
require_once get_template_directory() . '/incs/cpt.php';


//add customize sidebar
add_action('widgets_init', function(){
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'wooeshop' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar', 'wooeshop' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
});

remove_action('woocommerce_shop_loop_subcategory_title','woocommerce_template_loop_category_title', 10);
add_action('woocommerce_shop_loop_subcategory_title', function($category){
	echo "<h5 class='mt-2 categories-home'>{$category->name}<span>({$category->count})</span></h5>";
});

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);