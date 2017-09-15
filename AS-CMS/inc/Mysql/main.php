<?php
/** Mysql 
 *
 * this component is a very basic Mysql interface for interacting with a Mysql 
 * database
 *
 */

class Mysql {
    private $db;    ///< mysqli instance

    /** constructor
     *
     * - tries to connect to a given mysql database<br />
     * - tries to select the requested database<br />
     * - sets the charset for all queries to UTF-8
     *
     * \param   $acc    mysql login data
     *
     * \note exit on error
     * \note persistent connection is used
     */
    function __construct($acc) {
        // connect to mysql server
        $this->db = new mysqli($acc["host"], $acc["user"], $acc["pass"], $acc["base"]);

        if ($this->db->connect_error)
            exit($this->db->connect_errno . ": " . $this->db->connect_error);

        // use this if 5.2.9 <= php version <= 5.3.0
        /*
        if (mysqli_connect_error())
            exit(mysqli_connect_errno() . ": " . mysqli_connect_error());
         */

        // set charset
        if (!$this->db->set_charset("utf8"))
            trigger_error("Mysql could not set charset to utf8");
    }

    /** destructor
     *
     * tries to close a connection
     *
     * \note use less in case of persistent connection
     */
    function __destruct() {
        $this->db->close();
    }

    /** raw query
     *
     * this function is uesd to send raw queries to the database. $res should 
     * be freed after usage.
     *
     * \param   $s      string to pass
     * \return  $res    resulting resource
     *
     * \note triggers error
     */
    public function query($s) {
        if (!($res = $this->db->query($s)))
            trigger_error($this->db->error);

        return $res;
    }

    /** secure array
     *
     * this function secures the values of a provided array by using secSz()
     *
     * \param   $arr    reference to array
     */
    public function secArr(&$arr) {
        foreach ($arr as $key => $val)
            $arr[$key] = $this->secSz($val);
    }

    /** secure string
     *
     * this function secures a string for mysql passing
     *
     * \param   $s  string to secure
     * \return  secured string
     *
     * \note only mysql_real_escape_string is used
     */
    public function secSz($s) {
        return $this->db->real_escape_string($s);
    }

    /** select
     *
     * a basic select function to get entries from the mysql database
     *
     * \param   $table  name of table to get entries from
     * \param   $where  (optional) an _array_ to select specific entries (key = col, value = value)
     *                  if not set, all entries will be selected
     * \param   $op     multible $where entries will be interconnected using $op (AND / OR)
     * \return  a 2 dimensional array
     *      1. level: number => array (...)
     *      2. level: column => value
     */
    public function sel($table, $where="", $op="AND") {
        if ($where === "") {
            // select all
            $s = "SELECT * FROM ".$table.";";
        } else {
            // secure values and add to an array
            foreach ($where as $key => $val)
                $arr[] = $key."='".$this->secSz($val)."'";

            // create $where string
            $where = implode(" ".$op." ", $arr);

            // put together the whole string
            $s = "SELECT * FROM ".$table." WHERE ".$where.";";

            // reset $arr
            $arr = array();
        }

        $res = $this->query($s);

        $ret = array();
        while ($row = $res->fetch_assoc())
            $ret[] = $row;

        $res->free();

        return $ret;
    }

    /** insert
     *
     * a basic insert function to add new entries to the mysql database
     *
     * \param   $table  name of table to insert new entry
     * \param   $data   array( col => value) providing data for insertion
     */
    public function ins($table, $data) {
        $this->secArr($data);

        $cols = "";
        $vals = "";
        foreach ($data as $key => $val) {
            $cols .= $key.",";
            $vals .= "'".$val."',";
        }
        $cols = substr($cols, 0, -1);
        $vals = substr($vals, 0, -1);

        $this->query("INSERT INTO ".$table."  (".$cols.") VALUES (".$vals.");");
    }

    /** update
     *
     * a basic function to update existing entries in the mysql database
     *
     * \param   $table  name of table to insert new entry
     * \param   $id     id of entry which should be updated
     * \param   $data   array( col => value) providing data for insertion
     */
    public function upd($table, $id, $data) {
        $this->secArr($data);

        $s = "";
        foreach ($data as $key => $val)
            $s .= $key."='".$val."',";

        $s = substr($s, 0, -1);

        $this->query("UPDATE ".$table." SET ".$s." WHERE id=".$id.";");
    }

    /** delete
     *
     * a basic function to delete entries from the mysql database
     *
     * \param   $table  name of table to insert new entry
     * \param   $id     id of entry which should be deleted
     */
    public function del($table, $id) {
        $this->query("DELETE FROM ".$table." WHERE id=".$id.";");
    }

    /** get mysqli instance
     *
     * returns the mysqli instance
     *
     * \return  mysqli instance
     */
    public function getInstance() {
        return $this->db;
    }
}

?>
