<?php get_header(); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-3 col-md-4">
			<?php do_action( 'woocommerce_sidebar' ); ?>
		</div><!-- ./col-lg-3 col-md-4 -->

		<div class="col-lg-9 col-md-8">
			<div class="row">
				<div class="col-12">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 class="woocommerce-products-header__title page-title section-title h3">
							<span><?php woocommerce_page_title(); ?></span>
						</h1>
					<?php endif; ?>
				</div><!-- ./col-12 -->

				<?php do_action( 'woocommerce_archive_description' ); ?>
			</div><!-- ./row -->
		</div><!-- ./col-lg-9 col-md-8 -->

	</div><!-- ./row -->
</div><!-- ./container -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>