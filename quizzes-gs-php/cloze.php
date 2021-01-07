<?php 
	define('STATE_AUTHORING', 0);
	define('STATE_DELIVERY', 1);
	define('STATE_REVIEW', 2);

	function get_param($name) {
		//Be comaptible with both magic_quotes on and off.
		return get_magic_quotes_gpc() ? stripslashes($_POST[$name]) : $_POST[$name];
	}
	function html_escape($text) {
		//Escape html special chars from UTF8-encoded strings.
		return htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
	}
	
	//load the Wiris Quizzes library.
	require_once 'quizzes/quizzes.php';
	
	// Wiris Quizzes builder. This is the single entry point to the Wiris Quizzes API.
	$builder = com_wiris_quizzes_api_Quizzes::getInstance();
	
	// AUTHORING
	if (empty($_POST['test']) && empty($_POST['deliver']) && empty($_POST['back'])) {
		// Initialize the empty question.
		$question = html_escape($builder->newQuestion()->serialize());
		$text = "";
		// Set state.
		$state = STATE_AUTHORING;
	}
	// AUTHORING
	else if (!empty($_POST['back'])) {
		// Get parameters.
		$question = get_param('question');
		$text = get_param('text');
		
		// Load question object.
		$questionObject = $builder->readQuestion($question);
		// Parse text to authoring mode.
		$e = $builder->getQuizzesComponentBuilder()->newEmbeddedAnswersEditor($questionObject, null);
		$text = $e->filterHTML($text, com_wiris_quizzes_api_ui_EmbeddedAnswersEditorMode::$AUTHORING);
		// Set state.
		$state = STATE_AUTHORING;
		
		// Define output variables.
		$question = html_escape($questionObject->serialize());
		$text = html_escape($text);
	}
	// DELIVERY
	else if (!empty($_POST['deliver'])) {
		// Get parameters.
		$question = get_param('question');
		$text = get_param('text');
		
		// Load question object.
		$questionObject = $builder->readQuestion($question);
		// Create new question instance (sets the random seed)
		$instanceObject = $builder->newQuestionInstance($questionObject);
		// Build an auxiliar string concatenating all fragments that may have variable placeholders.
		$alltext = $text;
		$slots = $questionObject->getSlots();
		foreach ($slots as $slot) {
			$authorAnswers = $slot->getAuthorAnswers();
			$alltext .= ' ' . $authorAnswers[0]->getValue();
		}
		// Execute algorithm to get variable values.
		$request  = $builder->newVariablesRequest($alltext, $instanceObject);
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		// Save results to $instanceObject.
		$instanceObject->update($response);
		// Parse text to delivery mode.
		$e = $builder->getQuizzesComponentBuilder()->newEmbeddedAnswersEditor($questionObject, $instanceObject);
		$text = $e->filterHTML($text, com_wiris_quizzes_api_ui_EmbeddedAnswersEditorMode::$DELIVERY);
		// Set state.
		$state = STATE_DELIVERY;
		
		// Define output variables. Use getStudentQuestion() and getStudentQuestionInstance() to hide
		// sensible information (such as the correct answer) from student.
		$displayText = filter_math($text, $instanceObject);
		$studentQuestion = html_escape($questionObject->getStudentQuestion()->serialize());
		$studentInstance = html_escape($instanceObject->getStudentQuestionInstance()->serialize());
		
		// Save values for further use. In a production application these variables should be saved to a 
		// server persistent memory such as a database, but in this example we will set them into 
		// hidden form fields.
		$question = html_escape($questionObject->serialize());
		$instance = html_escape($instanceObject->serialize());
		$text = html_escape($text);
	}
	// REVIEW
	else if (!empty($_POST['test'])) {
		// Get parameters.
		$studentInstance = get_param('studentInstance');
		
		// Load saved values. In a production application these variables should be loaded from a server
		// persistent memory such as a database, but in this example we get them as HTTP request parameters.
		$question = get_param('question');
		$instance = get_param('instance');
		$text = get_param('text');
		
		// Load Question and QuestionInstance objects.
		$questionObject = $builder->readQuestion($question);
		$instanceObject = $builder->readQuestionInstance($instance, $questionObject);
		$studentInstanceObject = $builder->readQuestionInstance($studentInstance, $questionObject);
		// Save responses from student QuestionInstance into full QuestionInstance object.
		$instanceObject->updateFromStudentQuestionInstance($studentInstanceObject);
		
		// Build the evaluation request.
		$request  = $builder->newGradeRequest($instanceObject);
		// Do the remote call.
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		// Load the response into QuestionInstance object.
		$instanceObject->update($response);
		
		// Compute grade as the mean of all embedded answers grades.
		$grade = 0.0;
		$slots = $questionObject->getSlots();
		$n = count($slots);
		foreach ($slots as $slot) {
			$authorAnswers = $slot->getAuthorAnswers();
			$grade += $instanceObject->getGrade($slot, $authorAnswers[0]) / $n;
		}
		// Compute feedback.
		if ($grade == 1.0) {
			$feedback = 'Right! All your answers are correct!';
		}
		else if ($grade < 1.0 && $grade > 0.0) {
			$feedback = 'Partially correct! Your grade is ' . (ceil($grade * 100)) . '%.';
		}
		else {
			$feedback = 'Wrong! All your answers are incorrect.';
		}
		// Set state.
		$state = STATE_REVIEW;
		
		// Parse text to review mode.
		$e = $builder->getQuizzesComponentBuilder()->newEmbeddedAnswersEditor($questionObject, $instanceObject);
		$displayText = $e->filterHTML($text, com_wiris_quizzes_api_ui_EmbeddedAnswersEditorMode::$REVIEW);
		
		// Define output variables.
		$displayText = filter_math($displayText, $instanceObject);
		$studentInstance = html_escape($instanceObject->serialize());
		$studentQuestion = html_escape($questionObject->serialize());
		$feedback = html_escape($feedback);
		
		// Save values for further use (as in deliver state).
		$question = html_escape($questionObject->serialize());
		$instance = html_escape($instanceObject->serialize());
		$text = html_escape($text);
	}
	
	function filter_math($text, $instanceObject) {
		global $builder;
		// Replace variables from algorithm into its value in MathML: #a => <math...>
		$text = $instanceObject->expandVariables($text);
		// Render MathML into images: <math...> => <img...>
		$text = $builder->getMathFilter()->filter($text);
		return $text;
	}
?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Embedded answers</title>
		<!-- This stylesheet just style this tutorial elements. Wiris Quizzes API don't need it. -->
        <link rel="stylesheet" type="text/css" href="styles-gs.css" />
		<link rel="stylesheet" type="text/css" href="styles-topbar.css" />
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet"/>
        <!-- Include the CKEditor HTML editor for the question text field -->
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <!-- The following line includes the JavaScript part of the Wiris Quizzes library.-->
        <script type="text/javascript" src="quizzes/service.php?service=resource&name=quizzes.js"></script>
        <!-- Wiris Quizzes integration utility for cloze question in ckeditor. 
        Sets up the Wiris Quizzes button on CKEditor toolbar. -->
        <script type="text/javascript" src="cloze-ckeditor.js"></script>
		
		<?php if ($state == STATE_AUTHORING) { ?>
		<!-- Javascript code for Authoring page. -->
		<script type="text/javascript">//<![CDATA[
			// Bind init function to page load event (not cross-browser).
		window.addEventListener("load", init, false);
			// Authoring initialization function.
			function init() {
				// Create Wiris Quizzes builders.
				var builder = com.wiris.quizzes.api.Quizzes.getInstance();
				var uibuilder = builder.getQuizzesComponentBuilder();    
				
				// Read Question object from hidden input field.
				questionObject = builder.readQuestion(document.getElementById("question").value);
				
				// Create the embedded answers controller.
				var embeddedAnswersEditor = uibuilder.newEmbeddedAnswersEditor(questionObject, null);
				// Enable variables (Level 3).
				embeddedAnswersEditor.showVariablesTab(true);
				// Call functions from file cloze-ckeditor.js to configure and initialize the HTML editor.
				var text = document.getElementById("htmleditor").value;
				var ckeditor = ckeditor_init(embeddedAnswersEditor);
				ckeditor_setdata(ckeditor, text);
				
				// Add form submit function handler.
				document.getElementById("form").addEventListener("submit", function() {
					// Update the question hidden field.
					document.getElementById("question").value = questionObject.serialize();
				});
			}
		//]]></script>
		<?php } ?>
	</head>
	<body>
		<header id="page_header">
			<div class="wrs_css_inner">
				<nav>
					<a class="wrs_logo_small" href="http://www.wiris.com/en/quizzes" target="_blank" title="Wiris Quizzes"><img class="wrs_css_logo_wiris" src="images/w_icon_bg.svg"></a><a href="index.html" title="Demo Wiris Quizzes"><span id="store_link">Getting started with</span>
					<img id="logo_header"  src="images/quizzes.svg" alt="Wiris Quizzes"></a>
					<input type="checkbox" id="nav"><label for="nav" id="nav-label"></label>
					<ul id="menu-area">
						<li><a href="http://www.wiris.com/quizzes/download/generic" target="_blank">Download</a></li>
						<li><a href="http://docs.wiris.com/en/quizzes" target="_blank">Documentation</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<div id="wrapper">
	        <div id="header">
	            <h1>Embedded answers</h1>
	        </div>
	        <div id="main">
		        <form method="post" id="form" action="cloze.php">
		            <div id="tabs">
		                <ul>
		                    <li><button id="tabauthoring" class="<?php echo ($state == STATE_AUTHORING) ? 'tabactive' : ''; ?>" <?php if ($state != STATE_AUTHORING) { ?> type="submit" name="back" value="back" <?php } ?>> Teacher | Authoring</button></li>
		                    <li><button id="tabdelivery" class="<?php echo ($state == STATE_AUTHORING) ? '' : 'tabactive'; ?>" <?php if ($state == STATE_AUTHORING) { ?> type="submit" name="deliver" value="deliver" <?php } ?>>Student | Delivery</button></li>
		                </ul>
		                <div id="tabindicator" class="<?php echo ($state == STATE_AUTHORING) ? 'authoringindicator' : 'deliveryindicator'; ?>"></div>
		            </div>
		            <div id="<?php echo ($state == STATE_AUTHORING) ? 'authoring' : 'delivery'; ?>">
		                <div>
		                    <h2>Question text</h2>
		                    <?php if ($state == STATE_AUTHORING) { ?>
		                        <!-- Authoring page. Create a textarea that will be replaced by a CKEditor. -->
		                        <textarea name="text" id="htmleditor" rows="5" cols="10"><?php echo $text; ?></textarea>
		                    <?php } else { ?>
		                        <!-- Deliver page -->
		                        <div id="questiontext">
		                        <?php echo $displayText; ?>
		                        </div>
		                    <?php } ?>
		                    <div>
								<!-- Put here the desired language for Wiris Quizzes Studio and MathType.
								Available languages are "en", "es", "ca", "pt", "pt_br", "it", "fr", "de", "da", no", "nn", "el" -->
								<input type="hidden" class="wirislang" value="en" />
		                        <?php if ($state == STATE_AUTHORING) { ?>
								<!-- XML-serialized Question object. -->
								<input type="hidden" name="question" id="question" class="wirisquestion" value="<?php echo $question; ?>" />
								<?php } else { // Delivery or Review. ?>
								<!-- XML-serialized Question object. -->
		                        <input type="hidden" id="question" class="wirisquestion" value="<?php echo $studentQuestion; ?>" />
								<!-- XML-serialized QuestionInstance object. -->
		                        <input type="hidden" name="studentInstance" id="instance" class="wirisquestioninstance" value="<?php echo $studentInstance; ?>" />
		                        <div id="testcontainer">
			                        <input type="submit" value="Test" name="test" id="test"/>
			                        <?php } ?>
			                        <?php if ($state == STATE_DELIVERY) { ?>
			                            <strong>Click the test button to evaluate your answers.</strong>
			                        <?php } else if (($state == STATE_REVIEW)) { ?>
			                            <strong><?php echo $feedback; ?></strong>
			                        <?php } ?>
			                    </div>
								<!-- Auxiliar hidden fields. In a production application these values should be saved in a persistent server memory and souldn't be available to students.-->
								<?php if ($state == STATE_DELIVERY || $state == STATE_REVIEW) { ?>
								<input type="hidden" name="instance" value="<?php echo $instance; ?>" />
								<input type="hidden" name="question" value="<?php echo $question; ?>" />
								<input type="hidden" name="text" value="<?php echo $text; ?>" />
								<?php } ?>
		                    </div>
		                </div>
		            </div>
		            <div id="help">
		                <p>
		          This page shows how to integrate Wiris Quizzes in an <em>embedded answers</em>
		          question type. It is similar to Level 3 integration in Delivery and Review pages,
		          but with the addition of the Embedded Answers edition integrated in the HTML editor 
		          for the Authoring page.
		                </p>
		            </div>
		        </form>
	        </div>
	    </div>
    </body>
</html>
