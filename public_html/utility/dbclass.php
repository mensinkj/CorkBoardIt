<?php
class DB
{
    public $DB_HOST;
    public $DB_NAME;
    public $DB_USER;
    public $DB_PASSWORD;
    public $conn;
    public $SQL;
    public $errorMsg;
    public $successMsg;

    public function displayError($stop = 1)
    {
        echo "<p><font color='#FF0000'>" . $this->errorMsg . "</font></p>";
        if ($stop == 1) {
            exit();
        }

    }

    public function dbconnect()
    {
        $this->conn = mysqli_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD);

        if (!$this->conn) {
            $this->errorMsg = "DB Connection Error...";
            $this->displayError();
        }

        $result = mysqli_select_db($this->conn, $this->DB_NAME);

        if (!$result) {
            $this->errorMsg = mysqli_errno($this->conn) . ": " . mysqli_error($this->conn);
            $this->displayError();
        }

    }

    public function __construct()
    {
        $this->errorMsg = "";
        $this->successMsg = "";

        $this->DB_HOST = DB_HOST;
        $this->DB_NAME = DB_SCHEMA;
        $this->DB_USER = DB_USER;
        $this->DB_PASSWORD = DB_PASS;

        $this->conn = null;
        $this->SQL = "";
        $this->dbconnect();
    }

    public function setQuery($query)
    {
        $this->SQL = $query;
    }

    public function select()
    {
        if ($this->SQL == "") {
            return false;
        }

        $rs = mysqli_query($this->conn, $this->SQL);
        if ($rs === false) {
            $this->SQL = "";
            $this->errorMsg = mysqli_errno($this->conn) . ": " . mysqli_error($this->conn);
            $this->displayError();
        }

        $records = array();
        while (($row = mysqli_fetch_array($rs, MYSQL_ASSOC))) {
            $records[] = $row;
        }

        $this->SQL = "";
        mysqli_free_result($rs);
        return $records;
    }

    public function update()
    {
        if ($this->SQL == "") {
            return false;
        }

        $rs = mysqli_query($this->conn, $this->SQL);
        if ($rs === false) {
            $this->SQL = "";
            $this->errorMsg = mysqli_errno($this->conn) . ": " . mysqli_error($this->conn);
            $this->displayError();
        }

        $this->SQL = "";
        return mysqli_affected_rows($this->conn);

    }

    public function execute()
    {
        if ($this->SQL == "") {
            return false;
        }

        $rs = mysqli_query($this->conn, $this->SQL);
        if ($rs === false) {
            $this->SQL = "";
            $this->errorMsg = mysqli_errno($this->conn) . ": " . mysqli_error($this->conn);
            $this->displayError();
        }

        $this->SQL = "";
        return mysqli_affected_rows($this->conn);
    }

    public function insert()
    {
        if ($this->SQL == "") {
            return false;
        }

        $rs = mysqli_query($this->conn, $this->SQL);
        if ($rs === false) {
            $this->SQL = "";
            $this->errorMsg = mysqli_errno($this->conn) . ": " . mysqli_error($this->conn);
            $this->displayError();
        }

        $this->SQL = "";
        return mysqli_insert_id($this->conn);
    }

    public function close()
    {
        $this->errorMsg = "";
        $this->successMsg = "";

        $this->DB_HOST = "";
        $this->DB_NAME = "";
        $this->DB_USER = "";
        $this->DB_PASSWORD = "";

        if ($this->conn) {
            mysqli_close($this->conn);
            $this->conn = null;
        }
        $this->SQL = "";
    }

}
