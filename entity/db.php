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
    /////////////// original code /////////////// 
    // public function query($sql) {
    //     $result = $this->connection->query($sql);
    //     if (!$result) {
    //         die("ERROR: Query failed. " . $this->connection->error);
    //     }
        
    //     if ($result === true) {
    //         // non-SELECT statement
    //         $result = $this->connection->affected_rows;

    //         return $result;
    //     } else {
    //         // SELECT statement
    //         return $result;
    //     }
    // }

    // new function to be able handle sql statements with placeholders
    public function query($sql, $params = []) {
        // If parameters are provided, use prepared statements
        if (!empty($params)) {
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                die("ERROR: Preparing failed. " . $this->connection->error);
            }
    
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    
            $executed = $stmt->execute();
            if (!$executed) {
                die("ERROR: Execution failed. " . $stmt->error);
            }
    
            // For SELECT statements
            if ($result = $stmt->get_result()) {
                return $result;
            } else {
                // For non-SELECT statements
                return $stmt->affected_rows;
            }
        } else {
            // Original code for non-prepared statements
            $result = $this->connection->query($sql);
            if (!$result) {
                die("ERROR: Query failed. " . $this->connection->error);
            }
            
            if ($result === true) {
                // non-SELECT statement
                return $this->connection->affected_rows;
            } else {
                // SELECT statement
                return $result;
            }
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

    public function begin_transaction() {
        return $this->connection->begin_transaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollback() {
        return $this->connection->rollback();
    }
    
    public function end_transaction() {
        // You can use the same method as commit to end a transaction
        return $this->commit();
    }
}

?>
