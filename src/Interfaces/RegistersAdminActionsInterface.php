<?php 
    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists('RegistersAdminActionsInterface') ) 
    {
        interface RegistersAdminActionsInterface 
        {
            public function registerAdminActions(): void;
        }
    }
?>