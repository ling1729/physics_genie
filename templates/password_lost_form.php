<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
</head>
<div id="password-lost-form" class="register-login">
    <div class = "background"></div>
    <div class = "center">
        <h2>Recover Your Password</h2>

        <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class = "error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>

        <p>
            <?php
            _e(
                "Enter your email address and we'll send you a link you can use to pick a new password.",
                'personalize_login'
            );
            ?>
        </p>

        <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
            <p class="form-row">
                <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
                    <input type="text" name="user_login" id="user_login">
            </p>

            <p class="lostpassword-submit submit">
                <input type="submit" name="submit" class="lostpassword-button"
                       value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
            </p>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    const form = $("#password-lost-form");
    form.height(window.innerHeight);
    $("#site-header a").css("color", "white");

    window.addEventListener("resize", function() {
        form.height(window.innerHeight);
    });

</script>