<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Antic' rel='stylesheet'>
</head>
<div class="login-form-container register-login">
    <div class = "background"></div>
    <div class = "center">

        <h2>Physics Genie</h2>

        <!-- Show errors if there are any -->
        <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class="login-error error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Show logged out message if user just logged out -->
        <?php if ( $attributes['logged_out'] ) : ?>
            <p class="login-info">
                <?php _e( 'You have signed out. Would you like to sign in again?', 'personalize-login' ); ?>
            </p>
        <?php endif; ?>

        <!-- Show registered message if user just registered -->
	    <?php if ( $attributes['registered'] ) : ?>
            <p class="login-info">
			    <?php
			    printf(
				    __( 'You have successfully registered to <strong>%s</strong>.', 'personalize-login' ),
				    get_bloginfo( 'name' )
			    );
			    ?>
            </p>
	    <?php endif; ?>

	    <?php if ( $attributes['lost_password_sent'] ) : ?>
            <p class="login-info">
			    <?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
            </p>
	    <?php endif; ?>

	    <?php if ( $attributes['password_updated'] ) : ?>
            <p class="login-info">
			    <?php _e( 'Your password has been changed. You can sign in now.', 'personalize-login' ); ?>
            </p>
	    <?php endif; ?>

	    <?php
	    wp_login_form(
		    array(
			    'label_username' => __( 'Email', 'personalize-login' ),
			    'label_log_in' => __( 'Log In', 'personalize-login' ),
			    'redirect' => $attributes['redirect'],
		    )
	    );
	    ?>

        <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
		    <?php _e( 'Forgot your password?', 'personalize-login' ); ?>
        </a>

    </div>
    <div class = "register-div">
        <h6>Don't have an account? Register <a href = "<?php echo wp_registration_url(); ?>">here</a>.</h6>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    const loginForm = $(".login-form-container");
    loginForm.height(window.innerHeight);
    $("#site-header a").css("color", "white");

    window.addEventListener("resize", function() {
        loginForm.height(window.innerHeight);
    });


</script>