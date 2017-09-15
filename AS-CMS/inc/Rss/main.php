<?php
/** rss feeds
 *
 * this component handles rss feeds for your page
 *
 * \note
 *      change URLs inside the feed.rss.
 *      add aditional .rss files by hand when working with multiple feeds
 */

class Rss {
    private $url;

    function __construct($cfg) {
        $this->url = $cfg["url"];
    }

    /** add entry
     *
     * this function adds a new entry to a already existing rss feed
     *
     * \param   $feed   the entry should be added to this feed
     * \param   $title  title of the new entry
     * \param   $link   link of the new entry (eg: run=Test&param=1)
     * \param   $desc   description of the new entry
     */
    public function add($feed, $title, $link, $desc) {
        // check for feed
        if (!is_readable("inc/".get_class($this)."/".$feed.".rss"))
            trigger_error("could not open feed");

        // init
        $dom = new DOMDocument("1.0", "utf-8");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        // load
        $dom->load("inc/".get_class($this)."/".$feed.".rss");

        // new
        $new = $dom->createElement("item");
        $new->appendChild($dom->createElement("title", $title));
        $new->appendChild($dom->createElement("link", htmlspecialchars($this->url."?".$link)));
        $new->appendChild($dom->createElement("guid", htmlspecialchars($this->url."?".Core::load("", "Link")->add("?".$link))));
        $new->appendChild($dom->createElement("pubDate", date("r")));
        $new->appendChild($dom->createElement("description", $desc));

        // insert
        $dom->getElementsByTagName("channel")->item(0)->insertBefore(
            $new,
            $dom->getElementsByTagName("item")->item(0)
        );

        // print out
        file_put_contents("inc/".get_class($this)."/".$feed.".rss", $dom->saveXML());
    }
}

?>
