<?php

class Db {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $connection;
    private $ssl;

    public function __construct() {
        $this->servername = "icloth.mysql.database.azure.com";
        $this->username = "iclothfyp";
        $this->password = "Fyp123!@#";
        $this->dbname = "eComDB";
        $this->ssl = dirname(__FILE__) . '/../SSL_cert/DigiCertGlobalRootCA.crt.pem';
        $this->connect();
    }

    private function connect() {
        // Initialize mysqli
        $this->connection = mysqli_init();
        
        // Set SSL options
        mysqli_ssl_set($this->connection, NULL, NULL, $this->ssl, NULL, NULL);
        
        // Real connect using SSL
        if (!$this->connection->real_connect($this->servername, $this->username, $this->password, $this->dbname, 3306, NULL, MYSQLI_CLIENT_SSL)) {
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
        // return $this->connection->prepare($sql);
        $stmt = $this->connection->prepare($sql);

        if ($params) {
            foreach ($params as $key => $value) {
                $stmt->bindParam(":$key", $params[$key]);
            }
        }
    }
}

?>
