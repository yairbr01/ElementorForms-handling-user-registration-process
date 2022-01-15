# Wordpress & Elementor - handling registration, login, user authentication and password resrt
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
3. Create 2 pages, one for password recovery and the other for password reset (make sure the password reset page address is "reset-password").


The functions extract the data from the fields according to the names of the fields, note the field names in the functions.


User registration form contains 3 fields:
1. Email address.
2. Password.
3. Password confirm.
The form forwards the user after filling out the form to the password verification page plus a parameter of the email address.
The parameter is "email".


User login form contains 3 fields:
1. Email address.
2. Password.
3. Remember me.


The user authentication form consists of 7 fields:
1. The user's email address with a default value from the "email" parameter.
2. The first digit in the code.
3. The second digit in the code.
4. The third digit in the code.
5. The fourth digit in the code.
6. The fifth digit in the code.
7. The sixth digit in the code.


The password recovery form contains one field and is the email address.


Password reset form contains 4 fields:
1. Hidden - The email address of the user with a default value from the "login" parameter.
2. Hidden - a unique key for resetting the password with a default value from the "key" parameter.
3. Password.
4. Password confirm.
