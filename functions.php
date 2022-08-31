<?php

function redirect( $url, $statusCode = 303 ) {
   header( 'Location: ' . $url, true, $statusCode );
   die();
}

function maybe_display_error( $field, $name ) {
	if ( empty( $_SESSION['errors'] && ! empty( $_SESSION['errors']['fields'] ) ) ) {
		return;
	}

	if ( in_array( $field, $_SESSION['errors']['fields'] ) ) {
		if ( ! empty( $_SESSION['errors']['fields']['custom_error'] ) ) {
			echo $_SESSION['errors']['fields']['custom_error'];
		} else {
			echo '<span class="error">' . $name . ' is required</span>';
		}
	}
}

function sanitize_input( $data ) {
	$data = trim( $data );
	$data = stripslashes( $data );
	$data = htmlspecialchars( $data );
	return $data;
}