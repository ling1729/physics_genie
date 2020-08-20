<head>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/e97a7a61dd.js"></script>
</head>
<div id = "play-menu">

    <div class = "flex">
        <a href = "<?php echo get_page_link( get_page_by_title( 'Profile' )->ID ); ?>">
            <div class = "img logo"></div>
            <div class = "text">Home</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'Play' )->ID ); ?>">
            <div class = "img problem">
                <i class = "fa fa-cubes" aria-hidden = "true"></i>
            </div>
            <div class = "text">Play</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'Review' )->ID ); ?>">
            <div class = "img review">
                <i class = "fa fa-retweet" aria-hidden = "true"></i>
            </div>
            <div class = "text">Review</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'Setup' )->ID ); ?>">
            <div class = "img setup">
                <i class = "fa fa-sliders" aria-hidden = "true"></i>
            </div>
            <div class = "text">Setup</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'Help' )->ID ); ?>">
            <div class = "img help">
                <i class = "fa fa-question" aria-hidden = "true"></i>
            </div>
            <div class = "text">Help</div>
        </a>
    </div>


    <a id = "back-home" href = "<?php echo get_page_link( get_page_by_title( 'Home Page' )->ID ); ?>">
        <i class = "fa fa-long-arrow-left" aria-hidden = "true"></i>
        <div class = "text">Back to Site</div>
    </a>


</div>

<a id = "play-header" href = "<?php echo get_page_link( get_page_by_title( 'Profile' )->ID ); ?>">
    <div class = "img avatar">
        <i class = "fa fa-user-circle-o" aria-hidden = "true"></i>
    </div>
    <div class = "text"><?php echo wp_get_current_user()->data->user_nicename ?></div>
</a>

<div id = "play-header-menu">
    <a href = "<?php echo get_page_link( get_page_by_title( 'Profile' )->ID ); ?>">
        <div class = "text">Profile</div>
    </a>
    <a href = "<?php echo get_page_link( get_page_by_title( 'Setup' )->ID ); ?>">
        <div class = "text">Problem Setup</div>
    </a>
    <a href = "http://ec2-54-153-56-57.us-west-1.compute.amazonaws.com//wp-login.php?action=logout">
        <i class = "fa fa-power-off" aria-hidden = "true"></i>
        <div class = "text">Logout</div>
    </a>
</div>

<script>
    (function($) {

        $(document).ready(function() {


            const playMenu = $("#play-menu");

            setTimeout(function () {
                $("#play-header").css("top", "0");
                $("#play-header-menu").width($("#play-header").outerWidth());
            }, 0);

            $("#site-header").css("display", "none");
            $("#footer").css("display", "none");
            document.body.style.overflow = "hidden";


            playMenu.height(window.innerHeight);
            $("body").height(window.innerHeight);

            var style = document.createElement("style");
            style.innerHTML = "body::-webkit-scrollbar {display: none;}";
            document.head.appendChild(style);

            window.addEventListener("resize", function() {
                playMenu.height(window.innerHeight);
                $("body").height(window.innerHeight );
            });


        });


    })(jQuery);
</script>