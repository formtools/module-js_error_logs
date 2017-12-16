<?php

require_once("../../../global/library.php");

use FormTools\Modules;

$module = Modules::initModulePage();

$msg        = $_POST["msg"];
$url        = $_POST["url"];
$line       = $_POST["line"];
$stacktrace = isset($_POST["stacktrace"]) ? $_POST["stacktrace"] : "";

$module->logError($msg, $url, $line, $stacktrace);
