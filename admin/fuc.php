
<?php


session_start();

// connect to database
$db = mysqli_connect('localhost', '', '', '');
mysqli_set_charset($db, "utf8");
if (!$db) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
	
mysqli_set_charset($con, "utf8");
    // define global constants
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/apdseminars/');

// variable declaration
$username = "";
$email    = "";
$errors   = array();


// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

    
    
	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
    
    
    
    // Ensure that no user is registered twice.
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";

    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
    }

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password_hashed = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password)
					  VALUES('$username', '$email', '$user_type', '$password_hashed')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			//header('location: dashboard.php');
		}else{

			$query = "INSERT INTO users (username, email, user_type, password)
					  VALUES('$username', '$email', 'user', '$password_hashed')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');

		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}


// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;
	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "<p style='color:red'>Username is required</p>");
	}
	if (empty($password)) {
		array_push($errors, "<p style='color:red'>Passwrod is required</p>");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {

        
		$query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
		$result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        
		if (password_verify($password, $row['password'])) { // user found
        
            

			$id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$email = $row['email'];
			
			$_SESSION['id']= $id;
			$_SESSION['username']=$username;
			
			$_SESSION['email']=$email;
            // put logged in user into session array
            $_SESSION['user'] = getUserById($id);

            // if user is admin, redirect to admin area
            if ( $row['user_type']=='admin' ){
                $_SESSION['success'] = "You are now logged in";
				$_SESSION['id']= $id;
			$_SESSION['username']=$username;
			
			$_SESSION['email']=$email;
            // put logged in user into session array
            $_SESSION['user'] = getUserById($id);
                // redirect to admin area
              header('location: admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['success'] = "You are now logged in";
				$_SESSION['id']= $id;
			    $_SESSION['username']=$username;
			
			    $_SESSION['email']=$email;
            // put logged in user into session array
                $_SESSION['user'] = getUserById($id);
				
                // redirect to public area
              header('location: index.php');
                exit(0);
            }
			
        } else {
            array_push($errors, 'Wrong credentials');
        }
            // if user is admin, redirect to admin area
        /*$row= mysqli_fetch_array($results);
        $password_hash = $row['password'];
        $checked=password_verify($password, $password_hash);
              
        if ($checked) {
            echo 'password correct';            
        }else{
            echo 'password wrong';
         array_push($errors, "<p style='color:red'>Wrong username/password combination</p>");
        }*/
    }
}

function getTopicNameById($id)
{
	global $db;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($db, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

?>



