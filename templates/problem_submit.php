<head>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Nanum Gothic' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://use.fontawesome.com/e97a7a61dd.js"></script>
	<script src="https://www.wiris.net/demo/editor/editor"></script>
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
</head>

<div id = "full-edit-container">
	<div class = "full-edit problem-text">
		<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Save and Exit</button>
		<h2>Problem <span class = "smaller">(LaTeX)</span></h2>
		<textarea type = "text"></textarea>
		<div class = "output">
			<button>Output<i class = "fa fa-angle-down"></i></button>
			<div class = "svg-output tex2jax_ignore"></div>
		</div>
	</div>
	<div class = "full-edit diagram">
		<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Save and Exit</button>
		<h2>Diagram <span class = "smaller">(svg)</span></h2>
		<textarea type = "text"></textarea>
		<div class = "output">
			<button>Output<i class = "fa fa-angle-down"></i></button>
			<p></p>
		</div>
	</div>
	<div class = "full-edit diagram-preview">
		<div>
			<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Exit</button>
			<h2>Diagram <span class = "smaller">(svg)</span></h2>
			<div class = "svg"></div>
		</div>
	</div>
	<div class = "full-edit solution">
		<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Save and Exit</button>
		<h2>Solution <span class = "smaller">(LaTeX)</span></h2>
		<textarea type = "text"></textarea>
		<div class = "output">
			<button>Output<i class = "fa fa-angle-down"></i></button>
			<p></p>
		</div>
	</div>
</div>

<div id = "container-fluid">
	<div id = "problem-submit">
		<div class = "flex">
			<div class = "problem-div container">
				<h3>Problem</h3>
				<div class = "input-container">
					<textarea type = "text" id = "problem-text" name = "problem-text"></textarea>
					<button class = "expand problem-text"><i class = "fa fa-reply"></i>Edit Full Screen</button>
				</div>
				<div class = "input-container">
					<h6>Diagram <span class = "smaller">(svg)</span></h6>
					<div class = "selector-buttons diagram">
						<div class = "indicator"><div></div></div>
						<button class = "file">File</button><button class = "code">Code</button><button class = "none">None</button>
					</div>
					<div class = "flex-options diagram">
						<div class = "diagram-file">
							<label for = "diagram" id = "diagram-file-label" class = "styled-button"><i class = "fa fa-upload"></i><span>Upload File</span>
								<input type = "file" id = "diagram" name = "diagram" accept = ".svg">
							</label>
							<div id = "file-name">
								File must be of type .svg
							</div>
						</div>
						<div>
							<textarea type = "text" id = "diagram-code" name = "diagram-code"></textarea>
							<button class = "expand diagram"><i class = "fa fa-reply"></i>Edit Full Screen</button>
						</div>

					</div>
				</div>
				<div class = "input-container">
					<h6>Hint One</h6>
					<input type = "text" id = "hint-one" name = "hint-one">
				</div>
				<div class = "input-container">
					<h6>Hint Two</h6>
					<input type = "text" id = "hint-two" name = "hint-two">
				</div>
			</div>
			<div class = "answer-div container">
				<h3>Answer</h3>
				<div class = "input-container">
					<div id = "answer"></div>
				</div>
				<div class = "input-container">
					<h6>Solution</h6>
					<textarea type = "text" id = "solution" name = "solution"></textarea>
					<button class = "expand solution"><i class = "fa fa-reply"></i>Edit Full Screen</button>
				</div>
			</div>
		</div>
		<div class = "flex">
			<div class = "topic-div container">
				<h3>Topic</h3>
				<div class = "input-container">
					<select id = "topic" name = "topic">
						<option disabled selected value> -- Select an Option -- </option>
						<option value = "hello">Hello</option>
						<option value = "what">What</option>
						<option value = "is">Is</option>
						<option value = "happening">Happening</option>
					</select>
				</div>
				<div class = "input-container">
					<h6>Main Focus</h6>
					<select id = "main-focus" name = "main-focus">
						<option disabled selected value> -- Select an Option -- </option>
						<option value = "hello">Hello</option>
						<option value = "what">What</option>
						<option value = "is">Is</option>
						<option value = "happening">Happening</option>
					</select>
				</div>
				<div class = "input-container">
					<h6>Other Foci</h6>
					<select id = "other-foci" name = "other-foci" multiple>
						<option value = "hello">Hello</option>
						<option value = "what">What</option>
						<option value = "is">Is</option>
						<option value = "happening">Happening</option>
					</select>
				</div>
			</div>
			<div class = "source-div container">
				<h3>Source</h3>
				<div class = "input-container">
					<select id = "source" name = "source">
						<option disabled selected value> -- Select an Option -- </option>
						<option value = "hello">Hello</option>
						<option value = "what">What</option>
						<option value = "is">Is</option>
						<option value = "happening">Happening</option>
					</select>
				</div>
				<div class = "input-container">
					<h6>Problem Number</h6>
					<input type = "text" id = "problem-number" name = "problem-number">
				</div>
			</div>
			<div class = "other-div container">
				<h3>Other</h3>
				<div class = "input-container">
					<h6>Difficulty</h6>
					<div id = "difficulty">
						<button><i class = "fa fa-star-o"></i></button>
						<button><i class = "fa fa-star-o"></i></button>
						<button><i class = "fa fa-star-o"></i></button>
						<button><i class = "fa fa-star-o"></i></button>
						<button><i class = "fa fa-star-o"></i></button>
					</div>
				</div>
				<div class = "input-container">
					<h6>Needs Calculus?</h6>
					<input type = "checkbox" id = "calculus" name = "calculus">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    (function($) {

        var editing = false;
        var problemTextEditingOutput = true;
        var diagramEditingOutput = true;
        var solutionEditingOutput = true;


        function nl2br (str, is_xhtml) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        $(document).ready(function() {

            setTimeout(function() {
                $("#answer").css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                $("#answer .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                $("#answer .wrs_formulaDisplayWrapper").css("top", "-8px");
            }, 500);

            var editor;
            editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en',
                'toolbar': '<toolbar ref = "quizzes"/>'
            });
            editor.insertInto(document.getElementById('answer'));
            $("#answer").css("height", "44px");


            $("#container-fluid").height(window.innerHeight);
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
            });

            $(document).on("click", function(event) {
                const div = $("#answer");
                if (event.pageX > div.offset().left && event.pageX < div.offset().left + div.width() && event.pageY > div.offset().top && event.pageY < div.offset().top + div.height()) {
                    div.css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#answer .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#answer .wrs_formulaDisplay").outerHeight()});
                    $("#answer .wrs_formulaDisplayWrapper").css("top", "-42px");
                    editing = true;
                } else {
                    div.css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                    $("#answer .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                    $("#answer .wrs_formulaDisplayWrapper").css("top", "-8px");
                    editing = false;
                }
            });

            $(document).keydown(function() {
                if (editing) {
                    $("#answer").css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#answer .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#answer .wrs_formulaDisplay").outerHeight()});
                }
            });


            $("#diagram").change(function(e) {
                $("#file-name").html(e.target.files[0].name + "<i class = 'fa fa-eye' title = 'Preview Diagram' style = 'display: inline-block; float: right; margin-top: 10px; cursor: pointer;'></i>");
                $("#file-name").css({"color": "#111521", "border-bottom": "1px dashed #111521", "padding-bottom": "5px"});
	            $("#diagram-file-label span").html("Change File");

                $("#file-name .fa-eye").on("click", function() {
                    $("#full-edit-container").css("display", "flex");
                    $(".full-edit.diagram-preview").css({"display": "flex"});

                    var file = e.target.files[0];
                    var reader = new FileReader();
                    reader.readAsText(file, "UTF-8");

                    reader.onload = function (evt) {
                        $(".diagram-preview.full-edit .svg").html(evt.target.result);
                    };

                    reader.onerror = function (evt) {
                        alert("Sorry! There was an error loading the file.")
                    };
                });
            });





            // Full Edit Functions
            $(".problem-text.expand").on("click", function() {
                $("#full-edit-container").css("display", "flex");
                $(".full-edit.problem-text").css({"display": "flex"});
                $(".problem-text.full-edit textarea").val($("#problem-text").val());
                $(".problem-text.full-edit .output p").html(nl2br($(".problem-text.full-edit textarea").val()));
                MathJax.typeset();
            });

            $(".problem-text.full-edit .return").on("click", function() {
                $("#full-edit-container").css("display", "none");
                $(".full-edit.problem-text").css({"display": "none"});
                $("#problem-text").val($(".problem-text.full-edit textarea").val());
            });

            $(".problem-text.full-edit .output button").on("click", function() {
                if (problemTextEditingOutput) {
                    $(".problem-text.full-edit .output").css({"height": "35px", "padding": "0 50px", "overflow": "hidden"});
                    $(".problem-text.full-edit .output .fa").css({"transform": "rotate(180deg)"});
                    $(".problem-text.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".problem-text.full-edit .output p").css({"visibility": "hidden", "transition": "visibility 0s ease 0s"});
                } else {
                    $(".problem-text.full-edit .output").css({"height": "30%", "padding": "45px 50px 20px 50px", "overflow": "auto"});
                    $(".problem-text.full-edit .output .fa").css({"transform": "rotate(0deg)"});
                    $(".problem-text.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".problem-text.full-edit .output p").css({"visibility": "visible", "transition": "visibility 0s ease 0.3s"});
                }
                problemTextEditingOutput = !problemTextEditingOutput;
            });


            $(".problem-text.full-edit textarea").on("input", function() {
                $(".problem-text.full-edit .output p").html(nl2br($(".problem-text.full-edit textarea").val()));
                MathJax.typeset();
            });


            // Diagram Preview Full Edit
            $(".diagram-preview.full-edit .return").on("click", function() {
                $("#full-edit-container").css("display", "none");
                $(".full-edit.diagram-preview").css({"display": "none"});

            });


            // Diagram Full Edit
            $(".diagram.expand").on("click", function() {
                $("#full-edit-container").css("display", "flex");
                $(".full-edit.diagram").css({"display": "flex"});
                $(".diagram.full-edit textarea").val($("#diagram-code").val());
                $(".diagram.full-edit .output p").html($(".diagram.full-edit textarea").val());
            });

            $(".diagram.full-edit .return").on("click", function() {
                $("#full-edit-container").css("display", "none");
                $(".full-edit.diagram").css({"display": "none"});
                $("#diagram-code").val($(".diagram.full-edit textarea").val());
            });

            $(".diagram.full-edit .output button").on("click", function() {
                if (diagramEditingOutput) {
                    $(".diagram.full-edit .output").css({"height": "35px", "padding": "0 50px", "overflow": "hidden"});
                    $(".diagram.full-edit .output .fa").css({"transform": "rotate(180deg)"});
                    $(".diagram.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".diagram.full-edit .output p").css({"visibility": "hidden", "transition": "visibility 0s ease 0s"});
                } else {
                    $(".diagram.full-edit .output").css({"height": "30%", "padding": "45px 50px 20px 50px", "overflow": "auto"});
                    $(".diagram.full-edit .output .fa").css({"transform": "rotate(0deg)"});
                    $(".diagram.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".diagram.full-edit .output p").css({"visibility": "visible", "transition": "visibility 0s ease 0.3s"});
                }
                diagramEditingOutput = !diagramEditingOutput;
            });

            $(".diagram.full-edit textarea").on("input", function() {
                $(".diagram.full-edit .output p").html($(".diagram.full-edit textarea").val());
            });


            // Solution Full Edit
            $(".solution.full-edit textarea").on("input", function() {
                $(".solution.full-edit .output p").html(nl2br($(".solution.full-edit textarea").val()));
                MathJax.typeset();
            });


            $(".solution.expand").on("click", function() {
                $("#full-edit-container").css("display", "flex");
                $(".full-edit.solution").css({"display": "flex"});
                $(".solution.full-edit textarea").val($("#solution").val());
                $(".solution.full-edit .output p").html(nl2br($(".solution.full-edit textarea").val()));
                MathJax.typeset();
            });

            $(".solution.full-edit .return").on("click", function() {
                $("#full-edit-container").css("display", "none");
                $(".full-edit.solution").css({"display": "none"});
                $("#solution").val($(".solution.full-edit textarea").val());
            });

            $(".solution.full-edit .output button").on("click", function() {
                if (solutionEditingOutput) {
                    $(".solution.full-edit .output").css({"height": "35px", "padding": "0 50px", "overflow": "hidden"});
                    $(".solution.full-edit .output .fa").css({"transform": "rotate(180deg)"});
                    $(".solution.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".solution.full-edit .output p").css({"visibility": "hidden", "transition": "visibility 0s ease 0s"});
                } else {
                    $(".solution.full-edit .output").css({"height": "30%", "padding": "45px 50px 20px 50px", "overflow": "auto"});
                    $(".solution.full-edit .output .fa").css({"transform": "rotate(0deg)"});
                    $(".solution.full-edit").css({"padding": "30px 50px 50px 50px"});
                    $(".solution.full-edit .output p").css({"visibility": "visible", "transition": "visibility 0s ease 0.3s"});
                }
                solutionEditingOutput = !solutionEditingOutput;
            });


            $(".solution.full-edit textarea").on("input", function() {
                $(".solution.full-edit .output p").html(nl2br($(".solution.full-edit textarea").val()));
                MathJax.typeset();
            });



	        // Button Selector Actions
	        $(".diagram.selector-buttons .file").on("click", function() {
                $(".diagram.selector-buttons .file").css("color", "white");
                $(".diagram.selector-buttons .code").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .none").css("color", "rgb(155, 155, 155)");
	            $(".diagram.selector-buttons .indicator").css("left", "0");

                $(".diagram.flex-options > div:first-child").css({"height": "inherit", "padding": "10px"});
                $(".diagram.flex-options > div:last-child").css({"height": "0", "padding": "0"});
	        });

            $(".diagram.selector-buttons .code").on("click", function() {
                $(".diagram.selector-buttons .file").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .code").css("color", "white");
                $(".diagram.selector-buttons .none").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .indicator").css("left", "33%");

                $(".diagram.flex-options > div:first-child").css({"height": "0", "padding": "0"});
                $(".diagram.flex-options > div:last-child").css({"height": "inherit", "padding": "10px"});
            });

            $(".diagram.selector-buttons .none").on("click", function() {
                $(".diagram.selector-buttons .file").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .code").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .none").css("color", "white");
                $(".diagram.selector-buttons .indicator").css("left", "66%");

                $(".diagram.flex-options > div:first-child").css({"height": "0", "padding": "0"});
                $(".diagram.flex-options > div:last-child").css({"height": "0", "padding": "0"});
            });



        });


    })(jQuery);
</script>