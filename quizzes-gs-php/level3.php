<?php
function get_param($name) {
	//Be comaptible with both magic_quotes on and off.
	return get_magic_quotes_gpc() ? stripslashes($_POST[$name]) : $_POST[$name];
}
function html_escape($text) {
	//Escape html special chars from UTF8-encoded strings.
	return htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
}
//Get user data.
	if(!empty($_POST['back'])){
		$question = get_param('question');
		$text = get_param('text');
		$feedbackText = get_param('feedbackText');
		
		//Build question object to read the correct answer.
		require_once 'quizzes/quizzes.php';
		$builder = com_wiris_quizzes_api_Quizzes::getInstance();
		$questionObject = $builder->readQuestion($question);
		$slots = $questionObject->getSlots();
		$slot = $slots[0];
		$authorAnswers = $slot->getAuthorAnswers();
		$authorAnswer = $authorAnswers[0];
		$correctAnswer = $authorAnswer->getValue();	
	}else{
		$question = '';
		$correctAnswer = '';
		$text = '';
		$feedbackText = '';
	}
//Warning: in a production environment, $text variable should be sanitized in
//order to avoid XSS security issues.
	$question = html_escape($question);
	$correctAnswer = html_escape($correctAnswer);
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
		<!-- The following line includes the CKEditor JavaScript.-->
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
							<li><button id="tabauthoring" class="tabactive">Teacher | Authoring</button></li>
							<li><button id="tabdelivery" type="submit" name="deliver" value="deliver">Student | Delivery</button></li>
						</ul>
						<div id="tabindicator" class="authoringindicator"></div>
					</div>
					<div id="authoring">
						<div id="text">
							<h2>Question text</h2>
							<!-- This textarea will be replaced with a CKEditor enchanced with MathType Plugin -->
							<textarea name="text" class="ckeditor"><?php echo $text; ?></textarea>
						</div>
						<h2>Correct answer</h2>
						<!-- This input will be replaced by a button launching the Wiris Quizzes Studio. It will have also the variables tab with Wiris Cas applet. -->
						<input type="hidden" class="wirisauthoringfield wirisstudio wirisvariables wirisauxiliarcas wirisgradingfunction" name="correctAnswer" value="<?php echo $correctAnswer; ?>" />
						<!-- This input will contain all question options from Wiris Quizzes Studio -->
						<input type="hidden" name="question" class="wirisquestion" value="<?php echo $question; ?>" />
						<!-- Put here the desired language for Wiris Quizzes Studio and MathType. Available languages are "en", "es", "ca", "it" -->
						<input type="hidden" class="wirislang" value="en" />
						<h2>Feedback text</h2>
						<textarea name="feedbackText" class="ckeditor"><?php echo $feedbackText; ?></textarea>
						<!-- Put here the desired language for Wiris Quizzes Studio and MathType.
						Available languages are "en", "es", "ca", "pt", "pt_br", "it", "fr", "de", "da", no", "nn", "el" -->
						<input type="hidden" class="wirislang" value="en" />
					</div>
					<div id="help">
						<p>
		          This page shows how to integrate Wiris Quizzes within a PHP platform using 
		          Wiris Quizzes Studio and automatically generated variables. In this authoring stage, in 
		          addition to Level 2 features, Wiris Quizzes Studio contains a new tab where the author 
		          can define an algorithm in order to generate output variables. The question text, 
		          the correct answer and the feedback can contain placeholders that will be replaced by the 
		          matching variables. The notation for placeholders is #a for a variable named 
		          <em>a</em>. In this level the author can also produce a custom feedback using 
				  the values of the variables and the student's answer. The value of the student's answer 
				  can be used within the algorithm, defining the parameter <em>answer</em> 
				  and treating it as another variable.
						</p>
						<p>
		          This example is the Level 3 one. Check the Level 1 and Level 2 examples to find 
		          simpler integrations.
						</p>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>