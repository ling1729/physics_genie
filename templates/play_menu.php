<head>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div id = "play-menu">

    <div class = "flex">
        <a href = "<?php echo get_page_link( get_page_by_title( 'profile' )->ID ); ?>">
            <div class = "img logo"></div>
            <div class = "text">Profile</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'problem' )->ID ); ?>">
            <div class = "img problem"></div>
            <div class = "text">Play</div>
        </a>
        <a href = "<?php echo get_page_link( get_page_by_title( 'Home Page' )->ID ); ?>">
            <div class = "img home"></div>
            <div class = "text">Home</div>
        </a>
        <a href = "http://ec2-54-153-56-57.us-west-1.compute.amazonaws.com//wp-login.php?action=logout">
            <div class = "img logout"></div>
            <div class = "text">Logout</div>
        </a>
    </div>


</div>

<script>
    (function($) {

        $(document).ready(function() {


            const playMenu = $("#play-menu");

            setTimeout(function () {
                $("#site-header").css("display", "none");
                $("#footer").css("display", "none");
            }, 0);

            $("#site-header").css("display", "none");
            $("#footer").css("display", "none");


            playMenu.height(window.innerHeight);

            window.addEventListener("resize", function() {
                playMenu.height(window.innerHeight);
            });


        });


    })(jQuery);
</script>