<?php
$conn = mysqli_connect("localhost", "root", "", "madevdb");

if (!$conn) {
	die("Error Connecting to DB : " . mysqli_connect_error());
}