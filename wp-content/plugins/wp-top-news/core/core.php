<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Core
*/
trait Wtn_Core
{
    protected $data;

	protected function wtn_admin_sidebar() {
		?>
		<div class="wtn-admin-sidebar" style="width: 20%; float: left;">
			<div class="postbox pro-features">
				<h3 class="hndle"><span>Pro Features</span></h3>
				<div class="inside centered">
					<ul>
						<li>&#10003; Display Ticker News For Internal and External News</li>
						<li>&#10003; Display Hero News Section</li>
						<li>&#10003; Display Internal Featured News</li>
						<li>&#10003; More News Sources for External News</li>
						<li>&#10003; Display External News of a Country</li>
						<li>&#10003; Lots of Shortcoded Options</li>
					</ul>
					<p style="margin-bottom: 1px! important;"><a href="https://topnewswp.com/" target="_blank" class="button button-primary wtn-button" style="background: #F5653E;">Upgrade Now!</a></p>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span>Support / Bug / Customization</span></h3>
				<div class="inside centered">
					<p>Please feel free to let us know if you have any bugs to report. Your report / suggestion can make the plugin awesome!</p>
					<p style="margin-bottom: 1px! important;"><a href="https://topnewswp.com/" target="_blank" class="button button-primary wtn-button">Get Support</a></p>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span>Join HM Plugin on facebook</span></h3>
                <div class="inside centered">
                    <p style="margin-bottom: 1px! important;"><a href='https://wwww.facebook.com/hmplugin' class="button button-info" target="_blank">Join HM Plugin<span class="dashicons dashicons-facebook" style="position: relative; top: 3px; margin-left: 3px; color: #0fb9da;"></span></a></p>
                </div>
				<div class="inside centered">
					<a href="https://twitter.com/hmplugin" target="_blank" class="button button-secondary">Follow @hmplugin<span class="dashicons dashicons-twitter" style="position: relative; top: 3px; margin-left: 3px; color: #0fb9da;"></span></a>
				</div>
				<div class="inside centered">
					<a href="http://www.youtube.com/channel/UC9UVmN-KZ6iuZypToFp_YTQ?sub_confirmation=1" target="_blank" class="button button-secondary">Subscribe HM Plugin<span class="dashicons dashicons-youtube" style="position: relative; top: 3px; margin-left: 3px; color: #CC0000;"></span></a>
				</div>
			</div>
		</div> 
		<?php
	}

	protected function wtn_build_set_settings_options( $fields, $post ) {

		$this->data = [];

		$i=0;
        foreach ( $fields as $field => $value ) {

            if ( 'string' === $fields[$i]['type'] ) {

                $this->data[$fields[$i]['name']] = isset( $post[$fields[$i]['name']] ) && filter_var( $post[$fields[$i]['name']], FILTER_SANITIZE_STRING ) ? $post[$fields[$i]['name']] : $fields[$i]['default'];

            }
            if ( 'number' === $fields[$i]['type'] ) {

                $this->data[$fields[$i]['name']] = isset( $post[$fields[$i]['name']] ) && filter_var( $post[$fields[$i]['name']], FILTER_SANITIZE_NUMBER_INT ) ? $post[$fields[$i]['name']] : $fields[$i]['default'];

            }
            if ( 'boolean' === $fields[$i]['type'] ) {

                $this->data[$fields[$i]['name']] = isset( $post[$fields[$i]['name']] ) ? $post[$fields[$i]['name']] : $fields[$i]['default'];

            }
            if ( 'text' === $this->fields[$i]['type'] ) {

                $this->data[$this->fields[$i]['name']] = isset( $post[$this->fields[$i]['name']] ) ? sanitize_text_field( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'];

            }
            if ( 'textarea' === $this->fields[$i]['type'] ) {

                $this->data[$this->fields[$i]['name']] = isset( $post[$this->fields[$i]['name']] ) ? sanitize_textarea_field( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'];

            }
            if ( 'email' === $this->fields[$i]['type'] ) {

                $this->data[$this->fields[$i]['name']] = isset( $post[$this->fields[$i]['name']] ) ? sanitize_email( $post[$this->fields[$i]['name']] ) : $this->fields[$i]['default'];

            }
            $i++;
        }

		return $this->data;
	}

	protected function wtn_build_get_settings_options( $fields, $settings ) {
		
		$this->data = [];
        $i=0;

        foreach ( $fields as $option => $value ) {
            $this->data[$fields[$i]['name']]  = isset( $settings[$fields[$i]['name']] ) ? $settings[$fields[$i]['name']] : $fields[$i]['default'];
            $i++;
        }

		return $this->data;
	}
}