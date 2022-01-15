add_action( 'elementor_pro/forms/new_record',  'yair_elementor_user_authentication' , 10, 2 );

function yair_elementor_user_authentication($record,$ajax_handler)
{
  $form_name = $record->get_form_settings('form_name');
  
  //Check that the form is the "User authentication" if not - stop and return;
  if ('User authentication' !== $form_name) {
      return;
  }
  $form_data = $record->get_formatted_data();

  $email = $form_data['email'];

	$user = get_user_by( 'email', $user_email );
	$user_id = $user->ID;
		
  $code_1 = $form_data['code_1'];
  $code_2 = $form_data['code_2'];
  $code_3 = $form_data['code_3'];
  $code_4 = $form_data['code_4'];
  $code_5 = $form_data['code_5'];
  $code_6 = $form_data['code_6'];
	
	$all_code = $code_6 . $code_5 . $code_4 . $code_3 . $code_2 . $code_1;
	
	$user_code = get_user_meta( $user_id, 'user_confirm_code', true );
		
	if ($all_code == $user_code) {		
		update_user_meta( $user_id, 'user_confirm_status', 'verified' );
		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true);
		
	} else {	
		
    $ajax_handler->add_error_message("Error: The code is invalid"); 
    $ajax_handler->is_success = false;
    return;
		
	}
}
