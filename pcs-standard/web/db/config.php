
<?php

$dbName = "pcs_db";
$conn = new PDO('mysql:host=172.25.112.171;dbname='.$dbName, 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
date_default_timezone_set('Asia/Manila');

include 'class.db.php';

$db = new DB($conn);


