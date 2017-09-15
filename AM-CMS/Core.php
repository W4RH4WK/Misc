<?php
/** \file
 *
 * This is the Core of the CMS.
 *
 */

// enable errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

/** core class 
 *
 * this is the core class which holds a error handler and a loader for 
 * components, as well as a php parse include function. Additional head 
 * includes can be added via this Core.
 */
class Core {
    const version = "v0.2";

    private static $head;           ///< additional head includes
    private static $msg;            ///< message cache

    public static function init() {
        // set error handler
        set_error_handler("Core::errHandler");

        // set head includes
        self::$head = "";

        // set message cache
        self::$msg = "";
    }

    /** add head
     *
     * adds a string to the head buffer.
     *
     * \param   $s  string to add
     */
    public static function addHead($s) {
        self::$head .= "        " . $s . "\n";
    }

    /** get head
     *
     * \return head
     */
    public static function getHead() {
        return self::$head;
    }

    /** add message
     *
     * this function adds a new message to the message cache with design
     *
     * \param   $title      the headline of the message
     * \param   $msg        the message text
     * \param   $type       error | success | info
     */
    public static function addMsg($title, $msg, $type="info") {
        self::$msg .= "<div class=\"alert alert-$type\"><strong class=\"alert-heading\">$title</strong><br />$msg</div>\n";
    }

    /** get messages
     *
     * \return  messages
     */
    public static function getMsg() {
        return self::$msg;
    }

    /** error handler
     *
     * This is a wrapper to combine the 'trigger_error' function with the 
     * 'addMsg' function.
     * also a backtrace is applied to he message
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
        self::addMsg("#$errno [ $errfile @ $errline ]", $errstr.$bt, "error");
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
            trigger_error($fn . " couldn't be opened");
        }
    }

    /** render markdown
     *
     * this function is a wrapper for the markdown library
     *
     * \param   $s  string with markdown code
     * \return  html code
     */
    public static function renderMarkdown($s) {
        require_once("lib/markdown/markdown.php");
        return Markdown($s);
    }
}

Core::init();

?>
