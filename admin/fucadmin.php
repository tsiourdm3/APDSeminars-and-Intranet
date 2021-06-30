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

// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$role = "";
// general variables
$errors = [];
// variable declaration
$username = "";
$email    = "";
$first_name = "";
$last_name = "";
$errors   = array();


// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email, $first_name, $last_name;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$first_name  =  e($_POST['first_name']);
	$last_name   =  e($_POST['last_name']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	$user_type   =  e($_POST['user_type']);

    
    
	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "<p style='color:red'>Απαιτείται username.</p></p>");
	}
	if (empty($email)) {
		array_push($errors, "<p style='color:red'>Απαιτείται email.</p>");
	}
	if (empty($first_name)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται όνομα χρήστη</i>"); }
	
	if (empty($last_name)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται επίθετο χρήστη</i>"); }
	
	if (empty($password_1)) {
		array_push($errors, "<p style='color:red'>Απαιτείται εισαγωγή κωδικού.</p>");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "<p style='color:red'>Οι κωδικοί δεν ταιριάζουν. </p>");
	}
    
    
    
    // Ensure that no user is registered twice.
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";

    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    
        if (mysqli_num_rows($user_check_query) > 0 ) {
            array_push($errors, "<p style='color:red'>Το όνομα χρήστη υπάρχει ήδη. Δοκιμάστε κλατι άλλο.</p>");
			$_SESSION['message']  = "<p style='color:red'>Το όνομα χρήστη υπάρχει ήδη. Δοκιμάστε κλατι άλλο.</p>";
        }
	else{
		
		if ($password_1 === $password_2) {
		$password_hashed = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database
		$query = "INSERT INTO users (username, email, first_name, last_name, user_type, password)
					  VALUES('$username', '$email', '$first_name','$last_name', '$user_type', '$password_hashed')";
		mysqli_query($db, $query);	
		
			if($query){
				
			$_SESSION['message']  = "New user successfully created!!";
			$_SESSION['message-status'] = "success";
			header('location: tableusers.php');
				
			}else{
				
			$_SESSION['message']  = "Something went wrong";
			$_SESSION['message-status'] = "error";
			header('location: tableusers.php');
				
			}
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
		array_push($errors, "<p style='color:red'>Απαιτείται εισαγωγή Username.</p>");
	}
	if (empty($password)) {
		array_push($errors, "<p style='color:red'>Απαιτείται εισαγωγή κωδικού.</p>");
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
                $_SESSION['success'] = "Είστε συνδεδεμέμος/η";
				$_SESSION['id']= $id;
			    $_SESSION['username']=$username;
			
			    $_SESSION['email']=$email;
                // put logged in user into session array
                $_SESSION['user'] = getUserById($id);
				
				// sessions for quiz
				$_SESSION['name']     = 'Admin';
                $_SESSION['key']      = '54585c506829293a2d4c3b68543b316e2e7a2d277858545a36362e5f39';
                // redirect to admin area
                 header('location: admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['success'] = "Είστε συνδεδεμέμος/η";
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
            array_push($errors, '<p style="color:red">Λάθος κωδικός ή κωδικός. Δοκιμάστε ξανά!</p>');
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


// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}


function esc(String $value){
	// bring the global db connect object into function
	global $db;
	// remove empty space sorrounding string
	$val = trim($value);
	$val = mysqli_real_escape_string($db, $value);
	return $val;
}


/* - - - - - - - - - - - -
-  Admin users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new admin data from form
* - Create new admin user
* - Returns all admin users with their roles
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values){
	global $db, $errors, $role, $username, $email, $first_name, $last_name;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$first_name = esc($request_values['first_name']);
	$last_name = esc($request_values['last_name']);
	$password_1 = esc($request_values['password_1']);
	$password_2 = esc($request_values['password_2']);

	if(isset($request_values['role'])){
		$role = esc($request_values['role']);
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται username</i>"); }
		if (empty($email)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται email</i>"); }
	if (empty($first_name)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται όνομα χρήστη</i>"); }
	if (empty($last_name)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται επίθετο χρήστη</i>"); }
	if (empty($role)) { array_push($errors, "<p style='color:red'><i>Επιλέξτε ρόλο για κάθε χρήστη</i>");}
	if (empty($password_1)) { array_push($errors, "<p style='color:red'><i>Παρακαλώ εισάγεται κωδικό</i>"); }
	if ($password_1 != $password_2) { array_push($errors, "<p style='color:red'><i>Οι δύο κωδικοί δεν ταιρίαζουν. Παρακαλώ επιβεβαιώστε σωστά τον κωδικό πρόσβασης</i>"); }
	// Ensure that no user is registered twice.
	// the email and usernames should be unique
	$user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // if user exists
		if ($user['username'] === $username) {
		  array_push($errors, "<p style='color:red'>Το Username υπάρχει ήδη. Δοκιμάστε κάτι άλλο!</p>");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "<p style='color:red'>Το Email υπάρχει ήδη. Δοκιμάστε κάτι άλλο!</p>");
		}
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		
		$password_hashed = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database

		if (isset($_POST['role'])) {
		$query = "INSERT INTO users (username, email, first_name, last_name, user_type, password)
				  VALUES('$username', '$email','$first_name','$last_name', '$role', '$password_hashed')";
		mysqli_query($db, $query);

		$_SESSION['message'] = "Ο χρήστης αποθηκεύτηκε επιτυχώς";
		header('location: tableusers.php');
		exit(0);
	}
}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes admin id as parameter
* - Fetches the admin from database
* - sets admin fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $db, $username, $role, $isEditingUser, $admin_id, $email,  $first_name, $last_name;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($db, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['username'];
	$email = $admin['email'];
	$first_name =$admin['first_name'];
	$last_name = $admin['last_name'];
	
	
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* - Receives admin request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $db, $errors, $role, $username, $isEditingUser, $admin_id, $email, $first_name, $last_name;
	// get id of the admin to be updated
	$admin_id = $request_values['admin_id'];
	// set edit state to false
	$isEditingUser = false;
	
    
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$first_name = esc($request_values['first_name']);
	$last_name = esc($request_values['last_name']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "<p style='color:red'>Απαιτείται username.</p></p>");
	}
	if (empty($email)) {
		array_push($errors, "<p style='color:red'>Απαιτείται email.</p>");
	}
	if (empty($first_name)) {
		array_push($errors, "<p style='color:red'>Απαιτείται όνομα.</p></p>");
	}
	if (empty($last_name)) {
		array_push($errors, "<p style='color:red'>Απαιτείται επίθετο.</p></p>");
	}
	if (empty($password)) {
		array_push($errors, "<p style='color:red'>Απαιτείται εισαγωγή κωδικού.</p>");
	}
	if ($password != $passwordConfirmation) {
		array_push($errors, "<p style='color:red'>Οι κωδικοί δεν ταιριάζουν. </p>");
	}
	// register user if there are no errors in the form
	if (count($errors) == 0 ) {
		$password_hashed = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database

		if (isset($_POST['role'])) {

		$query = "UPDATE users SET username='$username', email='$email', first_name='$first_name', last_name='$last_name', user_type='$role', password='$password_hashed' WHERE id=$admin_id";
		mysqli_query($db, $query);
         if(mysqli_query){
			 
		 	$_SESSION['message'] = "Η πληροφορίες του χρήστη άλλαξαν επιτυχώς";
		    $_SESSION['message-status']= "success";
		    header('location: tableusers.php');
		    exit(0); 
			 
		 }else{
			 
		    $_SESSION['message'] = "Κάτι πήγε στραβά. Προσπαθήστε ξανά!";
		    $_SESSION['message-status']= "error";
		    header('location: tableusers.php');
	}
		}
	}
}

// delete admin user
function deleteAdmin($admin_id) {
	global $db;
	$sql = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($db, $sql)) {
		$_SESSION['message'] = "Ο χρήστης διαγράφηκε επιτυχώς!";
		$_SESSION['message-status']= "success";
		
		header("location: tableusers.php");
		exit(0);
	}else{
		$_SESSION['message'] = "Κάτι πήγε στραβά. Προσπαθήστε ξανά!";
		$_SESSION['message-status']= "info";
		header("location: tableusers.php");
	}
	
}
	// Admin user variables
	// ... varaibles here ...

	// Topics variables
	$post_id = 0;
	$isEditingTopic = false;
    $isEditingPost = false;
	$topic_name = "";
    $title="";
    $body="";

	/* - - - - - - - - - -
	-  Admin users actions
	- - - - - - - - - - -*/
	// ...

	/* - - - - - - - - - -
	-  Topic actions
	- - - - - - - - - - -*/
	// if user clicks the create topic button
	if (isset($_POST['create_topic'])) { createTopic($_POST); }
	// if user clicks the Edit topic button
	if (isset($_GET['edit-topic'])) {
		$isEditingTopic = true;
		$topic_id = $_GET['edit-topic'];
		editTopic($topic_id);
	}
	// if user clicks the update topic button
	if (isset($_POST['update_topic'])) {
		updateTopic($_POST);
	}
	// if user clicks the Delete topic button
	if (isset($_GET['delete-topic'])) {
		$topic_id = $_GET['delete-topic'];
		deleteTopic($topic_id);
	}


   // if user clicks the create topic button
	if (isset($_POST['create_post'])) { createPost($_POST); }
	// if user clicks the Edit topic button
	if (isset($_GET['edit-post'])) {
		$isEditingPost = true;
		$post_id = $_GET['edit-post'];
		editPost($post_id);
	}
	// if user clicks the update topic button
	if (isset($_POST['update_post'])) {
		updatePost($_POST);
	}
	// if user clicks the Delete topic button
	if (isset($_GET['delete-post'])) {
		$post_id = $_GET['delete-post'];
		deletePost($post_id);
	}


	/* - - - - - - - - - - - -
	-  Admin posts functions
	- - - - - - - - - - - - -*/
	function editPost($post_id)
	{
		global $db, $title, $body, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts WHERE id=$post_id LIMIT 1";
		$result = mysqli_query($db, $sql);
		$post = mysqli_fetch_assoc($result);
		// set form values on the form to be updated
		$title = esc($post['title']);
		$body = esc($post['body']);
		$topic_id = esc($post['topic_id']);
	}

	function updatePost($request_values)
	{
		global $db, $errors, $post_id, $title, $topic_id, $body, $isEditingPost;
        $post_id = $request_values['post_id'];
		
		// set edit state to false
	    $isEditingPost = false;
		
		$title = esc($request_values['title']);
		$body = esc($request_values['body']);
		
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}

		if (empty($title)) { array_push($errors, "<p style='color:red'>Απαιτείται τίτλος.</p>"); }
		if (empty($body)) { array_push($errors, "<p style='color:red'>Παρακλώ εισάγεται μήνυμα.</p> "); }

		// register topic if there are no errors in the form
		if (count($errors) == 0) {
			$query = "UPDATE posts SET title='$title', body='$body', topic_id =$topic_id WHERE id=$post_id";
			// attach topic to post on post_topic table
			if(mysqli_query($db, $query)){ // if post created successfully
				
			$_SESSION['message'] = "Post updated successfully";
			$_SESSION['message-status']="success";
			header('location: adminposts.php');
			exit(0);
			}else{
			 $_SESSION['message'] = "Something went wrong. Try again.";
			 $_SESSION['message-status']="error";
			header('location: adminposts.php');
			exit(0);
			}
		}
	}
	// delete blog post
	function deletePost($post_id)
	{
		global $db;
		$sql = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($db, $sql)) {
			$_SESSION['message'] = "Η συνομιλία διαγράφηκε επιτυχώς!";
			$_SESSION['message-status']= "success";
			header("location: adminposts.php");
			exit(0);
		}else{
			$_SESSION['message'] = "Κάτι πήγε στραβά. Προσπαθήστε ξανά!";
		$_SESSION['message-status']= "info";
		header("location: tableusers.php");
		}
	}


	/* - - - - - - - - - -
	-  Topics functions
	- - - - - - - - - - -*/
	// get all topics from DB
	function getAllTopics() {
		global $db;
		$sql = "SELECT * FROM topics";
		$result = mysqli_query($db, $sql);
		$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $topics;
	}
	function createTopic($request_values){
		global $db, $errors, $topic_name;
		$topic_name = esc($request_values['name']);
		// validate form
		if (empty($topic_name)) {
			array_push($errors, "Topic name required");
		}
		// Ensure that no topic is saved twice.
		$topic_check_query = "SELECT * FROM topics WHERE name='$topic_name' LIMIT 1";
		$result = mysqli_query($db, $topic_check_query);
		if (mysqli_num_rows($result) > 0) { // if topic exists
			array_push($errors, "Topic already exists");
		}
		// register topic if there are no errors in the form
		if (count($errors) == 0) {
			$query = "INSERT INTO topics (name)
					  VALUES('$topic_name')";
			mysqli_query($db, $query);

			$_SESSION['message'] = "Topic created successfully";
			header('location: topics.php');
			exit(0);
		}
	}
	/* * * * * * * * * * * * * * * * * * * * *
	* - Takes topic id as parameter
	* - Fetches the topic from database
	* - sets topic fields on form for editing
	* * * * * * * * * * * * * * * * * * * * * */
	function editTopic($topic_id) {
		global $db, $topic_name, $isEditingTopic, $topic_id;
		$sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
		$result = mysqli_query($db, $sql);
		$topic = mysqli_fetch_assoc($result);
		// set form values ($topic_name) on the form to be updated
		$topic_name = $topic['name'];
	}
	function updateTopic($request_values) {
		global $db, $errors, $topic_name, $topic_id;
		$topic_name = esc($request_values['topic_name']);
		$topic_id = esc($request_values['topic_id']);
		
		// validate form
		if (empty($topic_name)) {
			array_push($errors, "Topic name required");
		}
		// register topic if there are no errors in the form
		if (count($errors) == 0) {
			$query = "UPDATE topics SET name='$topic_name' WHERE id=$topic_id";
			mysqli_query($db, $query);

			$_SESSION['message'] = "Topic updated successfully";
			header('location: topics.php');
			exit(0);
		}
	}
	// delete topic
	function deleteTopic($topic_id) {
		global $db;
		$sql = "DELETE FROM topics WHERE id=$topic_id";
		if (mysqli_query($db, $sql)) {
			$_SESSION['message'] = "Topic successfully deleted";
			header("location: topics.php");
			exit(0);
		}
	}



// if user clicks the Delete file button
	if (isset($_GET['delete-file'])) {
		$id = $_GET['delete-file'];
		deleteFile($id);
	}
function deleteFile($id) {
	global $db;
	$sql = "DELETE FROM files WHERE id=$id";
	if (mysqli_query($db, $sql)) {
		$_SESSION['message'] = "Το αρχείο διαγράφηκε επιτυχώς!";
		$_SESSION['message-status']= "success";
		
		header("location: dashboard.php");
		exit(0);
	}else{
		$_SESSION['message'] = "Κάτι πήγε στραβά. Προσπαθήστε ξανά!";
		$_SESSION['message-status']= "info";
		header("location: dashboard.php");
	}
	
}

?>

