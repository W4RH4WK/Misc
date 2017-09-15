<?php
/** \file
 *
 * this is the cms core with error handler and component loader.
 * also the interfaces will be defined here
 *
 */

/** Runable interface
 *
 * this interface indicates that a component can be run.
 * the Run() method is invoked upon running
 * the getNavEntries() method is invoked upon nav entry request
 */
interface Runable {
    public function Run();
    public function getNavEntries();
}

/** Adminable interface
 *
 * this interface indicates that a component has admin page.
 * the Admin() method is run upon admining.
 */
interface Adminable {
    public function Admin();
}

/** Ajaxable interface
 *
 * this interface indicates that a component can handle ajax callouts
 * the Ajax() method is run upon an ajax callout.
 */
interface Ajaxable {
    public function Ajax();
}

/** Installable interface
 *
 * this interface indicates that a component needs installation.
 * when the CMS is installed by the installer, Install() is called.
 * it's also possible to run Install() from the Installer component itself
 *
 * \param   $cfg    configuration array
 */
interface Installable {
    public function Install($cfg);
}

// -- enable errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

// -- init session
session_name("AS-CMS");
session_start();

// -- load config
require_once("config.php");

/** core class 
 *
 * this is the core class which holds a error handler and a loader for 
 * components.
 */
class Core {
    const version = "v1.0";

    private static $loaderCache;    ///< cache for loader

    public static function init() {
        // set error handler
        set_error_handler("Core::errHandler");

        // set loader cache
        self::$loaderCache = array();
    }

    /** error handler
     *
     * this method is invoked whenever an error is triggered. the error message 
     * and all it's information is appended to $err
     * a backtrace will be added too
     *
     * \param   $errno      number of error
     * \param   $errstr     error message
     * \param   $errfile    file where error occured
     * \param   $errline    line where error occured
     */
    public static function errHandler($errno, $errstr, $errfile, $errline) {
        // backtrace
        $bt = "";
        foreach (debug_backtrace() as $n => $e) {
            if ($n == 0) continue;
            $bt .= '<li>#'.(string) ($n - 1).' in '.$e["file"].' at '.$e["line"].': <strong>'.$e["function"]."</strong></li>\n";
        }
        $bt = "<ul class=\"backtrace unstyled\">$bt</ul>";
        
        // msg handler call
        Core::load("MsgHandler")->add("#$errno [ $errfile @ $errline ]", $errstr.$bt, "error");
    }

    /** core include
     *
     * gets the content of a file and evals php code. the result is returned as 
     * string
     *
     * \param   $fn     filename
     * \param   $data   data which can be used in the file as $data
     * \return  evaled content
     */
    public static function inc($fn, $data="") {
        if (is_readable($fn)) {
            ob_start();
            include($fn);
            return ob_get_clean();
        } else {
            trigger_error($fn . "couldn't be opened");
        }
    }

    /** loader
     *
     * the loader might be the most complex part of the CMS but using it will 
     * be essential.
     * it does not only load components, but also caches created instances so 
     * you can reuse them. see usage for more information. Components using the 
     * standard configuration are stored in the cache with the same name like 
     * the class. (eg: Mysql ... Mysql class instance if default configuration)
     *
     * usage:
     *      load("Mysql");
     *          if and instance with the name Mysql is cached, it will
     *          be returned, otherwise a new instance of the class
     *          Mysql is created with default configuration
     *
     *      load("", "Mysql");
     *          returns a new Mysql instance with default configuration
     *          the newly created object is not stored in cache
     *
     *      load("Mysql2", "Mysql");
     *          if there is already a cached element with the name
     *          Mysql2, it is returend. otherwise a new instace of the
     *          class Mysql is created with default configuration,
     *          stored in the cache with the name Mysql and returned
     *
     *      load("", "Mysql", array("host" => "1.2.3.4"));
     *          this time we altered the default configuration, only the host 
     *          parameter is changed, all other parameters are left to their 
     *          default values
     *
     * \param   $name   the name is used to store a created instance in the 
     *                  cache and restore them
     * \param   $class  an object from this class is created
     * \param   $cfg    config alterations go here (not specified use the 
     *                  defaults)
     * \return  reference to new / cached instance
     */
    public static function load($name, $class="", $cfg=array()) {
        // try to load cached instance
        if (isset(self::$loaderCache[$name]))
            return self::$loaderCache[$name];

        // if no class is set, use name
        if ($class == "")
            $class = $name;
        
        // glue config together
        global $config;
        if (isset($config[$class]) && is_array($config[$class]))
            $cfg = array_merge($config[$class], $cfg);

        // create new instance
        require_once("inc/" . $class . "/main.php");
        $obj = new $class($cfg);

        // store if name is given
        if ($name !== "")
            self::$loaderCache[$name] = $obj;

        // return new instance
        return $obj;
    }
}

Core::init();

?>
