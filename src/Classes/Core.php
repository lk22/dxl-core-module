<?php 

namespace Dxl\Classes;

if( !defined('ABSPATH') ) exit;

use Dxl\Classes\Utilities\Logger;
use Dxl\Classes\Utilities\SpreadsheetUtility;

if(!class_exists('Core')) 
{
    class Core 
    {
        /**
         * DXL Core version 
         */
        const DXL_CORE_VERSION = "1.0.0";
        
        /**
         * required php version
         */
        const REQUIRED_PHP_VERSION = "7.4";

        /**
         * Construct core plugin
         */
        public function __construct()
        {
            // add_action('admin_init', [$this, 'registerMenu']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_core_scripts']);
            $this->validate_requirements();

            $this->initialize_settings_page(); // ACF settings page
        }
        
        public function enqueue_core_scripts()
        {
            wp_enqueue_script('dxl-toast-plugin', plugins_url('dxl-core/src/admin/assets/js/dependencies/toast.min.js'), array('jquery'));
            wp_enqueue_script('dxl-core', plugins_url('dxl-core/src/admin/assets/js/dxl-core.js'), array('jquery'));
            wp_register_style('dxl-toast-style', plugins_url('/dxl-core/src/admin/assets/css/dependencies/toast.min.css'));
            wp_enqueue_style('dxl-toast-style');
            wp_register_style('dxl-core-style', plugins_url('/dxl-core/src/admin/assets/css/dxl-admin.css'));
            wp_enqueue_style('dxl-core-style');

            wp_localize_script('dxl-core', 'dxl_core_vars', [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'dxl_core_nonce' => wp_create_nonce('dxl-core-nonce'),
            ]);
        }

        public function enqueue_core_frontend_scripts()
        {
            wp_enqueue_script('dxl-frontend-core', plugins_url('dxl-core/src/frontend/assets/js/dxl-core.js'), array('jquery'));
            wp_localize_script('dxl-frontend-core', 'dxl_core_vars', [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'dxl_front_core_nonce' => wp_create_nonce('dxl-front-core-nonce')
            ]);
        }

        public function validate_requirements()
        {
            if( version_compare(PHP_VERSION, self::REQUIRED_PHP_VERSION)) {
                add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            }
        }

        public function admin_notice_minimum_php_version()
        {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

            $message = sprintf(
                esc_html__( '"%1$s" kræver "%2$s" version %3$s or højrer.', 'dxl-core-plugin' ),
                '<strong>' . esc_html__( 'DXL Core plugin', 'dxl-core-plugin' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'dxl-core-plugin' ) . '</strong>',
                self::REQUIRED_PHP_VERSION
            );

            // printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        public function initialize_settings_page()
        {
            if( function_exists('acf_add_options_page') ) {
                acf_add_options_page([
                    'page_title' => 'DXL Indstillinger',
                    'menu_title' => 'DXL Indstillinger',
                    'menu_slug' => 'dxl-core',
                    'capability' => 'edit_posts',
                    'redirect' => false
                ]);
            }
        }

        public function response($module, $data, $format = JSON_PRETTY_PRINT) {
            echo wp_json_encode([$module => $data], JSON_PRETTY_PRINT);
        }

        public function log(string $message, string $plugin = "dxl", int $level = 1) 
        {
            return Logger::getInstance()->log($message, $plugin, $level);
        }

        /**
         * Returning utility instance
         *
         * @param [type] $utility
         * @return void
         */
        public function getUtility($utility) {
            switch($utility)
            {
                case 'Logger':
                    return Logger::getInstance();
                    break;

                case 'Spreadsheet':
                    return SpreadsheetUtility::getInstance();
                    break;
            }
        }

        public function forbiddenRequest($module)
        {
            $logger = $this->log("Valid request token not found could not procceed the request", "", 2);
            $this->response($module, [
                "error" => true, 
                "response" => "Systemet kunne ikke give dig adgang til at udføre din handling"
            ]);
            wp_die('Request verification failed, nonce not found', 403);
        }
    }
}



?>