<?php 
    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists('ViewInterface') ) 
    {
        interface ViewInterface 
        {
            public function render();
        }
    }

?>