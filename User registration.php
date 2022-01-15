add_action( 'elementor_pro/forms/new_record',  'yair_elementor_rgistration_form' , 10, 2 );

function yair_elementor_rgistration_form($record,$ajax_handler)
{
  $form_name = $record->get_form_settings('form_name');
  
  //Check that the form is the "Rgistration Form" if not - stop and return;
  if ('Rgistration Form' !== $form_name) {
      return;
  }
  $form_data = $record->get_formatted_data();

	$email = $form_data['email'];
  //Check if the user already exists
    if ( email_exists( $email ) ){ 
        $ajax_handler->add_error_message("The user already exists"); 
        $ajax_handler->is_success = false;
        return;
    }
	
	$password = $form_data['password'];
	$password_confirm = $form_data['password_confirm'];	
  //Check if the 2 passwords match
	if ( $password !== $password_confirm ){ 
        $ajax_handler->add_error_message("הסיסמאות אינן תואמות"); 
        $ajax_handler->is_success = false;
        return;
    }	
	
	$user_data = array(
		'user_pass' => $password,
		'user_login' => $email,
		'role' => get_option('default_role'),
		'user_email' => $email,
		'show_admin_bar_front' => 'false'
	);
	$user_id = wp_insert_user( $user_data );
	
	$confirm_code = wp_rand(111111, 999999);
	
	update_user_meta( $user_id, 'user_confirm_code', $confirm_code );
	update_user_meta( $user_id, 'user_confirm_status', 'not_verified' );
		
  //Call the html file that contains the design code for the email message  
	$html_email_template_file = get_stylesheet_directory_uri().'/html/user_confirm_email_template.html';
  $message = file_get_contents($html_email_template_file);
  $subject = "Please verify your account";
	$headers = 'From: '. "no_reply@example.com" . "\r\n" .
		'Reply-To: ' . "no_reply@example.com" . "\r\n";
	
  //Replace the content of the file with post meat filds
  $message = str_replace('code_to_replace', $confirm_code, $message);
	
	$sent = wp_mail($email, $subject, $message, $headers);	
}
