<?php 

class FTS_Facebook_Custom_Feed extends feed_them_social_functions {
	function __construct() {
		add_shortcode( 'fts facebook_custom', array( $this,'fts_fb_custom_func'));

		add_action('wp_enqueue_scripts', array( $this,'fts_fb_custom_head'));
	}

	function  fts_fb_custom_head() {
		wp_enqueue_style( 'fts_fb_custom_css', plugins_url( 'facebook_custom/css/styles.css',  dirname(__FILE__ ) ) );
	}

	public function fts_fb_custom_func($atts)
	{
		extract( shortcode_atts( array(
				'user' => '',
				'title' => '',
			), $atts ) );

		//API Access Token
		$custom_access_token = get_option('fts_facebook_custom_api_token');
		if(!empty($custom_access_token)){
			$access_token = get_option('fts_facebook_custom_api_token');
		}
		else{
			//Randomizer (Custom Facebook Feed guy aka SmashBallon hahaha)
			$values = array('226916994002335|ks3AFvyAOckiTA1u_aDoI4HYuuw','358962200939086|lyXQ5-zqXjvYSIgEf8mEhE9gZ_M','705020102908771|rdaGxW9NK2caHCtFrulCZwJNPyY');
			$access_token = $values[array_rand($values,1)];
		}

		//Error Check
		if (!$user){
			return 'Please enter a username for this feed.';
		}

		$url = 'https://www.facebook.com/' . $user;

		return '<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.0";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script> 
			
			<div class="col-md-12 facebook-custom">
				<span class="fa fa-3x icon-facebook-sign col-md-2"></span>
				<h4 class="col-md-10">' . $title . '</h4>
				<div class="fb-like-box" data-href="' . $url . '" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true">
				</div>
			</div>';
	}
}

