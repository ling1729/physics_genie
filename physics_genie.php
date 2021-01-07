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
		add_shortcode('register-problem-setup', array($this, 'render_register_problem_setup'));

		// Actions
		add_action('wp', array($this, 'remove_admin_bar'));
		add_action('wp_enqueue_scripts', array($this, 'callback_for_setting_up_scripts'));
		add_action( 'template_redirect', array($this, 'template_redirect') );

		// Ajax Actions
		add_action('wp_ajax_check_answer', array($this, 'check_answer'));
		add_action('wp_ajax_submit_answer', array($this, 'submit_answer'));
		add_action('wp_ajax_save_problem', array($this, 'save_problem'));
		add_action('wp_ajax_add_source', array($this, 'add_source'));
		add_action('wp_ajax_submit_problem', array($this, 'submit_problem'));

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
		wp_register_style( 'register_problem_setup_style', plugins_url("/styles/register_problem_setup.css", __FILE__));

		wp_enqueue_style( 'play_menu_style' );
		wp_enqueue_style( 'problem_style' );
		wp_enqueue_style( 'problem_submit_style' );
		wp_enqueue_style( 'register_problem_setup_style' );
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

		// THE PROBLEM SELECTION ALGORITHM WILL GO HERE (SQL STATEMENT)
		$problem = $wpdb->get_results( "SELECT * FROM pg_problems WHERE pg_problems.problem_id NOT IN (SELECT problem_id FROM pg_user_problems WHERE user_id = " . get_current_user_id() . ")", OBJECT )[0];
		if (isset($_REQUEST['problem']) && (get_current_user_id() === 1 || get_current_user_id() === intval($wpdb->get_results("SELECT * FROM pg_problems WHERE pg_problems.problem_id = ".$_REQUEST['problem'].";")[0]->submitter))) {
			$problem = $wpdb->get_results("SELECT * FROM pg_problems WHERE pg_problems.problem_id = ".$_REQUEST['problem'].";", OBJECT)[0];
		} else {
			wp_redirect("play/problem");
		}
		$problem->main_focus = $wpdb->get_results("SELECT name FROM pg_topics WHERE topic = 0 AND focus = '".$problem->main_focus."';")[0]->name;
		$problem->other_foci = $wpdb->get_results("SELECT name FROM pg_topics WHERE topic = 0 AND focus = '".substr($problem->other_foci, 0)."';");

		$topic_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = '".$problem->topic."';")[0];
		$focus_stats = $wpdb->get_results("SELECT * FROM pg_user_stats WHERE user_id = ".get_current_user_id()." AND topic = '".$problem->topic.$problem->main_focus."';")[0];

		$attributes = shortcode_atts( array(
			'problem' => $problem,
			'topic_stats' => $topic_stats,
			'focus_stats' => $focus_stats
		), null );

		return $this->get_template_html( 'problem', $attributes);
	}

	public function render_problem_submit() {

		global $wpdb;

		$attributes = shortcode_atts(array(
			'focuses' => $wpdb->get_results("SELECT focus, name FROM pg_topics WHERE topic = 0 AND focus != 'z';"),
			'source_categories' => $wpdb->get_results("SELECT DISTINCT category FROM pg_sources ORDER BY category;"),
			'sources' => $wpdb->get_results("SELECT * FROM pg_sources ORDER BY source;"),
			'problems' => $wpdb->get_results("SELECT * FROM pg_problems WHERE submitter = ".(get_current_user_id() === 1 ? 17 : get_current_user_id())." ORDER BY problem_id DESC;")
		), null);

		return $this->get_template_html('problem_submit', $attributes);
	}

	public function render_register_problem_setup() {

		global $wpdb;

		$attributes = shortcode_atts(array(
			'focuses' => $wpdb->get_results("SELECT focus, name FROM pg_topics WHERE topic = 0 AND focus != 'z';")
		), null);

		return $this->get_template_html('register_problem_setup', $attributes);
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
	public function check_answer() {

		echo 1;

		wp_die();
	}


	public function submit_answer() {
		global $wpdb;

		if (!($_POST['submitter'] === get_current_user_id())) {

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


	public function add_source() {
		global $wpdb;

		$wpdb->insert(
			'pg_sources',
			array(
				'category' => $_POST['category'],
				'author' => $_POST['author'],
				'source' => $_POST['source']
			)
		);

	}

	public function submit_problem() {
		global $wpdb;

		if ($_POST['editing'] === 'true') {
			$wpdb->update(
				'pg_problems',
				array(
					'problem_text' => $_POST['problem_text'],
					'diagram' => ($_POST['diagram'] === "" ? null: $_POST['diagram']),
					'answer' => $_POST['answer'],
					'solution' => $_POST['solution'],
					'hint_one' => $_POST['hint_one'],
					'hint_two' => ($_POST['hint_two'] === "" ? null: $_POST['hint_two']),
					'source' => intval($_POST['source']),
					'number_in_source' => $_POST['problem_number'],
					'submitter' => (get_current_user_id() === 1 ? 16 : get_current_user_id()),
					'difficulty' => intval($_POST['difficulty']),
					'calculus' => $_POST['calculus'],
					'topic' => $_POST['topic'],
					'main_focus' => $_POST['main_focus'],
					'other_foci' => ($_POST['other_foci'] === "" ? null: $_POST['other_foci']),
					'date_added' => date('Y-m-d'),
				),
				array(
					'problem_id' => intval($_POST['problem_id'])
				),
				null,
				array('%d')
			);
		} else {
			$wpdb->insert(
				'pg_problems',
				array(
					'problem_text' => $_POST['problem_text'],
					'diagram' => ($_POST['diagram'] === "" ? null: $_POST['diagram']),
					'answer' => $_POST['answer'],
					'solution' => $_POST['solution'],
					'hint_one' => $_POST['hint_one'],
					'hint_two' => ($_POST['hint_two'] === "" ? null: $_POST['hint_two']),
					'source' => intval($_POST['source']),
					'number_in_source' => $_POST['problem_number'],
					'submitter' => get_current_user_id(),
					'difficulty' => intval($_POST['difficulty']),
					'calculus' => $_POST['calculus'],
					'topic' => $_POST['topic'],
					'main_focus' => $_POST['main_focus'],
					'other_foci' => ($_POST['other_foci'] === "" ? null: $_POST['other_foci']),
					'date_added' => date('Y-m-d'),
				)
			);
		}
	}
}


require plugin_dir_path( __FILE__ ) . 'personalize_login.php';

// Initialize the plugin
$physics_genie = new Physics_Genie();


// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Personalize_login', 'physics_genie_activated' ) );


//function getEquivSymbolicAssertionMessage($mathml1, $mathml2) {
//	$assertion_name = 'equivalent_symbolic';
//	$operation_name = 'getCheckAssertions';
//
//	$mathml1 = wrapInCDATA($mathml1);
//	$mathml2 = wrapInCDATA($mathml2);
//
//	$xml = '<doProcessQuestions>'.            '<processQuestions>'.              '<processQuestion>'.                '<question>'.                  '<correctAnswers>'.                    '<correctAnswer type="mathml">'.                         $mathml1.                    '</correctAnswer>'.                  '</correctAnswers>'.                  '<assertions>'.                    '<assertion name="'.$assertion_name.'" />'.                  '</assertions>'.                '</question>'.                '<userData>'.                  '<answers>'.                    '<answer type="mathml">'.                      $mathml2.                    '</answer>'.                  '</answers>'.                '</userData>'.                '<processes>'.                  '<'.$operation_name.'/>'.                '</processes>'.              '</processQuestion>'.            '</processQuestions>'.          '</doProcessQuestions>';
//	return $xml;
//}
//
//function callWIRISAPI($xml) {
//	$url = 'http://services.wiris.com/quizzes/rest';
//	$opts = array( 'http' =>
//		               array('method' => 'POST',
//		                     'header' => 'Content-type: text/xml; charset=utf-8'."\n".
//		                                 'Content-Length: '.strlen($xml)."\n",
//		                     'content'=> $xml
//		               )
//	);
//	$context = stream_context_create($opts);
//	$result = file_get_contents($url, false, $context);
//	return $result;
//}
//
//function wrapInCDATA($str) {
//	return '<![CDATA['.$str.']]>';
//}
//
//function getReturnValue($xml) {
//	//in a more general purpose client the xml should be completely parsed,
//	//here we go directly to the result.
//	$pattern = '/<check[^>]*>(\d+)<\/check>/';
//	$matches = array();
//	preg_match($pattern, $xml, $matches);
//	return $matches[1];
//}


