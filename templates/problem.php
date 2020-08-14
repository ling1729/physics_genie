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
    <div id = "problem">
        <div id = "already-entered" style = "display: none">
            <p>You have already tried this response</p>
        </div>
        <div id = "result" style = "display: none">
            <p id = "correct" style = "display: none">Correct</p>
            <p id = "incorrect" style = "display: none">Incorrect</p>
            <p id = "gave-up" style = "display: none">You Gave Up</p>
        </div>
        <p><?php echo $attributes['problem']->problem_text; ?></p>
        <div id = "hints">
            <p class = "hint one" style = "display: none">Hint: <?php echo $attributes['problem']->hint_one; ?></p>
            <p class = "hint two" style = "display: none">Hint: <?php echo $attributes['problem']->hint_two; ?></p>
        </div>
        <div style = "width: 500px; height: 200px" id = "studentAnswer"><span></span></div>
        <div id = "solution" style = "display: none">
            <div id = "student-answers"></div>
            <p style = "display: none" id = "answer">Answer: <span class = "correct"><?php echo $attributes['problem']->answer; ?></span></p>
            <p><?php echo $attributes['problem']->solution; ?></p>
        </div>
        <div id = "buttons">
            <button id = "submit">Submit</button>
            <button id = "give-up">Give Up</button>
            <button id = "save" style = "display: none">Save</button>
            <button id = "report" style = "display: none">Report an Error</button>
            <button id = "next" style = "display: none">Next</button>
        </div>
    </div>
    <div id = "solution" style = "display: none">
    </div>
</div>

<script>
    (function($) {

        var attempt = 1;
        var studentAnswers = [];
        var saved = false;

        $(document).ready(function() {


            var editor;
            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor.insertInto(document.getElementById('studentAnswer'));

            $("#container-fluid").height(window.innerHeight);
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
            });

            $("#submit").on("click", function() {
                if (studentAnswers.includes(editor.getMathML())) {
                    $("#already-entered").show();
                } else {
                    $("#already-entered").hide();
                    studentAnswers.push(editor.getMathML());
                    if (answerValidator(editor.getMathML())) {
                        showAnswer("correct");
                    } else if (attempt === 1) {
                        $(".hint.one").show();
                        attempt++;
                        // editor.clear? <-- find this function
                    } else if (attempt === 2) {
                        $(".hint.two").show();
                        attempt++;
                        // editor.clear
                    } else {
                        showAnswer("incorrect");
                    }
                }
            });

            $("#give-up").on("click", function() {
                showAnswer("gave-up");
            });

            $("#next").on("click", function() {
                location.reload();
            });

            $("#save").on("click", function() {
                saved = !saved;
                jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                    'action': 'save_problem',
                    'problem_id': <?php echo $attributes['problem']->problem_id; ?>,
                    'saved': saved
                }, null);
            })

        });


        // Result Strings
        //   Correct: 'correct'
        //   Incorrect: 'incorrect'
        //   Gave Up: 'gave-up'
        function showAnswer(result) {

            jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                'action': 'submit_answer',
                'problem_id': <?php echo $attributes['problem']->problem_id; ?>,
                'num_attempts': attempt,
                'correct': (result === 'correct'),
                'skipped': (result === 'gave-up')
            }, null);

            // Show divs
            $("#solution").show();
            $("#result").show();
            $("#report").show();
            $("#next").show();
            $("#save").show();

            // Hide divs
            $("#hints").hide();
            $("#studentAnswer").hide();
            $("#correct").hide();
            $("#incorrect").hide();
            $("#gave-up").hide();
            $("#submit").hide();
            $("#give-up").hide();
            $("#already-entered").hide();

            if (result === "correct") {
                $("#correct").show();
            } else if (result === "incorrect") {
                $("#incorrect").show();
            } else if (result === "gave-up") {
                $("#gave-up").show();
            }

            const ordinalNumbers = ["First", "Second", "Third"];
            for (var i = 0; i < studentAnswers.length; i++) {
                var answerClass = "incorrect";
                if (result === "correct" && i === attempt - 1) {
                    answerClass = "correct";
                }
                $("#student-answers").append("<p>" + ordinalNumbers[i] + " Answer: <span class = '" + answerClass + "'>" + studentAnswers[i] + "</span></p>");
            }

            if (result === "incorrect" || result === "gave-up") {
                $("#answer").show();
            }
        }

        function answerValidator(studentAnswer) {
            return (studentAnswer.toString() === '<math xmlns="http://www.w3.org/1998/Math/MathML"><mn>2</mn><mi>k</mi></math>');
        }


    })(jQuery);
</script>
