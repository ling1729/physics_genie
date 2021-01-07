<?php
	function get_param($name) {
		//Be comaptible with both magic_quotes on and off.
		return get_magic_quotes_gpc() ? stripslashes($_POST[$name]) : $_POST[$name];
	}
	function html_escape($text) {
		//Escape html special chars from UTF8-encoded strings.
		return htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
	}
	//Get data from authoring page.
	$question = get_param('question');
	$text = get_param('text');
	$feedbackText = get_param('feedbackText');
	
	//load the Wiris Quizzes library.
	require_once 'quizzes/quizzes.php';
	
	//Build a question object. This object carries all question options from Wiris Quizzes Studio.
	$builder = com_wiris_quizzes_api_Quizzes::getInstance();
	$questionObject = $builder->readQuestion($question);

	$slots = $questionObject->getSlots();
	$slot = $slots[0];
	$authorAnswers = $slot->getAuthorAnswers();
	$authorAnswer = $authorAnswers[0];

	//Get the correct answer from the question object.
	$correctAnswer = $authorAnswer->getValue();
	
	if (empty($_POST['test'])) {  //Coming from level3.php
		//Create question instance (sets the random seed)
		$instanceObject = $builder->newQuestionInstance($questionObject);
		// Set the platform user identifier -here "123" as example- to allow the use of user_id parameter in algorithm.
        $instanceObject->setParameter(com_wiris_quizzes_api_QuizzesConstants::$PARAMETER_USER_ID, "123");
		//Execute program to get variable values.
		$request  = $builder->newVariablesRequest($text . ' ' . $correctAnswer, $instanceObject);
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		//Save results to $instanceObject.
		$instanceObject->update($response);
		//Set default values for variables
		$feedback = '<strong>Click to check the answer.</strong>';
		$studentAnswer = '';
		$customFeedback = '';
	} else {  //Coming from level3b.php
		//Get data from this page submit
		$instance = get_param('instance');
		$studentInstance = get_param('studentinstance');
		
		//Parse XML value to object and update with student instance.
		$instanceObject = $builder->readQuestionInstance($instance, $questionObject);
		$instanceObject->updateFromStudentQuestionInstance($builder->readQuestionInstance($studentInstance, $questionObject));
		
		//Get data from the instgance object.
		$studentAnswer = $instanceObject->getSlotAnswer($slot);
		
		//Build a request using the question object.
		$request  = $builder->newFeedbackRequest($feedbackText, $instanceObject);
		//Make the remote call.
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		//Get the response into this useful object.
		$instanceObject->update($response);
		//Ask for the correctness of the response.
		$correct = $instanceObject->getGrade($slot, $authorAnswer);
		$correct = round($correct, 2);
		//Set up output. $correctAnswer will be filtered.
		if ($correct == 1.0) {
			$feedback = 'Right! The answer is correct.';
		} else if ($correct == 0.0) {
			$feedback = 'Incorrect! The correct answer is ' . $correctAnswer . '.';
		} else {
			$feedback = ($correct * 100) . '% '.'Partially correct! The correct answer is ' . $correctAnswer . '.';
		}
		//Prepare the custom feedback. Variables will be expanded.
		$feedback = '<p><strong>' . $feedback . '</strong></p>';
		$customFeedback = $feedbackText;
	}
	//Replace placeholders by MathML. #a => <math...> 
	$displayText = $instanceObject->expandVariables($text);
	$feedback = $instanceObject->expandVariables($feedback);
	$customFeedback = $instanceObject->expandVariables($customFeedback);
	//Replace MathML by image tags. <math...> => <img...>
	$filter = $builder->getMathFilter();
	$displayText = $filter->filter($displayText);
	$feedback = $filter->filter($feedback);
	$customFeedback = $filter->filter($customFeedback);
		
	$studentAnswer = html_escape($studentAnswer);
	//$studentQuestion and $studentInstance don't not contain any sensible information.
	$studentQuestion = html_escape($questionObject->getStudentQuestion()->serialize());
	$studentInstance = html_escape($instanceObject->getStudentQuestionInstance()->serialize());
	
	//These variables shouldn't be outputted in a real application since 
	//they contain sensible information for the student. They should be saved
	//in the database. However we use the web page in order to save them so we 
	//get all at the next page execution. They are not used in this page.
	$question = html_escape($question);
	$instance = html_escape($instanceObject->serialize());
	$correctAnswer = html_escape($correctAnswer);
	$text = html_escape($text);
	$feedbackText = html_escape($feedbackText);

?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Level 3. Random parameters</title>
		<link rel="stylesheet" type="text/css" href="styles-gs.css" />
		<link rel="stylesheet" type="text/css" href="styles-topbar.css" />
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet"/>
		<!-- The following line includes the JavaScript part of the Wiris Quizzes library.-->
		<script type="text/javascript" src="quizzes/service.php?service=resource&amp;name=quizzes.js"></script>
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
				<h1>Level 3. Random parameters</h1>
			</div>
			<div id="main">
				<form method="post" action="level3b.php">
					<div id="tabs">
						<ul>
							<li><button id="tabauthoring" type="submit" name="back" value="back" onclick="document.forms[0].action='level3.php';">Teacher | Authoring</button></li>
							<li><button id="tabdelivery" class="tabactive">Student | Delivery</button></li>
						</ul>
						<div id="tabindicator" class="deliveryindicator"></div>
					</div>
					<div id="delivery">
						<div id="text">
							<h2>Question text</h2>
							<?php echo $displayText; ?>
						</div>
						<h2>Student answer</h2>
						<!-- This input will be replaced by a cas applet if it has been enabled in question options. -->
						<input type="hidden" class="wirisauxiliarcasapplet"/>
						<!-- This input will be replaced by an input field for student answer. -->
						<input type="hidden" class="wirisanswerfield wirisembeddedfeedback" value="<?php echo $studentAnswer; ?>" />
						<!-- This input will contain all question options from Wiris Quizzes Studio -->
						<input type="hidden" class="wirisquestion" value="<?php echo $studentQuestion; ?>" />
						<!-- This input will contain evaluaion details to build the feedback. -->
						<input type="hidden" class="wirisquestioninstance" name="studentinstance" value="<?php echo $studentInstance; ?>" />
						<div id="testcontainer">
							<input type="submit" value="Test" id="test" name="test" class="wirissubmit"/>
							<?php echo $feedback; ?>
						</div>
						<?php echo $customFeedback; ?>
						<!-- The default feedback will be inserted here; before the element with class="wirisanswerfeedback" -->
						<div class="wirisanswerfeedback" ></div>
						<!-- These variables shouldn't be outputted in a real application since 
						they contain sensible information for the student. They should be saved
						in the database. However we use the web page in order to save them so we 
						get all at the next page execution. They are not used in this page. -->
						<input type="hidden" name="instance" value="<?php echo $instance; ?>" />
						<input type="hidden" name="question" value="<?php echo $question; ?>" />
						<input type="hidden" name="text" value="<?php echo $text; ?>" />
						<input type="hidden" name="feedbackText" value="<?php echo $feedbackText; ?>" />
					</div>
				</form>
				<div id="help">
					<p>
					This page shows how to integrate Wiris Quizzes within a PHP platform using Wiris Quizzes Studio.
					In this answering stage, in addition of Level 2 features, all variables have been replaced by
					images using the MathType render service.
					</p>
					<p>
					This example is the Level 3 one. Check the Level 1 and Level 2 examples to find simpler integrations.
					</p>
				</div>
			</div>
		</div>
	</body>
</html>