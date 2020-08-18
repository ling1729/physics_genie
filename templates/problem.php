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
<!--    <link rel="stylesheet" type="text/css" href="http://tikzjax.com/v1/fonts.css">-->
<!--    <script src="http://tikzjax.com/v1/tikzjax.js"></script>-->
</head>

<div id = "container-fluid">
    <div id = "problem">
        <div id = "already-entered" class = "error">You have already tried this response</div>
        <div id = "blank" class = "error">Please enter a response</div>
        <div id = "result" style = "display: none">
            <p id = "correct" style = "display: none">Correct</p>
            <p id = "incorrect" style = "display: none">Incorrect</p>
            <p id = "gave-up" style = "display: none">You Gave Up</p>
        </div>
        <p id = "problem-text"><?php echo $attributes['problem']->problem_text; ?></p>
        <div id = "hints">
            <p class = "hint one" style = "display: none">Hint: <?php echo $attributes['problem']->hint_one; ?></p>
            <p class = "hint two" style = "display: none">Hint: <?php echo $attributes['problem']->hint_two; ?></p>
        </div>
        <div id = "previous-answers">
            <span class = "previous-answer one"></span>
            <span class = "previous-answer two"></span>
        </div>
        <div class = "flex row problem">
            <div style = "width: 500px" id = "studentAnswer"><span></span></div>
            <div class = "buttons">
                <button id = "submit" class = "top">Submit</button>
                <button id = "give-up" class = "bottom">Give Up</button>
            </div>
        </div>

        <div id = "solution" style = "display: none">
            <div id = "student-answers"></div>
            <p style = "display: none" id = "answer">Answer: <span class = "correct"><?php echo $attributes['problem']->answer; ?></span></p>
            <p><?php echo $attributes['problem']->solution; ?></p>
        </div>
        <div class = "buttons">
            <button id = "save" style = "display: none">Save</button>
            <button id = "report" style = "display: none">Report an Error</button>
            <button id = "next" style = "display: none">Next</button>
        </div>
    </div>
</div>

<script>

    (function($) {

        var attempt = 1;
        var studentAnswers = [];
        const ordinalNumbers = ["First", "Second", "Third"];
        var saved = false;
        var editing = false;

        $(document).ready(function() {

            setTimeout(function() {
                $("#studentAnswer").css("height", ($("#studentAnswer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                $("#studentAnswer .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                $("#studentAnswer .wrs_formulaDisplayWrapper").css("top", "-8px");
            }, 500);

            var editor;
            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en',
                'toolbar': '<toolbar ref = "quizzes"/>'
            });
            editor.insertInto(document.getElementById('studentAnswer'));
            $("#studentAnswer").css("height", "44px");

            $("#container-fluid").height(window.innerHeight);
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
            });

            $("#submit").on("click", function() {
                // Change conditional string if necessary
                if (editor.getMathML().toString() === '<math xmlns="http://www.w3.org/1998/Math/MathML"/>') {
                    $("#blank").css({"top": "-" + $("#blank").outerHeight() + "px", "opacity": "1"});
                    setTimeout(function() {
                        $("#blank").css({"top": "0", "opacity": "0"});
                    }, 2000);
                } else if (studentAnswers.includes(editor.getMathML())) {
                    $("#already-entered").css({"top": "-" + $("#already-entered").outerHeight() + "px", "opacity": "1"});
                    setTimeout(function() {
                        $("#already-entered").css({"top": "0", "opacity": "0"});
                    }, 2000);
                } else {
                    studentAnswers.push(editor.getMathML());
                    if (answerValidator(editor.getMathML())) {
                        showAnswer("correct");
                    } else if (attempt === 1) {
                        wrongAnimation(function() {
                            $(".hint.one").show();
                            $(".previous-answer.one").html(editor.getMathML());
                            // editor.clear? <-- find this function
                            attempt++;
                        });
                    } else if (attempt === 2) {
                        wrongAnimation(function() {
                            $(".hint.two").show();
                            $(".previous-answer.two").html(",  " + editor.getMathML());
                            attempt++;
                            // editor.clear
                        });
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
            });

            $(document).on("click", function(event) {
                const div = $("#studentAnswer");
                if (event.pageX > div.offset().left && event.pageX < div.offset().left + div.width() && event.pageY > div.offset().top && event.pageY < div.offset().top + div.height()) {
                    div.css("height", ($("#studentAnswer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#studentAnswer .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#studentAnswer .wrs_formulaDisplay").outerHeight()});
                    $("#studentAnswer .wrs_formulaDisplayWrapper").css("top", "-42px");
                    editing = true;
                } else {
                    div.css("height", ($("#studentAnswer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                    $("#studentAnswer .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                    $("#studentAnswer .wrs_formulaDisplayWrapper").css("top", "-8px");
                    editing = false;
                }
            });

            $(document).keydown(function() {
                if (editing) {
                    $("#studentAnswer").css("height", ($("#studentAnswer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#studentAnswer .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#studentAnswer .wrs_formulaDisplay").outerHeight()});
                }
            });

        });


        function wrongAnimation(callback) {
            const problem = $("#problem");
            const duration = 80;
            problem.css("border-color", "#ff6469");
            $("#submit").addClass("before-red");
            $("#submit").css("border-color", "#ff6469");
            problem.animate({left: "-20px"}, duration);
            problem.animate({left: "20px"}, duration);
            problem.animate({left: "-20px"}, duration);
            problem.animate({left: "20px"}, duration);
            problem.animate({left: "0"}, duration, function() {
                setTimeout(function() {
                    problem.css("border-color", "#111521");
                    $("#submit").removeClass("before-red");
                    $("#submit").css("border-color", "#285380");
                    callback();
                }, 200);
            });
        }


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
            $("#previous-answers").hide();
            $("#hints").hide();
            $("#studentAnswer").hide();
            $("#correct").hide();
            $("#incorrect").hide();
            $("#gave-up").hide();
            $("#submit").hide();
            $("#give-up").hide();
            $("#already-entered").hide();
            $("#blank").hide();

            if (result === "correct") {
                $("#correct").show();
            } else if (result === "incorrect") {
                $("#incorrect").show();
            } else if (result === "gave-up") {
                $("#gave-up").show();
            }

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
