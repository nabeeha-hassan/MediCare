<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0){ 
    header('location:index.php');
} else { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User| Dashboard</title>

<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/style-responsive.css" rel="stylesheet">

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<style>
html, body { height: 100%; }
#container { min-height: 100%; display: flex; flex-direction: column; }
#main-content { flex: 1; }
footer, .footer { margin-top: auto; }

.card-box {
    background: #0d6efd;
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
}

.notification-box {
    background: #fff3cd;
    padding: 10px;
    border-left: 5px solid #ffc107;
    margin-bottom: 15px;
}

.booking-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.reminder-box {
    background:#e3f2fd;
    padding:20px;
    border-radius:10px;
    border-left:6px solid #0d6efd;
    margin-top:20px;
}
</style>
</head>

<body>

<section id="container">
<?php include("includes/header.php");?>
<?php include("includes/sidebar.php");?>

<section id="main-content">
<section class="wrapper">

<h3>Welcome Back, <?php echo $_SESSION['login']; ?> 👋</h3>

<div style="margin-bottom:15px;">
    <a href="register-complaint.php" class="btn btn-primary">+ New Complaint</a>
    <a href="complaint-history.php" class="btn btn-info">View Complaints</a>
</div>

<?php
$uid = $_SESSION['id'];

/* ================= DATA ================= */
$num1 = mysqli_num_rows(mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE userId='$uid' AND status IS NULL"));
$num2 = mysqli_num_rows(mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE userId='$uid' AND status='in Process'"));
$num3 = mysqli_num_rows(mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE userId='$uid' AND status='closed'"));
$total = mysqli_num_rows(mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE userId='$uid'"));

/* ================= BOOKING INSERT ================= */
if(isset($_POST['book'])){
    $treatment = $_POST['treatment'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    mysqli_query($bd, "INSERT INTO tblbookings(userId, treatment, bookingDate, bookingTime) 
    VALUES('$uid','$treatment','$date','$time')");
}
?>

<!-- Notification -->
<div class="notification-box">
    You have <?php echo $num1; ?> pending complaints.
</div>

<!-- CARDS -->
<div class="row">
    <div class="col-md-3"><div class="card-box"><h3><?php echo $num1; ?></h3><p>Not Processed</p></div></div>
    <div class="col-md-3"><div class="card-box"><h3><?php echo $num2; ?></h3><p>In Process</p></div></div>
    <div class="col-md-3"><div class="card-box"><h3><?php echo $num3; ?></h3><p>Closed</p></div></div>
    <div class="col-md-3"><div class="card-box"><h3><?php echo $total; ?></h3><p>Total</p></div></div>
</div>

<!-- TABLE + BOOKING -->
<div class="row">

<!-- LEFT: TABLE -->
<div class="col-md-8">
<h4>Recent Complaints</h4>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Complaint</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>

<tbody>
<?php
$query = mysqli_query($bd, "
SELECT tblcomplaints.*, category.categoryName 
FROM tblcomplaints 
JOIN category ON category.id = tblcomplaints.category 
WHERE tblcomplaints.userId='$uid' 
ORDER BY tblcomplaints.regDate DESC 
LIMIT 5
");
while($row = mysqli_fetch_array($query)){
?>
<tr>
<td><?php echo $row['complaintNumber']; ?></td>
<td><?php echo $row['categoryName']; ?></td>
<td>
<?php 
$status = $row['status'];
if($status=="closed"){
    echo "<span class='label label-success'>Closed</span>";
}elseif($status=="in Process"){
    echo "<span class='label label-warning'>In Process</span>";
}else{
    echo "<span class='label label-danger'>Not Processed</span>";
}
?>
</td>
<td><?php echo $row['regDate']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<!-- RIGHT: BOOKING -->
<div class="col-md-4">
<div class="booking-box">
<h4>Book Beauty Treatment 💆‍♀️</h4>

<form method="post">
    <div class="form-group">
        <label>Treatment</label>
        <select class="form-control" name="treatment">
            <option>Facial</option>
            <option>Hair Spa</option>
            <option>Manicure</option>
            <option>Pedicure</option>
            <option>Skin Treatment</option>
        </select>
    </div>

    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Time</label>
        <input type="time" name="time" class="form-control" required>
    </div>

    <button type="submit" name="book" class="btn btn-success btn-block">
        Book Now
    </button>
</form>

</div>
</div>

</div>

<!-- REMINDER CARD -->
<?php
$today = date('Y-m-d');

$upcoming = mysqli_query($bd, "
SELECT * FROM tblbookings 
WHERE userId='$uid' 
AND bookingDate >= '$today'
ORDER BY bookingDate ASC, bookingTime ASC 
LIMIT 1
");

$data = mysqli_fetch_array($upcoming);

if($data){
?>

<div class="reminder-box">
    <h4>Upcoming Treatment Reminder 💡</h4>
    <p><b>Treatment:</b> <?php echo $data['treatment']; ?></p>
    <p><b>Date:</b> <?php echo $data['bookingDate']; ?></p>
    <p><b>Time:</b> <?php echo $data['bookingTime']; ?></p>
</div>

<?php } else { ?>

<div class="reminder-box" style="background:#f8f9fa;">
    <h4>No Upcoming Treatments</h4>
    <p>You haven’t booked any treatments yet.</p>
</div>

<?php } ?>

</section>
</section>

<?php include("includes/footer.php");?>
</section>

</body>
</html>

<?php } ?>