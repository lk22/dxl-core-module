<?php 
    namespace Dxl\Interfaces;

    if ( ! defined('ABSPATH') ) exit;

    if ( ! interface_exists("CronFactoryInterface")) 
    {
        interface CronFactoryInterface 
        {
            public function get($task);
        }
    }
?>