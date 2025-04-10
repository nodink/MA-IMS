<?php

require_once '../inc/db.php';

// $conn = mysqli_connect("localhost:3318", "root", "root", "invoicedb");

// if (!$conn) {
// 	die("Error Connecting to DB : " . mysqli_connect_error());
// }


$sqlbal = 'SELECT DISTINCT p.iname, p.icat,
				SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
				SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
				SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty
				FROM vhrdetails as d 
			    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
			    INNER JOIN products as p ON p.i_id = i.vhritem_product
			    GROUP BY p.iname, p.icat';


$rmrs = mysqli_query($conn, $sqlbal);
if (!$rmrs) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_assoc($rmrs)) {
	$data[] = $row;
	//$product = $row['iname'];           
}
//$totalrm = $qty;

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>My Home Page</h3>
		<?php require_once '../inc/nav.php'; ?>
		<div class="w3-row">
			<div class="w3-third w3-mobile">
				<div class="w3-card-2 w3-margin" style="width:95%">
					<header class="w3-container w3-light-grey">
						<h3><b>Raw Materials</b></h3>
					</header>
					<div class="w3-container">
						<p>In Stock</p>
						<hr>
						<div id="rmis" style="height:127px; font-size:14px;">
							<div>
								<?php foreach ($data as $rmlist) {
									if ($rmlist['icat'] == "Raw Material") {
								?>
										<span><a href="prodtrans.php?item=<?= $rmlist["iname"] ?>" class="w3-link"><?php echo $rmlist['iname']; ?></a></span>
										<span class="w3-right"><?php echo $rmlist['rnqty'] - ($rmlist['tnqty'] + $rmlist['dnqty']); ?></span><br>
								<?php }
								} ?>
							</div>
						</div>
					</div>
					<button class="w3-button w3-block w3-dark-grey"><a href="rmlist.php?group=Raw Material" style="text-decoration:none;">+ Connect</a></button>
				</div>
			</div>
			<div class="w3-third w3-mobile">
				<div class="w3-card-4 w3-margin" style="width:95%">
					<header class="w3-container w3-light-grey">
						<h3><b>Packing Materials</b></h3>
					</header>
					<div class="w3-container">
						<p>In Stock</p>
						<hr>
						<div id="pkmis" style="height:127px; font-size:14px;">
							<?php foreach ($data as $pklist) {
								if ($pklist['icat'] == "Packaging Materials") {
							?>
									<span><a href="prodtrans.php?item=<?= $pklist["iname"] ?>" class="w3-link"><?php echo $pklist['iname']; ?></a></span>
									<span class="w3-right"><?php echo $pklist['rnqty'] - ($pklist['tnqty'] + $pklist['dnqty']); ?></span><br>
							<?php }
							} ?>
						</div>
					</div>
					<button class="w3-button w3-block w3-dark-grey"><a href="rmlist.php?group=Packaging Materials" style="text-decoration:none;">+ Connect</a></button>
				</div>
			</div>
			<div class="w3-third w3-mobile">
				<div class="w3-card-4 w3-margin" style="width:95%">
					<header class="w3-container w3-light-grey">
						<h3><b>Finished Goods</b></h3>
					</header>
					<div class="w3-container">
						<p>In Stock</p>
						<hr>
						<div id="fgis" style="height:127px;font-size:14px;">
							<?php foreach ($data as $fglist) {
								if ($fglist['icat'] == "Finished Goods") {
							?>
									<span><a href="prodtrans.php?item=<?= $fglist["iname"] ?>" class="w3-link"><?php echo $fglist['iname']; ?></a></span>
									<span class="w3-right"><?php echo $fglist['rnqty'] - ($fglist['tnqty'] + $fglist['dnqty']); ?></span><br>
							<?php }
							} ?>
						</div>
					</div>
					<button class="w3-button w3-block w3-dark-grey"><a href="rmlist.php?group=Finished Goods" style="text-decoration:none;">+ Connect</a></button>
				</div>
			</div>
		</div>

		<!-- <div class="w3-card-4 w3-margin" style="width:50%">
			<div class="w3-display-container w3-text-white">
				<div class="w3-container w3-teal" style="width:100%; height: 80px;"> </div>
				<div class="w3-xlarge w3-display-bottomleft w3-padding">LONDON 60&deg; F</div>
			</div>
			<div class="w3-row">
				<div class="w3-third w3-center">
					<h3>MON</h3>
					<div class="w3-blue" style="width:80%; height:50px;"> </div>
				</div>
				<div class="w3-third w3-center w3-padding">
					<h3>TUE</h3>
					<div class="w3-green" style="width:80%; height:50px;"> </div>
				</div>
				<div class="w3-third w3-center w3-margin-bottom">
					<h3>WED</h3>
					<div class="w3-yellow" style="width:80%; height:50px;"> </div>
				</div>
			</div>
		</div>

		<div class="w3-container w3-center w3-yellow w3-margin" style="width:40%;">
			this is a container
			<div class="w3-row">
				<div class="w3-third w3-center">
					<div class="w3-center w3-red" style="width:90%; height:50px;">Inside</div>
				</div>
				<div class="w3-third w3-center">
					<div class="w3-center w3-red" style="width:90%; height:50px;">Inside</div>
				</div>
				<div class="w3-third w3-center">
					<div class="w3-center w3-red w3-margin-bottom" style="width:90%; height:50px;">Inside</div>
				</div>
			</div>
		</div>
 -->
	</div>


</body>

</html>