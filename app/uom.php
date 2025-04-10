<?php

require_once '../inc/db.php';

$ucode = $uname = "";

$retsql = 'SELECT * FROM uom ORDER BY ucode ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$data[] = $row;
}

$ulist = $data;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Units</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>Unit of Measure</h3>
		<?php require_once '../inc/nav.php'; ?>
		<div class="w3-row">
			<div class="w3-half w3-border-right w3-mobile">
				<div id="msg" class="w3-hide"></div>
				<form action="invoicedb.php" method="post">
					<div class="w3-cell-row">
						<div class="w3-container w3-cell">
							<label>UoM Code</label>
							<input type="text" id="ucode" name="ucode" class="w3-input" autocomplete="off">
						</div>
						<div class="w3-container w3-cell">
							<label>UoM Name</label>
							<input type="text" id="uname" name="uname" class="w3-input" autocomplete="off">
						</div>
					</div><br>
					<div class="w3-container w3-cell">
						<input type="hidden" name="uomid" id="uomid">
						<input type="submit" id="usubmit" name="usubmit" value="Submit" />
					</div>
				</form>
			</div>
			<div class="w3-half w3-border-left w3-mobile">
				<table id="matbl" class='w3-table w3-striped w3-hoverable uomtbl'>
					<thead>
						<tr>
							<th>UoM Code</th>
							<th>UoM Name</th>
							<th>Action</th>
						</tr>
					</thead>

					<?php
					//$i = 1;
					foreach ($ulist as $list) { ?>
						<tr>
							<td><?php echo $list["ucode"]; ?></td>
							<td><?php echo $list["uname"]; ?></td>
							<td>
								<input type="button" name="uomedit" value="Edit" id="<?php echo $list["u_id"]; ?>" class="w3-lightblue uomedit" />
								<input type="button" name="uomdelete" value="Delete" id="<?php echo $list["u_id"]; ?>" class="w3-border-red w3-red uomdelete">
							</td>
						</tr>
					<?php } //$i++ 
					?>
				</table>
			</div>
		</div>
	</div>
	<script src="../lib/sdt.js"></script>
	<script type="text/javascript">
		//Shows UoM of Product selected

		const uomtb = document.querySelector('.uomtbl');
		const ucode = document.querySelector('#ucode');
		const uname = document.querySelector('#uname');
		const usubmit = document.querySelector("#usubmit");
		const umsg = document.querySelector("#msg");

		uomtb.addEventListener("click", (e) => {
			e.preventDefault();
			usubmit.setAttribute("name", "update");
			var uen = e.target.getAttribute('name');
			var param = '';
			const xhr = new XMLHttpRequest();
			const url = 'ajaxdb.php';
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			if (uen == 'uomedit') {
				param = 'uedit=' + e.target.id;
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var drs = JSON.parse(this.responseText);
						ucode.value = drs[0].ucode;
						uname.value = drs[0].uname;
						uomid.value = drs[0].u_id
						usubmit.value = 'Update';
						//console.log(drs);
						//console.log(drs[0].uname)
						//console.log(drs[0].ucode)
					}
				};
				//console.log(param);
				//console.log(usubmit.getAttribute("name"));
			} else if (uen == 'uomdelete') {
				const conf = confirm("Are you sure you want to delete?")
				if (conf == true) {
					param = 'udelete=' + e.target.id;
				}
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var drs = this.responseText;
						umsg.innerHTML = drs;
						setTimeout(()=> umsg.remove(), 3000);
						//umsg.setAttribute('class', 'w3-show');
						//umsg.style.hover = 'display: none';
						//umsg.setAttribute('class', 'w3-hide');
						//console.log(drs);
					}
				};
				//xhr.send(param); 
				//console.log(param);
			}

			//console.log(uen);
			xhr.send(param);
		});

		//uomed.addEventListener("click", () => {
		//e.preventDefault();
		//udid = uomed.getAttribute('id');

		// console.log(udid);
		//}); 

		/*document.addEventListener("click", function(e) {
			var uomid = e.target.id;
			
	    	console.log(uomid);
	    	//console.log(tbd);

	      let xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function () {
				if(this.readyState == 4 && this.status == 200){
					this.responseText;
					//console.log(drs);
				}
			};
			xhr.open("GET", "ajaxdb.php?uom=" + uomid, true);
			xhr.send(); 
		
	}); */
	</script>
</body>

</html>