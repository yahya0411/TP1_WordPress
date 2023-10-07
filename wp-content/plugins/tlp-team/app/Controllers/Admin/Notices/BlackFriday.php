<?php
/**
 * Black Friday Notice Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Controllers\Admin\Notices;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Black Friday Notice Class.
 */
class BlackFriday {
	use \RT\Team\Traits\SingletonTrait;

	/**
	 * Class Init.
	 *
	 * @return void
	 */
	protected function init() {
		$current      = time();
		$black_friday = mktime( 0, 0, 0, 11, 18, 2022 ) <= $current && $current <= mktime( 0, 0, 0, 1, 15, 2023 );

		if ( ! $black_friday ) {
			return;
		}

		add_action( 'admin_init', [ $this, 'bf_notice' ] );
	}

	/**
	 * Black Friday Notice.
	 *
	 * @return void|string
	 */
	public function bf_notice() {
		if ( get_option( 'rtteam_ny_2023' ) != '1' ) {
			if ( ! isset( $GLOBALS['rt_team_ny_2023_notice'] ) ) {
				$GLOBALS['rt_team_ny_2023_notice'] = 'rtteam_ny_2023';
				self::notice();
			}
		}
	}

	/**
	 * Render Notice
	 *
	 * @return void
	 */
	private static function notice() {

		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_script( 'jquery' );
			}
		);

		add_action(
			'admin_notices',
			function () {
				$plugin_name   = 'Team Pro';
				$download_link = rttlp_team()->pro_version_link();
				?>
                <style>
                    .team_page_tlp_team_get_help .rttm-black-friday {
                        margin-left: 2px;
                        margin-top: 15px;
                    }
                </style>
				<div class="notice notice-info is-dismissible rttm-black-friday" data-rtteamdismissable="rtteam_ny_2023"
					style="display:grid;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;">
					<img alt="<?php echo esc_attr( $plugin_name ); ?>"
						src="<?php echo esc_url( rttlp_team()->assets_url() . 'images/team-pro-gif.gif' ); ?>" width="74px"
						height="74px" style="grid-row: 1 / 4; align-self: center;justify-self: center"/>
					<h3 style="margin:0;"><?php echo sprintf( '%s New Year Deal!!', esc_html( $plugin_name ) ); ?></h3>

					<p style="margin:0 0 2px;">
					<?php echo esc_html__( "Don't miss out on our biggest sale of the year! Get yours.", 'tlp-team' ); ?>
						<b><?php echo esc_html( $plugin_name ); ?> plan</b> with <b>UP TO 50% OFF</b>! Limited time offer!!!
					</p>

					<p style="margin:0;" class="rttm-btn-wrapper">
						<a class="button button-primary" href="<?php echo esc_url( $download_link ); ?>" target="_blank">Buy Now</a>
						<a class="button button-dismiss" href="#">Dismiss</a>
					</p>
				</div>
					<?php
			}
		);

		add_action(
			'admin_footer',
			function () {
				?>
				<script type="text/javascript">
					(function ($) {
						$(function () {
							setTimeout(function () {
								$('div[data-rtteamdismissable] .notice-dismiss, div[data-rtteamdismissable] .button-dismiss')
									.on('click', function (e) {
										e.preventDefault();
										$.post(ajaxurl, {
											'action': 'rtteam_dismiss_admin_notice',
											'nonce': <?php echo json_encode( wp_create_nonce( 'rtteam-dismissible-notice' ) ); ?>
										});
										$(e.target).closest('.is-dismissible').remove();
									});
							}, 1000);
						});
					})(jQuery);
				</script>
				<?php
			}
		);

		add_action(
			'wp_ajax_rtteam_dismiss_admin_notice',
			function () {
				check_ajax_referer( 'rtteam-dismissible-notice', 'nonce' );

				update_option( 'rtteam_ny_2023', '1' );
				wp_die();
			}
		);
	}
}
