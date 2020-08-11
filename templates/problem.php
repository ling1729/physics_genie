<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
        <script>
            MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']]
                }
            };
        </script>
        <script id="MathJax-script" async
                src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
        </script>
        <script src="https://www.wiris.net/demo/editor/editor"></script>
    </head>
    <div id = "problem">
        <p style = "margin-left: 200px;"><?php echo $attributes['results']->problem_text; ?></p>

        <!-- This input will be replaced by a MathType instance. -->
        <div style="width:500px;height:200px" id="studentAnswer"><span></span></div>
        <br>
    </div>

<!--    <h1>A: --><?php
//    require_once '../quizzes-gs-php/quizzes/quizzes.php';
//    $correctAnswer = "x+1";
//    $studentAnswer = "1+x";
//    //build a request for the service.
//    $builder = com_wiris_quizzes_api_Quizzes::getInstance();
//    $request = $builder->newSimpleGradeRequest($correctAnswer, $studentAnswer);
//    //Make the remote call.
//    $service = $builder->getQuizzesService();
//    $response = $service->execute($request);
//    //Get the response into QuestionInstance object. This object allows us to interpret the response of the service and see if the student's answer is correct.
//    $instance = $builder->newQuestionInstance(null);
//    $instance->update($response);
//    //Ask for the correctness of the answer
//    $correct = $instance->areAllAnswersCorrect();
//    echo $builder;
//    ?><!--</h1>-->

    <script>

        var editor;
        window.onload = function () {
            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor.insertInto(document.getElementById('studentAnswer'));
        };


        alert(editor.getMathML());

        console.log("<?php echo 'Hello World' ?>");
        console.log("<?php echo $attributes['results']->problem_text; ?>");

    </script>
</html>