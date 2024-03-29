<?php 
  namespace Dxl\Classes\Utilities;

  if( ! defined('ABSPATH') ) exit;

  if ( ! class_exists('CalendarUtility') ) {
    class CalendarUtility {

      /**
       * Instance of the class
       */
      public static $instance;

      /**
       * Get utility instance
       *
       * @return CalendarUtility
       */
      public static function getInstance(): CalendarUtility 
      {
        if ( ! self::$instance ) {
          return new CalendarUtility();
        }

        return self::$instance;
      }

      /**
       * Get days of the week
       *
       * @return array
       */
      public static function getWeekDays(): array 
      {
        return ['Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag', 'Søndag'];
      }

      /**
       * get months of the year
       *
       * @return array
       */
      public static function getMonths($year): array 
      {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
          $months[] = date("F", mktime(0, 0, 0, $i, 1, $year));
        }

        return $months;
      }

      /**
       * get days of a specified month
       *
       * @param [type] $daysInMonth
       * @return array
       */
      public static function getMonthDays($daysInMonth): array 
      {
        $days = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
          $days[] = $i;
        }

        return $days;
      }

      /**
       * Get interval period
       *
       * @param [type] $start
       * @param [type] $end
       * @param [type] $interval
       * @param [type] $modify
       * @return \DatePeriod
       */
      public static function getIntervalPeriod($start, $end, $interval, $modify = ""): \DatePeriod
      {
        $startDate = new \DateTime($start);
        $endDate = new \DateTime($end);
        $intervalDefintion = new \DateInterval($interval);

        if ( ! empty($modify) ) {
          $modifiedEndDate = $endDate->modify($modify);
        } else {
          $modifiedEndDate = $endDate;
        }

        $period = new \DatePeriod($startDate, $intervalDefintion, $modifiedEndDate);
        // $period = new \DatePeriod($start, $intervalDefintion, $modifiedEndDate);

        return $period;
      }
    }
  }
?>