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
		$correctAnswer = get_param('correctAnswer');
	}else{
		$question = '';
		$correctAnswer = '';
	}
	$question = html_escape($question);
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
							<li><button id="tabauthoring" class="tabactive">Teacher | Authoring</button></li>
							<li><button id="tabdelivery" type="submit" name="deliver" value="deliver">Student | Delivery</button></li>
						</ul>
						<div id="tabindicator" class="authoringindicator"></div>
					</div>
					<div id="authoring">
						<h2>Correct answer</h2>
						<!-- This input will be replaced by a button launching the Wiris Quizzes Studio. -->
						<input type="hidden" class="wirisauthoringfield wirisstudio" name="correctAnswer" value="<?php echo $correctAnswer; ?>" />
						<!-- This input will contain all question options from Wiris Quizzes Studio -->
						<input type="hidden" name="question" class="wirisquestion" value="<?php echo $question; ?>" />
						<!-- Put here the desired language for Wiris Quizzes Studio and MathType.
						Available languages are "en", "es", "ca", "pt", "pt_br", "it", "fr", "de", "da", no", "nn", "el" -->
						<input type="hidden" class="wirislang" value="en" />
					</div>
					<div id="help">
						<p>
						This page shows how to integrate Wiris Quizzes within a PHP platform using Wiris Quizzes Studio.
						In this authoring stage, Wiris Quizzes replaces a plain input field by the Wiris Quizzes Studio interface that allows
						fine tunning mathematical answer checking. It saves all the options in another plain input field so they can
						be sent to the answering page.
						</p>
						<p>
						This example is the Level 2 one. Check the following to discover all Wiris Quizzes features or the first to 
						get an even simpler integration.
						</p>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>