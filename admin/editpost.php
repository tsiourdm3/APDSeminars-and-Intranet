<?php include 'fucadmin.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog | Αρχική </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="static/css/public_styling.css">
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

}

	@media screen and (max-width:600px){
		.titles{font-size:19px;}
	}

.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
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
    <h1 style="text-align:center;font-size:70px;">Intra-<span>net</span></h1>
    </div>

    </div></div>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="profile.php">
    <?php if (isset($_SESSION['user'])): ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<br>
						<a href="logout.php">Αποσύνδεση</a>
					</small>

				<?php endif?></a>
  <a href="dashboard.php">Αρχική</a>
  <a href="tableusers.php">Διαχείριση Χρηστών</a>
  <a href="adminposts.php">Διαχείριση Blog</a>
  <a href="adminquiz.php">Διαχείριση Quiz</a>
</div>

<div class="container-fluid">
        <div class="row">
    <div class="col-md-12" style="margin-top:20px;">
		<div class="card" style="background-color: #FFFFFF;">
     <div class="card-body">
     <form class="form-horizontal" method="post" action="post.php" >
		<fieldset>

		 <h1>Επεξεργασία Συνομιλίας </h1><hr>
			<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label for="title" class="col-lg-3 col-form-label">Τίτλος</label>
				<div class="col-lg-9">
				<input type="text" name="title" class="form-control" placeholder="Τίτλος">
				</div>
				</div>
			</div>
				</div>

			<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label for="body" class="col-lg-3 col-form-label">Μήνυμα</label>
				<div class="col-lg-9">
					<textarea type="text" rows="5" cols="10" name="body" class="form-control" placeholder="Εισάγετε κείμενο..."></textarea>
				</div>
				</div>
			</div>
				</div>


			<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label for="topic_id" class="col-lg-3 col-form-label">Κατηγορία</label>
				<div class="col-lg-9">
					<select name="topic_id" class="form-control">

					<option>--Επιλογή--</option>
						<?php
$sql = "SELECT id FROM topics";
$result = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<option>' . $row['id'] . '</option>';

}
?>
					</select>
				</div>
				</div>


			</div>
				</div>


			<div class="row" style="margin-top:30px;">
			<div class="col-md-6">
			<div class="form-group">

				<div class="col-lg-9">
					<button type="submit" name="post" class="btn btn-primary" value="Δημιουργία">Δημιουργία</button>
				    <button type="reset" class="btn btn-default">Ακύρωση</button>
					<button type="button" class="btn btn-dark" onclick="history.go(-1);"> Επιστροφή </button>

				</div>
				</div>

			</div>
			</div>
		 </fieldset>



		</form>
			</div>
		</div></div>
	</div>
	</div>

<!-- // content -->

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
<!-- Javascripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="scripts.js"></script>

	</body>
</html>
