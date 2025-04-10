function O(i) {
	return typeof(i) == 'object' ? i : document.getElementById(i)
}

function S(i) {
	return O(i).style
}

function C(i) {
	return document.getElementsByClassName(i)
}

function T(i) {
	return document.getElementsByTagName(i)
}


function deleteRow(tableID){
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount > '2'){
		var conf = confirm("Are you sure you want to delete?");
		console.log(conf);
	  if(conf === true) {
	  	console.log(conf);
		var row = table.deleteRow(rowCount-1);
		rowCount--;
	  }
	} else {
		alert('There should be at least one row');
	}
}

function addRow(tableID){
    var table=O(tableID);
	var rowCount=table.rows.length;
	var row=table.insertRow(rowCount);
	var colCount=table.rows[0].cells.length;
	        	//var cell1=row.insertCell(0);
	        	//cell1.innerHTML= rowCount;
	if(row) {
	for(var i=0;i<colCount;i++){
      	var newcell=row.insertCell(i);
		newcell.innerHTML=table.rows[1].cells[i].innerHTML;
		if(newcell.getAttribute('id')){
			var str = newcell.getAttribute('id');
			var id = str.replace("_1", "");
			var new_id = id+"_"+rowCount;
			newcell.setAttribute('id',new_id);
		}
	if(newcell.children[0]){
		if(newcell.children[0].getAttribute('id')){
			var str = newcell.children[0].getAttribute('id');
			var id = str.replace("_1", "");
			var new_id = id+"_"+rowCount;
			newcell.children[0].setAttribute('id',new_id);
		}
	}
	}}
}


/*
function showDiv(divId1, divId2, element) {
    let div1 = document.getElementById(divId1).style;
    let div2 = document.getElementById(divId2).style;

    switch(element.value) {
    	case 'rn':
    	 div1.display = 'block';
    	 div2.display = 'none';
    	 break;
    	case 'dn':
    	 div2.display = 'block';
    	 div1.display = 'none';
    	 break;
    	default:
    	 div1.display = 'none';
    	 div2.display = 'none';
    }
}

function getUoM(el){
	//let inp = document.getElementById(inpId);
	//let inp1 = document.querySelectorAll()
	let td = el.target.nextElementSibling.id;
	//let inp1 = td.id;
	//let isel = el.value;

	//console.log(isel);
	console.log(td);
	//console.log(inp1);
	if(isel != "") {
		let xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if(this.readyState == 4 && this.status == 200){
				//inp1.value = this.responseText;
			}
		};
		xhr.open("GET", "invoicedb.php?q=" + isel, true);
		xhr.send();
	}
} */