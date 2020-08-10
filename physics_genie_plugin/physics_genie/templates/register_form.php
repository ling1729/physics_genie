<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
</head>
<div id="register-form" class = "register-login">
    <div class = "background"></div>
    <div class = "center">

        <h2>Register</h2>

	    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		    <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class = "error">
				    <?php echo $error; ?>
                </p>
		    <?php endforeach; ?>
	    <?php endif; ?>

        <form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
            <p class="form-row">
                <label for="email"><?php _e( 'Email', 'personalize-login' ); ?> <strong>*</strong></label>
                <input type="text" name="email" id="email">
            </p>

            <p class="form-row">
                <label for="username"><?php _e( 'Username', 'personalize-login' ); ?> <strong>*</strong></label>
                <input type="text" name="username" id="username">
            </p>

            <p class="form-row">
                <label for="password"><?php _e( 'Password', 'personalize-login' ); ?> <strong>*</strong></label>
                <input type="text" name="password" id="password">
            </p>

		    <?php if ( $attributes['recaptcha_site_key'] ) : ?>
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="<?php echo $attributes['recaptcha_site_key']; ?>"></div>
                </div>
		    <?php endif; ?>

            <p class="signup-submit submit">
                <input type="submit" name="submit" class="register-button"
                       value="<?php _e( 'Register', 'personalize-login' ); ?>"/>
            </p>
        </form>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    const registerForm = $("#register-form");
    registerForm.height(window.innerHeight);
    $("#site-header a").css("color", "white");

    window.addEventListener("resize", function() {
        registerForm.height(window.innerHeight);
    });


</script>