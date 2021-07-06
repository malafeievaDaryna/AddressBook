<?php

require_once 'CConnection.php';

$conn = new CConnection();

$obj = new CContact();
$obj->name = 'Alex';
$obj->phone = '068254543';

echo json_encode($obj);
