<?php

require_once 'Logger.php';

class CContact {
    public int $id;
    public string $name;
    public string $phone;
    
    function __construct(string $name, string $phone, int $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
    }
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
    
    private function executeQuery(string $sql) {
        $res = $this->conn->query($sql);
        if (!$res) {
            Logger::getInstance()->log("Error: " . $this->conn->error );
        }
        
        return $res;
    }

    function insertOrUpdateContact(CContact $contact) {
        // first check whether such contact already present
        $sql = "SELECT * FROM " . self::TABLE . " WHERE NAME = '" . $contact->name ."';";
        Logger::getInstance()->log(__METHOD__ . " " . $sql);
        if ( $result = $this->executeQuery($sql) ) {
            // already present then we'll update
            if ($result->num_rows > 0) {
                $row = $result->fetch_object();
                $sql = "UPDATE " . self::TABLE . " SET PHONE = '" . htmlspecialchars($contact->phone) . 
                        "' WHERE ID = $row->ID;";
                Logger::getInstance()->log(__METHOD__ . " " . $sql);
                $this->executeQuery($sql);
            }
            else {
                $sql = "INSERT INTO " . self::TABLE . " (NAME,PHONE)
                        VALUES ('" . htmlspecialchars($contact->name) . "' , '" . htmlspecialchars($contact->phone) . "');";
                Logger::getInstance()->log(__METHOD__ . " " . $sql);
                $this->executeQuery($sql);
            }
        }
    }
    
    function deleteContact(int $id) {
        $sql = "DELETE FROM " . self::TABLE ." WHERE ID = $id;";
        Logger::getInstance()->log(__METHOD__ . " " . $sql);
        $this->executeQuery($sql);
    }
    
    function getContacts() : array {
        $arr = [];
        $sql = "SELECT ID, NAME, PHONE FROM " . self::TABLE . ";";
        Logger::getInstance()->log(__METHOD__ . " " . $sql);
        if ($result = $this->executeQuery($sql)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    Logger::getInstance()->log("id: " . $row->ID . " Name: " . $row->NAME . " PHONE " . $row->PHONE);
                    array_push($arr, $row);
                }
            } else {
                Logger::getInstance()->log("0 results");
            }
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
