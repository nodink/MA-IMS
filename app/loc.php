<?php

require_once '../inc/db.php';

$ucode = $uname = "";

$retsql = 'SELECT * FROM location ORDER BY loc_code ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$data[] = $row;
}

$loclist = $data;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Location</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Location</h3>
		<?php require_once '../inc/nav.php'; ?>
		<div class="w3-row">
			<div class="w3-half w3-border-right w3-mobile">
				<div id="msg" class="w3-hide"></div>
				<form action="invoicedb.php" method="post">
					<div class="w3-cell-row">
						<div class="w3-container w3-cell">
							<label>Location Code</label>
							<input type="text" id="loccode" name="loccode" class="w3-input">
						</div>
						<div class="w3-container w3-cell">
							<label>Location Name</label>
							<input type="text" id="locname" name="locname" class="w3-input">
						</div>
					</div><br>
					<div class="w3-container w3-cell">
						<input type="hidden" name="locid" id="locid">
						<input type="submit" id="locsubmit" name="locsubmit" value="Submit" />
					</div>
				</form>
			</div>
			<div class="w3-half w3-border-left w3-mobile">
				<table id="matbl" class='w3-table w3-striped w3-hoverable loctbl'>
					<thead>
						<tr>
							<th>Location Code</th>
							<th>Location Name</th>
							<th>Action</th>
						</tr>
					</thead>

					<?php
					foreach ($loclist as $list) { ?>
						<tr>
							<td><?php echo $list["loc_code"]; ?></td>
							<td><?php echo $list["loc_name"]; ?></td>
							<td>
								<input type="button" name="locedit" value="Edit" id="<?php echo $list["loc_id"]; ?>" class="w3-seablue locedit" />
								<input type="button" name="locdelete" value="Delete" id="<?php echo $list["loc_id"]; ?>" class="w3-border-red w3-red locdelete" />
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
	<script src="../lib/sdt.js"></script>
	<script type="text/javascript">
		//Shows UoM of Product selected

		const loctb = document.querySelector('.loctbl');
		const loccode = document.querySelector('#loccode');
		const locname = document.querySelector('#locname');
		const locsubmit = document.querySelector("#locsubmit");
		const lmsg = document.querySelector("#msg");


		loctb.addEventListener("click", (e) => {
			e.preventDefault();
			locsubmit.setAttribute("name", "update");
			var len = e.target.getAttribute('name');
			var param = '';
			const xhr = new XMLHttpRequest();
			const url = 'ajaxdb.php';
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			if (len == 'locedit') {
				param = 'ledit=' + e.target.id;
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var drs = JSON.parse(this.responseText);
						drs.forEach(c => {
							loccode.value = `${c.loc_code}`;
							locname.value = `${c.loc_name}`;
							locid.value = `${c.loc_id}`;
						});
						locsubmit.value = 'Update';
						//locsubmit.setAttribute("name", "update");
						//console.log(drs);
					}
				};
				//console.log(param);
				//console.log(locsubmit.getAttribute("name"));
			} else if (len == 'locdelete') {
				const conf = confirm("Are you sure you want to delete?");
				if (conf == true) {
					param = 'ldelete=' + e.target.id;
				}
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var drs = this.responseText;
						lmsg.innerHTML = drs;
						lmsg.setAttribute('class', 'w3-show');
						setTimeout(()=> lmsg.remove(), 3000);
						//console.log(drs);
					}
				};
			}
			xhr.send(param);
		});
	</script>
</body>

</html>