<?php

require_once("../../global/library.php");

use FormTools\General;
use FormTools\Modules;

$module = Modules::initModulePage("admin");

if (isset($request["clear"])) {
	$module->clearLogs();
	$_GET["page"] = 1;
}

$page = Modules::loadModuleField("js_error_logs", "page", "page", 1);
$results = $module->getErrorLogs($page);

$page_vars = array(
    "lines"       => $results["results"],
    "num_results" => $results["num_results"],
    "pagination"  => General::getPageNav($results["num_results"], 20, $page)
);

$module->displayPage("templates/index.tpl", $page_vars);
