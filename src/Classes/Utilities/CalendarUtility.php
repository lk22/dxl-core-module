<?php 
  namespace Dxl\Classes\Utilities;

  if( ! defined('ABSPATH') ) exit;

  if ( ! class_exists('CalendarUtility') ) {
    class CalendarUtility {
      public static $instance;

      public static function getInstance() {
        if ( ! self::$instance ) {
          return new CalendarUtility();
        }

        return self::$instance;
      }

      public static function getWeekDays() {
        return ['Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag', 'Søndag'];
      }

      public static function getMonths() {
        return ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      }

      public static function getMonthDays($daysInMonth) {
        $days = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
          $days[] = $i;
        }

        return $days;
      }
    }
  }
?>