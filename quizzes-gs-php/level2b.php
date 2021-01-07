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
	$correctAnswer = get_param('correctAnswer');
	//load the Wiris Quizzes library.
	require_once 'quizzes/quizzes.php';
	//Build a question object. This object carries all question options from Wiris Quizzes Studio.
	$builder  = com_wiris_quizzes_api_Quizzes::getInstance();
	$questionObject = $builder->readQuestion($question);
	if (empty($_POST['test'])) { // Deliver.
		$instanceObject = $builder->newQuestionInstance($questionObject);
		$feedback = 'Click to check the answer.';
		$studentAnswer = '';
	}
	else { // Test.
		$slots = $questionObject->getSlots();
		$slot = $slots[0];
		$authorAnswers = $slot->getAuthorAnswers();
		$authorAnswer = $authorAnswers[0];

		$studentAnswer = get_param('studentAnswer');
		$instance = get_param('instance');
		
		$instanceObject = $builder->readQuestionInstance($instance, $questionObject);
		$instanceObject->setSlotAnswer($slot, $studentAnswer);

		//Build a request using the question object.
		$request  = $builder->newGradeRequest($instanceObject);
		//Make the remote call.
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		
		$instanceObject->update($response);

		//Ask for the correctness of the response.
		$correct = $instanceObject->getGrade($slot, $authorAnswer);
		$correct = round($correct, 2);
		//Set up output.
		if ($correct == 1.0) {
			$feedback = 'Right! The answer is correct.';
		} else if ($correct == 0.0) {
			$feedback = 'Incorrect! The student answer does not match the correct one.';
		} else {
			$feedback = ($correct * 100) . '% '.'Partially correct!';
		}
	}
	// $studentQuestion does not contain any sensible information.
	$studentQuestion = html_escape($questionObject->getStudentQuestion()->serialize());
	// Output the instance information to setup the answer and feedback fields.
	$studentInstance = html_escape($instanceObject->getStudentQuestionInstance()->serialize());
	$studentAnswer = html_escape($studentAnswer);
	
	//These variables should not be outputted in a real application since 
	//they contain sensible information for the student. They should be saved
	//in the database. However we use the web page in order to save them and 
	//get them at authoring and they are not used in this page.
	$question = html_escape($question);
	$instance = html_escape($instanceObject->serialize());
	$correctAnswer = html_escape($correctAnswer);
	
?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Level 2. With rules</title>
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
				<h1>Level 2. With rules</h1>
			</div>
			<div id="main">
				<form method="post" action="level2b.php">
					<div id="tabs">
						<ul>
							<li><button id="tabauthoring" type="submit" name="back" value="back" onclick="document.forms[0].action='level2.php';">Teacher | Authoring</button></li>
							<li><button id="tabdelivery" class="tabactive">Student | Delivery</button></li>
						</ul>
						<div id="tabindicator" class="deliveryindicator"></div>
					</div>
					<div id="delivery">
						<h2>Student answer</h2>
						<!-- This input will be replaced by a math input widget. -->
						<input type="hidden" class="wirisanswerfield wirisembeddedfeedback" name="studentAnswer" value="<?php echo $studentAnswer; ?>" />
						<!-- This input will contain question options from Wiris Quizzes Studio. -->
						<input type="hidden" class="wirisquestion" value="<?php echo $studentQuestion; ?>" />
						<!-- This input will contain evaluaion details to build the feedback. -->
						<input type="hidden" class="wirisquestioninstance" value="<?php echo $studentInstance; ?>" />
						<div id="testcontainer">
							<input type="submit" value="Test" id="test" name="test" class="wirissubmit"/>
							<strong><?php echo $feedback; ?></strong>
						</div>
						<!-- The default feedback will be inserted here; before the element with class="wirisanswerfeedback" -->
						<div class="wirisanswerfeedback"></div>
						<input type="hidden" name="question" value="<?php echo $question; ?>" />
						<input type="hidden" name="instance" value="<?php echo $instance; ?>" />
						<input type="hidden" name="correctAnswer" value="<?php echo $correctAnswer; ?>" />
					</div>
				</form>
				<div id="help">
					<p>
					This page shows how to integrate Wiris Quizzes within a PHP platform using Wiris Quizzes Studio.
					In this answering stage, a plain input field is replaced by a MathType or another widget depending on the question options.
					Then the answer is checked using not only the defined correct answer but also all the defined options. The real time syntax 
					checking system in MathType takes in count the choosen allowed input options.
					</p>
					<p>
					This example is the Level 2 one. Check the following level to discover all Wiris Quizzes features or the first level to 
					get an even simpler integration.
					</p>
				</div>
			</div>
		</div>
	</body>
</html>