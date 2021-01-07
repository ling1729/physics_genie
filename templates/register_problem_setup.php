<head>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Caveat' rel='stylesheet'>
	<script src="https://use.fontawesome.com/e97a7a61dd.js"></script>
</head>

<div id = "rps">

	<div class = "container-fluid">
		<div id = "container">
			<div>
				<h2>Problem Setup</h2>
				<div class = "slide-container">
					<div class = "slide" style = "opacity: 1; height: inherit;">
						<p>
							Before playing, please take a few minutes to respond to a brief question-calibration survey.
							This helps us match questions to your level to maximize your Physics Genie experience!
						</p>
						<button id = "begin" class = "button">Begin!</button>
					</div>
					<div class = "slide">
						<h4>How would you qualify your experience/level/achievements with competition physics?</h4>
						<div class = "multiple-choice">
							<div class = "option">
								<div class = "circle"><div></div></div>
								<h6>No Experience With Physics</h6>
							</div>
							<div class = "option">
								<div class = "circle"><div></div></div>
								<h6>Completed Some Physics Course</h6>
							</div>
							<div class = "option">
								<div class = "circle"><div></div></div>
								<h6>Completed an AP level Course</h6>
							</div>
							<div class = "option">
								<div class = "circle"><div></div></div>
								<h6>4 or 5 on Physics 1 Advanced Placement Exam</h6>
							</div>
							<div class = "option">
								<div class = "circle"><div></div></div>
								<h6>4 or 5 on Mechanics C Advanced Placement Exam</h6>
							</div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Above 8 in F=ma</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Qualified for USAPhO Exam</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Honorable Mention on USAPhO Exam</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Bronze on USAPhO Exam</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Silver on USAPhO Exam</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Gold on USAPhO Exam</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Physics Olympiad Training Camp</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>International Physics Olympiad Medalist</h6>
                            </div>
						</div>
					</div>
                    <div class = "slide">
                        <h4>Which of the following subtopics of mechanics are you familiar with and want to be quizzed on?</h4>
                        <div class = "multiple-choice"></div>
                    </div>
                    <div class = "slide">
                        <h4>Add any subtopics you would like to focus on to start with. If you add none, you will be quizzed on any subtopic you selected in the previous question.</h4>
                        <button class = "add-focus"><i class = "fa fa-plus"></i>Add Focus</button>
                    </div>
                    <div class = "slide">
                        <h4>Would you like to be presented with questions that require calculus?</h4>
                        <div class = "multiple-choice">
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>Yes</h6>
                            </div>
                            <div class = "option">
                                <div class = "circle"><div></div></div>
                                <h6>No</h6>
                            </div>
                        </div>
                    </div>
				</div>
				<div class = "controls">
					<button id = "previous" class = "button" style = "visibility: hidden;">Previous</button>
					<button id = "rps_next" class = "button">Next</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>

    (function($) {

        var currSlide = 0;
        var focuses = <?php echo json_encode($attributes['focuses']); ?>;

        $(document).ready(function() {

            /* Setup */
            for (var i = 0; i < focuses.length; i++) {
                $(".slide:nth-child(4) .multiple-choice").append("<div class = 'option'><i class = 'fa fa-square-o'></i><h6>" + focuses[i].name + "</h6></div>");
            }

            $("#site-header").css("display", "none");
            $("#footer").css("display", "none");
            document.body.style.overflow = "hidden";

            $(".container-fluid").height(window.innerHeight);
            $("body").height(window.innerHeight);

            var style = document.createElement("style");
            style.innerHTML = "body::-webkit-scrollbar {display: none;}";
            document.head.appendChild(style);

            window.addEventListener("resize", function() {
                $(".container-fluid").height(window.innerHeight);
                $("body").height(window.innerHeight);
            });

            $(".controls").hide();

            $(".slide:nth-child(2) .option").on("click", function() {
                $(".slide:nth-child(2) .option").removeClass("selected");
                $(this).addClass("selected");
            });

            $(".slide:nth-child(3) .option, .slide:nth-child(4) .option").on("click", function() {
                if ($(this).find(".fa").hasClass("fa-square-o")) {
                    $(this).find(".fa").removeClass("fa-square-o").addClass("fa-check-square");
                } else {
                    $(this).find(".fa").removeClass("fa-check-square").addClass("fa-square-o");
                }
            });

            $(".add-focus").on("click", function() {
                var html = "<div class = 'focus'><select class = 'focus' name = 'focus' style = 'width: 95%;'>";
                for (var i = 0; i < focuses.length; i++) {
                    html = html + "<option value = '" + focuses[i].focus + "'>" + focuses[i].name + "</option>";
                }
                html = html + "</select><i class = 'fa fa-times' style = 'color: red; cursor: pointer;'></i></div>";

                $(this).before(html);

                $(".slide:nth-child(5) div.focus i").on("click", function() {
                    event.target.parentElement.remove();
                });
            });

            $(".slide.calc .option").on("click", function() {
                $(".slide.calc .option").removeClass("selected");
                $(this).addClass("selected");
            });


            // Control Buttons
            $("#begin").on("click", function() {
                $(".slide").eq(currSlide).css("opacity", "0");
                $(".slide").eq(currSlide + 1).css("opacity", "1");
                $(".slide-container").css("left", "-" + (500 * (currSlide + 1)) + "px");
                $("#container").css({"top": "100px", "justify-content": "flex-start"});
                setTimeout(function() {
                    $(".slide").eq(currSlide).css("height", "0");
                    $(".slide").eq(currSlide + 1).css("height", "inherit");
                    $(".controls").show();
                    currSlide++;
                }, 300);
            });

            $("#rps_next").on("click", function() {
                $(".slide").eq(currSlide).css("opacity", "0");
                $(".slide").eq(currSlide + 1).css("opacity", "1");
                $(".slide-container").css("left", "-" + (500 * (currSlide + 1)) + "px");
                setTimeout(function() {
                    $(".slide").eq(currSlide).css("height", "0");
                    $(".slide").eq(currSlide + 1).css("height", "inherit");
                    if (currSlide === 1) {
                        $("#previous").css("visibility", "visible");
                    }
                    currSlide++;
                }, 300);
            });


            $("#previous").on("click", function() {
                $(".slide").eq(currSlide).css("opacity", "0");
                $(".slide").eq(currSlide - 1).css("opacity", "1");
                $(".slide-container").css("left", "-" + (500 * (currSlide - 1)) + "px");
                setTimeout(function() {
                    $(".slide").eq(currSlide).css("height", "0");
                    $(".slide").eq(currSlide - 1).css("height", "inherit");
                    if (currSlide === 2) {
                        $("#previous").css("visibility", "hidden");
                    }
                    currSlide--;
                }, 300);
            });

        });


    })(jQuery);
</script>
