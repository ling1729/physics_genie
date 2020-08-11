<?php

/*
Plugin Name: physics_genie
*/

class Physics_Genie {

	public function __construct() {
		$personalize_login = new Personalize_Login();

		// Shortcodes
		add_shortcode('play_menu', array($this, 'render_play_menu'));
		add_shortcode('problem', array($this, 'render_problem'));

		// Actions
		add_action('wp', array($this, 'remove_admin_bar'));
		add_action('wp_enqueue_scripts', array($this, 'callback_for_setting_up_scripts'));
		add_action( 'template_redirect', array($this, 'template_redirect') );
		// Registers the path /physics_genie/git-deploy to update the plugin
		add_action( 'rest_api_init', function () {
			register_rest_route( 'physics_genie', '/git-deploy', array(
			'methods'  => 'POST',
			'callback' => array($this, 'deploy'),
		));
} );
	}

	public function deploy() {
		file_put_contents("request.txt", file_get_contents("php://input")); // writes the post request to a file so the other script can read it, there is probably a better way to do this that I don't know about
		include('deploy.php');
	}

	function callback_for_setting_up_scripts() {
		wp_register_style( 'play_style', plugins_url("/styles/play.css", __FILE__));
		wp_enqueue_style( 'play_style' );
	}

	public static function physics_genie_activated() {
		Personalize_Login::login_activated();
	}

	private function get_template_html( $template_name, $attributes = null ) {
		if ( ! $attributes ) {
			$attributes = array();
		}

		ob_start();

		do_action( 'personalize_login_before_' . $template_name );

		require( 'templates/' . $template_name . '.php');

		do_action( 'personalize_login_after_' . $template_name );

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}


	public static function remove_admin_bar() {
		if (!current_user_can('administrator') && !current_user_can('editor')) {
			show_admin_bar(false);
		}
	}

	public function render_play_menu() {
		return $this->get_template_html( 'play_menu');
	}

	public function render_problem() {

		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM pg_problems", OBJECT );

		$attributes = shortcode_atts( array(
			'results' => $results[18]
		), null );

		return $this->get_template_html( 'problem', $attributes);
	}

	public function template_redirect() {
		if (is_page('play')) {
			wp_redirect( home_url( 'problem' ) );
			die;
		}

		if ( (is_page( 'profile' ) || is_page('problem')) && ! is_user_logged_in() ) {
			wp_redirect( home_url( 'member-login' ) );
			die;
		}
	}

}


require plugin_dir_path( __FILE__ ) . 'personalize_login.php';

// Initialize the plugin
$physics_genie = new Physics_Genie();


// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Personalize_login', 'physics_genie_activated' ) );

