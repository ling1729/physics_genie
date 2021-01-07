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

<div id = "psp">
    <h1>Welcome Problem Submitter!</h1>
    <button class = "styled-button" id = "start-submission" style = "padding: 12px 17px;">Submit a Problem</button>
    <div id = "past-problems">
        <div id = "load-more"><button>Load More</button></div>
    </div>
</div>

<div id = "full-edit-container">
	<div class = "full-edit problem-text">
		<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Save and Exit</button>
		<h2>Problem <span class = "smaller">(LaTeX)</span></h2>
		<textarea type = "text"></textarea>
		<div class = "output">
			<button>Output<i class = "fa fa-angle-down"></i></button>
			<p></p>
		</div>
	</div>
	<div class = "full-edit diagram">
		<button class = "return styled-button"><i class = "fa fa-paper-plane"></i>Save and Exit</button>
		<h2>Diagram <span class = "smaller">(svg)</span></h2>
		<textarea type = "text"></textarea>
		<div class = "output">
			<button>Output<i class = "fa fa-angle-down"></i></button>
			<p class = "tex2jax_ignore"></p>
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

<div id = "container-fluid" class = "psp">
    <div>
        <button id = "stop-editing"><i class = "fa fa-arrow-up"></i></button>
    </div>
    <div id = "errors">
        <p>Please address the following errors before submitting again:</p>
        <ul></ul>
    </div>
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
                    <div class = "selector-buttons hint-two">
                        <div class = "indicator"><div></div></div>
                        <button class = "include">Include</button><button class = "none">None</button>
                    </div>
                    <div class = "flex-options hint-two">
                        <input type = "text" id = "hint-two" name = "hint-two">
                    </div>
				</div>
			</div>
			<div class = "answer-div container">
				<h3>Answer</h3>
				<div class = "input-container">
					<div id = "answer"></div>
				</div>
				<div class = "input-container solution">
					<h6>Solution <span class = "smaller">(LaTeX)</span></h6>
					<textarea type = "text" id = "solution" name = "solution"></textarea>
					<button class = "expand solution"><i class = "fa fa-reply"></i>Edit Full Screen</button>
				</div>
			</div>
		</div>
		<div class = "flex">
			<div class = "topic-div container">
				<h3>Topic</h3>
				<div class = "input-container topic">
					<select id = "topic" name = "topic">
						<option disabled selected value> -- Select a Topic -- </option>
						<option value = "0">Mechanics</option>
					</select>
				</div>
				<div class = "input-container">
					<h6>Main Focus</h6>
					<select id = "main-focus" name = "main-focus">
						<option disabled selected value> -- Select a Focus -- </option>
					</select>
				</div>
				<div class = "input-container">
					<h6>Other Foci</h6>
					<div class = "other-foci">
                        <button><i class = "fa fa-plus"></i>Add Focus</button>
                    </div>
				</div>
			</div>
			<div class = "source-div container">
				<h3>Source</h3>
				<div class = "input-container source">
					<select id = "source" name = "source">
						<option disabled selected value> -- Select a Source -- </option>
						<option value = "other" id = "source-other-option">Other...</option>
					</select>
                    <div class = "source-other">
                        <div>
                            <i class = "fa fa-reply" style = "transform: rotate(180deg)"></i>
                            <p>Category: </p>
                            <select type = "text" class = "source-other-select source-other" name = "source-other-select">
                                <option disabled selected value> -- Select a Category -- </option>
                            </select>
                        </div>
                        <div>
                            <i class = "fa fa-reply" style = "transform: rotate(180deg)"></i>
                            <p>Source:</p>
                            <input type = "text" class = "source-other" id = "source-other" name = "source-other">
                        </div>
                        <div>
                            <i class = "fa fa-reply" style = "transform: rotate(180deg)"></i>
                            <p>Author: </p>
                            <input type = "text" class = "author-other" name = "author-other">
                        </div>

                    </div>
				</div>
				<div class = "input-container">
					<h6>Problem Number in Source</h6>
					<input type = "text" id = "problem-number" name = "problem-number">
				</div>
			</div>
			<div class = "other-div container">
				<h3>Other</h3>
				<div class = "input-container">
					<h6>Difficulty</h6>
					<div id = "difficulty">
						<i class = "fa fa-star-o" data-rating = "1"></i><i class = "fa fa-star-o" data-rating = "2"></i><i class = "fa fa-star-o" data-rating = "3"></i><i class = "fa fa-star-o" data-rating = "4"></i><i class = "fa fa-star-o" data-rating = "5"></i>
					</div>
				</div>
				<div class = "input-container">
					<h6>Calculus?</h6>
                    <div class = "selector-buttons calculus">
                        <div class = "indicator"><div></div></div>
                        <button class = "none">None</button><button class = "helps">Helps</button><button class = "required">Required</button>
                    </div>
                </div>
			</div>
            <button class = "styled-button" id = "submit"><i class = "fa fa-database"></i>SUBMIT</button>
		</div>
	</div>
</div>

<script>
    (function($) {

        var problems = <?php echo json_encode($attributes['problems']); ?>;
        var focuses = <?php echo json_encode($attributes['focuses']); ?>;
        var sources = <?php echo json_encode($attributes['sources']); ?>;
        var sourceCategories = <?php echo json_encode($attributes['source_categories']); ?>;

        var editingProblem = false;
        var editingProblemID = -1;
        var formOpen = false;

        // Setting up WIRIS editor
        var editor;
        editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en',
            'toolbar': '<toolbar ref = "quizzes"/>'
        });
        editor.insertInto(document.getElementById('answer'));

        function escString(string) {
            return string.replace(/\\\\/g, "\\").replace(/\\"/g, "'")
        }

        console.log(editor.getMathML().toString());


        /////////////////////////////////////////////////////////////////////////////////////////////
        // Problem Submit Parent Page

        $(document).ready(function() {



            // Past Problems Setup
            for (var i = 0; i < problems.length; i++) {
                problems[i].problem_text = escString(problems[i].problem_text);

                var html = "<div class = 'problem showing'>" +
                    "<div class = 'buttons'>" +
                    "<button class = 'styled-button edit'><i class = 'fa fa-pencil'></i>Edit</button>" +
                    "<a class = 'preview' href = '" + "<?php echo get_page_link( get_page_by_path( 'play/problem' )->ID ); ?>?problem=" + problems[i].problem_id + "' target = '_blank'><button class = 'styled-button preview'><i class = 'fa fa-eye'></i>Preview</button></a>" +
                    "</div><div class = 'topic-focus'><span class = 'topic'>Mechanics</span>><span class = 'focus'>" + focuses.filter(function(focus) {return focus.focus === problems[i].main_focus})[0].name + "</span></div>";

                if (problems[i].problem_text.length <= 200) {
                    html += "<p class = 'problem-text'>" + problems[i].problem_text + "</p>";
                } else {
                    var problemText = problems[i].problem_text.slice(0, 200);
                    if ((problemText.match(/\$/g)||[]).length % 2 === 1) {
                        problemText = problemText.slice(0, problemText.lastIndexOf("$"));
                    }
                    html += "<p class = 'problem-text'>" + problemText + " ...</p>";
                }

                html += "<div class = 'info'>" +
                    "<h6 class = 'source'>" + sources.filter(function(source) {return source.source_id === problems[i].source})[0].source + "</h6>" +
                    "<div class = 'difficulty'>";

                for (var j = 0; j < 5; j++) {
                    if (j < problems[i].difficulty) {
                        html += "<i class = 'fa fa-star'></i>";
                    } else {
                        html += "<i class = 'fa fa-star-o'></i>"
                    }
                }

                html += "</div></div>";

                html += "</div>";
                $("#load-more").before(html);
                MathJax.typeset();

                if (i >= 5) {
                    $("#past-problems .problem").eq(i).removeClass("showing");
                }
            }

            $("#load-more button").on("click", function() {
                console.log("Hello worlodlds");
                var currDisplayed = $("#past-problems .problem.showing").length - 1;

                var newDisplayed = currDisplayed + 5;
                if (newDisplayed >= problems.length) {
                    newDisplayed = problems.length;
                    $("#load-more").hide();
                }

                for (var i = currDisplayed; i < newDisplayed; i++) {
                    $("#past-problems .problem").eq(i).addClass("showing");
                }
            });

            $("#past-problems .problem .buttons .edit").on("click", function() {

                if (!confirm("To edit this problem, all fields currently filled out for a new problem submission will be emptied. Are you sure you would like to continue?")) {
                    return;
                }

                editingProblem = true;
                var currProblem = problems[$(this).parent().parent().index()];
                editingProblemID = currProblem.problem_id;

                $("#errors").hide();
                $("#problem-text").val(currProblem.problem_text);
                $("#diagram").val(null);
                $("#file-name").html("File must be of type .svg");
                $("#file-name").css({"border-bottom": "none", "padding-bottom": "0", "color": "rgba(17, 21, 33, 0.75)"});
                $("#diagram-file-label span").html("Upload File");

                if (currProblem.diagram === null) {
                    $(".selector-buttons.diagram .file").trigger("click");
                    $("#diagram-code").val(null);
                } else {
                    $(".selector-buttons.diagram .code").trigger("click");
                    $("#diagram-code").val(escString(currProblem.diagram));
                }

                $("#hint-one").val(escString(currProblem.hint_one));

                if (currProblem.hint_two === null) {
                    $(".selector-buttons.hint-two .none").trigger("click");
                } else {
                    $(".selector-buttons.hint-two .include").trigger("click");
                    $("#hint-two").val(escString(currProblem.hint_two));
                }

                editor.setMathML(escString(currProblem.answer));
                $("#solution").val(escString(currProblem.solution));

                // Topic and Main Focus
                $("#topic").val(currProblem.topic).trigger("change");
                $("#main-focus").val(currProblem.main_focus).trigger("change");


                // Other Foci
                // Resets Fields
                $(".input-container .other-foci").html("<button><i class = 'fa fa-plus'></i>Add Focus</button>");

                $(".input-container .other-foci button").on("click", function() {
                    var html = "<div class = 'other-focus'><select class = 'other-focus' name = 'other-focus' style = 'width: 95%;'>";
                    for (var i = 0; i < focuses.length; i++) {
                        html = html + "<option value = '" + focuses[i].focus + "'>" + focuses[i].name + "</option>";
                    }
                    html = html + "</select><i class = 'fa fa-times' style = 'color: red; cursor: pointer;'></i></div>";

                    problemData.otherFoci.push("0");

                    $(".input-container.source").css({"margin-bottom": "30px"});
                    $(".input-container .other-foci button").before(html);
                    $(".input-container .other-foci .other-focus i").on("click", function(event) {
                        event.target.parentElement.remove();
                        problemData.otherFoci.splice($(this).parent().index(), 1);
                    });
                    $(".input-container select.other-focus").change(function() {
                        problemData.otherFoci[$(this).parent().index()] = $(this).val();
                    });
                });

                // Sets New Fields
                if (currProblem.other_foci !== null) {
                    var otherFoci = currProblem.other_foci.split("");
                    for (var i = 0; i < otherFoci.length; i++) {

                        var html = "<div class = 'other-focus'><select class = 'other-focus' name = 'other-focus' style = 'width: 95%;'>";
                        for (var j = 0; j < focuses.length; j++) {
                            if (focuses[j].focus === otherFoci[i]) {
                                html = html + "<option value = '" + focuses[j].focus + "' selected>" + focuses[j].name + "</option>";
                            } else {
                                html = html + "<option value = '" + focuses[j].focus + "'>" + focuses[j].name + "</option>";
                            }
                        }
                        html = html + "</select><i class = 'fa fa-times' style = 'color: red; cursor: pointer;'></i></div>";

                        $(".input-container.source").css({"margin-bottom": "30px"});
                        $(".input-container .other-foci button").before(html);
                        $(".input-container .other-foci .other-focus i").on("click", function(event) {
                            event.target.parentElement.remove();
                            problemData.otherFoci.splice($(this).parent().index(), 1);
                        });
                        $(".input-container select.other-focus").change(function() {
                            problemData.otherFoci[$(this).parent().index()] = $(this).val();
                        });

                        problemData.otherFoci.push(otherFoci[i]);

                    }
                }


                // Source
                $("#source").val(currProblem.source).trigger("change");
                $("#problem-number").val(escString(currProblem.number_in_source));


                // Misc Fields
                $("#difficulty .fa").eq(parseInt(currProblem.difficulty) - 1).trigger("click");

                if (currProblem.calculus === "None") {
                    $(".selector-buttons.calculus .none").trigger("click");
                } else if (currProblem.calculus === "Helps") {
                    $(".selector-buttons.calculus .helps").trigger("click");
                } else if (currProblem.calculus === "Required") {
                    $(".selector-buttons.calculus .required").trigger("click");
                }


                $("#container-fluid").css("top", "0");
                formOpen = true;
            });

            $("#psp").height(window.innerHeight);
            window.addEventListener("resize", function() {
                $("#psp").height(window.innerHeight);
            });


            $("#start-submission").on("click", function() {
                $("#container-fluid").css("top", "0");
                formOpen = true;
            });

        });





        /////////////////////////////////////////////////////////////////////////////////////////////
        // Problem Submission Tab


        var editing = false;
        var problemTextEditingOutput = true;
        var diagramEditingOutput = true;
        var solutionEditingOutput = true;

        var divExpandedBounds = {
            top: 0,
	        left: 0,
	        bottom: 0,
	        right: 0
	    };


        var problemData = {
            diagram: "file",
            diagramFile: "",
            hintTwo: "",
            otherFoci: [],
            difficulty: 0,
            calculus: "None"
        };


        function nl2br (str, is_xhtml) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        function hasDuplicates(arr) {
            var counts = [];

            for (var i = 0; i <= arr.length; i++) {
                if (counts[arr[i]] === undefined) {
                    counts[arr[i]] = 1;
                } else {
                    return true;
                }
            }
            return false;
        }


        $(document).ready(function() {

            // Input Setup

            for (var i = 0; i < focuses.length; i++) {
                $("#main-focus").append("<option value = '" + focuses[i].focus + "'>" + focuses[i].name + "</option>")
            }

            for (var i = 0; i < sourceCategories.length; i++) {
                var html = "<optgroup label = '" + sourceCategories[i].category + "'>";
                var currSources = sources.filter(function(source) {
                    return source.category === sourceCategories[i].category;
                });
                for (var e = 0; e < currSources.length; e++) {
                    html = html + "<option value = '" + currSources[e].source_id + "'>" + currSources[e].source + " (" + currSources[e].author + ")</option>"
                }
                html = html + "</optgroup>";
                $("#source-other-option").before(html);

                $(".source-other-select").append("<option value = '" + sourceCategories[i].category + "'>" + sourceCategories[i].category + "</option>");
            }

            /////////////

            setTimeout(function() {
                $("#answer").css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                $("#answer .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                $("#answer .wrs_formulaDisplayWrapper").css("top", "-8px");
            }, 1000);



            $("#container-fluid").height(window.innerHeight);
            $("#container-fluid").css("top", window.innerHeight + "px");
            window.addEventListener("resize", function() {
                $("#container-fluid").height(window.innerHeight);
                $("#psp").height(window.innerHeight);
                if (!formOpen) {
                    $("#container-fluid").css("top", window.innerHeight + "px");
                }
            });
            $("#answer").css("height", "44px");

            $("#stop-editing").on("click", function() {
                $("#container-fluid").css("top", window.innerHeight + "px");

                formOpen = false;
                if (editingProblem) {
                    if (!confirm("If you exit before submitting, all changes you may have made to this problem will not be saved. Are you sure you would like to continue?")) {
                        return;
                    }

                    editingProblem = false;
                    editingProblemID = -1;

                    // Resetting Fields
                    $("#errors").hide();
                    $("#problem-text").val(null);
                    $(".selector-buttons.diagram .file").trigger("click");
                    $("#diagram").val(null);
                    $("#file-name").html("File must be of type .svg");
                    $("#file-name").css({"border-bottom": "none", "padding-bottom": "0", "color": "rgba(17, 21, 33, 0.75)"});
                    $("#diagram-file-label span").html("Upload File");
                    $("#diagram-code").val(null);
                    $("#hint-one").val(null);
                    $(".selector-buttons.hint-two .include").trigger("click");
                    $("#hint-two").val(null);
                    editor.setMathML("<math xmlns='HTTP://www.w3.org/1998/Math/MathML'/>");
                    $("#solution").val(null);
                    $("#topic").val(null).css({"border": "1px solid rgb(170, 170, 170)", "color": "rgb(170, 170, 170)"});
                    $("#main-focus").val(null).css({"border": "1px solid rgb(170, 170, 170)", "color": "rgb(170, 170, 170)"});
                    $("#source").val(null).css({"border": "1px solid rgb(170, 170, 170)", "color": "rgb(170, 170, 170)"});
                    $(".input-container div.source-other").css({"height": "0", "opacity": "0", "transition": "height .3s ease, opacity .3s ease 0s"});
                    $(".input-container.source").css({"margin-bottom": "20px"});
                    $("select.source-other-select").val(null).css({"border": "1px solid rgb(170, 170, 170)", "color": "rgb(170, 170, 170)"});
                    $("#source-other").val(null);
                    $("input.author-other").val(null);
                    $("#problem-number").val(null);

                    // Difficulty
                    for (var i = 1; i <= 5; i++) {
                        var el = $("#difficulty .fa:nth-child(" + i + ")");
                        if (el.hasClass("selected")) {
                            el.removeClass("fa-star");
                            el.removeClass("selected");
                            el.addClass("fa-star-o");
                            el.css("color", "rgba(170, 170, 170)");
                        }
                    }

                    $(".selector-buttons.calculus .none").trigger("click");

                    // Other Foci
                    $(".input-container .other-foci").html("<button><i class = 'fa fa-plus'></i>Add Focus</button>");

                    $(".input-container .other-foci button").on("click", function() {
                        var html = "<div class = 'other-focus'><select class = 'other-focus' name = 'other-focus' style = 'width: 95%;'>";
                        for (var i = 0; i < focuses.length; i++) {
                            html = html + "<option value = '" + focuses[i].focus + "'>" + focuses[i].name + "</option>";
                        }
                        html = html + "</select><i class = 'fa fa-times' style = 'color: red; cursor: pointer;'></i></div>";

                        problemData.otherFoci.push("0");

                        $(".input-container.source").css({"margin-bottom": "30px"});
                        $(".input-container .other-foci button").before(html);
                        $(".input-container .other-foci .other-focus i").on("click", function(event) {
                            event.target.parentElement.remove();
                            problemData.otherFoci.splice($(this).parent().index(), 1);
                        });
                        $(".input-container select.other-focus").change(function() {
                            problemData.otherFoci[$(this).parent().index()] = $(this).val();
                        });
                    });
                }
            });

            $(document).on("click", function(event) {
                const div = $("#answer");
                const divExpanded = $("#answer .wrs_contextPanel");
                if ((event.pageX > div.offset().left && event.pageX < div.offset().left + div.width() && event.pageY > div.offset().top && event.pageY < div.offset().top + div.height())
                 ||  (event.pageX > divExpandedBounds.left && event.pageX < divExpandedBounds.right && event.pageY > divExpandedBounds.top && event.pageY < divExpandedBounds.bottom)) {
                    div.css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#answer .wrs_toolbar .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#answer .wrs_formulaDisplay").outerHeight()});
                    $("#answer .wrs_formulaDisplayWrapper").css("top", "-42px");
                    editing = true;
                    divExpandedBounds = {
                        top: divExpanded.offset().top,
	                    left: divExpanded.offset().left,
	                    bottom: divExpanded.offset().top + divExpanded.height(),
	                    right: divExpanded.offset().left + divExpanded.width()
                    }
                } else {
                    div.css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 8) + "px");
                    $("#answer .wrs_toolbar .wrs_panelContainer").css({"height": "0", "opacity": "0", "top": "0"});
                    $("#answer .wrs_formulaDisplayWrapper").css("top", "-8px");
                    editing = false;
                }
            });

            $(document).keydown(function() {
                if (editing) {
                    $("#answer").css("height", ($("#answer .wrs_formulaDisplay").outerHeight() + 48) + "px");
                    $("#answer .wrs_toolbar .wrs_panelContainer").css({"height": "40px", "opacity": "1", "top": $("#answer .wrs_formulaDisplay").outerHeight()});
                }
            });


            $("#diagram").change(function(e) {
                $("#file-name").html(e.target.files[0].name + "<i class = 'fa fa-eye' title = 'Preview Diagram' style = 'display: inline-block; float: right; margin-top: 10px; cursor: pointer;'></i>");
                $("#file-name").css({"color": "#111521", "border-bottom": "1px dashed #111521", "padding-bottom": "5px"});
	            $("#diagram-file-label span").html("Change File");

                var file = e.target.files[0];
                var reader = new FileReader();
                reader.readAsText(file, "UTF-8");

                reader.onload = function (evt) {
                    problemData.diagramFile = evt.target.result;
                };

                reader.onerror = function (evt) {
                    alert("Sorry! There was an error loading the file.")
                };

                $("#file-name .fa-eye").on("click", function() {
                    $("#full-edit-container").css("display", "flex");
                    $(".full-edit.diagram-preview").css({"display": "flex"});

                    console.log(problemData.diagramFile);
                    $(".diagram-preview.full-edit .svg").html(problemData.diagramFile);
                });
            });

            $(".input-container select").change(function(event) {
                event.target.style.color = "rgb(29, 34, 41)";
                event.target.style.border = "1px solid rgba(17, 21, 33, 0.5)";
            });

            $(".input-container .other-foci button").on("click", function() {
                console.log("INM THIS TING");
                var html = "<div class = 'other-focus'><select class = 'other-focus' name = 'other-focus' style = 'width: 95%;'>";
                for (var i = 0; i < focuses.length; i++) {
                    html = html + "<option value = '" + focuses[i].focus + "'>" + focuses[i].name + "</option>";
                }
                html = html + "</select><i class = 'fa fa-times' style = 'color: red; cursor: pointer;'></i></div>";

                problemData.otherFoci.push("0");

                $(".input-container.source").css({"margin-bottom": "30px"});
                $(".input-container .other-foci button").before(html);
                $(".input-container .other-foci .other-focus i").on("click", function(event) {
                    event.target.parentElement.remove();
                    problemData.otherFoci.splice($(this).parent().index(), 1);
                });
                $(".input-container select.other-focus").change(function() {
                    problemData.otherFoci[$(this).parent().index()] = $(this).val();
                });
            });

            $("#source").change(function(event) {
                if ($("#source").val() === "other") {
                    $(".input-container div.source-other").css({"height": "180px", "opacity": "1", "transition": "height .2s ease, opacity .3s ease .2s"});
                    $(".input-container.source").css({"margin-bottom": "30px"});
                } else {
                    $(".input-container div.source-other").css({"height": "0", "opacity": "0", "transition": "height .3s ease, opacity .3s ease 0s"});
                    $(".input-container.source").css({"margin-bottom": "20px"});
                }
            });

            $("#difficulty .fa").hover(function(event) {
                var currDifficulty = 0;

                switch(event.target.getAttribute("data-rating")) {
                    case "1":
                        currDifficulty = 1;
                        break;
                    case "2":
                        currDifficulty = 2;
                        break;
                    case "3":
                        currDifficulty = 3;
                        break;
                    case "4":
                        currDifficulty = 4;
                        break;
                    case "5":
                        currDifficulty = 5;
                        break;
                    default:
                        currDifficulty = 0;
                }

                for (var i = 1; i <= currDifficulty; i++) {
                    var el = $("#difficulty .fa:nth-child(" + i + ")");
                    if (!el.hasClass("selected")) {
                        el.removeClass("fa-star-o");
                        el.addClass("fa-star");
                        el.css("color", "rgba(40, 83, 128, 0.4)");
                    }
                }

            }, function(event) {
                var el = $("#difficulty .fa:not(.selected)");
                el.removeClass("fa-star");
                el.addClass("fa-star-o");
                el.css("color", "rgb(170, 170, 170)");
            });

            $("#difficulty .fa").on("click", function(event) {
                var element = $("#difficulty .fa");
                element.removeClass("fa-star");
                element.removeClass("selected");
                element.addClass("fa-star-o");
                element.css("color", "rgb(170, 170, 170)");

                var currDifficulty = 0;

                switch(event.target.getAttribute("data-rating")) {
                    case "1":
                        currDifficulty = 1;
                        break;
                    case "2":
                        currDifficulty = 2;
                        break;
                    case "3":
                        currDifficulty = 3;
                        break;
                    case "4":
                        currDifficulty = 4;
                        break;
                    case "5":
                        currDifficulty = 5;
                        break;
                    default:
                        currDifficulty = 0;
                }

                problemData.difficulty = currDifficulty;

                for (var i = 1; i <= currDifficulty; i++) {
                    var el = $("#difficulty .fa:nth-child(" + i + ")");
                    el.removeClass("fa-star-o");
                    el.addClass("fa-star");
                    el.addClass("fa-star selected");
                    el.css("color", "rgba(40, 83, 128, 0.8)");
                }
            });


            $("#submit").on("click", function() {

                $("#errors").show();

                var errors = "";

                // Handling Errors and writing to data
                 if (!$.trim($("#problem-text").val())) {
                     errors = errors + "<li>Please enter the problem text (latex)</li>";
                 }

                 if (problemData.diagram === "file" && problemData.diagramFile === "") {
                     errors = errors + "<li>Please upload a non-empty .svg diagram file or select a different diagram option</li>";
                 } else if (problemData.diagram === "code" && !$.trim($("#diagram-code").val())) {
                     errors = errors + "<li>Please enter the diagram svg markup code or select a different diagram option</li>";
                 }

                 if (!$.trim($("#hint-one").val())) {
                     errors = errors + "<li>Please enter the first hint</li>";
                 }

                 if (problemData.hintTwo !== null && !$.trim($("#hint-one").val())) {
                     errors = errors + "<li>Please enter the second hint or set it to \"none\"</li>";
                 }

                 if (editor.getMathML().toString() === "<math xmlns=\"http://www.w3.org/1998/Math/MathML\"/>") {
                     errors = errors + "<li>Please enter the answer</li>";
                 }

                 if (!$.trim($("#solution").val())) {
                     errors = errors + "<li>Please enter the solution text (latex)</li>";
                 }

                 if ($("#topic").val() === null) {
                     errors = errors + "<li>Please select a topic</li>";
                 }

                if ($("#main-focus").val() === null) {
                    errors = errors + "<li>Please select a main focus</li>";
                }

                if (problemData.otherFoci.length > 0 && (hasDuplicates(problemData.otherFoci) || problemData.otherFoci.includes($("#main-focus").val()))) {
                    errors = errors + "<li>You have duplicated foci -- please delete any duplicates</li>";
                }

                if ($("#source").val() === null) {
                    errors = errors + "<li>Please select a source</li>";
                }

                if ($("#source").val() === "other") {

                    if ($(".source-other-select").val() === null) {
                        errors = errors + "<li>Please enter the category of your custom source or select a source from the dropdown menu</li>";
                    }

                    if (!$.trim($("#source-other").val())) {
                        errors = errors + "<li>Please enter the name of your custom source or select a source from the dropdown menu</li>";
                    }

                    if (!$.trim($(".author-other").val())) {
                        errors = errors + "<li>Please enter the author (can be organization) of your custom source or select a source from the dropdown menu</li>";
                    }
                }

                if (problemData.difficulty === 0) {
                    errors = errors + "<li>Please select a difficulty</li>";
                }


                if (errors === "") {

                    $("#errors").hide();



                    var diagramFinal = null;
                    if (problemData.diagram === "file") {
                        diagramFinal = problemData.diagramFile.replace(/(\r\n|\n|\r)/gm," ");
                    } else if (problemData.diagram === "code") {
                        diagramFinal = $("#diagram-code").val().replace(/(\r\n|\n|\r)/gm," ");
                    }

                    if (problemData.hintTwo !== null) {
                        problemData.hintTwo = $("#hint-two").val();
                    }

                    var otherFoci = null;

                    if (problemData.otherFoci.length > 0) {
                        otherFoci = "";

                        for (var i = 0; i < problemData.otherFoci.length; i++) {
                            otherFoci = otherFoci + problemData.otherFoci[i];
                        }
                    }


                    if ($("#source").val() === "other") {
                        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                            'action': 'add_source',
                            'category': $(".source-other-select").val(),
                            'author': $(".author-other").val(),
                            'source': $("#source-other").val()
                        }, function() {
                            jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                                'action': 'submit_problem',
                                'editing': editingProblem,
                                'problem_id': editingProblemID,
                                'problem_text': $("#problem-text").val().replace(/(\r\n|\n|\r)/gm,""),
                                'diagram': diagramFinal,
                                'hint_one': $("#hint-one").val(),
                                'hint_two': problemData.hintTwo,
                                'answer': editor.getMathML().toString(),
                                'solution': $("#solution").val().replace(/(\r\n|\n|\r)/gm,""),
                                'topic': $("#topic").val(),
                                'main_focus': $("#main-focus").val(),
                                'other_foci': otherFoci,
                                'source': sources.length + 1,
                                'problem_number': $("#problem-number").val(),
                                'difficulty': problemData.difficulty,
                                'calculus': problemData.calculus
                            }, function() {

                                if (confirm("Your problem has been succesfully submitted!")) {
                                    location.reload();
                                }

                            });
                        });
                    } else {
                        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
                            'action': 'submit_problem',
                            'editing': editingProblem,
                            'problem_id': editingProblemID,
                            'problem_text': $("#problem-text").val().replace(/(\r\n|\n|\r)/gm,""),
                            'diagram': diagramFinal,
                            'hint_one': $("#hint-one").val(),
                            'hint_two': problemData.hintTwo,
                            'answer': editor.getMathML().toString(),
                            'solution': $("#solution").val().replace(/(\r\n|\n|\r)/gm,""),
                            'topic': $("#topic").val(),
                            'main_focus': $("#main-focus").val(),
                            'other_foci': otherFoci,
                            'source': parseInt($("#source").val()),
                            'problem_number': $("#problem-number").val(),
                            'difficulty': problemData.difficulty,
                            'calculus': problemData.calculus
                        }, function() {

                            if (confirm("Your problem has been succesfully submitted!")) {
                                location.reload();
                            }

                        });
                    }


                } else {
                    $("#errors ul").html(errors);
                    $("#container-fluid").animate({scrollTop: 0})
                }

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
                console.log($("#diagram-code").val());
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

                problemData.diagram = "file";
	        });

            $(".diagram.selector-buttons .code").on("click", function() {
                $(".diagram.selector-buttons .file").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .code").css("color", "white");
                $(".diagram.selector-buttons .none").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .indicator").css("left", "33%");

                $(".diagram.flex-options > div:first-child").css({"height": "0", "padding": "0"});
                $(".diagram.flex-options > div:last-child").css({"height": "inherit", "padding": "10px"});

                problemData.diagram = "code";
            });

            $(".diagram.selector-buttons .none").on("click", function() {
                $(".diagram.selector-buttons .file").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .code").css("color", "rgb(155, 155, 155)");
                $(".diagram.selector-buttons .none").css("color", "white");
                $(".diagram.selector-buttons .indicator").css("left", "66%");

                $(".diagram.flex-options > div:first-child").css({"height": "0", "padding": "0"});
                $(".diagram.flex-options > div:last-child").css({"height": "0", "padding": "0"});

                problemData.diagram = null;
            });

            // Hint Two Selector Actions
            $(".hint-two.selector-buttons .include").on("click", function() {
                $(".hint-two.selector-buttons .include").css("color", "white");
                $(".hint-two.selector-buttons .none").css("color", "rgb(155, 155, 155)");
                $(".hint-two.selector-buttons .indicator").css("left", "0");

                $(".hint-two.flex-options > input").css({"height": "inherit", "padding": "10px", "border": "1px solid rgba(17, 21, 33, 0.51)"});

                problemData.hintTwo = "";
            });

            $(".hint-two.selector-buttons .none").on("click", function() {
                $(".hint-two.selector-buttons .include").css("color", "rgb(155, 155, 155)");
                $(".hint-two.selector-buttons .none").css("color", "white");
                $(".hint-two.selector-buttons .indicator").css("left", "50%");

                $(".hint-two.flex-options > input").css({"height": "0", "padding": "0", "border": "none"});

                problemData.hintTwo = null;
            });

            // Calculus Selector Actions
            $(".calculus.selector-buttons .none").on("click", function() {
                $(".calculus.selector-buttons .none").css("color", "white");
                $(".calculus.selector-buttons .helps").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .required").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .indicator").css("left", "0%");

                problemData.calculus = "None";
            });

            $(".calculus.selector-buttons .helps").on("click", function() {
                $(".calculus.selector-buttons .none").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .helps").css("color", "white");
                $(".calculus.selector-buttons .required").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .indicator").css("left", "33%");

                problemData.calculus = "Helps";
            });

            $(".calculus.selector-buttons .required").on("click", function() {
                $(".calculus.selector-buttons .none").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .helps").css("color", "rgb(155, 155, 155)");
                $(".calculus.selector-buttons .required").css("color", "white");
                $(".calculus.selector-buttons .indicator").css("left", "66%");

                problemData.calculus = "Required";
            });



        });


    })(jQuery);
</script>