add_action( 'elementor_pro/forms/new_record',  'yair_elementor_form_login' , 10, 2 );

function yair_elementor_form_login($record,$ajax_handler)
{
  $form_name = $record->get_form_settings('form_name');

  //Check that the form is the "Login" if not - stop and return;
  if ('Login' !== $form_name) {
      return;
  }
  $form_data = $record->get_formatted_data();
    
	$email = $form_data['email'];
	$password = $form_data['password'];
	$remember = $form_data['remember'];
	
	$login_data = array();
	$login_data['user_login'] = $email;
    $login_data['user_password'] = $password;
    $login_data['remember'] = $remember;
	
	$user = wp_signon( $login_data, false );
	
	if ( is_wp_error( $user ) ){ 
      $ajax_handler->add_error_message( $user->get_error_message() ); 
      $ajax_handler->is_success = false;
      return;
  } else {		
      $user_id = $user->ID;
      $user_confirm_status = get_user_meta( $user_id, 'user_confirm_status', true );
      if ($user_confirm_status == 'not_verified') {			
          $link_user_confirm = "https://dirave.co.il/user_confirm/?email=".$email;
          $ajax_handler->add_error_message("כתובת האימייל אינה מאומתת, אנא אמת את כתובת האימייל ונסה שוב <a href='".$link_user_confirm."'>לאימות לחץ כאן</a>"); 
        	$ajax_handler->is_success = false;
        	return;			
  }
		
  wp_clear_auth_cookie();
  wp_set_current_user($user->ID);
  wp_set_auth_cookie($user->ID, true);
		
  $redirect_to = home_url();
  $redirect_to = $record->replace_setting_shortcodes( $redirect_to );
  $ajax_handler->add_response_data( 'redirect_url', $redirect_to );		
  }	
}
