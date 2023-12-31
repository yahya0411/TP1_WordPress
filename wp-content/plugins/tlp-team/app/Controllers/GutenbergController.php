<?php
/**
 * Gutenberg Controller Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Controllers;

use RT\Team\Helpers\Fns;
use RT\Team\Controllers\Frontend\Blocks\Blocks;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Gutenberg Controller Class.
 */
class GutenbergController {
	use \RT\Team\Traits\SingletonTrait;

	/**
	 * Class Init.
	 *
	 * @return void
	 */
	protected function init() {
		add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_assets' ] );

		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				'rttpg/tlp-team-pro',
				[
					'render_callback' => [ __CLASS__, 'render_shortcode' ],
				]
			);
		}
	}

	/**
	 * Render Shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string|void
	 */
	public static function render_shortcode( $atts ) {
		if ( ! empty( $atts['gridId'] ) ) {
			return do_shortcode( '[tlpteam id="' . absint( $atts['gridId'] ) . '"]' );
		}
	}

	/**
	 * Block Assets.
	 *
	 * @return void
	 */
	public function block_assets() {
		wp_enqueue_style( 'wp-blocks' );
	}

	/**
	 * Block Editor Assets.
	 *
	 * @return void
	 */
	public function block_editor_assets() {
		// Scripts.
		wp_enqueue_script(
			'rt-team-cgb-block-js',
			rttlp_team()->assets_url() . 'js/tlp-team-blocks.min.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element' ],
			( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : TLP_TEAM_VERSION,
			true
		);
		wp_localize_script(
			'rt-team-cgb-block-js',
			'rtTeam',
			[
				'short_codes' => Fns::getTTPShortcodeList(),
				'icon'        => rttlp_team()->assets_url() . 'images/team.png',
			]
		);
		wp_enqueue_style( 'wp-edit-blocks' );
	}
}
