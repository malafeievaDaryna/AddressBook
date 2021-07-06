<?php

require_once 'Logger.php';

class CContact {
    public string $name;
    public string $phone;
}

class CConnection {

    private const SERVERNAME = "127.0.0.1:3306";
    private const USERNAME = "root";
    private const PASSWORD = "root";
    private const DBNAME = "address-book";
    
    private const TABLE = "contacts";

    private $conn = NULL;

    function __construct() {
        Logger::getInstance()->log(__METHOD__);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->conn = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        } catch (mysqli_sql_exception $e) {
            Logger::getInstance()->log("Connection failed: " . $e->__toString());
            die();
        }
    }

    function insertContact(CContact $contact) {
        $sql = "INSERT INTO " . self::TABLE ." (NAME,PHONE)
               VALUES ('" . htmlspecialchars($contact->name) . "' , '" . htmlspecialchars($contact->phone) . "');";
        Logger::getInstance()->log(__METHOD__ . " " . $sql);
        if ($this->conn && ($this->conn->query($sql) === TRUE)) {
        } else {
            Logger::getInstance()->log("Error: " . $this->conn->error);
        }
    }
    
    function getContacts() : array {
        $arr = [];
        $sql = "SELECT ID, NAME, PHONE FROM " . self::TABLE . ";";
        Logger::getInstance()->log(__METHOD__ . " " . $sql);
        if ( $this->conn && ($result = $this->conn->query($sql))) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    Logger::getInstance()->log("id: " . $row->ID . " Name: " . $row->NAME . " PHONE " . $row->PHONE);
                    array_push($arr, $row);
                }
            } else {
                Logger::getInstance()->log("0 results");
            }
        } else {
            Logger::getInstance()->log("Error: " . $this->conn->error);
        }
        
        return $arr;
    }

    function __destruct() {
        Logger::getInstance()->log(__METHOD__ );
        if ($this->conn) {
            $this->conn->close();
        }
    }

}
?>
