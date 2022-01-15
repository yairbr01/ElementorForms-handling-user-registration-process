add_action( 'elementor_pro/forms/new_record',  'yair_elementor_form_lost_password' , 10, 2 );

function yair_elementor_form_lost_password($record,$ajax_handler) 
{
  $form_name = $record->get_form_settings('form_name');
  
//Check that the form is the "Lost Password" if not - stop and return;
  if ('Lost Password' !== $form_name) {
      return;
  }
  $form_data = $record->get_formatted_data();
	$email = $form_data['email'];
	$user_data = get_user_by( 'email', $email );

	$errors = retrieve_password( $user_data->user_login );
	
	if ( is_wp_error( $errors ) ) {		
      $ajax_handler->add_error_message( $errors->get_error_message() ); 
      $ajax_handler->is_success = false;
      return;		
	} else {
      $ajax_handler->is_success = true;
	}	
}


add_filter("retrieve_password_message", "custom_password_reset", 99, 4);

function custom_password_reset($message, $key, $user_login, $user_data )    {

	$message = "
	Hey,
  
	We have received your request to reset your account password.

	Email address:" . sprintf(__('%s'), $user_data->user_email) . "

	If you did not make the request, this message should be ignored.

	Click the link to reset your password

	" . network_site_url("reset-password?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n" . "

	If you encounter a problem or have any further questions please feel free to contact us at the email address: support@example.com

	
	Best regards";

	return $message;

}
