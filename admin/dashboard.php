<?php
include_once 'fucadmin.php';

if (!isAdmin()) {
    $_SESSION['message'] = "You must log in first";
    header('location: ../login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ../login.php");
}

// get all topics from DB
function getAllMonths()
{
    global $db;
    $sql = "SELECT * FROM months";
    $result = mysqli_query($db, $sql);
    $months = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $months;
}

$months = getAllMonths();

?>
<?php include 'filesLogic.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Διαχείριση Intra-net</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/public_styling.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
body {
  font-family: "Lato", sans-serif;
  background-color:#eee;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 22px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 15px;
  font-size: 30px;
  margin-left: 50px;
}

h1{
	color:  grey;
	font: normal 36px 'Cookie', cursive;
	margin: 0;
    position: center;
    font-style: normal;
    font-variant-ligatures: normal;
    font-variant-caps: normal;
    font-variant-numeric: normal;
    font-variant-east-asian: normal;
    font-weight: normal;
    font-stretch: normal;
    font-size: 36px;
    line-height: normal;
    font-family: 'Cookie', cursive;
}

h1 span{
	color:  #5383d3;
}
h1{
    display: block;
    padding: 0;

        }

#main {
  transition: margin-left .5s;

}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
	li a{
		float:left;
	}
}

.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
  border: none;
  border-radius: 5px;
  margin-top:10px;
}

.active, .accordion:hover {
  background-color: #ccc;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;

}

.active:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}

.card-body {
    border-radius: .25rem;
}
.card-body{
    flex: 1 1 auto;
    padding: 1.25rem;
    }

	form {
  width: 100%;

}
input {
  width: 100%;
  border: 1px solid #f1e1e1;
  display: block;
  padding: 5px 10px;
  text-overflow: clip;
  overflow: hidden;
  font-family: 'Quicksand', sans-serif;
}

#drop_file_zone {
    background-color: #EEE;
    border: #999 4px dashed;
    width: 100;
    height: 300px;
    padding: 8px;
    font-size: 18px;
	font-family: 'Quicksand', sans-serif;
}
#drag_upload_file {
  width:100%;
  margin:0 auto;
}
#drag_upload_file p {
  text-align: center;
}
</style>
</head>
<body>
<div class="col-sm-12">
<div class="card" style="background-color: #FFFFFF;">
     <div class="card-body">
<div id="main">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()" id="menuspan">&#9776;</span>
    </div>
    </div>

    <div class="title" style="text-align:center;">
		<a href="dashboard.php" style="text-decoration:none;">
			<h1 style="text-align:center;font-size:70px;">Intra-<span>net</span></h1></a>
    </div>

    </div></div>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="dashboard.php">
    <?php if (isset($_SESSION['user'])): ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<br>
						<a href='logout.php'>Αποσύνδεση</a>
					</small>


				<?php endif?></a>
  <a href="dashboard.php">Αρχική</a>
  <a href="tableusers.php">Διαχείριση Χρηστών</a>
  <a href="adminposts.php">Διαχείριση Blog</a>
  <a href="adminquiz.php">Διαχείριση Quiz</a>

    </div>
	<div class="container-fluid">
        <div class="row">
    <div class="col-sm-8" style="margin-top:20px;">
    <div class="card">
        <div class="card-header" style="background-color:#5383d3; color:white;">
        Περιεχόμενο Σεμιναρίων
        </div>

      <div class="card-body">
		  <div style="text-align:center;">
		   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" style="margin-top:20px;margin-bottom:10px;outline:none;"><img src="upload.png">
  Upload files
</button>
			  </div>
    <button class="accordion">Ιανουάριος</button>
<div class="panel">

	<div>
  <p>Καλωσορίσατε στο διαδικτυακό πρόγραμμα Διαταραχής Ακουστικής Επεξεργασίας.</p><p>Παρακάτω θα βρείτε τα αρχεία τα οποία θα χρειαστεί να χρησιμοποιήσετε για την διεκπεραίωση των υποχρεώσεων σας τον Ιανουάριο. Το online μάθημα μπορείτε να το βρείτε <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EWb6mdUZcw9KqL95WG5TECkB7kheA15nies7zihNwO-s5Q" style="text-decoration;none" target="_blank">εδώ</a> και η διάρκεια του είναι 2 ώρες και 27 λεπτά. Οι πληροφορίες που σας δίνονται στο μάθημα σας είναι απαραίτητες για την ορθή χρήση δοκιμασιών και προτείνεται η παρακολούθηση του πριν οποιαδήποτε εργασία και τεστ.</p>
  <p>Τα αρχεία έχουν κατηγοριοποιηθεί με τον εξής τρόπο : Τα πρώτα τέσσερα αναφέρονται σε γενικές βασικές γνώσεις. Τα επόμενα 4 σχετίζονται με την Ομιλητική ακουομετρία σε ησυχία ενώ στην συνέχεια ακολουθούν 5 αρχεία για την Ομιλητική ακουομετρία σε θόρυβο,τελειώνοντας με 6 αρχεία για την Μνήμη αριθμών.</p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='1'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Φεβρουάριος</button>
<div class="panel">
	<div>
	    <br><br>
  <p>Την διάλεξη του Φεβρουαρίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EfkuSGQgzqFPmZlJIaYJftkB2CiqpY4OI6TQIdOpfwjv8Q?e=Lg3IN8" target="_blank">σύνδεσμο</a>.</p><p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Φεβρουάριο.</p><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='2'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
			    <li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Μάρτιος</button>
<div class="panel">
	<div>
 <br><br> <p>Την διάλεξη του Μαρτίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EW-8O8rKzwFLiKWrUKJSi6ABbWx5Lw42QF4WlH7SzlLIkw?e=fXb7dn" target="_blank">σύνδεσμο</a>.</p><p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Μάρτιο.</p><br><br>

		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='4'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
			    <li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>

</div>
    <button class="accordion">Απρίλιος</button>
<div class="panel">
	<div>
  <br><br><p>Η διαλεξη του Απριλιου <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EYc4iCd5fPBCu15lMxszKW0BMxjh2F3VspKcpiSQ6bYfUQ?e=5cbwfH" target="_blank">εδω</a>.</p><br><br><br>

		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='5'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
				<ul>
			    <li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Μάϊος</button>
<div class="panel">
	<div>
  <br><br> <p>Την διάλεξη του μήνα Μαΐου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EfdyGZXd1DVEl6xexGqQwXIBRbuiq22LC84GWGVxm5eZSg?e=APydDM" target="_blank">σύνδεσμο</a>.</p><p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Μάιο.</p><br><br>

			<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='6'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
			    <li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>


<button class="accordion">Ιούνιος</button>
<div class="panel">
	<div>
    <br><br> <p>Την διάλεξη του μήνα Ιουνίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://www.dropbox.com/scl/fi/9cljgthlvh3rjv6uf8n1o/6.m4v?dl=0&oref=e&r=ABZOMhhDVRbIUu_fkWp5KRpTyUd-4_iiVM9jAqQcIy-hHZNMzqTPi6fGgvCik7P0nS0kDQnbcD40jcrt4qVL_8AnU6iM3W4YD_yWmsSgCu1CyVa8ATeS3GbGsC1hkopooMFJMNNit57Ri7P_PELETQFJNBf_lXUGxWfk8a5IhTIa5zH4ntNCyZng2BzL1iwVQA0&sm=1" target="_blank">σύνδεσμο</a>.</p><p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Ιουνίου.</p><br><br>

		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='7'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
				<ul>
			    <li><a href="dashboard.php?delete-file=<?php echo $com['id'] ?>" data-id="<?php echo $com['id']; ?>" id="delete-file" name="delete-file" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a> <?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>
    <button class="accordion">Ιούλιος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='8'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Αύγουστος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='9'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Σεπτέμβριος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='10'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>
    <button class="accordion">Οκτώβριος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='11'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Νοέμβριος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='12'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>

<button class="accordion">Δεκέμβριος</button>
<div class="panel">
	<div>
  <p></p><br><br><br>
		<div class="container-fluid">
			<?php
$com_query = "SELECT * FROM files WHERE month='13'";
$coms_results = mysqli_query($db, $com_query) or die("error");
if (mysqli_num_rows($coms_results) > 0) {
    while ($com = mysqli_fetch_assoc($coms_results)) {?>
			<ul>
	<li><?php echo $com['name']; ?><a href="dashboard.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
	</ul>
		<?php	}}?>
</div>


		</div>
</div>
</div>
</div>
</div>


			<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color:black">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<form action="dashboard.php" method="post" enctype="multipart/form-data" id="upload_form">
      <div class="modal-body">

			<?php include ROOT_PATH . '/errors.php'?>

  <div class="form-group">
	 <div class="container" id="drop_file_zone">
       <div class="row" id="drag_upload_file">

            <h3 style="text-align:center">Upload File&nbsp;&nbsp;</h3>
			<p><i class="fa fa-upload" aria-hidden="true" style="font-size:30px;"></i></p>

			<p class="container"><input type="file" name="selectfile" id="selectfile"></p> <br>

      </div>
    </div>
</div>

			<div class="form-group">
				<label style="color:grey">Μήνας</label>

				<select name="months" id="months" style="text-align:center;"  style="border-radius: 5px;">
				<option value="" selected disabled>--Επιλογή--</option>
					<?php foreach ($months as $month): ?>
						<option value="<?php echo $month['id']; ?>">
							<?php echo $month['name']; ?>
						</option>
					<?php endforeach?>
			        </select>


				</div>

      </div>


      <div class="modal-footer">

        <button type="submit" class="btn btn-primary" name="save" onclick="uploadFile()">Ανέβασμα</button>

		  <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
      </div>
			 </form>
    </div>
  </div>
</div>




<div class="col-sm-4">
    <div class="card" style="margin-top:20px;">
        <div class="card-header" style="color:white;background-color:#5383d3;">
        Γενικές Πληροφορίες
        </div>
      <div class="card-body">
          <p>Η διαδικτυακή πλατφόρμα Intra-Net προσφέρει στους χρήστες την δυνατότητα παρακολούθησης των σεμιναρίων για την
          Διαταραχή Ακουστικής Επεξεργασίας. Επιπλέον, τα quiz test και το blog δίνουν την ευκαιρία στον χρήστη για εξέταση
          των γνώσεων του και την σωστή ενημέρωση του. Για οποιοδήποτε πρόβλημα προκύψει κατά την χρήση του, απευθυνθείτε στο παρακάτω email:<br>
          <a href="mailto:misaaris@gmail.com">misaaris@gmail.com</a></p>
        </div>




    <div class="card" style="margin-top:15px;">
        <div class="card-header" style="color:white;background-color:#5383d3;">
        Quiz Test
        </div>
      <div class="card-body">
          <p>Το παρακάτω quiz είναι διαθέσιμο για όλους τους χρήστες και γίνεται ανανέωση κάθε μήνα, ανάλογα με την ύλη που έχει καλυφθεί.</p>
          <a class="btn btn-primary" href="adminquiz.php" role="button">Δοκίμασε τις γνώσεις σου</a>
        </div>



        <div class="card" style="margin-top:20px;">
        <div class="card-header" style="color:white;background-color:#5383d3;">
        Blog
        </div>
      <div class="card-body">
          <p>Το Blog είναι ένας εύκολος και γρήγορος τρόπος για την ενημέρωση των χρηστών για θέματα που αφορούν τα σεμινάρια, καθώς και άλλα νέα
          που αφορούν την κοινότητα μας. </p>
          <a class="btn btn-primary" href="adminposts.php" role="button">Ενημερώσου</a>


        </div>
        </div>
           </div>
        </div>
    </div>


        </div>
</div>


	<!--footer-->
	<div class="col-sm-12" style="margin-top:20px;">

    <div class="card" style="background-color: #FFFFFF;">
    <div class="card-body">
    <?php if (isset($_SESSION['success'])): ?>
			<div class="error success" >
				<h3>
					<?php
echo $_SESSION['success'];
unset($_SESSION['success']);
?>
				</h3>
			</div>
		<?php endif?>
    <?php if (isset($_SESSION['user'])): ?>
        <h5>Συνδεθήκατε επιτυχώς</h5>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<br>
						<a href="logout.php">Αποσύνδεση</a>
					</small>

				<?php endif?>

    </div>
        </div>

        </div>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.getElementById("menuspan").style.visibility = "hidden";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.getElementById("menuspan").style.visibility = "visible";
}
</script>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
</script>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script>
	  function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  var file = _("selectfile").files[0];
  var months = _("months").val();
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData.getAll();
  formdata.append("selectfile", file);

  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "file_upload_parser.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText;
  _("progressBar").value = 0; //wil clear progress bar after successful upload
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}
	  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>


	<?php if (isset($_SESSION['message']) && $_SESSION['message'] != '') {?>
	<script>
      swal({
  title: "<?php echo $_SESSION['message']; ?>",
  text: "",
  icon: "<?php echo $_SESSION['message-status']; ?>",
  button: "Εξοδος",
});
		</script>
  <?php unset($_SESSION['message']);}
?>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>