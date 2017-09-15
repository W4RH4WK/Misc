<?php
/** link component
 *
 * this component enables you to create permanent / unique links to the content 
 * of your page. you can think about this as an alias for URLs
 */

class Link implements Runable, Installable {
    public function Run() {
        if (isset($_GET["id"])) {
            $e = Core::load("Mysql")->sel("Link", array("id" => $_GET["id"]));
            header("location: ".$e[0]["link"]);
        } else {
            trigger_error("no id given");
        }
    }

    public function getNavEntries() {
        return array();
    }

    /** add new
     *
     * this method adds a new unique link
     *
     * \param   $l  link to alias
     *              (eg: http://w4rh4wk.dyndns.org/ascms/index.php?run=Test&param=1)
     * \return  new link
     *              (eg: run=Link&id=5)
     */
    public function add($l) {
        Core::load("Mysql")->ins("Link", array("link" => $l));
        return "run=Link&id=".Core::load("Mysql")->getInstance()->insert_id;
    }

    /** install method
     *
     * - this is called upon installing
     */
    public function Install($cfg) {
        // get instance
        $i = Core::load("Mysql")->getInstance();

        // do a multi query
        $i->multi_query(file_get_contents("inc/".get_class($this)."/dump.sql"));

        // use results to keep query flow alive
        do
            $i->use_result();
        while ($i->next_result());
    }
}

?>
