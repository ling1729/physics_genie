<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Caveat' rel='stylesheet'>
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
    <div id = "container">
        <div id = "problem">
            <div id = "progress-bars">
                <div class = "topic">
                    <h4>Mechanics</h4>
                    <div class = "bar">
                        <div class = "curr-progress"></div>
                        <div class = "advancement-progress">+10</div>
                    </div>
                    <div class = "badge"><div class = "img"></div></div>
                </div>
                <div class = "focus">
                    <h4>Angular Momentum</h4>
                    <div class = "bar">
                        <div class = "curr-progress"></div>
                        <div class = "advancement-progress">+10</div>
                    </div>
                    <div class = "badge"><div class = "img"></div></div>
                </div>
            </div>
            <div id = "already-entered" class = "error">You have already tried this response</div>
            <div id = "blank" class = "error">Please enter a response</div>
            <div id = "add-saved" class = "error">Problem added to saved</div>
            <div id = "remove-saved" class = "error">Problem remove from saved</div>
            <div id = "result" style = "display: none">
                <div id = "correct" style = "display: none"><i class = "fa fa-check"></i>Correct</div>
                <div id = "incorrect" style = "display: none"><i class = "fa fa-times"></i>Incorrect</div>
                <div id = "gave-up" style = "display: none"><i class = "fa fa-minus-circle"></i>You Gave Up</div>
            </div>
            <div id = "summary">
                <div class = "difficulty">
                    <span>Difficulty:</span>
                    <i class = "fa fa-star-o one" style = "margin-left: 5px;"></i>
                    <i class = "fa fa-star-o two"></i>
                    <i class = "fa fa-star-o three"></i>
                    <i class = "fa fa-star-o four"></i>
                    <i class = "fa fa-star-o five"></i>
                </div>
                <div class = "main-focus"><span class = "topic">Mechanics</span>><span class = "focus"></span></div>
                <div class = "secondary-focus"></div>
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
                    <button id = "submit" class = "blue top">Submit</button>
                    <button id = "give-up" class = "bottom">Give Up</button>
                </div>
            </div>

            <div id = "solution" style = "display: none">
                <div id = "student-answers"></div>
                <p style = "display: none" id = "answer">Answer: <span class = "correct"><?php echo $attributes['problem']->answer; ?></span></p>
                <p id = "solution-text"><?php echo $attributes['problem']->solution; ?></p>
            </div>
            <div class = "buttons">
                <button id = "save" class = "blue top" style = "display: none"><i class = "fa fa-plus"></i>Save</button>
                <button id = "report" class = "bottom" style = "display: none"><i class = "fa fa-flag"></i>Report an Error</button>
            </div>
            <button id = "next" style = "display: none">Next<div class = "arrow"><div></div><div></div><div></div></div></button>
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
        const topicStats = <?php echo json_encode($attributes['topic_stats']); ?>;
        const focusStats = <?php echo json_encode($attributes['focus_stats']); ?>;

        $(document).ready(function() {

            setTimeout(setProgress, 800);

            setSummary();

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
            if ($("#progress-bars").offset().top <= 100) {
                $("#container").css({"display": "block", "height": "inherit"});
                $("#container-fluid").css("overflow-y", "scroll");
                $("#problem").css("margin", "170px 20%");
            }
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
                if ($("#progress-bars").offset().top <= 100) {
                    $("#container").css({"display": "block", "height": "inherit"});
                    $("#container-fluid").css("overflow-y", "scroll");
                    $("#problem").css("margin", "170px 20%");
                }
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
                if (saved) {
                    jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                        'action': 'save_problem',
                        'problem_id': <?php echo $attributes['problem']->problem_id; ?>,
                        'saved': false
                    }, function() {
                        $("#save").html("<i class = 'fa fa-plus'></i>Save");
                        $("#remove-saved").css({"top": "-" + $("#remove-saved").outerHeight() + "px", "opacity": "1"});
                        setTimeout(function() {
                            $("#remove-saved").css({"top": "0", "opacity": "0"});
                        }, 1400);
                    });
                } else {
                    jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                        'action': 'save_problem',
                        'problem_id': <?php echo $attributes['problem']->problem_id; ?>,
                        'saved': true
                    }, function() {
                        $("#save").html("<i class = 'fa fa-minus'></i>Remove From Saved");
                        $("#add-saved").css({"top": "-" + $("#add-saved").outerHeight() + "px", "opacity": "1"});
                        setTimeout(function() {
                            $("#add-saved").css({"top": "0", "opacity": "0"});
                        }, 1400);
                    });
                }
                saved = !saved;
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


        function setProgress() {

            $("#progress-bars .badge .img").css({"width": "25px", "height": "25px", "top": "6px"});
            $("#progress-bars .focus .badge .img").css({"width": "30px", "height": "30px", "top": "1.5px"});

            if (topicStats === null) {
                $("#progress-bars .topic .badge").append("1");
            } else {
                $("#progress-bars .topic .badge").append("" + topicStats.level);
                $("#progress-bars .topic .bar .curr-progress").css("width", topicStats.xp + "%")
            }

            $("#progress-bars .topic .bar .advancement-progress").css("width", "10%");

            if (focusStats === null) {
                $("#progress-bars .focus .badge").append("1");
            } else {
                $("#progress-bars .focus .badge").append("" + topicStats.level);
                $("#progress-bars .topic .bar .curr-progress").css("width", topicStats.xp + "%")
            }

            $("#progress-bars .focus .bar .advancement-progress").css("width", "10%");

        }


        function setSummary() {

            for (var i = 2; i <= <?php echo $attributes['problem']->difficulty ?> + 1; i++) {
                $("#summary .difficulty .fa:nth-child(" + i + ")").removeClass("fa-star-o");
                $("#summary .difficulty .fa:nth-child(" + i + ")").addClass("fa-star");
            }

           $("#summary .focus").html("<?php echo $attributes['problem']->main_focus; ?>");
            const otherFoci = <?php echo json_encode($attributes['problem']->other_foci); ?>;
            if (otherFoci.length < 1) {
                $("#summary .secondary-focus").hide();
            } else {
                $("#summary .secondary-focus").html("Also Includes: " + otherFoci[0].name);
                for (var i = 1; i < otherFoci.length; i++) {
                    $("#summary .secondary-focus").append(", " + otherFoci[i].name);
                }
            }
        }


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
                    if ($("#progress-bars").offset().top <= 100) {
                        $("#container").css({"display": "block", "height": "inherit"});
                        $("#container-fluid").css("overflow-y", "scroll");
                        $("#problem").css("margin", "170px 20%");
                    }
                }, 200);
            });
        }


        // Result Strings
        //   Correct: 'correct'
        //   Incorrect: 'incorrect'
        //   Gave Up: 'gave-up'
        function showAnswer(result) {
            
            console.log(focusStats === null);
            console.log(("<?php echo $attributes['problem']->topic; ?>").charAt(0));

            jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                'action': 'submit_answer',
                'problem_id': <?php echo $attributes['problem']->problem_id; ?>,
                'num_attempts': attempt,
                'correct': (result === 'correct'),
                'skipped': (result === 'gave-up'),
                'first_in_topic': (topicStats === null),
                'first_in_focus': (focusStats === null),
                'topic': 0,
                'focus': ("<?php echo $attributes['problem']->topic; ?>").charAt(0)
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
            $("#progress-bars .advancement-progress").hide();

            if (result === "correct") {
                $("#correct").show();
                $("#problem").css("border", "1px solid rgb(5, 178, 0)");
                if (topicStats === null) {
                    $("#progress-bars .topic .curr-progress").css("width", "10%");
                } else {
                    $("#progress-bars .topic .curr-progress").css("width", (parseInt(topicStats.xp) + 10) + "%");
                }
                if (focusStats === null) {
                    $("#progress-bars .focus .curr-progress").css("width", "10%");
                } else {
                    $("#progress-bars .focus .curr-progress").css("width", (parseInt(focusStats.xp) + 10) + "%");
                }
            } else if (result === "incorrect") {
                $("#incorrect").show();
                $("#problem").css("border", "1px solid #ff6469");
            } else if (result === "gave-up") {
                $("#gave-up").show();
            }

            for (var i = 0; i < studentAnswers.length; i++) {
                var answerClass = "incorrect";
                if (result === "correct" && i === attempt - 1) {
                    answerClass = "correct";
                }
                $("#student-answers").append("<div class = '" + answerClass + "'>" + ordinalNumbers[i] + " Response: " + studentAnswers[i] + "</div>");
            }

            if (result === "incorrect" || result === "gave-up") {
                $("#answer").show();
            }

            if ($("#progress-bars").offset().top <= 100) {
                $("#container").css({"display": "block", "height": "inherit"});
                $("#container-fluid").css("overflow-y", "scroll");
                $("#problem").css("margin", "170px 20%");
            }
        }

        function answerValidator(studentAnswer) {
            return (studentAnswer.toString() === '<math xmlns="http://www.w3.org/1998/Math/MathML"><mn>2</mn><mi>k</mi></math>');
        }


    })(jQuery);
</script>
