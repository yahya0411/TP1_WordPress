<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Core
*/
trait Wtn_API
{
    //protected $fields, $settings, $options;
	protected $data, $transient;
    
    protected function wtn_news_sources() {

        return [ 
			'abc-news' 				=> 'ABC News',
			'abc-news-au' 			=> 'ABC News (AU)',
			'al-jazeera-english' 	=> 'Al Jazeera English',
			'ary-news' 				=> 'Ary News',
			'bbc-news' 				=> 'BBC News',
			'bbc-sport' 			=> 'BBC Sport',
			'bloomberg' 			=> 'Bloomberg',
			'business-insider' 		=> 'Business Insider',
			'business-insider-uk'	=> 'Business Insider (UK)',
			'cbc-news' 				=> 'CBC News',
			'cbs-news' 				=> 'CBS News',
			'cnbc'					=> 'CNBC',
			'cnn' 					=> 'CNN',
			'cnn-es' 				=> 'CNN Spanish',
			'daily-mail'			=> 'Daily Mail',
			'der-tagesspiegel'		=> 'Der Tagesspiegel', //Germany
			'el-mundo'				=> 'El Mundo',
			'espn'					=> 'ESPN',
			'fox-news' 				=> 'Fox News',
			'google-news' 			=> 'Google News',
			'marca'					=> 'Marca',
			'mirror'				=> 'Mirror',
			'nbc-news' 				=> 'NBC News',
			'rt'					=> 'RT',
			'the-huffington-post' 	=> 'The Huffington Post',
			'the-new-york-times' 	=> 'The New York Times',
			'the-guardian-uk' 		=> 'The Guardian (UK)',
			'the-economist' 		=> 'The Economist',
			'the-washington-post' 	=> 'The Washington Post',
			'the-washington-times' 	=> 'The Washington Times',
			'the-hindu' 			=> 'The Hindu'
        ];
    }

    private function wtn_get_api_data( $category, $source, $country ) {
        
		if ( 'country' === $category ) {
            $wQuery = "country={$country}";
			$this->transient = "wtn_api_cached_data_{$country}";
        }
        if ( 'country' != $category ) {
            $wQuery = "sources={$source}";
			$this->transient = "wtn_api_cached_data_{$source}";
        }
		
		//delete_transient( $this->transient );
		
		if ( ( false === get_transient( $this->transient ) ) or ( empty( get_transient( $this->transient ) ) ) ) {
			
			$wtn_api_key = get_option('wtn_api_key');
        
        	$urla = "https://newsapi.org/v2/top-headlines?apiKey={$wtn_api_key}&{$wQuery}";
			
			$headers = array(
				'Content-Type' => 'application/json',
				'User-Agent' => esc_html( get_bloginfo( 'name' ) ),
			);

			//$this->wtn_api = wp_remote_get( $urla, array( 'headers' => $headers ) );
			$this->wtn_api = wp_remote_get( $urla, array(
				'timeout' => 20,
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'
			));

			$this->data = (array) json_decode( wp_remote_retrieve_body( $this->wtn_api ) );

			//echo '<pre>';
			//print_r($this->data);
			
			echo '<i class="fa fa-hdd" aria-hidden="true"></i>';
			
			delete_transient( $this->transient );

			$wtn_caching_time  = ( null !== get_option('wtn_caching_time') ) ? get_option('wtn_caching_time') : '24';
			
			set_transient( $this->transient , $this->data, 361 * $wtn_caching_time );
		}

		return get_transient( $this->transient );
	}
}