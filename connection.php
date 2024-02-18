<?php
class Connection {
    public $conn;

    public function __construct($server, $user, $password) {
        $this->conn = new mysqli($server, $user, $password);

        if ($this->conn->connect_error) {
            echo '<script>alert("Connection failed: ' . $this->conn->connect_error . '")</script>';
        }
    }

    public function createDB($db) {
        $create = "CREATE DATABASE IF NOT EXISTS $db";
        if ($this->conn->query($create) === TRUE) {
            echo '<script>alert("Database created successfully)</script>"';
        } else {
            echo "Error creating database: " . $this->conn->error;
        }
    }

    public function selectDB($db) {
        if ($this->conn->select_db($db)) {
            echo '<script>alert("Database selected successfully")</script>';
        } else {
            echo '<script>alert("Error selecting database: ' . $this->conn->error . '")</script>';
        }
    }

    public function createTable($table, $columns) {
        $query = "CREATE TABLE IF NOT EXISTS $table ($columns)";
        if ($this->conn->query($query) === TRUE) {
            echo '<script>alert("Table created successfully<br>")</script>';
        } else {
            echo '<script>alert("Error creating table: ' . $this->conn->error . '")</script>';
        }
    }

    public function listDatabases() {
        $query = "SHOW DATABASES";

        $result = $this->conn->query($query);

        if ($result === FALSE) {
            // $this->lastError = "Error listing databases: " . $this->conn->error;
            return FALSE;
        } else {
            return $result;
        }
    }
    
    public function selectTable($table, $db) {
        $this->conn->select_db($db);

        $query = "SELECT * FROM $table";
        $result = $this->conn->query($query);

        if ($result === FALSE) {
            echo '<script>alert("Error retrieving data: ' . $this->conn->error . '")</script>';
            return FALSE; // Return FALSE to indicate an error
        }

        return $result;
    }

    public function deleteDB($db) {
        // Check if the database exists
        $checkQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db'";
        $existsResult = $this->conn->query($checkQuery);
    
        if ($existsResult !== FALSE && $existsResult->num_rows > 0) {
            // Database exists, proceed with deletion
            $deleteQuery = "DROP DATABASE $db";
            $result = $this->conn->query($deleteQuery);
    
            if ($result === FALSE) {
                echo '<script>alert("Error deleting database: ' . $this->conn->error . '")</script>';
                return false;
            } else {
                echo '<script>alert("Database deleted successfully")</script>';
                return true;
            }
        } else {
            echo '<script>alert("Error: Database \'' . $db . '\' does not exist")</script>';
            return false;
        }
    } 
    
    public function deletetable($table){
        $delete = "DROP TABLE IF EXISTS $table";
        $result = $this->conn->query($delete);

        if($result === FALSE){
            echo '<script>alert("Error delete table: ' . $this->conn->error . '")</script>';
        }

        return $result;
    }

    public function getLastError() {
        return $this->conn->error;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>

