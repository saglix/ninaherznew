<?php
/**
 * Upload type support.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_allow_upload_types( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['json'] = 'application/json';

	return $mimes;
}
add_filter( 'upload_mimes', 'site_theme_allow_upload_types' );

function site_theme_check_upload_types( $data, $file, $filename, $mimes ) {
	$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

	if ( 'svg' === $extension ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}

	if ( 'json' === $extension ) {
		$data['ext']  = 'json';
		$data['type'] = 'application/json';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'site_theme_check_upload_types', 10, 4 );
