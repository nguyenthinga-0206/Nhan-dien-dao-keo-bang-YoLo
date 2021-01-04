
<html>
<head>
<style>
.header h2 {
  font-size: 50px;
  text-align: LEFT;
}
.leftrow {   
  float: left;
  width: 80%; 
  height: 10%
}

/*Right column */
.rightrow {
  float: right;
  width: 10%;
  height: 10%;
  /* background-color: #f1f1f1; */
  /* padding-left: 20px;
} */

.card {
  background-color: white;
  /* padding: 1px; */
  margin-top: 5px;
  text-align: left; 
}
</style>
</head>
</html>
<?php 
	$conn = mysqli_connect("localhost", "root", "root", "do_an");
	
	$Time = "";
	$Time_to_date = "";
	
	$queryCondition = "";
	if(!empty($_POST["search"]["Time"])) {			
		$Time = $_POST["search"]["Time"];
		list($fid,$fim,$fiy) = explode("-",$Time);
		
		$Time_todate = date('Y-m-d');
		if(!empty($_POST["search"]["Time_to_date"])) {
			$Time_to_date = $_POST["search"]["Time_to_date"];
			list($tid,$tim,$tiy) = explode("-",$_POST["search"]["Time_to_date"]);
			$Time_todate = "$tiy-$tim-$tid";
		}
		
		$queryCondition .= "WHERE Time BETWEEN '$fiy-$fim-$fid' AND '" . $Time_todate . "'";
	}

	$sql = "SELECT ID,Url,Time from image " . $queryCondition . " ORDER BY ID desc";
	$result = mysqli_query($conn,$sql);
?>

<html>
	<head>
	<div class="row">
    <div class="card">
		<div class ="rightrow">
    
	  <p style="font-family: Bold; font-size:20px" ><a href="index.php">Home</a></p> 
    </div>
	<div class ="leftrow">
	<h1> Lịch sử </h1>
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	</div>
	</div>
  </div>
  
    
	<style>
	.table-content{border-top:#CCCCCC 10px solid; width:100%;}
	.table-content th {padding:15px 30px; background: #F0F0F0; vertical-align:top;} 
	.table-content td {padding:10px 30px; border-bottom: #F0F0F0 1px solid;vertical-align:top;} 
	</style>
	</head>
	
	<body>
    <div class="demo-content">
  <form name="frmSearch" method="post" action="">
	 <p class="search_input">
		<input type="text" placeholder="From Date" id="Time" name="search[Time]"  value="<?php echo $Time; ?>" class="input-control" />
	    <input type="text" placeholder="To Date" id="Time_to_date" name="search[Time_to_date]" style="margin-left:10px"  value="<?php echo $Time_to_date; ?>" class="input-control"  />			 
		</br>
        </br>
        <input type="submit" name="go" value="Search" >
	</p>
<?php if(!empty($result))	 { ?>
<table class="table-content">
          <thead>
        <tr>
                      
          <th width="15%"><span>ID</span></th>       
		  <th width="70%"><span>Url</span></th>   
          <th width="15%"><span>Post Date</span></th>	  
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr>
		    <td><?php echo $row["ID"]; ?></td>
			<td><img src="<?php echo $row['Url'];?>" height="100%" width="100%"></td>
			<td><?php echo $row["Time"]; ?></td>

		</tr>
   <?php
		}
   ?>
   <tbody>
  </table>
<?php } ?>
  </form>
  </div>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$.datepicker.setDefaults({
showOn: "button",
buttonText: "  Chọn  ",
dateFormat: 'dd-mm-yy'  
});
$(function() {
$("#Time").datepicker();
$("#Time_to_date").datepicker();
});
</script>
</body></html>
