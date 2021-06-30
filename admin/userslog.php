
<?php include('fuc.php');
if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}


function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
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
		<a href="dashboard.php" style="text-decoration:none;">
			<h1 style="text-align:center;font-size:70px;">Intra-<span>net</span></h1></a>
    </div>

    </div></div>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="dashboard.php">
    <?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href='http://localhost/apdseminars/index.php?logout="1"'>Αποσύνδεση</a>
					</small>

				<?php endif ?></a>
  <a href="dashboard.php">Αρχική</a>
  <a href="tableusers.php">Διαχείρηση Χρηστών</a>
  <a href="adminposts.php">Διαχείρηση Blog</a>
  <a href="#">Διαχείρηση Quiz</a>
  <a href="#">Διαχείρηση Περιεχομένου</a>
</div>
	
	<!-- Page content -->
	<div class="container-fluid">
		<table align="center" border="1">
<tr>
<th>Sno.</th>
<th>User Id</th>
<th>User Name</th>
<th>User Ip</th>
<th>Action Performed</th>
<th>Login Time</th>
</tr>
<?php $query=mysqli_query($db,"SELECT * FROM userlog");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>
<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $row['userID'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['userIp'];?></td>
<td><?php echo $row['action'];?></td>
<td><?php echo $row['loginTime'];?></td>
</tr>
<?php $cnt=$cnt+1;
} ?>
</table>
	</div>
	
	<!--footer-->  
    <div class="col-sm-12" style="margin-top:20px;">
    
    <div class="card" style="background-color: #FFFFFF;">
    <div class="card-body">
    <?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
    <?php  if (isset($_SESSION['user'])) : ?>
        <h5>Συνδεθήκατε επιτυχώς</h5>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a name='logout' href="<?php echo BASE_URL .'logout.php' ; ?>" class="logout"> Αποσύνδεση</a>
					</small>

				<?php endif ?>
    
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	

	<?php if (isset($_SESSION['message']) && $_SESSION['message'] !='') { ?>
	<script>
      swal({
  title: "<?php echo $_SESSION['message']; ?>",
  text: "",
  icon: "<?php echo $_SESSION['message-status']; ?>",
  button: "Εξοδος",
});
		</script>
  <?php unset($_SESSION['message']); }
?>
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body></html>