<?php
$db = new mysqli("localhost","root","","products_system");
if ($db -> connect_errno) {
  echo "Failed to connect to MySQL: " . $db -> connect_error;
  exit();
}
?>