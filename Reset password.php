add_action( 'elementor_pro/forms/new_record',  'yair_elementor_form_resrt_password' , 10, 2 );

function yair_elementor_form_resrt_password($record,$ajax_handler) 
{
  $form_name = $record->get_form_settings('form_name');
  
  //Check that the form is the "Reset Password" if not - stop and return;
  if ('Reset Password' !== $form_name) {
      return;
  }
  
  $form_data = $record->get_formatted_data();
    
  $email = $form_data['email'];
  $user_key = $form_data['key'];
  $new_pass_1 = $form_data['password'];
  $new_pass_2 = $form_data['password_confirm'];
	
  $user_data = get_user_by( 'email', $email );	
  $user_login = $user_data->user_login;	
  
  $user = check_password_reset_key( $user_key, $user_login );
  
  if ( !$user || is_wp_error( $user ) ) {    
        $ajax_handler->add_error_message( $user->get_error_message() ); 
        $ajax_handler->is_success = false;
        return;      
  }  
  
  if ( $new_pass_1 != $new_pass_2 ) {    
    $ajax_handler->add_error_message( 'The passwords do not match' ); 
        $ajax_handler->is_success = false;
        return;      
  }
  
  reset_password( $user, $new_pass_1 );
  wp_send_json_success(['message' => 'Password reset successfully!', 'data' => $ajax_handler->data,]);
  $ajax_handler->is_success = true;  
}
