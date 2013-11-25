<?php

return array(

    'username' => 'Username',
    'password' => 'Password',
    'password_confirmation' => 'Confirm Password',
    'e_mail' => 'Email',
	'name' => 'Name',
	'surname' => 'Surname',
	'activate_user' => 'Activate User?',
	'roles' =>'Roles',
	'roles_info' =>'Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.',
    'username_e_mail' => 'Username or Email',
	'name' => 'Name',
	'permissions' => 'Permissions',
	'update' => 'Update',
	'avatar' => 'Avatar',
	'signup' => array(
        'title' => 'Signup',
        'desc' => 'Signup for new account',
        'confirmation_required' => 'Confirmation required',
        'submit' => 'Create new account',
    ),

    'login' => array(
        'title' => 'Login',
        'accestouser' => 'Access to your account',
        'desc' => 'Login to system',
        'forgot_password' => 'Forgot password',
        'remember' => 'Remember me',
        'submit' => 'Login',
    ),

    'forgot' => array(
        'title' => 'Forgot password',
        'submit' => 'Continue',
    ),

    'alerts' => array(
        'account_created' => 'Your account has been successfully created. Please check your email for the instructions on how to confirm your account.',
        'too_many_attempts' => 'Too many attempts. Try again in few minutes.',
        'wrong_credentials' => 'Incorrect username or password.',
        'not_confirmed' => 'Your account may not be confirmed. Check your email for the confirmation link',
        'confirmation' => 'Your account has been confirmed! You may now login.',
        'wrong_confirmation' => 'Wrong confirmation code.',
        'password_forgot' => 'The information regarding password reset was sent to your email.',
        'wrong_password_forgot' => 'User not found.',
        'password_reset' => 'Your password has been changed successfully.',
        'wrong_password_reset' => 'Invalid password. Try again',
        'wrong_token' => 'The password reset token is not valid.',
        'duplicated_credentials' => 'The credentials provided have already been used. Try with different credentials.',
    ),

    'email' => array(
        'account_confirmation' => array(
            'subject' => 'Account Confirmation',
            'greetings' => 'Hello :name',
            'body' => 'Please access the link below to confirm your account.',
            'farewell' => 'Regards',
        ),

        'password_reset' => array(
            'subject' => 'Password Reset',
            'info' => 'To reset your password, complete this form:',
            'greetings' => 'Hello :name',
            'body' => 'Access the following link to change your password',
            'farewell' => 'Regards',
        ),
    ),

);