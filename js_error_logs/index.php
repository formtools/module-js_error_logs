<?php

require_once("../../global/library.php");
ft_init_module_page();
$request = array_merge($_POST, $_GET);

if (isset($request["clear"]))
{
	jsel_clear_logs();
	$_GET["page"] = 1;
}

$page = ft_load_module_field("js_error_logs", "page", "page", 1);

$results = jsel_get_error_logs($page);

$page_vars = array();
$page_vars["lines"]       = $results["results"];
$page_vars["num_results"] = $results["num_results"];
$page_vars["pagination"]  = ft_get_page_nav($results["num_results"], 20, $page);

ft_display_module_page("templates/index.tpl", $page_vars);