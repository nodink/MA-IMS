<?php require_once '../config/init.php';?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY APP - <?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="../lib/myapp.css">
    <link rel="stylesheet" type="text/css" href="../lib/w3s.css">
</head>

<body>

    <ul class="sidenav">
        <li><a href="../dashboard.php">Home</a></li>
        <li><a href="../stock/masters.php">Inventory Info</a></li>
        <li><a href="#news">News</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#about">About</a></li>
    </ul>

    <div class="content">
        <div class="w3-bar">
            <span class="w3-bar-item w3-right">
                Welcome <strong><?php echo $_SESSION['username']; ?></strong></span>
            <a class="w3-bar-item w3-right w3-button w3-hover-none w3-border-white w3-bottombar w3-hover-border-black" href="../logout.php?logout='1'" style="color: red;">Logout</a>
        </div>