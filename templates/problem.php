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
        <div id = "result" style = "display: none">
            <p id = "correct" style = "display: none">Correct</p>
            <p id = "incorrect" style = "display: none">Incorrect</p>
            <p id = "gave-up" style = "display: none">You Gave Up</p>
        </div>
        <p><?php echo $attributes['results']->problem_text; ?></p>
        <div id = "hints">
            <p class = "hint one" style = "display: none">Hint: <?php echo $attributes['results']->hint_one; ?></p>
            <p class = "hint two" style = "display: none">Hint: <?php echo $attributes['results']->hint_two; ?></p>
        </div>
        <div style = "width: 500px; height: 200px" id = "studentAnswer"><span></span></div>
        <div id = "solution" style = "display: none">
            <div id = "student-answers"></div>
            <p style = "display: none" id = "answer">Answer: <span class = "correct"><?php echo $attributes['results']->answer; ?></span></p>
            <p><?php echo $attributes['results']->solution; ?></p>
        </div>
        <div id = "buttons">
            <button id = "submit">Submit</button>
            <button id = "give-up">Give Up</button>
            <button id = "save">Save</button>
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

        $(document).ready(function() {


            var editor;
            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor.insertInto(document.getElementById('studentAnswer'));

            $("#container-fluid").height(window.innerHeight);
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
            });

            $("#submit").on("click", function() {
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
            });

            $("#give-up").on("click", function() {
                showAnswer("gave-up");
            });

        });

        // Result Strings
        //   Correct: 'correct'
        //   Incorrect: 'incorrect'
        //   Gave Up: 'gave-up'
        function showAnswer(result) {

            // Show divs
            $("#solution").show();
            $("#result").show();
            $("#report").show();
            $("#next").show();

            // Hide divs
            $("#hints").hide();
            $("#studentAnswer").hide();
            $("#correct").hide();
            $("#incorrect").hide();
            $("#gave-up").hide();
            $("#submit").hide();
            $("#give-up").hide();

            if (result === "correct") {
                $("#correct").show();
            } else if (result === "incorrect") {
                $("#incorrect").show();
            } else if (result === "gave-up") {
                $("#gave-up").show();
            }

            const ordinalNumbers = ["First", "Second", "Third"];
            console.log(studentAnswers.length);
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
