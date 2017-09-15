<?php
/** admin component
 *
 * used for administrator login and such stuff
 *
 */

class Admin implements Adminable, Installable {
    private $cookieName;    ///< holds a name for the session cookie
    private $loggedin;      ///< (bool) logged in

    function __construct($cfg) {
        $this->cookieName = $cfg["cookieName"];
        $this->loggedin = false;

        $this->checkLoggedin();
    }

    /** is logged in
     *
     * \return  $loggedin
     */
    public function isLoggedin() {
        return $this->loggedin;
    }

    /** check login
     *
     * checks if a login is valid and sets $loggedin
     */
    private function checkLoggedin() {
        if (isset($_SESSION[$this->cookieName]["loggedin"]))
            $this->loggedin = true;
        else
            $this->loggedin = false;
    }

    /** check permissions
     *
     * checks if the admin has permission to access component
     * 
     * \param   $c  check if this component can be accessed
     * \return  true | false according to permission
     */
    public function checkPerm($c) {
        if ($this->loggedin)
            if (in_array("*", $_SESSION[$this->cookieName]["perm"]))
                return true;
            else
                return in_array($c, $_SESSION[$this->cookieName]["perm"]);
        else
            return false;
    }

    /** login
     *
     * tries to login with given username and password
     *
     * \param   $u  username
     * \param   $p  password
     */
    public function login($u, $p) {
        // get entry
        $entry = Core::load("Mysql")->sel(
            "Admin",
            array("user" => $u)
        );

        // check for password
        if (isset($entry[0]) && $entry[0]["hash"] == self::genHash($p, $entry[0]["salt"])) {
            $_SESSION[$this->cookieName]["loggedin"] = true;
            $_SESSION[$this->cookieName]["user"] = $entry[0]["user"];
            $_SESSION[$this->cookieName]["perm"] = explode(":", $entry[0]["perm"]);
        }

        // set members
        $this->checkLoggedin();
    }

    /** logout
     *
     * logs the currently logged in admin out
     */
    public function logout() {
        unset($_SESSION[$this->cookieName]);
        $this->checkLoggedin();
    }

    /** admin method
     *
     * - called upon administration
     */
    public function Admin() {
        // handle actions
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "new") {
                if (isset($_POST["user"])) {
                    if ($_POST["pass"] == $_POST["pass2"]) {
                        $this->addUser($_POST["user"], $_POST["pass"], $_POST["perm"]);
                    } else {
                        trigger_error("passwords do not match");
                    }
                } else {
                    trigger_error("no username given");
                }
            } else if ($_POST["action"] == "changePw") {
                if ($_POST["pass"] == $_POST["pass2"]) {
                    $salt = self::genSalt();
                    $hash = self::genHash($_POST["pass"], $salt);

                    Core::load("Mysql")->upd(
                        "Admin",
                        $_POST["id"],
                        array(
                            "hash" => $hash,
                            "salt" => $salt
                        )
                    );
                } else {
                    trigger_error("passwords do not match");
                }
            } else if ($_POST["action"] == "changePerm") {
                Core::load("Mysql")->upd(
                    "Admin",
                    $_POST["id"],
                    array("perm" => $_POST["perm"])
                );
            } else if ($_POST["action"] == "remove") {
                Core::load("Mysql")->del("Admin", $_POST["id"]);
            } else {
                trigger_error("unknown action");
            }
        }

        return Core::inc(
            "inc/".get_class($this)."/adminView.php",
            array (
                "entries" => Core::load("Mysql")->sel("Admin"),
                "name" => get_class($this)
            )
        );
    }

    /** add user
     *
     * adds a new admin user
     *
     * \param   $user   username
     * \param   $pass   password
     * \param   $perm   permissions
     */
    public function addUser($user, $pass, $perm) {
        $salt = self::genSalt();
        $hash = self::genHash($pass, $salt);

        Core::load("Mysql")->ins(
            "Admin",
            array(
                "user" => $user,
                "hash" => $hash,
                "salt" => $salt,
                "perm" => $perm
            )
        );
    }

    /** install method
     *
     * - called upon installing
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

    /** generate hash
     *
     * generates a hash with given pass and salt
     *
     * \param   $p  password
     * \param   $s  salt
     * \return  hash
     */
    private static function genHash($p, $s) {
        return hash('sha256', $p.$s);
    }

    /** generate salt
     *
     * generates a random salt
     *
     * \return  salt
     */
    private static function genSalt() {
        mt_srand(microtime(true) * 100000 + memory_get_usage(true));
        return uniqid(mt_rand(), true);
    }
}

?>
