<?php
/** page component
 *
 * the page component helps putting the page design and content together
 *
 */

class Page {
    private $author;            ///< holds the page author
    private $content;           ///< this holds a components HTML output
    private $headAdditions;     ///< additional includes in head
    private $loggedin;          ///< should login form be printed, ...
    private $markitup;          ///< should markitup be loaded
    private $title;             ///< holds the page title

    function __construct($cfg) {
        // init default
        $this->content = ""; 
        $this->headAdditions = "";
        $this->loggedin = false;
        $this->markitup = false;

        // store config
        $this->title = $cfg["title"];
        $this->author = $cfg["author"];

        // check for login
        if (Core::load("Admin")->isLoggedin())
            $this->loggedin = true;
    }

    /** set content
     *
     * a simple setter for content
     * 
     * \param   $s  content HTML string
     */
    public function setContent($s) {
        $this->content = $s;
    }

    /** add head
     *
     * adds a line to the additional line inside the <head>
     *
     * \param   $s  new line to add
     */
    public function addHead($s) {
        $this->headAdditions .= "        " . $s . "\n";
    }

    /** set loggedin
     *
     * sets the logged in indicator member
     *
     * \param   $l  new loggedin value
     */
    public function setLoggedin($l) {
        $this->loggedin = $l;
    }

    /** enable markitup
     *
     * this function enables the markitup texteditor for the page
     */
    public function enableMarkitup() {
        $this->markitup = true;
    }

    /** sidemenu entries
     *
     * generate the entries for the sidemenu
     *
     * \return sidemenu HTML
     */
    private static function sidemenuEntries() {
        $ret = "";

        foreach (scandir("inc") as $f) {
            if ($f == "." || $f == "..") continue;
            if (Core::load("", $f) instanceof Adminable)
                if(Core::load("Admin")->checkPerm($f))
                    $ret .= "<li><a href=\"?admin=".$f."\"><i class=\"icon-edit\"></i> ".$f."</a></li>\n";
        }

        return $ret;
    }

    /** show
     *
     * print the page with it's content
     */
    public function show() {
        return Core::inc(
            "style/page.html",
            array(
                "author" => $this->author,
                "content" => $this->content,
                "incsHead" => substr($this->headAdditions, 8),
                "loggedin" => $this->loggedin,
                "sidemenuEntries" => ($this->loggedin) ? self::sidemenuEntries() : "",
                "markitup" => $this->markitup,
                "title" => $this->title
            )
        );
    }
}

?>
