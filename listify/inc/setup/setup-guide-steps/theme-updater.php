<?php
/**
 */

$api      = Astoundify_Envato_Market_API::instance();
$is_valid = $api->can_make_request_with_token();
?>

<div id="step-status-theme-updater" class="step-status step-
<?php
if ( ! $is_valid ) :
?>
in<?php endif; ?>complete" data-string-complete="<?php _e( 'Completed', 'listify' ); ?>" data-string-incomplete="<?php _e( 'Not Complete', 'listify' ); ?>"><?php echo ( $is_valid ? __( 'Complete', 'listify' ) : __( 'Not Complete', 'listify' ) ); ?></div>

<p><?php _e( 'In order to receive automatic updates for your purchase please generate a personal token from ThemeForest.', 'listify' ); ?></p>

<p><a href="https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t" target="_blank" class="button"><?php _e( 'Generate a Token', 'listify' ); ?></a></p>

<p><?php _e( 'Once generated, add the token below:', 'listify' ); ?></p>

<form action="post" name="astoundify-updates-step" id="astoundify-add-update-token">
	<p>
		<strong><label for="token"><?php _e( 'Personal Token:', 'listify' ); ?></label></strong><br />
		<input name="token" value="<?php echo esc_attr( get_option( Listify_Setup::get_template_name() . '_themeforest_updater_token', false ) ); ?>" name="token" style="width: 80%;" />
		<?php submit_button( __( 'Save Token', 'listify' ), 'primary', 'submit', false ); ?>
		<?php wp_nonce_field( 'astoundify-add-token' ); ?>
	</p>
	<div class="spinner"></div>
</form>

<p class="api-connection">API Connection: <strong class="astoundify-setup-<?php echo $is_valid ? 'green' : 'red'; ?>"><?php echo esc_attr( $api->connection_status_label() ); ?></strong></p>

<script>
	jQuery(document).ready(function($) {
		$( '#astoundify-add-update-token' ).on( 'submit', function(e) {
			e.preventDefault();

			$form = $(this);

			var args = {
				action: 'astoundify_updater_set_token',
				token: $form.find( 'input[name=token]' ).val(),
				security: '<?php echo wp_create_nonce( 'astoundify-add-token' ); ?>'
			};

			$stepTitle = $( '#step-status-theme-updater' );
			$spinner = $( '#theme-updater .spinner' );
			$spinner.addClass( 'is-active' );

			$.ajax({
				type: 'POST',
				url: ajaxurl, 
				data: args, 
				dataType: 'json',
				success: function(response) {
					$status = $( '#theme-updater .api-connection strong' );

					if ( response.data.can_request ) {
						$stepTitle.text( $stepTitle.data( 'string-complete' ) ).removeClass( 'step-incomplete' ).addClass( 'step-complete' );
						$status.removeClass( 'astoundify-setup-red' ).addClass( 'astoundify-setup-green' );
					} else {
						$stepTitle.text( $stepTitle.data( 'string-incomplete' ) ).removeClass( 'step-complete' ).addClass( 'step-incomplete' );
						$status.removeClass( 'astoundify-setup-green' ).addClass( 'astoundify-setup-red' );
					}

					$status.text( response.data.request_label );
					$spinner.removeClass( 'is-active' );
				}
			});
		});
	});
</script>

<style>
#theme-updater .spinner {
	float: none;
	display: inline-block;
	margin-top: -2px;
	vertical-align: middle;
}

#astoundify-add-update-token p {
	display: inline-block;
	width: 50%;
}
</style>
