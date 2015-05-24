<?php 

class FTS_Twitter_Custom_Feed extends feed_them_social_functions {
	function __construct() {
		add_shortcode( 'fts twitter_custom', array( $this,'fts_tw_custom_func'));

		add_action('wp_enqueue_scripts', array( $this,'fts_tw_custom_head'));
	}

	function  fts_tw_custom_head() {
		wp_enqueue_style( 'fts_tw_custom_css', plugins_url( 'twitter_custom/css/styles.css',  dirname(__FILE__ ) ) );
	}

	public function fts_tw_custom_func($atts)
	{
		extract( shortcode_atts( array(
				'user' => '',
				'title' => '',
			), $atts ) );

		//API Access Token
		$custom_access_token = get_option('fts_twitter_custom_api_token');
		if(!empty($custom_access_token)){
			$access_token = get_option('fts_twitter_custom_api_token');
		}
		else{
			//Randomizer (Custom twitter Feed guy aka SmashBallon hahaha)
			$values = array('226916994002335|ks3AFvyAOckiTA1u_aDoI4HYuuw','358962200939086|lyXQ5-zqXjvYSIgEf8mEhE9gZ_M','705020102908771|rdaGxW9NK2caHCtFrulCZwJNPyY');
			$access_token = $values[array_rand($values,1)];
		}

		//Error Check
		if (!$user){
			return 'Please enter a username for this feed.';
		}

		if (!$title) {
			$title = 'Tweets por el @' . $user;
		}

		$url = 'https://twitter.com/' . $user;
		
		$result = file_get_contents('http://192.168.0.150/bancaynegocios/iframe-twitter-custom.html');

		return '<div class="col-md-12 twitter-custom">
					<h4 class="col-md-10">' .$title . '</h4>
				 	<span class="fa fa-3x icon-twitter col-md-2"></span>
				 	<div class="clear"></div>
					<a class="twitter-timeline" href="' . $url . '" data-widget-id="558617630782013440">Tweets por el @' . $user . '.</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>';
	}
}

