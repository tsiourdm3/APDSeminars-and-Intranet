<?php include 'fucadmin.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}
// Topics variables
$post_id = 0;
$isEditingPost = false;
$topic_name = "";
$title = "";
$body = "";
/* - - - - - - - - - -
-  Admin users actions
- - - - - - - - - - -*/
// ...

if (isset($_GET['post_id'])) {
    $post = getPost($_GET['post_id']);
}
$topics = getAllTopics();

/* - - - - - - - - - -
-  Topic actions
- - - - - - - - - - -*/
// if user clicks the create topic button
if (isset($_POST['create_post'])) {createPost($_POST);}
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
-  Admin users functions
- - - - - - - - - - - - -*/
// ...

/* - - - - - - - - - -
-  Topics functions
- - - - - - - - - - -*/

?>
<?php
// Get posts under a particular topic
if (isset($_GET['topic'])) {
    $topic_id = $_GET['topic'];
    $posts = getPublishedPostsByTopic($topic_id);
}

function getPostTopic($post_id)
{
    global $db;
    $sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM posts WHERE post_id=$post_id) LIMIT 1";
    $result = mysqli_query($db, $sql);
    $topic = mysqli_fetch_assoc($result);
    return $topic;
}

/* * * * * * * * * * * * * * * *
 * Returns all posts under a topic
 * * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id)
{
    global $db;
    $sql = "SELECT * FROM posts ps
			WHERE topic_id=$topic_id ";
    $result = mysqli_query($db, $sql);
    // fetch all posts as an associative array called $posts
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

function getAllPosts()
{
    global $db;
    $posts_query = "SELECT * FROM posts";
    $posts_result = mysqli_query($db, $posts_query);
    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);

    return $posts;
}

// Get all admin users from DB
$posts = getAllPosts();
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

	<!-- Page content -->
	<div class="container-fluid">
        <div class="row">
    <div class="col-lg-8" style="margin-top:20px;">
    <div class="card">
        <div class="card-header" style="background-color:#5383d3; color:white;">

			<h2 class="content-title" style="text-align:center;">Συζήτηση</h2>

			</div>

		<div class="col-lg-12" style="margin-top:30px;margin-left:20px;">


			<a class="btn btn-primary" href="create_posts.php" role="button">Νέα Συζήτηση</a>


		    <button type="button" class="btn btn-dark" onclick="history.go(-1);" style="float:right;margin-right:30px;"> Επιστροφή </button>

		</div><br><br>
			<!-- more content still to come here ... -->

			<!-- Add this ... -->
<div class="container-fluid" style="margin-bottom:20px">



		  <div class="col-sm-12" style="margin-top:20px;">
			 <?php foreach ($posts as $post): ?>
          <div class="card">


        <div class="card-header">

			<?php if (isset($post['topic_id'])): ?>
			<a
				href="<?php echo BASE_URL . 'filtered_posts.php?category=' . $post['topic_id']['id'] ?>"
				class="btn category" style="background-color:white;color:#3399FF; border:1px solid">
				<?php echo getTopicNameById($post['topic_id']) ?>
			</a>
	    	<a class="fa fa-pencil btn edit" href="adminposts.php?edit-post=<?php echo $post['id']; ?>" style="float:right;background-color:white;color:#3399FF; border:1px solid"></a>
			<a  class="fa fa-trash btn delete" name="delete-post" href="adminposts.php?delete-post=<?php echo $post['id'] ?>" style="float:right;background-color:white;color:red; border:1px solid;margin-right:10px;"></a>

			<h3 class="titles" style="margin-top:10px;"><?php echo $post['title'] ?></h3>
			<?php endif?>
		</div>
			  <div class="card-body">

			  <p><?php echo $post['body']; ?> </p>

				<div class="info">
					<span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
					<span style="float:right"><a href="singleposts.php?id=<?php echo $post['id']; ?>">Περισσότερα..</a></span>
				</div>
				  </div>

			  </div>
			  <br>
			  <?php endforeach?>

			  </div>




		</div></div>
		</div>
		<div class="col-sm-4" style="margin-top:20px;">
		<div class="card" style="background-color: #FFFFFF;">
     <div class="card-body">
			<h1 class="page-title">Edit Post</h1>

			<form method="post" action="adminposts.php" >

				<fieldset>
				<!-- validation errors for the form -->

				<?php include ROOT_PATH . '/errors.php'?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" style="border-radius: 5px;">
				<?php endif?>


			<div class="form-group">
				<label style="color:grey">Τίτλος</label>
				<input type="text" name="title" class="form-control" value="<?php echo $title; ?>" placeholder="Τίτλος" style="border-radius: 5px;">
				</div>

			<div class="form-group">
				<label style="color:grey">Μήνυμα</label>
				<input type="text" rows="5" cols="10" name="body" class="form-control" placeholder="Εισάγετε κείμενο..." value="<?php echo $body; ?>">
				</div>


			<div class="form-group">
				<label style="color:grey">Κατηγορία</label>
				<select name="topic_id" class="form-control" style="text-align:center;"  style="border-radius: 5px;">
				<option value="" selected disabled>-- Επιλογή --</option>
				<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>">
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach?>
				</select>

				</div>

				<!-- if editing user, display the update button instead of create button -->

			<div class="form-group">
				<?php if ($isEditingPost === true): ?>
				<button type="submit" class="btn btn-primary" name="update_post">Επεξεργασία</button>
				<button type="button" class="btn btn-default" name="reset" onclick="history.go(-1);">Ακύρωση</button>
				<?php else: ?>
					<div class="alert alert-info">
						<i class="fas fa-info-circle"></i> Πιέστε ένα κουμπί επεξεργασίας για την ενεργοποίηση της φόρμας.
				</div>
				<?php endif?>
				</div>

				</fieldset>
			</form>
		</div>
	</div>
		</div>

		</div></div>

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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body></html>