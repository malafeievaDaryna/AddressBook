<?php

require_once 'CConnection.php';

$conn = new CConnection();
$arr = $conn->getContacts();

$obj = new CContact();
$obj->name = 'Alex';
$obj->phone = '068254543';

//$conn->insertContact($obj);

echo json_encode($arr);
