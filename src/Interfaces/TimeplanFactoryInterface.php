<?php 
  namespace Dxl\Interfaces;

  if ( ! defined("ABSPATH") ) {
    exit;
  }

  if ( ! interface_exists('TimeplanFactoryInterface') ) {
    interface TimeplanFactoryInterface {
      public function get($action);
    }
  }