
<?php include('fuc.php');
   ?>
<?php
   if (!isLoggedIn()) {
   	$_SESSION['msg'] = "You must log in first";
   	header('location: login.php');
   }
   
   	if (isset($_GET['post_id'])) {
   		$post = getPost($_GET['post_id']);
   	}
   	$topics = getAllTopics();
   ?>
<?php	function getAllTopics()
   {
   	global $db;
   	$sql = "SELECT * FROM topics";
   	$result = mysqli_query($db, $sql);
   	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
   	return $topics;
   }
   				?>
<?php 
   $topics = getAllTopics();
   
   function getPostTopic($id){
   global $db;
   $sql = "SELECT * FROM topics WHERE id=
   (SELECT topic_id FROM post_topic WHERE post_id=$id) LIMIT 1";
   $result = mysqli_query($db, $sql);
   $topic = mysqli_fetch_assoc($result);
   return $topic;
   }
   
   /* * * * * * * * * * * * * * * *
   * Returns all posts under a topic
   * * * * * * * * * * * * * * * * */
   function getPublishedPostsByTopic($topic_id) {
   global $db;
   $sql = "SELECT * FROM posts ps
   WHERE ps.id IN
   (SELECT pt.post_id FROM post_topic pt
   WHERE pt.topic_id=$topic_id GROUP BY pt.post_id
   HAVING COUNT(1) = 1)";
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
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Forum</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="static/css/public_styling.css">
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
         form button { margin: 5px 0px; }
         textarea { display: block; margin-bottom: 10px; }
         /*post*/
         .post { border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px; }
         /*comments*/
         .comments-section { margin-top: 10px; border: 1px solid #ccc; }
         .comment { margin-bottom: 10px; }
         .comment .comment-name { font-weight: bold; }
         .comment .comment-date {
         font-style: italic;
         font-size: 0.8em;
         }
         .comment .reply-btn, .edit-btn { font-size: 0.8em; }
         .comment-details { width: 91.5%; float: left; }
         .comment-details p { margin-bottom: 0px; }
         .profile_pic {
         width: 35px;
         height: 35px;
         margin-right: 5px;
         float: left;
         border-radius: 50%;
         }
      </style>
   </head>
   <body>
      <!-- Navbar -->
      <div class="col-sm-12">
         <div class="card" style="background-color: #FFFFFF;">
            <div class="card-body">
               <div id="main">
                  <span style="font-size:30px;cursor:pointer" onclick="openNav()" id="menuspan">&#9776;</span>
               </div>
            </div>
            <div class="title" style="text-align:center;">
               <a href="index.php" style="text-decoration:none;">
                  <h1 style="text-align:center;font-size:70px;">Intra-<span>net</span></h1>
               </a>
            </div>
         </div>
      </div>
      <div id="mySidenav" class="sidenav">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <a href="index.php">
         <?php  if (isset($_SESSION['user'])) : ?>
         <strong><?php echo $_SESSION['user']['username']; ?></strong>
         <small>
         <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
         <br>
         <a href="logout.php">Αποσύνδεση</a>
         </small>
         <?php endif ?></a>
         <a href="indexblog.php">Forum/ <br>Συζητήσεις</a>
         <a href="quiz/account.php?q=1">Quiz</a>
      </div>
      <!-- // Navbar -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12" style="margin-top:20px;">
               <?php $id=$_GET['id']; ?>
               <?php 
                  $posts_query = "SELECT * FROM posts WHERE id='$id'";
                  $posts_results = mysqli_query($db, $posts_query) or die("error");
                  if(mysqli_num_rows($posts_results)>0){
                  	while($posts = mysqli_fetch_assoc($posts_results)){
                  		$id = $posts['id'];
                  		$username=$posts['username'];
                  		$title= $posts['title'];
                  		$body = $posts['body'];
                  		$topic_id = $posts['topic_id'];
                  		$created_at = $posts['created_at'];
                  		$user_id = $posts['user_id'];
                  	}
                  }
                  	
                  	
                  // Receives a user id and returns the username
                  function getUsernameById($id)
                  {
                  	global $db;
                  	$result = mysqli_query($db, "SELECT username FROM users WHERE id=(SELECT user_id FROM posts WHERE id = $id ) LIMIT 1");
                  	// return the username
                  	return mysqli_fetch_assoc($result)['username'];
                  }
                  	
                  ?>
               <div class="card">
                  <div class="card-header" style="background-color:#5383d3; color:white;">
                     <h2 class="post-title" style="text-align:center">Συζήτηση</h2>
                  </div>
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-sm-8" style="margin-top:10px;" >
                           <!-- Page wrapper -->
                           <div class="content">
                              <div class="post-wrapper">
                                 <!-- full post div -->
                                 <div class="full-post-div" style="border-radius:25px;">
                                    <div class="col-md-12 col-md-offset-3 comments-section" style="border-radius: 25px;border: 2px solid #5383d3; padding: 20px;min-height: 150px;">
                                       <h2 class="post-title"><?php echo $title; ?></h2>
                                       <hr>
                                       <small style="text">Δημοσιεύτηκε από <i><?php echo $username ?></i></small><br>
                                       <small style="color:blue"><?php echo $created_at ?></small>
                                       <hr>
                                       <br>
                                       <div class="post-body-div">
                                          <div class="text" style="text-align:justify;font-family: Arial;">
                                             <?php echo html_entity_decode($body); ?>
                                          </div>
                                          <!-- // full post div -->
                                       </div>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3" style="border-radius: 25px; padding: 20px;min-height: 150px;">
                                       <!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
                                       <!-- comments wrapper -->
                                       <div class="row">
                                          <div class="col-lg-12"></div>
                                          <div class="col-lg-12">
                                             <h2>Σχόλια</h2>
                                             <?php 
                                                $com_query = "SELECT * FROM comments WHERE post_id='$id'";
                                                $coms_results = mysqli_query($db, $com_query) or die("error");
                                                if(mysqli_num_rows($coms_results)>0){
                                                	while($com = mysqli_fetch_assoc($coms_results)){
                                                		$comment = $com['comment'];
                                                		?>
                                             <div class="col-lg-12" style="border-radius:20px;margin-top:20px;">
                                                <img src="fonts/profile.png" alt="" class="profile_pic">
                                                <small style="text">Δημοσιεύτηκε από <i><?php echo $com['username'] ?></i></small><br>
                                                <p><?php echo $comment ;?></p>
                                             </div>
                                             <?php
                                                }
                                                }
                                                			?>
                                          </div>
                                       </div>
                                       <div class="row" style="margin-top:60px;">
                                          <div class="col-lg-12"></div>
                                          <div class="col-lg-12">
                                             <form class="form-horizontal" action="comment.php" method="POST" style="text-align:left">
                                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                                <div class="form-group">
                                                   <label class="col-lg-9 control-label" style="font-size:20px;">Πρόσθεσε Σχόλιο</label> 
                                                   <div class="col-lg-12">
                                                      <textarea class="form-control" rows="5" cols="12" name="comment" placeholder="Γράψτε το σχόλιο σας..."></textarea>
                                                   </div>
                                                </div>
                                                <input type="submit" name="postcomment" value="Σχολίασε" class="btn btn-primary" style="margin-left:20px;">
                                                <button type="button" class="btn btn-dark" onclick="history.go(-1);">Επιστροφή </button>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- // all comments --><!-- // all comments -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- // Page wrapper -->
                        <div class="col-md-4" style="margin-top:10px;">
                           <div class="post-sidebar">
                              <div class="card">
                                 <div class="card-header" style="background-color:#5383d3; color:white;">
                                    <h2>Θέματα</h2>
                                 </div>
                                 <div class="card-content">
                                    <?php foreach ($topics as $topic): ?>
                                    <a
                                       href="<?php echo 'filtered_posts.php?topic=' . $topic['id'] ?>">
                                    <?php echo $topic['name']; ?>
                                    </a>
                                    <?php endforeach ?>
                                 </div>
                              </div>
                              <button type="button" class="btn btn-dark" onclick="history.go(-1);">Επιστροφή </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- // content -->
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
      <!-- Javascripts -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="scripts.js"></script>
   </body>
</html>