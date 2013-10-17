<?php


function js_error_logs__install($module_id)
{
  global $g_table_prefix;

  // check the version. If this is earlier than 2.1.0, throw an error
  $version_info = ft_get_core_version_info();
  if ($version_info["release_date"] < 20110426)
  {
    return array(false, "Sorry, this module only works with Form Tools 2.1.0 or later.");
  }

  $query = mysql_query("
    CREATE TABLE {$g_table_prefix}module_js_error_logs (
      log_id mediumint NOT NULL AUTO_INCREMENT PRIMARY KEY,
      error_datetime datetime NOT NULL,
      msg mediumtext NULL,
      url mediumtext NULL,
      line varchar(7) NULL,
      stacktrace mediumtext NULL
      ) DEFAULT CHARSET=utf8
  ");

  if (!$query)
  {
    return array(false, "There was a problem installing the module: " . mysql_error());
  }

  ft_register_hook("template", "js_error_logs", "modules_head_top", "", "jsel_include_js");
  ft_register_hook("template", "js_error_logs", "head_top", "", "jsel_include_js");
  return array(true, "");
}


function js_error_logs__uninstall($module_id)
{
  global $g_table_prefix;

  // our create table query
  mysql_query("DROP TABLE {$g_table_prefix}module_js_error_logs");

  return array(true, "");
}


// this just includes the error catching JS
function jsel_include_js()
{
  global $g_root_url;
  echo "<script src=\"$g_root_url/modules/js_error_logs/scripts/errors.js\"></script>\n";
}


/**
 * @param integer $page
 * @param string $search - a string to search any database field
 * @return array
 */
function jsel_get_error_logs($page = 1, $search = "")
{
  global $g_table_prefix, $L;

  $per_page = 20;

  // determine the LIMIT clause
  $limit_clause = "";
  $first_item = ($page - 1) * $per_page;
  $limit_clause = "LIMIT $first_item, $per_page";

  // later, perhaps
  $search = ft_sanitize($search);
  $search_clause = "";


  // our main search query
  $query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}module_js_error_logs
    ORDER BY log_id DESC
    $limit_clause
  ");

  $info = array();
  while ($row = mysql_fetch_assoc($query))
    $info[] = $row;

  $count_result = mysql_query("
    SELECT count(*) as c
    FROM   {$g_table_prefix}module_js_error_logs
    ");
  $count_hash = mysql_fetch_assoc($count_result);

  $return_hash["results"]     = $info;
  $return_hash["num_results"] = $count_hash["c"];

  return $return_hash;
}


function jsel_clear_logs()
{
  global $g_table_prefix;

  mysql_query("TRUNCATE {$g_table_prefix}module_js_error_logs");
}
