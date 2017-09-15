<?php
/** message handler
 *
 * this is a basic message handler, which will show messages on the bottom of 
 * the page
 */

class MsgHandler {
    private $msg;   ///< holds all messages

    function __construct($cfg) {
        $this->msg = "";
    }

    /** add message
     *
     * this function adds a new message to the message buffer
     *
     * \param   $title      the headline of the message
     * \param   $msg        the message text
     * \param   $type       error | success | info
     */
    public function add($title, $msg, $type="info") {
        $this->msg .= "<div class=\"alert alert-$type\"><strong class=\"alert-heading\">$title</strong><br />$msg</div>";
    }

    /** get messages
     *
     * this function returns the message buffer
     *
     * \return  message buffer
     */
    public function getMsg() {
        return $this->msg;
    }
}

?>
