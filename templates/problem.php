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

<div id = "container-fluid">
    <div id = "problem-line"></div>
    <div id = "problem">
        <p><?php echo $attributes['results']->problem_text; ?></p>
    </div>
</div>

<!--        <div style="width:500px;height:200px" id="studentAnswer"><span></span></div>-->
<!--        <br>-->
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
    (function($) {

        $(document).ready(function() {

            console.log("hello");

            const container = $("#container-fluid");

//            var editor;
//            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
//            editor.insertInto(document.getElementById('studentAnswer'));
//
//
//            alert(editor.getMathML());

            container.height(window.innerHeight);
            window.addEventListener("resize", function() {
                container.height(window.innerHeight);
            });

        });


    })(jQuery);
</script>
