# Wordpress-Elementor---Registration-Login-User-Authentication
PHP functions for registering and logging users to WordPress sites using Elementor Pro, including user authentication after registration.

Using the functions located in this repository you can handle the whole part of registering users for the site.

The functions take care of all the related parts:
1. Register users.
2. Authentication of users after registration.
3. Login users.
4. User password recovery.


In order for all the functions to work properly the parts on the site must be created according to these instructions:

1. At the beginning of each function there is a condition that checks the name of the form. Make sure the name of the form is exactly as it says in the function.
2. 2 custom fields should be added to the user settings (with ACF or any other plugin), one "text" field named "user_confirm_code". and a second "select" field named "user_confirm_status" with 2 values, one "not_verified" and the other "verified".
