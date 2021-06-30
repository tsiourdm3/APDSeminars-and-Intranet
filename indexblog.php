
<?php include('fuc.php'); ?>
<?php
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
   if (!isLoggedIn()) {
   $_SESSION['msg'] = "You must log in first";
   header('location: login.php');
   }				
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Blog | Αρχική </title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8" />
      <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="static/css/public_styling.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
         .form-control {
         border-radius: 7px;
         border: 1.5px solid #E3E6ED;
         }
         input.form-control:focus {
         box-shadow: none;
         border: 1.5px solid #E3E6ED;
         background-color: #F7F8FD;
         letter-spacing: 1px
         }
         .btn-primary {
         background-color: #5878FF !important;
         border-radius: 7px;
         }
         .btn-primary:focus {
         box-shadow: none;
         }
         .text {
         font-size: 13px;
         color: #9CA1A4;
         }
         @media screen and (max-width: 450px) {
         #1 {
         display:flex;
         justify-content: center;
         text-align: center;
         }
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
      <!-- Page content -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12" style="margin-top:20px;">
               <div class="card">
                  <div class="card-header" style="background-color:#5383d3; color:white;">
                     <h2 class="content-title" style="text-align:center;">Συζήτηση</h2>
                  </div>
                  <div class="col-sm-12" style="margin-top:30px;margin-left:20px;">
                     <form  style="tetx-align:center;" action="indexblog.php" method="post">
                        <div class="container d-flex justify-content-center">
                           <div class="card" style="border:none;width:100%;" id="1">
                              <div class="input-group sm-3" id="2">
                                 <input name="search" placeholder="Αναζήτηση συνομιλίας..." type="text" class="form-control">
                                 <div class="input-group-append" id="3"><button type="submit" name="submit-search" class="btn btn-primary"><i class="fas fa-search"></i></button></div>
                              </div>
                           </div>
                        </div>
                     </form>
                     <a href="post.php" role="button" class="btn btn-primary">Νέα Συζήτηση</a>
                     <button type="button" class="btn btn-dark" onclick="history.go(-1);" style="float:right;margin-right:30px;"> Επιστροφή </button>
                  </div>
                  <br><br>
                  <!-- more content still to come here ... -->
                  <!-- Add this ... -->
                  <div class="container-fluid" style="background-color:#A9B5FF">
                     <?php if(isset($_POST['submit-search'])){
                        $search = mysqli_real_escape_string($db, $_POST['search']);
                        $sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR body LIKE '%$search%'";
                        $result = mysqli_query($db,$sql);
                        $queryResult = mysqli_num_rows($result);
                        
                        echo "<h3 style='text-align:center;margin-top:10px;'>Βρέθηκαν " .$queryResult." αποτελέσματα!</h3>";
                        
                        if($queryResult > 0){
                        	while($row= mysqli_fetch_assoc($result)){
                        		$id = $row['id'];
                        		$title= $row['title'];
                        		$body = $row['body'];
                        		$topic_id = $row['topic_id'];
                        		$created_at = $row['created_at'];
                        		?>
                     <div class="col-sm-12" style="margin-top:20px;margin-bottom:20px;">
                        <div class="card">
                           <div class="card-header">
                              <?php if (isset($row['topic_id'])): ?>
                              <a href="<?php echo BASE_URL . 'filtered_posts.php?category=' . $row['topic_id']['id'] ?>" class="btn category" style="background-color:white;color:#3399FF; border:1px solid">
                              <?php echo getTopicNameById($topic_id)?>
                              </a>
                              <?php endif ?>
                              <h3 class="titles"><?php echo $row['title'] ?></h3>
                           </div>
                           <div class="card-body">
                              <p><?php echo $row['body'];?> </p>
                              <div class="info">
                                 <span><?php echo date('F j, Y ', strtotime($row['created_at'])); ?></span>
                                 <span style="float:right"><a href="single_post.php?id=<?php echo $row['id']; ?>">Περισσότερα..</a></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                        }
                        }else{
                        echo "<h2 style='text-align:center;color:red'>Δεν υπάρχουν αποτελέσματα για αυτή την αναζήτηση.</h2>";
                        }
                        }
                        ?>
                  </div>
                  <?php  
                     $posts_query = "SELECT * FROM posts";
                     $posts_result = mysqli_query($db, $posts_query);
                     if(mysqli_num_rows($posts_result) > 0){
                     while($posts = mysqli_fetch_assoc($posts_result)){
                     $id = $posts['id'];
                     $title= $posts['title'];
                     $body = $posts['body'];
                     $topic_id = $posts['topic_id'];
                     $created_at = $posts['created_at'];
                     
                     
                     ?>
                  <div class="col-sm-12" style="margin-top:20px;margin-bottom:20px;">
                     <div class="card">
                        <div class="card-header">
                           <?php if (isset($posts['topic_id'])): ?>
                           <a
                              href="<?php echo BASE_URL . 'filtered_posts.php?category=' . $posts['topic_id']['id'] ?>"
                              class="btn category" style="background-color:white;color:#3399FF; border:1px solid">
                           <?php echo getTopicNameById($topic_id)?>
                           </a>
                           <?php endif ?>
                           <h3 class="titles"><?php echo $posts['title'] ?></h3>
                        </div>
                        <div class="card-body">
                           <p><?php echo $body;?> </p>
                           <div class="info">
                              <span><?php echo date("F j, Y ", strtotime($posts["created_at"])); ?></span>
                              <span style="float:right"><a href="single_post.php?id=<?php echo $posts['id']; ?>">Περισσότερα..</a></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php
                     }
                     }
                     
                     
                     
                     ?>
               </div>
            </div>
         </div>
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
   </body>
</html>