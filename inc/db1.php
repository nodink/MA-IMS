<?php
$conn = mysqli_connect("localhost", "root", "root", "invoicedb");

if (!$conn) {
	die("Error Connecting to DB : " . mysqli_connect_error());
}