<?php 
    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists('RegisterGuestActionsInterface') ) 
    {
        interface RegisterGuestActionsInterface 
        {
            public function registerGuestActions(): void;
        }
    }
?>