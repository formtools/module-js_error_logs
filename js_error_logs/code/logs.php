<?php

require_once("../../../global/library.php");

$_POST = ft_sanitize($_POST);
$msg        = $_POST["msg"];
$url        = $_POST["url"];
$line       = $_POST["line"];
$stacktrace = isset($_POST["stacktrace"]) ? $_POST["stacktrace"] : "";

$now = ft_get_current_datetime();

mysql_query("
  INSERT INTO {$g_table_prefix}module_js_error_logs (error_datetime, msg, url, line, stacktrace)
  VALUES ('$now', '$msg', '$url', '$line', '$stacktrace')
");
