<?php
require_once( 'init.php' );

if ( empty( $_POST ) && empty( $_POST['action'] ) ) {
	redirect( '/' );
	return;
}

switch ( $_POST['action'] ) {
	case 'register':
		handleRegister( $_POST );
		break;

}

function handleRegister( $data ) {

	$required_fields = array(
		'first_name',
		'last_name',
		'email',
		'password',
		'repeat_password',
	);

	$missing_fields = array();

	foreach ( $required_fields as $field ) {
		if ( empty( $data[ $field ] ) ) {
			$missing_fields[] = $field;
		}
	}

	if ( ! empty( $missing_fields ) ) {
		$_SESSION['errors'] = array(
			'message' => 'Please fill in all required fields',
			'fields'  => $missing_fields,
		);
		return;
	}

}

redirect( $_SERVER['HTTP_REFERER'] );
