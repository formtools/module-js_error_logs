<?php


namespace FormTools\Modules\JsErrorLogs;

use FormTools\Core;
use FormTools\General;
use FormTools\Hooks;
use FormTools\Module as FormToolsModule;
use Exception, PDO;


class Module extends FormToolsModule
{
    protected $moduleName = "JS Error Logs";
    protected $moduleDesc = "This module tracks all javascript errors and logs them in a database table for easy browsing. This is handy for alpha/beta releases and to help locate problems with your Form Tools installation.";
    protected $author = "Ben Keen";
    protected $authorEmail = "ben.keen@gmail.com";
    protected $authorLink = "https://formtools.org";
    protected $version = "2.0.0";
    protected $date = "2017-12-15";
    protected $originLanguage = "en_us";

    protected $nav = array(
        "module_name" => array("index.php", false)
    );


    public function install($module_id)
    {
        $db = Core::$db;

        if (Core::getReleaseDate() < 20110426) {
            return array(false, "Sorry, this module only works with Form Tools 2.1.0 or later.");
        }

        try {
            $db->query("
                CREATE TABLE {PREFIX}module_js_error_logs (
                    log_id mediumint NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    error_datetime datetime NOT NULL,
                    msg mediumtext NULL,
                    url mediumtext NULL,
                    line varchar(7) NULL,
                    stacktrace mediumtext NULL
                ) DEFAULT CHARSET=utf8
            ");
            $db->execute();
        } catch (Exception $e) {
            return array(false, "There was a problem installing the module: " . $e->getMessage());
        }

        Hooks::registerHook("template", "js_error_logs", "modules_head_top", "", "includeJs");
        Hooks::registerHook("template", "js_error_logs", "head_top", "", "includeJs");

        return array(true, "");
    }


    public function uninstall($module_id)
    {
        $db = Core::$db;

        try {
            $db->query("DROP TABLE {PREFIX}module_js_error_logs");
            $db->execute();
        } catch (Exception $e) {

        }
        return array(true, "");
    }


    // this just includes the error catching JS
    public function includeJs()
    {
        $root_url = Core::getRootUrl();
        echo "<script src=\"$root_url/modules/js_error_logs/scripts/errors.js\"></script>\n";
    }


    /**
     * @param integer $page
     * @param string $search - a string to search any database field
     * @return array
     */
    public function getErrorLogs($page = 1, $search = "")
    {
        $db = Core::$db;

        $per_page = 20;

        // determine the LIMIT clause
        $first_item = ($page - 1) * $per_page;
        $limit_clause = "LIMIT $first_item, $per_page";

        // our main search query
        $db->query("
            SELECT *
            FROM   {PREFIX}module_js_error_logs
            ORDER BY log_id DESC
            $limit_clause
        ");
        $db->execute();
        $info = $db->fetchAll();

        $db->query("
            SELECT count(*)
            FROM   {PREFIX}module_js_error_logs
        ");
        $db->execute();

        return array(
            "results"     => $info,
            "num_results" => $db->fetch(PDO::FETCH_COLUMN)
        );
    }


    public function clearLogs()
    {
        $db = Core::$db;
        $db->query("TRUNCATE {PREFIX}module_js_error_logs");
        $db->execute();
    }


    public function logError($msg, $url, $line, $stacktrace)
    {
        $db = Core::$db;

        $db->query("
            INSERT INTO {PREFIX}module_js_error_logs (error_datetime, msg, url, line, stacktrace)
            VALUES (:error_datetime, :msg, :url, :line, :stacktrace)
        ");
        $db->bindAll(array(
            "error_datetime" => General::getCurrentDatetime(),
            "msg" => $msg,
            "url" => $url,
            "line" => $line,
            "stacktrace" => $stacktrace
        ));
        $db->execute();
    }

}
