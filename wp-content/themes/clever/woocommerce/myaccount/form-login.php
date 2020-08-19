<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
            if(lang() == 'es'){
            	$re = "Recuerdame";
            	$pass = "Perdiste tu contraseña";
            	$acc = "Crea una cuenta";
            	$log = "Iniciar sesión";
            } 
            else{
            	$re = "Remember me";
                $pass = "Lost your password";
                $acc = "Create an account";
                $log = "Log in";
            } 
do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-12 flex-login">

<?php endif; ?>

    <?php if ($_GET["create"] != 'account') { ?>
		<form class="woocommerce-form form-custom woocommerce-form-login login" method="post">
			<div class="login-img">

				<img class="" src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
			</div>
            <h2><?php if(lang() == 'es'){echo $log;} else{echo $log;}?></h2>
			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username" class="label-user" >
				<img class="" src="<?php echo get_template_directory_uri();?>/assets/img/usergray.png">
				<input type="text" placeholder="<?php if(lang() == 'es'){echo "Usuario";} else{echo "Username";}?>" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="off" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</label>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password">
				<img class="" src="<?php echo get_template_directory_uri();?>/assets/img/pass.png">

				<input placeholder="<?php if(lang() == 'es'){echo "Contraseña";} else{echo "Password";}?>" class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="off" />
			</label>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( $re, 'woocommerce' ); ?></span>
				</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="main-general__button woocommerce-button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( $log, 'woocommerce' ); ?></button>
			</p>
			<div class="form-login__register" >
				<p class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( $pass, 'woocommerce' ); ?></a>
					<p class="woocommerce-in-account"><a href="?create=account"><?=$acc ?></a></p>
				</p>
			</div>


			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
    <?php } ?> 

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

<?php if ($_GET["create"] == 'account') { ?>

	<div class="u-column2 col-12 flex-login">
		<div class="login-img">
			<img class="" src="<?php echo get_template_directory_uri();?>/assets/img/user.png">
		</div>
		<h2><?php if(lang() == 'es'){$la = "Registrarse";} else{$la = "Register";}?></h2>

		<h2><?php esc_html_e( $la, 'woocommerce' ); ?></h2>

		<?php if(lang() == 'es')
		{ 
		  echo do_shortcode('[user_registration_form id="90"]');
		}  
		if(lang() == 'en')
		{ 
		  echo do_shortcode('[user_registration_form id="91"]');
		} ?>

			<div class="form-login__register" >
				<p class="woocommerce-LostPassword lost_password">					
					
					<a href="?"><?=$log ?></a>
					<p class="woocommerce-in-account"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( $pass, 'woocommerce' ); ?></a></p>
				</p>
			</div>				

	</div>
<?php } ?>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

<style>
	.banner-small {
display: none;
	}

	.grid-woocommerce {
		background-image: url('<?php echo get_template_directory_uri();?>/assets/img/login-bg.png');
background-repeat: no-repeat;
background-size: cover;
/* padding-top: 33px; */
	}
</style>