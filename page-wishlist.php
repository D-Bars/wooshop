<?php get_header() ?>

<?php if (have_posts()):
	while (have_posts()):
		the_post(); ?>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<nav class="breadcrumbs">
							<ul>
								<li><a href="<?php echo home_url('/') ?>"><?php _e('Home', 'wooeshop') ?></a></li>
								<li><?php _e('Wishlist', 'wooeshop') ?></li>
							</ul>
						</nav>
					</div>
					<div class="col-12">
						<h1 class="section-title"><span><?php the_title() ?></span></h1>
						<?php
						$wishlist = wooeshop_get_wishlist();
						$wishlist = implode(',', $wishlist);
						?>
						<?php if (!$wishlist) { ?>
							<p><?php echo _e('Wishlist is empty', 'wooeshop'); ?></p>
						<?php } else { ?>
							<?php echo do_shortcode("[products ids='$wishlist' limit=4]"); ?>
						<?php } ?>
					</div>
				</div><!-- ./row -->
			</div><!-- ./container -->
		</main><!-- ./main -->
		<?php the_content(); ?>
	<?php endwhile; else: ?>
	<p>Записей нет.</p>
<?php endif; ?>

<?php get_footer() ?>