<?php
/** wrapper component
 *
 * right now this is experimental. All wrappers go here
 *
 */

class Wrapper {
    /** render markdown
     * 
     * providing a markdown text this method converts the markdown to html
     *
     * \param   $s  markdown text
     * \return  html output
     */
    public function renderMarkdown($s) {
        require_once("lib/markdown/markdown.php");
        return Markdown($s);
    }
}

?>
