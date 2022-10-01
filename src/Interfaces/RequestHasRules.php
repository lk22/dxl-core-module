<?php 

    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists('RequestHasRules') ) 
    {
        interface RequestHasRules
        {
            /**
             * Apply rules to request
             */
            public function rules();
        }
    }
?>