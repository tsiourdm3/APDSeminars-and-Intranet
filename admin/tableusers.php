<?php include('fucadmin.php'); 

if (!isAdmin()) {
	$_SESSION['message'] = "You must log in first";
	header('location: ../login.php');
}
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// general variables
$errors = [];

/* - - - - - - - - - -
-  Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}

function getAllUsers(){
	global $db, $user_type;
	$sql = "SELECT * FROM users WHERE user_type IS NOT NULL";
	$result = mysqli_query($db, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}

	// Get all admin users from DB
	$users = getAllUsers();
	$roles = ['admin', 'user'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin | Χρήστες</title>
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
<style>
body {
  font-family: 'Varela Round', sans-serif;
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
		.titles{font-size:16px;}
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
<style>
/* Table div (Displaying records from DB) */

.table-div .message { width: 90%; margin-top: 20px; }
.table-div table { width: 100%; }
.table-div a.fa { color: white; padding: 3px; }
	

</style>
	<style>
	.table-responsive {
        margin: 30px 0;
    }
	.table-wrapper {
        min-width: 1000px;
        background: #fff;
        padding: 20px 25px;
		border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
		padding: 12px 15px;
		vertical-align: middle;
    }
	table.table tr th:first-child {
		width: 60px;
	}
	table.table tr th:last-child {
		width: 100px;
	}
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
		opacity: 0.9;
		font-size: 22px;
        margin: 0 5px;
    }
	table.table td a {
		font-weight: bold;
		color: #566787;
		display: inline-block;
		text-decoration: none;
	}
	table.table td a:hover {
		color: #2196F3;
	}
	table.table td a.settings {
        color: #2196F3;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}
		
	
	</style>
	<style>
    .space-between {
        display: inline-block;
        padding-left: 3em;
    }
    .space-between:first-child {
        padding-left: 0;
    }
		
    .container i {
    margin-left: -30px;
    cursor: pointer;
}
		.field-icon {
  float: right;
  margin-right: 10px;
  margin-top: -28px;
  position: relative;
  z-index: 2;
}
		
		.btn-primary {
  font-family: Raleway-SemiBold;
  font-size: 16px;
  color: rgba(58, 133, 191, 0.75);
  letter-spacing: 1px;
  line-height: 15px;
  border: 2px solid rgba(58, 133, 191, 0.75);
  border-radius: 40px;
  background: transparent;
  transition: all 0.3s ease 0s;
}

.btn-primary:hover {
  color: #FFF;
  background: rgba(58, 133, 191, 0.75);
  border: 2px solid rgba(58, 133, 191, 0.75);
}
	.btn-default {
  font-family: Raleway-SemiBold;
  font-size: 15px;
  color: dimgrey;
  letter-spacing: 1px;
  line-height: 15px;
  border: 2px solid dimgrey;
  border-radius: 40px;
  background: transparent;
  transition: all 0.3s ease 0s;
}

.btn-default:hover {
  color: #FFF;
  background:grey;
  border: 2px solid grey;
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
						<a href='logout.php'>Αποσύνδεση</a>
					</small>

				<?php endif ?></a>
  <a href="dashboard.php">Αρχική</a>
  <a href="tableusers.php">Διαχείρηση Χρηστών</a>
  <a href="adminposts.php">Διαχείρηση Blog</a>
  <a href="adminquiz.php">Διαχείρηση Quiz</a>
  
</div>
	
	<div class="container-fluid">
		<div class="row">
	<div class="col-sm-8" style="margin-top:20px;">
	<div class="card" style="background-color: #FFFFFF;">
		<div class="card-header" style="background: #299be4;
		color: #fff;border-radius: 3px 3px 0 0;">
			<div class="table-title">
                
                    <div class="col-xs-4" style="text-align:center">
                        <h2>Πίνακας Χρηστών <b>Intra-net</b></h2>
					</div>
				
<!-- Modal -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color:black">Νέο Μέλος</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		 <form action="tableusers.php" method="POST">
      <div class="modal-body">
    
			<?php include(ROOT_PATH . '/errors.php') ?>
			<div class="form-group">
				<label style="color:grey">Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Username" style="border-radius: 5px;">
				</div>
					
			
			<div class="form-group">
				<label style="color:grey">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo $email ?>" placeholder="Email" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<label style="color:grey">First Name</label>
				<input type="text"  name="first_name" class="form-control" value="<?php echo $first_name; ?>" placeholder="Όνομα" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<label style="color:grey">Last Name</label>
				<input type="text"  name="last_name" class="form-control" value="<?php echo $last_name; ?>" placeholder="Επίθετο" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<label style="color:grey">Password</label>
				<input type="password" name="password_1" class="form-control" placeholder="Κωδικός" style="border-radius: 5px;">
				
				</div>
				
			<div class="form-group">
				<label style="color:grey">Password Confirmation</label>
				<input type="password" class="form-control" name="password_2" placeholder="Επιβεβαίωση κωδικού" style="border-radius: 5px;">
				
				</div>
			<div class="form-group">
				<label style="color:grey">User Type</label>
				
					<select name="role" id="user_type" style="text-align:center;"  style="border-radius: 5px;">
				<option value="">-- Επιλογή --</option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			        </select>
				

				</div>
			
      </div>
		  
			
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
        <button type="submit" name="create_admin" class="btn btn-primary">Αποθήκευση</button>
      </div>
			 </form>
    </div>
  </div>
</div>
			</div>
			</div>
		
     <div class="card-body" id="load-products">
		 <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile"><i class="material-icons" style="margin-top:2px;">&#xE147;</i><span style="float:right;margin-left:7px;margin-top:8px;font-family:Arial">Προσθέστε μέλος</span>
        </button>
        <a type="button" class="btn btn-dark" href="dashboard.php" style="float:right;margin-right:30px;border-radius:40px;"> Επιστροφή στην Αρχική</a>
		 <?php if (empty($users)): ?>
				<h1>No admins in the database.</h1>
			<?php else: ?>
		 <div class="table-responsive" style="max-height:333px;font-size:14px;">
	<table class="table table-striped table-hover" >
                <thead>
                    <tr>
                        <th>Νο.</th>
						<th>Χρήστες</th>
						<th>Όνομα</th>
						<th>Επίθετο</th>
						<th>Email</th>
						<th>Ρόλος Χρήστη</th>
						<th colspan="2" >Ενέργειες</th>
                    </tr>
                </thead>
				
					<tbody>
					<?php foreach ($users as $key => $user): ?>
						<tr>
							<input type="hidden" class="admin_id" value="<?php echo $user['id']; ?>">
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $user['username']; ?>
							</td>
							<td><?php echo $user['first_name']; ?></td>
							<td><?php echo $user['last_name']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td><?php echo $user['user_type']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit" style="background-color:#BFF5FF"
									href="tableusers.php?edit-admin=<?php echo $user['id'] ?>">
								</a>
							</td>
							<td>
									<a href="tableusers.php?delete-admin=<?php echo $user['id'] ?>" data-id="<?php echo $user['id']; ?>" id="delete-admin" name="delete-admin" data-toggle="tooltip" class="delete" title="Delete" ><i class="fa fa-trash btn trash"></i></a>
								
							</td>
						</tr>
					<?php endforeach ?>
						
					</tbody>
						
					
				  </table>
				 </div>
					  		 
		
			<?php endif ?>
		 
		 </div>
		</div>
		</div>
		 
		 
    <div class="col-sm-4" style="margin-top:20px;">
		<div class="card" style="background-color: #FFFFFF;">
     <div class="card-body">
			<h1 class="page-title">Edit Admin User</h1>

			<form method="post" action="tableusers.php" >

				<fieldset>
				<!-- validation errors for the form -->
					<div style="color:red;">
				<?php include(ROOT_PATH . '/errors.php') ?>
						</div>
				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" style="border-radius: 5px;">
				<?php endif ?>

					
			<div class="form-group">
				<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Username" style="border-radius: 5px;">
				</div>
					
			<div class="form-group">
				<input type="email" name="email" class="form-control" value="<?php echo $email ?>" placeholder="Email" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<input type="text"  name="first_name" class="form-control" value="<?php echo $first_name; ?>" placeholder="Όνομα" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<input type="text"  name="last_name" class="form-control" value="<?php echo $last_name; ?>" placeholder="Επίθετο" style="border-radius: 5px;">
				</div>
				
			<div class="form-group">
				<input id="password-field" type="password" name="password" class="form-control" placeholder="Κωδικός" style="border-radius: 5px;">
				<span toggle="#password-field"  class="fa fa-fw fa-eye field-icon toggle-password"></span>
				</div>
				
			<div class="form-group">
				<input type="password" name="passwordConfirmation" class="form-control" placeholder="Επιβεβαίωση κωδικού" style="border-radius: 5px;">
				
				</div>
				
			<div class="form-group">
				<select name="role" style="border-radius: 5px;" class="form-control">
					<option value="" selected disabled>-- Επιλογή --</option>
					<?php foreach ($roles as $key => $role): ?>
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
					<?php endforeach ?>
				</select>

				</div>
				<!-- if editing user, display the update button instead of create button -->
					
			<div class="form-group">
				<?php if ($isEditingUser === true): ?>
				<button type="submit" class="btn btn-primary" name="update_admin">Επεξεργασία</button>
				<button type="button" class="btn btn-default" name="reset" onclick="history.go(-1);">Ακύρωση</button>
				<?php else: ?>
					<div class="alert alert-info">
						<i class="fas fa-info-circle"></i> Πιέστε ένα κουμπί επεξεργασίας για την ενεργοποίηση της φόρμας.
				</div>
				<?php endif ?> 
				</div>
					
				</fieldset>
			</form>
		</div>
	</div>
		</div></div>
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
						<a href="logout.php">Αποσύνδεση</a>
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
	<script>
	$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
	
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
	</script>
</body>
</html>