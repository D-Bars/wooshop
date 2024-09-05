<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="col-12">
	<?php do_action( 'woocommerce_before_single_product' ); ?>
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'col-12 producr-content-wrapper', $product ); ?>>

	<div class="row">

		<div class="col-md-5 col-lg-4 mb-3">
			<div class="bg-white h-100">
				<div id="carouselExampleFade" class="carousel carousel-dark slide carousel-fade">
					<div class="carousel-inner">
						<?php
						$product_img_id = $product->get_image_id();
						if ( $product_img_id ) {
							$main_img = wp_get_attachment_url( $product_img_id );
						} else {
							$main_img = wc_placeholder_img_src( 'woocommerce_full' );
						}
						$product_img_ids = $product->get_gallery_image_ids();
						?>
						<div class="carousel-item active">
							<img src="<?php echo $main_img; ?>" class="d-block w-100"
								alt="<?php echo $product->get_title(); ?>">
						</div>
						<?php if ( $product_img_ids ): ?>
							<?php foreach ( $product_img_ids as $product_img_id): ?>
								<div class="carousel-item">
									<img src="<?php echo wp_get_attachment_url( $product_img_id ); ?>"
										class="d-block w-100" alt="<?php echo $product->get_title(); ?>">
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<?php if ( $product_img_ids ): ?>
						<button class="carousel-control-prev" type="button"
								data-bs-target="#carouselExampleFade" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button"
								data-bs-target="#carouselExampleFade" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- ./col-md-5 col-lg-4 mb-3 -->

		<div class="col-md-7 col-lg-8 mb-3">
			<div class="bg-white product-content p-3 h-100">
				Content
			</div><!-- ./bg-white product-content p-3 h-100 -->
		</div><!-- ./col-md-7 col-lg-8 mb-3 -->

	</div><!-- ./row -->

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div><!-- ./col-12 producr-content-wrapper -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
