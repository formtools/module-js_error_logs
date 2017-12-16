<?php

$STRUCTURE = array();
$STRUCTURE["tables"] = array();
$STRUCTURE["tables"]["module_js_error_logs"] = array(
    array(
        "Field"   => "log_id",
        "Type"    => "mediumint(9)",
        "Null"    => "NO",
        "Key"     => "PRI",
        "Default" => ""
    ),
    array(
        "Field"   => "error_datetime",
        "Type"    => "datetime",
        "Null"    => "NO",
        "Key"     => "",
        "Default" => ""
    ),
    array(
        "Field"   => "msg",
        "Type"    => "mediumtext",
        "Null"    => "YES",
        "Key"     => "",
        "Default" => ""
    ),
    array(
        "Field"   => "url",
        "Type"    => "mediumtext",
        "Null"    => "YES",
        "Key"     => "",
        "Default" => ""
    ),
    array(
        "Field"   => "line",
        "Type"    => "varchar(7)",
        "Null"    => "YES",
        "Key"     => "",
        "Default" => ""
    ),
    array(
        "Field"   => "stacktrace",
        "Type"    => "mediumtext",
        "Null"    => "YES",
        "Key"     => "",
        "Default" => ""
    )
);

$HOOKS = array(
    array(
        "hook_type"       => "template",
        "action_location" => "modules_head_top",
        "function_name"   => "",
        "hook_function"   => "includeJs",
        "priority"        => "50"
    ),
    array(
        "hook_type"       => "template",
        "action_location" => "head_top",
        "function_name"   => "",
        "hook_function"   => "includeJs",
        "priority"        => "50"
    )
);

$FILES = array(
    "code/",
    "code/index.html",
    "code/logs.php",
    "code/Module.class.php",
    "images/",
    "images/icon.png",
    "index.php",
    "lang/",
    "lang/en_us.php",
    "library.php",
    "module_config.php",
    "README.md",
    "scripts/",
    "scripts/errors.js",
    "templates/",
    "templates/index.tpl"
);
