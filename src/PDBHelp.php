<?php

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class PDBHelp {

  static function concat(array $values, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      return DB::raw("" . implode("||", $values) . " $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("concat(" . implode(",", $values) . ") $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  static function round(string $column, int $precision = 0, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      return DB::raw("round($column, $precision) $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("round($column, $precision) $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  static function sum(string $column, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      return DB::raw("sum($column) $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("sum($column) $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  static function max(string $column, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      return DB::raw("max($column) $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("max($column) $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  static function min(string $column, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      return DB::raw("min($column) $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("min($column) $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  const DIFF_SECOND = 'SECOND';
  const DIFF_MINUTE = 'MINUTE';
  const DIFF_HOUR = 'HOUR';
  const DIFF_DAY = 'DAY';
  static function dateDiff($returnType, string $startColumnDate, string $endColumnDate, string $columnName = '') {
    if (env('DB_CONNECTION') == 'oracle') {
      $multiple = "*1";
      switch ($returnType) {
        case self::DIFF_SECOND:
          $multiple = "*24*60*60";
          break;
        case self::DIFF_MINUTE:
          $multiple = "*24*60";
          break;
        case self::DIFF_HOUR:
          $multiple = "*24";
          break;
      }
      return DB::raw("($startColumnDate - $endColumnDate)$multiple $columnName");
    } else if (env('DB_CONNECTION') == 'mysql') {
      return DB::raw("TIMESTAMPDIFF($returnType,$startColumnDate, $endColumnDate) $columnName");
    } else {
      throw new Exception('This function do not implemented to current database');
    }
  }

  static function toDate(Carbon $date, string $columnName = '') {
    if ($_ENV['DB_CONNECTION'] == 'oracle') {
      return "to_date('" . $date->format('Y-m-d') . "', 'YYYY-MM-DD') $columnName";
    } else if ($_ENV['DB_CONNECTION'] == 'pgsql') {
      return "(to_date('" . $date->format('Y-m-d') . "','YYYY-MM-DD')') $columnName";
    } else {
      return "STR_TO_DATE('" . $date->format('Y-m-d') . "', '%Y-%m-%d') $columnName";
    }
  }

  static function toDateTime(Carbon $date, string $columnName = '') {
    if ($_ENV['DB_CONNECTION'] == 'oracle') {
      return "to_date('" . $date->format('Y-m-d H:i:s') . "', 'YYYY-MM-DD HH24:MI:SS') $columnName";
    } else if ($_ENV['DB_CONNECTION'] == 'pgsql') {
      return "(to_timestamp('" . $date->format('Y-m-d H:i:s') . "','YYYY-MM-DD HH24:MI:SS')') $columnName";
    } else {
      return "STR_TO_DATE('" . $date->format('Y-m-d H:i:s') . "', '%Y-%m-%d %H:%i:%s') $columnName";
    }
  }
}
