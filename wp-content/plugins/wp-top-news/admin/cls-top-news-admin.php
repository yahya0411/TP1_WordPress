<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
@ Admin Panel Parent Class
*/
class WTN_Admin 
{
	use Wtn_API, Wtn_Core, Wtn_Country, Wtn_General_Settings, Wtn_Cache,
	Wtn_Int_General_Settings, 
	Wtn_Int_Featured_General_Settings, 
	Wtn_Int_Ticker_Content_Settings, Wtn_Int_Ticker_Styles_Settings;
	protected $wtn_version;
	protected $wtn_assets_prefix;

	function __construct( $version ){
		$this->wtn_version = $version;
		$this->wtn_assets_prefix = substr(WTN_PRFX, 0, -1) . '-';
	}

	/*
	@	Loading admin panel styles
	*/
	function wtn_enqueue_assets() {
		
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_style(
			$this->wtn_assets_prefix . 'font-awesome', 
			WTN_ASSETS .'css/fontawesome/css/all.min.css',
			array(),
			$this->wtn_version,
			FALSE
		);

		wp_enqueue_style(
			'wtn-admin', 
			WTN_ASSETS . 'css/wtn-admin.css', 
			array(), 
			$this->wtn_version, 
			FALSE 
		);
		
		if ( ! wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}

		wp_enqueue_script(
			'wtn-admin', 
			WTN_ASSETS . 'js/wtn-admin.js', 
			array('jquery'), 
			$this->wtn_version, 
			true 
		);
	}

	/*
	@	Loading the admin menu
	*/
	function wtn_admin_menu(){
		
		add_menu_page(  
			__('WP Top News', 'wp-top-news'),
			__('WP Top News', 'wp-top-news'),
			'manage_options',
			'wp-top-news',
			array( $this, 'wtn_get_help' ),
			'dashicons-admin-site-alt',
			100 
		);
		
		add_submenu_page( 	
			'wp-top-news', 
			__('API Settings', 'wp-top-news'), 
			__('API Settings', 'wp-top-news'), 
			'manage_options', 
			'wtn-api-settings', 
			array( $this, WTN_PRFX . 'api_settings' )
		);

		add_submenu_page( 	
			'wp-top-news', 
			__('Settings', 'wp-top-news'), 
			__('General Settings', 'wp-top-news'), 
			'manage_options', 
			'wtn-settings', 
			array( $this, 'wtn_general_settings' )
		);

		add_submenu_page(
			'wp-top-news',
			__( 'Manage Cache', 'wp-top-news' ),
			__( 'Manage Cache', 'wp-top-news' ),
			'manage_options',
			'wtn-clear-cache',
			array( $this, 'wtn_manage_cache' )
		);

		add_submenu_page(
			'wp-top-news',
			__( 'Usage & Tutorial', 'wp-top-news' ),
			__( 'Usage & Tutorial', 'wp-top-news' ),
			'manage_options',
			'wtn-get-help',
			array( $this, 'wtn_get_help' )
		);

		$wtn_cpt_menu = 'edit.php?post_type=wtn_news';

		add_submenu_page(
			$wtn_cpt_menu,
			__('Settings', 'wp-top-news'),
			__('Settings', 'wp-top-news'),
			'manage_options',
			'wtn-inernal-settings',
			array($this, 'wtn_internal_settings'),
			9
		);

		add_submenu_page(
			$wtn_cpt_menu,
			__('Featured Settings', 'wp-top-news'),
			__('Featured Settings', 'wp-top-news'),
			'manage_options',
			'wtn-featured-settings',
			array($this, 'wtn_featured_settings')
		);

		add_submenu_page(
			$wtn_cpt_menu,
			__('Ticker Settings', 'wp-top-news'),
			__('Ticker Settings', 'wp-top-news'),
			'manage_options',
			'wtn-ticker-settings',
			array($this, 'wtn_ticker_settings')
		);

		add_submenu_page(
			$wtn_cpt_menu,
			__('How it works', 'wp-top-news'),
			__('How it works', 'wp-top-news'),
			'manage_options',
			'wtn-how-it-works',
			array($this, 'wtn_help_usage_settings')
		);
    }

	/**
	 *	Function For Loading News Custom Post Type
	 */
	function wtn_custom_post_type() {

		$labels = array(
							'name'                => __('All News', 'wp-top-news'),
							'singular_name'       => __('WP News', 'wp-top-news'),
							'menu_name'           => __('News', 'wp-top-news'),
							'parent_item_colon'   => __('Parent News', 'wp-top-news'),
							'all_items'           => __('All News', 'wp-top-news'),
							'view_item'           => __('View News', 'wp-top-news'),
							'add_new_item'        => __('Add News', 'wp-top-news'),
							'add_new'             => __('Add News Item', 'wp-top-news'),
							'edit_item'           => __('Edit News', 'wp-top-news'),
							'update_item'         => __('Update News', 'wp-top-news'),
							'search_items'        => __('Search News', 'wp-top-news'),
							'not_found'           => __('Not Found', 'wp-top-news'),
							'not_found_in_trash'  => __('Not found in Trash', 'wp-top-news')
						);
		$args = array(
						'label'               => __('wtn_news', 'wp-top-news'),
						'description'         => __('Description For News', 'wp-top-news'),
						'labels'              => $labels,
						'supports'            => array('title', 'editor', 'thumbnail', 'author', 'page-attributes'),
						'public'              	=> true, // hide all metabox
						'hierarchical'        	=> true,
						'show_ui'             	=> true,
						'show_in_menu'        	=> true,
						'show_in_nav_menus'   	=> true,
						'show_in_admin_bar'   	=> true,
						'has_archive'         	=> true,
						'has_category'         	=> true, 
						'can_export'          	=> true,
						'exclude_from_search' 	=> false,
						'yarpp_support'       	=> true,
						'publicly_queryable'  	=> true,
						'capability_type'       => 'post',
						'menu_icon'           	=> 'dashicons-rss',
						'query_var' 		  	=> true,
						'taxonomies'  			=> array( 'post_tag' ),
						'rewrite'				=> array('slug' => 'news'),
					);

		register_post_type('wtn_news', $args);
	}

	function wtn_register_taxonomy() {

		$labels = array(
			'name' 				=> __('News Categories', 'wp-top-news'),
			'singular_name' 	=> __('News Category', 'wp-top-news'),
			'search_items' 		=> __('Search News Categories', 'wp-top-news'),
			'all_items' 		=> __('All News Categories', 'wp-top-news'),
			'parent_item' 		=> __('Parent News Category', 'wp-top-news'),
			'parent_item_colon'	=> __('Parent News Category:', 'wp-top-news'),
			'edit_item' 		=> __('Edit News Category', 'wp-top-news'),
			'update_item' 		=> __('Update News Category', 'wp-top-news'),
			'add_new_item' 		=> __('Add New News Category', 'wp-top-news'),
			'new_item_name' 	=> __('New News Category Name', 'wp-top-news'),
			'menu_name' 		=> __('News Categories', 'wp-top-news'),
		);

		register_taxonomy('news_category', array('wtn_news'), array(
			'hierarchical' 		=> true,
			'labels' 			=> $labels,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true,
			'sort'				=> true,
			'rewrite' 			=> array('slug' => 'news-category'),
			'default_term'      => [ 
				'name' => 'Politics',
				'slug' => 'politics',
				'description' => 'Politics News',
			],
		));
	}

	function wtn_news_metaboxes() {

		add_meta_box(
			'wtn_news_details_link',
			__('News Information', 'wp-top-news'),
			array( $this, 'wtn_news_details_content' ),
			'wtn_news',
			'normal',
			'high'
		);
	}

	function wtn_news_details_content() {

		wp_nonce_field( basename(__FILE__), 'wtn_news_fields' );
	
		require_once WTN_PATH . 'admin/view/partial/news-information.php';
	}

	/**
	 * Save books information meta data
	 */
	function wtn_save_news_meta( $post_id ) {

		global $post;

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( ! isset( $_POST['wtn_status'] ) || ! wp_verify_nonce( $_POST['wtn_news_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		$wtn_news_meta_posts = $_POST;

		$wtn_news_meta_params = [
			'wtn_status'		=> isset( $_POST['wtn_status'] ) ? sanitize_text_field( $_POST['wtn_status'] ) : '',
			'wtn_is_breaking'	=> isset( $_POST['wtn_is_breaking'] ) ? sanitize_text_field( $_POST['wtn_is_breaking'] ) : '',
			'wtn_is_hero'		=> isset( $_POST['wtn_is_hero'] ) ? sanitize_text_field( $_POST['wtn_is_hero'] ) : '',
			'wtn_is_featured'	=> isset( $_POST['wtn_is_featured'] ) ? sanitize_text_field( $_POST['wtn_is_featured'] ) : '',
		];

		$wtn_news_meta = apply_filters( 'wtn_news_meta', $wtn_news_meta_params, $wtn_news_meta_posts );

		foreach ( $wtn_news_meta as $key => $value ) {
			
			if ( 'revision' === $post->post_type ) {
				return;
			}

			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value );
			}

			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}
		}
	}

	function wtn_help_usage_settings() {
		require_once WTN_PATH . 'admin/view/help.php';
	}

	
	function wtn_internal_settings() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';

		$wtnInfoMessage = false;

		if ( isset( $_POST['updateGeneralSettings'] ) ) {
			if ( ! isset( $_POST['wtn_general_content_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wtn_general_content_nonce_field'], 'wtn_general_content_action' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				$wtnInfoMessage = $this->wtn_int_set_general_settings( $_POST );
			}
		}

        $wtnSettingsContent = $this->wtn_int_get_general_settings();

		require_once WTN_PATH . 'admin/view/settings.php';
	}

	function wtn_featured_settings() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';

		$wtnInfoMessage = false;

		if ( isset( $_POST['updateGeneralSettings'] ) ) {
			if ( ! isset( $_POST['wtn_featured_content_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wtn_featured_content_nonce_field'], 'wtn_featured_content_action' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				$wtnInfoMessage = $this->wtn_int_set_featured_general_settings( $_POST );
			}
		}

        $wtnSettingsContent = $this->wtn_int_get_featured_general_settings();

		require_once WTN_PATH . 'admin/view/featured.php';
	}

	function wtn_ticker_settings() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';

		$wtnInfoMessage = false;

		if ( isset( $_POST['updateTickerContentSettings'] ) ) {
			if ( ! isset( $_POST['wtn_ticker_content_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wtn_ticker_content_nonce_field'], 'wtn_ticker_content_action' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				$wtnInfoMessage = $this->wtn_int_set_ticker_content_settings( $_POST );
			}
		}

		if ( isset( $_POST['updateTickerStylesSettings'] ) ) {
			if ( ! isset( $_POST['wtn_ticker_style_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wtn_ticker_style_nonce_field'], 'wtn_ticker_style_action' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				$wtnInfoMessage = $this->wtn_int_set_ticker_styles_settings( $_POST );
			}
		}

        $wtnTickerContentSettings = $this->wtn_int_get_ticker_content_settings();
		$wtnTickerStylesSettings = $this->wtn_int_get_ticker_styles_settings();

		require_once WTN_PATH . 'admin/view/ticker.php';
	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function wtn_general_settings() {

		$wtnShowMessage = false;

		if ( isset( $_POST['updateGeneralSettings'] ) ) {
			if ( ! isset( $_POST['wtn_int_general_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['wtn_int_general_nonce_field'], 'wtn_int_general_action' ) ) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				$wtnShowMessage = $this->wtn_set_general_settings( $_POST );
			}
		}

        $wtnGeneralSettings = $this->wtn_get_general_settings();

		require_once WTN_PATH . 'admin/view/general-settings.php';
	}
	
	function wtn_api_settings() {

		require_once WTN_PATH . 'admin/view/api-settings.php';
    }

	function wtn_get_help() {
        require_once WTN_PATH . 'admin/view/help-usage.php';
    }

	function wtn_manage_cache() {
		require_once WTN_PATH . 'admin/view/manage-cache.php';
	}

	protected function wtn_display_notification( $type, $msg ) { 
		?>
		<div class="wtn-alert <?php esc_attr_e( $type ); ?>">
			<span class="wtn-closebtn">&times;</span> 
			<strong><?php esc_html_e( ucfirst( $type ) ); ?>!</strong> <?php esc_html_e( $msg ); ?>
		</div>
		<?php 
	}
}
?>