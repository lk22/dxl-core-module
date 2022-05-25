<?php 

/**
 * Plugin name: DXL Core module
 * Description: DXL Core functionality 
 * Author: Leo Knudsen
 * Version: 1.0.0
 */

if(!defined('ABSPATH')) exit;
require (__DIR__ . "/vendor/autoload.php");
use Dxl\Classes\Core;

require_once dirname(__FILE__) . "/functions.php";

new Core();

?>