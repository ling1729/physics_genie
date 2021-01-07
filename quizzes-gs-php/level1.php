<?php 
	function get_param($name) {
		//Be comaptible with both magic_quotes on and off.
		return get_magic_quotes_gpc() ? stripslashes($_POST[$name]) : $_POST[$name];
	}
	function html_escape($text) {
		//Escape html special chars from UTF8-encoded strings.
		return htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
	}
	if(!empty($_POST['test'])){
		//Get user data. Since these variables come from MathType they are
		//math expressions encoded in MathML markup language.
		$correctAnswer = get_param('correctAnswer');
		$studentAnswer = get_param('studentAnswer');
		
		//Call Wiris Quizzes API to check the answer. This process implies a
		//remote HTTP call to Wiris Quizzes service. It will ulimately decide 
		//whether the student answer match the correct answer.
		
		//load the Wiris Quizzes library.
		require_once 'quizzes/quizzes.php';
		//build a request for the service.
		$builder  = com_wiris_quizzes_api_Quizzes::getInstance();
		$request  = $builder->newSimpleGradeRequest($correctAnswer, $studentAnswer);
		//Make the remote call.
		$service  = $builder->getQuizzesService();
		$response = $service->execute($request);
		//Get the response into this useful object.
		$instance = $builder->newQuestionInstance(null);
		$instance->update($response);
		//Ask for the correctness of the 0th response.
		$correct = $instance->areAllAnswersCorrect();
		//Set up output.
		$feedback = $correct ? 'Right! The answer is correct.' : 'Incorrect! The student answer does not match the correct one.';
		$correctAnswer = html_escape($correctAnswer);
		$studentAnswer = html_escape($studentAnswer);
	}else{
		//Set up output.
		$feedback = 'Click to check the answer.';
		$correctAnswer = '';
		$studentAnswer = '';
	}
?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Level 1. Grade</title>
		<!-- This stylesheet just style this tutorial elements. Wiris Quizzes don't need it -->
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
				<h1>Level 1. Grade</h1>
			</div>
			<div id="main">
				<form method="post">
					<div id="answers">
						<div id="column1">
							<h2>Teacher view | Authoring</h2>
							<!-- This input will be replaced by a MathType. -->
							<input type="hidden" class="wirisauthoringfield" name="correctAnswer" value="<?php echo $correctAnswer; ?>" />
						</div>
						<div id="column2">
							<h2>Student view | Delivery</h2>
							<!-- This input will be replaced by a MathType. -->
							<input type="hidden" class="wirisanswerfield" name="studentAnswer" value="<?php echo $studentAnswer; ?>" />
						</div>
						<div>
							<!-- Put here the desired language for MathType.
							Available languages are "en", "es", "ca", "pt", "pt_br", "it", "fr", "de", "da", no", "nn", "el" -->
							<input type="hidden" class="wirislang" value="en" />
							<div id="testcontainer">
								<input type="submit" value="Test" id="test" name="test"/>
								<strong><?php echo $feedback; ?></strong>
							</div>
						</div>
					</div>
					<div id="help">
						<p>
						This page shows how to integrate Wiris Quizzes within a PHP platform in a very simple but quite powerful way. 
						From the user interface point of view, Wiris Quizzes is replacing plain input fields by MathType. 
						From the grading point of view, the server uses Wiris Quizzes API to grade the answer using a remote symbolic math engine.
						</p>
						<p>
						This example is the simplest one, Level 1. Check the following to discover all Wiris Quizzes features.
						</p>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>