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
		add_shortcode('problem_submit', array($this, 'render_problem_submit'));

		// Actions
		add_action('wp', array($this, 'remove_admin_bar'));
		add_action('wp_enqueue_scripts', array($this, 'callback_for_setting_up_scripts'));
		add_action( 'template_redirect', array($this, 'template_redirect') );

		// Ajax Actions
		add_action('wp_ajax_submit_answer', array($this, 'submit_answer'));
		add_action('wp_ajax_save_problem', array($this, 'save_problem'));

		// Registers the path /physics_genie/git-deploy to update the plugin
		add_action('rest_api_init', function(){
			register_rest_route( 'physics_genie', '/git-deploy', array(
				'methods'  => 'POST',
				'callback' => array($this, 'deploy'),
			));
} );
	}

	public function deploy() {
		require_once('deploy.php');
	}

	function callback_for_setting_up_scripts() {
		wp_register_style( 'play_menu_style', plugins_url("/styles/play_menu.css", __FILE__));
		wp_register_style( 'problem_style', plugins_url("/styles/problem.css", __FILE__));
		wp_register_style( 'problem_submit_style', plugins_url("/styles/problem_submit.css", __FILE__));
		wp_enqueue_style( 'play_menu_style' );
		wp_enqueue_style( 'problem_style' );
		wp_enqueue_style( 'problem_submit_style' );
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
		$attributes = shortcode_atts(array(
			'contributor' => ((current_user_can('administrator') || current_user_can('editor') || current_user_can('contributor')) ? 1 : 0)
		), null);
		return $this->get_template_html( 'play_menu', $attributes);
	}

	public function render_problem() {

		global $wpdb;

		// THE PROBLM SELECTION ALGORITHM WILL GO HERE (SQL STATEMENT)
		$problem = $wpdb->get_results( "SELECT * FROM pg_problems WHERE pg_problems.problem_id NOT IN (SELECT problem_id FROM pg_user_problems WHERE user_id = ".get_current_user_id().")", OBJECT )[0];
		$problem->main_focus = $wpdb->get_results("SELECT name FROM pg_topics WHERE topic = 0 AND focus = '".str_split($problem->topic)[0]."';")[0]->name;
		$problem->other_foci = $wpdb->get_results("SELECT name FROM pg_topics WHERE topic = 0 AND focus = '".substr($problem->topic, 1)."';");

		$topic_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = '0';")[0];
		$focus_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = '0".str_split($problem->topic)[0]."';")[0];

		$attributes = shortcode_atts( array(
			'problem' => $problem,
			'topic_stats' => $topic_stats,
			'focus_stats' => $focus_stats
		), null );

		return $this->get_template_html( 'problem', $attributes);
	}

	public function render_problem_submit() {
		return $this->get_template_html('problem_submit');
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


	// Ajax Functions
	public function submit_answer() {
		global $wpdb;
		$wpdb->insert(
			'pg_user_problems',
			array(
				'user_id' => get_current_user_id(),
				'problem_id' => intval($_POST['problem_id']),
				'num_attempts' => intval($_POST['num_attempts']),
				'correct' => ($_POST['correct'] === 'true' ? true : false),
				'saved' => false,
				'skipped' => ($_POST['skipped'] === 'true' ? true : false)
			)
		);
		if ($_POST['first_in_topic'] === 'true') {
			$wpdb->insert(
				'pg_user_stats',
				array(
					'user_id' => get_current_user_id(),
					'topic' => $_POST['topic'],
					'num_presented' => 1,
					'num_skipped' => ($_POST['skipped'] === 'true' ? 1 : 0),
					'num_saved' => 0,
					'num_correct' => ($_POST['correct'] === 'true' ? 1 : 0),
					'avg_attempts' => intval($_POST['num_attempts']),
					'score' => 0,
					'level' => 1,
					'xp' => 10
				)
			);
		} else {
			$curr_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = ".$_POST['topic'].";")[0];
			$wpdb->update(
				'pg_user_stats',
				array(
					'num_presented' => $curr_stats->num_presented + 1,
					'num_skipped' => $curr_stats->num_skipped + ($_POST['skipped'] === 'true' ? 1 : 0),
					'num_correct' => $curr_stats->num_correct + ($_POST['correct'] === 'true' ? 1 : 0),
					'avg_attempts' => (($curr_stats->avg_attempts * $curr_stats->num_presented) + intval($_POST['num_attempts']))/($curr_stats->num_skipped + intval($_POST['num_attempts'])),
					'level' => ($curr_stats->xp + 10 >= 100 ? $curr_stats->level + 1 : $curr_stats->level),
					'xp' => ($curr_stats->xp + 10 >= 100 ? $curr_stats->xp + 10 - 100 : $curr_stats->xp + 10)
				),
				array(
					'user_id' => get_current_user_id(),
					'topic' => $_POST['topic']
				),
				array('%d'),
				array('%d', '%s')
			);
		}

		if ($_POST['first_in_focus'] === 'true') {
			$wpdb->insert(
				'pg_user_stats',
				array(
					'user_id' => get_current_user_id(),
					'topic' => $_POST['topic'].$_POST['focus'],
					'num_presented' => 1,
					'num_skipped' => ($_POST['skipped'] === 'true' ? 1 : 0),
					'num_saved' => 0,
					'num_correct' => ($_POST['correct'] === 'true' ? 1 : 0),
					'avg_attempts' => intval($_POST['num_attempts']),
					'score' => 0,
					'level' => 1,
					'xp' => 10
				)
			);
		} else {
			$curr_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = ".$_POST['topic'].$_POST['focus'].";")[0];
			$wpdb->update(
				'pg_user_stats',
				array(
					'num_presented' => $curr_stats->num_presented + 1,
					'num_skipped' => $curr_stats->num_skipped + ($_POST['skipped'] === 'true' ? 1 : 0),
					'num_correct' => $curr_stats->num_correct + ($_POST['correct'] === 'true' ? 1 : 0),
					'avg_attempts' => (($curr_stats->avg_attempts * $curr_stats->num_presented) + intval($_POST['num_attempts']))/($curr_stats->num_skipped + intval($_POST['num_attempts'])),
					'level' => ($curr_stats->xp + 10 >= 100 ? $curr_stats->level + 1 : $curr_stats->level),
					'xp' => ($curr_stats->xp + 10 >= 100 ? $curr_stats->xp + 10 - 100 : $curr_stats->xp + 10)
				),
				array(
					'user_id' => get_current_user_id(),
					'topic' => $_POST['topic'].$_POST['focus']
				),
				array('%d'),
				array('%d', '%s')
			);
		}
	}

	public function save_problem() {
		global $wpdb;
		$wpdb->update(
			'pg_user_problems',
			array('saved' => ($_POST['saved'] === 'true' ? true : false)),
			array(
				'user_id' => get_current_user_id(),
				'problem_id' => intval($_POST['problem_id'])
			),
			array('%d'),
			array('%d', '%d')
		);
	}
}


require plugin_dir_path( __FILE__ ) . 'personalize_login.php';

// Initialize the plugin
$physics_genie = new Physics_Genie();


// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Personalize_login', 'physics_genie_activated' ) );

