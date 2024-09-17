<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>
<?php do_action('woocommerce_before_main_content'); ?>

<div class="col-12 mb-3">
	<div class="p-3 bg-white h-100">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php do_action('woocommerce_account_navigation'); ?>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="woocommerce-MyAccount-content">
					<?php do_action('woocommerce_account_content'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php do_action('woocommerce_after_main_content'); ?>