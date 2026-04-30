
<?php
session_start();
include('include/config.php');
function getPriority($text) {
    $text = strtolower($text);

    if (
        strpos($text, 'emergency') !== false ||
        strpos($text, 'urgent') !== false ||
        strpos($text, 'bleeding') !== false ||
		strpos($text, 'serious') !== false ||
        strpos($text, 'ICU') !== false ||
		strpos($text, 'life-threatning') !== false ||
        strpos($text, 'critical') !== false
    ) {
        return "High";
    }

    if (
        strpos($text, 'delay') !== false ||
        strpos($text, 'waiting') !== false ||
		strpos($text, 'issue') !== false ||
        strpos($text, 'problem') !== false ||
		strpos($text, 'not working') !== false ||
        strpos($text, 'unavailable') !== false
    ) {
        return "Medium";
    }

    return "Low";
}
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Complaints</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+500+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
<?php include('include/sidebar.php');?>				
			<div class="span9">
					<div class="content">

	<div class="module">
							<div class="module-head">
								<h3>Complaints</h3>
							</div>
							<div class="module-body table">


							
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" >
									<thead>
										<tr>
											<th>Complaint No</th>
											<th>Complaint </th>
											<th>Priority</th>
											<th>Reg Date</th>
											<th>Status</th>
											
											<th>Action</th>
											
										
										</tr>
									</thead>
								
<tbody>
<?php 
$query=mysqli_query($bd, "select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.status is null ");
while($row=mysqli_fetch_array($query))
{
?>										
										<tr style="<?php if(getPriority($row['complaintDetails'])=='High') echo 'background-color:#ffe6e6;'; ?>">
    
    <td><?php echo htmlentities($row['complaintNumber']);?></td>
    
    <td><?php echo htmlentities($row['noc']);?></td>

    <!-- ✅ PRIORITY IN CORRECT POSITION -->
    <td>
    <?php 
    $priority = getPriority($row['complaintDetails']);

    if($priority == "High") {
        echo "<span style='color:red; font-weight:bold;'>🔴 High</span>";
    } elseif($priority == "Medium") {
        echo "<span style='color:orange;'>🟡 Medium</span>";
    } else {
        echo "<span style='color:green;'>🟢 Low</span>";
    }
    ?>
    </td>

    <!-- ✅ NOW REG DATE -->
    <td><?php echo htmlentities($row['regDate']);?></td>

    <td><button type="button" class="btn btn-danger">Not process yet</button></td>

    <td>
        <a href="complaint-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>">
            View Details
        </a>
    </td>

</tr>

										<?php  } ?>
										</tbody>
								</table>
							</div>
						</div>						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>