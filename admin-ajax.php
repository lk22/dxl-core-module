<?php
/**
 * WordPress Ajax Process Execution
 *
 * @package WordPress
 * @subpackage Administration
 *
 * @link https://codex.wordpress.org/AJAX_in_Plugins
 */

use Dxl\Classes\Core;
$dxl = new Core();

$logger = $dxl->getUtility('Logger');

/**
 * Executing Ajax process.
 *
 * @since 2.1.0
 */
define( 'DOING_AJAX', true );
if ( ! defined( 'WP_ADMIN' ) ) {
	define( 'WP_ADMIN', true );
}

/** Load WordPress Bootstrap */
require_once dirname( __DIR__ ) . '/wp-load.php';

/** Allow for cross-domain requests (from the front end). */
send_origin_headers();

header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
header( 'X-Robots-Tag: noindex' );

// Require an action parameter.
if ( empty( $_REQUEST['action'] ) ) {
    $logger->log("DXL Request not found, could not proceed");
	wp_die( '0', 400 );
}

/** Load WordPress Administration APIs */
require_once ABSPATH . 'wp-admin/includes/admin.php';

/** Load Ajax Handlers for WordPress Core */
require_once ABSPATH . 'wp-admin/includes/ajax-actions.php';

send_nosniff_header();
nocache_headers();

/** This action is documented in wp-admin/admin.php */
do_action( 'admin_init' );

$action = ( isset( $_REQUEST['action'] ) ) ? $_REQUEST['action'] : '';

if ( is_user_logged_in() ) {
	// If no action is registered, return a Bad Request response.
	if ( ! has_action( "wp_ajax_dxl_{$action}" ) ) {
        $dxl->response('action', [
            "error" => true,
            "response" => "Action: wp_ajax_dxl_{$action} not found"
        ]);

        $logger->log("Could not find DXL action: wp_ajax_{$action}");

		wp_die( '0', 400 );
	}


    $logger->log("Triggering action: wp_ajax_dxl_{$action}");
    $logger->log("Verifying action nonce..");

    if( ! isset($_REQUEST["dxl_core_nonce"]) && !wp_verify_nonce($_REQUEST["dxl_core_nonce"], 'dxl-core-nonce') ) {
        $dxl->response('action', [
            "error" => true,
            "response" => "Systemet Kunne ikke udføre din handling",
            "details" => "Request token verification failed"
        ]);
        
        $logger->log("Request token verification failed");
        wp_die('Verification failed', 403);
    }

	/**
	 * Fires authenticated Ajax actions for logged-in users.
	 *
	 * The dynamic portion of the hook name, `$action`, refers
	 * to the name of the Ajax action callback being fired.
	 *
	 * @since 2.1.0
	 */
	do_action( "wp_ajax_dxl_{$action}" );
} else {
	// If no action is registered, return a Bad Request response.
	if ( ! has_action( "wp_ajax_nopriv_dxl_{$action}" ) ) {
        $response = (new Core())->response('action', [
            "error" => true,
            "response" => "Action: wp_ajax_dxl_{$action} not found"
        ]);

        $logger->log("Could not find DXL action: wp_ajax_{$action}");
		wp_die( '0', 400 );
	}

	/**
	 * Fires non-authenticated Ajax actions for logged-out users.
	 *
	 * The dynamic portion of the hook name, `$action`, refers
	 * to the name of the Ajax action callback being fired.
	 *
	 * @since 2.8.0
	 */
	do_action( "wp_ajax_nopriv_dxl_{$action}" );
}
// Default status.
wp_die( '0' );
