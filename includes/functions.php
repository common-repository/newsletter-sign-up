<?php

/**
* Displays the comment checkbox, call this function if your theme does not use the 'comment_form' action in the comments.php template.
*/
function nsu_checkbox() {
	NSU::checkbox()->output_checkbox();
}


/**
* Outputs a sign-up form, for usage in your theme files.
*/
function nsu_form() {
	NSU::form()->output_form( true );
}


/* Backwards Compatibility */
function nsu_signup_form() {
	_deprecated_function( __FUNCTION__, '2.0', 'nsu_form' );
	nsu_form();
}
