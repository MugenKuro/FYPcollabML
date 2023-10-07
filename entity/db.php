<?php

class Db {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "eComDB";
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            die("ERROR: Could not connect. " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("ERROR: Query failed. " . $this->connection->error);
        }
        
        if ($result === true) {
            // non-SELECT statement
            $result = $this->connection->affected_rows;

            return $result;
        } else {
            // SELECT statement
            return $result;
        }
    }

    //prevent sql injection
    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }

    public function getLastInsertedId() {
        return $this->connection->insert_id;
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function getConnectError() {
        return $this->connection->connect_error;
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }
}

?>
