<?php

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
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->conn = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        } catch (mysqli_sql_exception $e) {
            die("Connection failed: " . $e->__toString());
        }
    }

    function insert(string $name, string $phone) {
        $sql = "INSERT INTO" . self::TABLE ."(NAME,PHONE)
               VALUES ('" . htmlspecialchars($name) . "' , '" . htmlspecialchars($phone) . "');";

        if ($conn && ($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    function __destruct() {
        if ($conn) {
            $conn->close();
        }
    }

}
?>
