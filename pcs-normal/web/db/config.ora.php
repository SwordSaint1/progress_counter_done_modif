
<?php
header("Content-type: text/html;charset=Shift-JIS");
$username = "IRCS";
$password = "IRCS";
$database = "172.25.116.61:1521/FSIB";
$conn3 = oci_connect($username, $password, $database);
if (!$conn3) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}