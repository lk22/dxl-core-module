<?php 
    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists('ActionInterface') ) {
        interface ActionInterface 
        {
            public function call();
        }
    }
?>