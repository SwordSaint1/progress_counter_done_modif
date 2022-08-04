
<?php

$dbName = "andon_database";
$conn = new PDO('mysql:host=172.25.112.171;dbname='.$dbName, 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
date_default_timezone_set('Asia/Manila');

include 'class.andon.db.php';

$db2 = new DB2($conn);


