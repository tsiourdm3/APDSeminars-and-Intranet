<!DOCTYPE>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
      <link href="css/bootstrap-4-navbar.css" rel="stylesheet">
      <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="style.css">
      <title>Intra-Quiz</title>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
         crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
         crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
         crossorigin="anonymous"></script>
      <script src="js/bootstrap.min.js"  type="text/javascript"></script>
      <!-- javascript link file name  -->
      <script src="/admin/js/bootstrap-4-navbar.js"></script>
      <!--<!—- ShareThis BEGIN -—>
         <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f6b422686d2b30012e17629&product=sticky-share-buttons" async="async"></script>
         <!—- ShareThis END -—>-->
   </head>
   <style>
      body{
      background-color: #eee;
      font: 13px "Century Gothic", "Times Roman", sans-serif;
      }
      li a{
      margin-left:50px;
      color:white;
      }
      .panel{border-color:#eee;margin:40px;padding:20px;font: 15px "Century Gothic", "Times Roman", sans-serif;}
      @media
      only screen 
      and (max-width: 760px), (min-device-width: 768px) 
      and (max-device-width: 1024px)  {
      /* Force table to not be like tables anymore */
      table, thead, tbody, th, td, tr {
      display: block;
      }
      /* Hide table headers (but not display: none;, for accessibility) */
      thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
      }
      tr {
      margin: 0 0 1rem 0;
      }
      tr:nth-child(odd) {
      background: #ccc;
      }
      td {
      /* Behave  like a "row" */
      border: none;
      border-bottom: 1px solid #eee;
      position: relative;
      padding-left: 50%;
      }
      td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 0;
      left: 6px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap;
      }
   </style>
   <body>
      <div class="container-fullwidth">
         <?php
            include('fuc.php');
            if (!isAdmin()) {
            $_SESSION['msg'] = "You must log in first";
            header('location: ../login.php');
            }
            	
            if (!(isset($_SESSION['username']))  || ($_SESSION['key']) != '54585c506829293a2d4c3b68543b316e2e7a2d277858545a36362e5f39') {
                session_destroy();
                header("location:logout.php");
            } else {
                $username = $_SESSION['username'];
            }
            ?>
         <!-- Static navbar -->
         <nav class="navbar navbar-expand-md navbar-light navbar-custom">
            <a class="navbar-brand" href="adminquiz.php">
               <h3 class="logo">Intra<span id="one">-</span><span>Quiz</span></h3>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
               <ul class="navbar-nav mr-auto">
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 0)
                        echo 'class="active"';
                     ?>><a href="adminquiz.php?q=0"><span aria-hidden="true"><i class="fas fa-home">&nbsp;Home</i></span><span class="sr-only">(current)</span></a></li>
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 1)
                         echo 'class="active"';
                     ?>><a href="adminquiz.php?q=1"><span aria-hidden="true"><i class="fas fa-user"></i>&nbsp;Users</span></a></li>
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 2)
                        echo 'class="active"';
                     ?>><a href="adminquiz.php?q=2"><span aria-hidden="true"><i class="fas fa-chart-bar"></i></span>&nbsp;Leaderboard</a></li>
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 4)
                            echo 'class="active"';
                     ?>><a href="adminquiz.php?q=4"><span aria-hidden="true"><i class="fas fa-plus"></i>&nbsp;Add Quiz</span></a></li>
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 5)
                            echo 'class="active"';
                     ?>><a href="adminquiz.php?q=5"><span aria-hidden="true"><i class="fas fa-trash"></i>&nbsp;Remove Quiz</span></a></li>
                  <li class="nav-item" <?php
                     if (@$_GET['q'] == 6)
                            echo 'class="active"';
                     ?>><a href="dashboard.php"><span aria-hidden="true"><i class="fas fa-door-open"></i></span>&nbsp;Έξοδος</a></li>
               </ul>
            </div>
         </nav>
         <div class="container" style="margin-top:30px;background-color:white;">
            <div class="row">
               <div class="col-md-12">
                  <?php
                     if (@$_GET['q'] == 0) {
                         
                         $result = mysqli_query($db, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                         echo '<div class="panel"><h2 style="text-align:center;">Quiz List</h2><table class="table table-striped title1"  style="vertical-align:middle;margin-top:30px;">
                     <tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Name</b></td><td style="vertical-align:middle"><b>Total question</b></td><td style="vertical-align:middle"><b>Marks</b></td><td style="vertical-align:middle"><b>Time limit</b></td><td style="vertical-align:middle"><b>Status</b></td><td style="vertical-align:middle"><b>Action</b></td></tr>';
                         $c = 1;
                         while ($row = mysqli_fetch_array($result)) {
                             $title   = $row['title'];
                             $total   = $row['total'];
                             $correct = $row['correct'];
                             $time    = $row['time'];
                             $eid     = $row['eid'];
                             $status  = $row['status'];
                             if ($status == "enabled") {
                                 echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td><td style="vertical-align:middle">Enabled</td>
                       <td style="vertical-align:middle"><b><a href="update.php?deidquiz=' . $eid . '" class="btn logb" style="color:#FFFFFF;background:#ff0000;font-size:12px;padding:5px;">&nbsp;<span><b>Disable</b></span></a></b></td></tr>';
                             } else {
                                 echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td><td style="vertical-align:middle">Disabled</td>
                       <td style="vertical-align:middle"><b><a href="update.php?eeidquiz=' . $eid . '" class="btn logb" style="color:#FFFFFF;background:darkgreen;font-size:12px;padding:5px;">&nbsp;<span><b>Enable </b></span></a></b></td></tr>';
                                 
                             }
                         }
                     }
                     if (@$_GET['q'] == 2) {
                         if(isset($_GET['show'])){
                             $show = $_GET['show'];
                             $showfrom = (($show-1)*10) + 1;
                             $showtill = $showfrom + 9;
                         }
                         else{
                             $show = 1;
                             $showfrom = 1;
                             $showtill = 10;
                         }
                         $q = mysqli_query($db, "SELECT * FROM rank") or die('Error223');
                         echo '<div class="panel">
                     <table class="table table-striped title1" >
                     <tr><td style="vertical-align:middle"><b>Rank</b></td><td style="vertical-align:middle"><b>Name</b></td><td style="vertical-align:middle"><b>Username</b></td><td style="vertical-align:middle"><b>Email</b></td><td style="vertical-align:middle"><b>Score</b></td><td style="vertical-align:middle"></td></tr>';
                         $c = $showfrom-1;
                         $total = mysqli_num_rows($q);
                         if($total >= $showfrom){
                             $q = mysqli_query($db, "SELECT * FROM rank ORDER BY score DESC, time ASC LIMIT ".($showfrom-1).",10") or die('Error223');
                             while ($row = mysqli_fetch_array($q)) {
                                 $e = $row['username'];
                                 $s = $row['score'];
                                 $q12 = mysqli_query($db, "SELECT * FROM users WHERE username='$e' ") or die('Error231');
                                 while ($row = mysqli_fetch_array($q12)) {
                                     $username     = $row['username'];
                                     $first_name  = $row['first_name'];
                                     $username = $row['username'];
                                     $email   = $row['email'];
                                     
                                 }
                                 $c++;
                                 echo '<tr><td style="color:#99cc32"><b>' . $c . '</b></td><td style="vertical-align:middle">' . $first_name . '</td><td style="vertical-align:middle">' . $username . '</td><td style="vertical-align:middle">' . $email . '</td><td style="vertical-align:middle">' . $s . '</td><td style="vertical-align:middle">';
                             }
                         }
                         else{
                         }
                         echo '</table></div>';
                         echo '<div class="panel"><table class="table table-striped title1" ><tr>';
                         $total = round($total/10) + 1;
                         if(isset($_GET['show'])){
                             $show = $_GET['show'];
                         }
                         else{
                             $show = 1;
                         }
                         if($show == 1 && $total==1){
                         }
                         else if($show == 1 && $total!=1){
                             $i = 1;
                             while($i<=$total){
                                 echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
                                 $i++;
                             }
                             echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.($show+1).'">&nbsp;>>&nbsp;</a></td>';
                         }
                         else if($show != 1 && $show==$total){
                             echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.($show-1).'">&nbsp;<<&nbsp;</a></td>';
                     
                             $i = 1;
                             while($i<=$total){
                                 echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
                                 $i++;
                             }
                         }
                         else{
                             echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.($show-1).'">&nbsp;<<&nbsp;</a></td>';
                             $i = 1;
                             while($i<=$total){
                                 echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
                                 $i++;
                             }
                             echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="adminquiz.php?q=2&show='.($show+1).'">&nbsp;>>&nbsp;</a></td>';
                         }
                         echo '</tr></table></div>';
                     }
                     if (@$_GET['q'] == 1) {
                         
                         $result = mysqli_query($db, "SELECT * FROM users") or die('Error');
                         echo '<div class="panel"><table class="table table-striped title1" style="margin-top:20px;"><h2 style="text-align:center;">Χρήστες</h2>
                     <tr><td style="vertical-align:middle"><b>No.</b></td><td style="vertical-align:middle"><b>First Name</b></td><td style="vertical-align:middle"><b>Last Name</b></td><td style="vertical-align:middle"><b>Email</b></td><td style="vertical-align:middle"><b>User Type</b></td><td style="vertical-align:middle"><b>Username</b></td><td style="vertical-align:middle"></td></tr>';
                         $c = 1;
                         while ($row = mysqli_fetch_array($result)) {
                             $first_name     = $row['first_name'];
                             $last_name      = $row['last_name'];
                             $email    = $row['email'];
                             $user_type    = $row['user_type'];
                             $username1 = $row['username'];
                             
                             echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $first_name . '</td><td style="vertical-align:middle">' . $last_name . '</td><td style="vertical-align:middle">' . $email . '</td><td style="vertical-align:middle">' . $user_type . '</td><td style="vertical-align:middle">' . $username1 . '</td>
                       <td style="vertical-align:middle"><a title="Delete User" href="update.php?dusername=' . $username1 . '"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
                         }
                         $c = 0;
                         echo '</table></div>';
                         
                     }
                     if (@$_GET['q'] == 3) {
                         $result = mysqli_query($db, "SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
                         echo '<div class="panel"><table class="table table-striped title1">
                     <tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Subject</b></td><td style="vertical-align:middle"><b>Username</b></td><td style="vertical-align:middle"><b>Date</b></td><td style="vertical-align:middle"><b>Time</b></td><td style="vertical-align:middle"><b>By</b></td><td style="vertical-align:middle"></td><td style="vertical-align:middle"><b>Action</b></td></tr>';
                         $c = 1;
                         while ($row = mysqli_fetch_array($result)) {
                             $date      = $row['date'];
                             $date      = date("d-m-Y", strtotime($date));
                             $time      = $row['time'];
                             $subject   = $row['subject'];
                             $name      = $row['name'];
                             $username1 = $row['username'];
                             $id        = $row['id'];
                             echo '<tr><td style="vertical-align:middle">' . $c++ . '</td>';
                             echo '<td style="vertical-align:middle"><a title="Click to open feedback" href="dash.php?q=3&fid=' . $id . '">' . $subject . '</a></td><td style="vertical-align:middle">' . $username1 . '</td><td style="vertical-align:middle">' . $date . '</td><td style="vertical-align:middle">' . $time . '</td><td style="vertical-align:middle">' . $name . '</td>
                       <td style="vertical-align:middle"><a title="Open Feedback" href="dash.php?q=3&fid=' . $id . '"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
                             echo '<td style="vertical-align:middle"><a title="Delete Feedback" href="update.php?fdid=' . $id . '"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td>
                     
                       </tr>';
                         }
                         echo '</table></div>';
                     }
                     if (@$_GET['fid']) {
                         echo '<br />';
                         $id = @$_GET['fid'];
                         $result = mysqli_query($db, "SELECT * FROM feedback WHERE id='$id' ") or die('Error');
                         while ($row = mysqli_fetch_array($result)) {
                             $name     = $row['name'];
                             $subject  = $row['subject'];
                             $date     = $row['date'];
                             $date     = date("d-m-Y", strtotime($date));
                             $time     = $row['time'];
                             $feedback = $row['feedback'];
                             
                             echo '<div class="panel"<a title="Back to Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Ubuntu", sans-serif;"><b>' . $subject . '</b></h1>';
                             echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;' . $date . '</span>
                     <span style="line-height:35px;padding:5px;">&nbsp;<b>Time:</b>&nbsp;' . $time . '</span><span style="line-height:35px;padding:5px;">&nbsp;<b>By:</b>&nbsp;' . $name . '</span><br />' . $feedback . '</div></div>';
                         }
                     }
                     if (@$_GET['q'] == 4 && !(@$_GET['step'])) {
                         echo ' 
                     <div class="row">
                     <div class="col-sm-8">
                     <h2 style="margin-left:18px;margin-top:10px;"><b>Enter Quiz Details</b></h2><br /><br />
                        <form class="form-horizontal" name="form" action="update.php?q=addquiz"  method="POST">
                     <fieldset>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="name"></label>  
                       <div class="col-md-12">
                       <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="total"></label>  
                       <div class="col-md-12">
                       <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="right"></label>  
                       <div class="col-md-12">
                       <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="wrong"></label>  
                       <div class="col-md-12">
                       <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="time"></label>  
                       <div class="col-md-12">
                       <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
                         
                       </div>
                     </div>
                     
                     
                     <div class="form-group">
                       <label class="col-md-12 control-label" for=""></label>
                       <div class="col-md-12"> 
                         <input  type="submit" style="" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                       </div>
                     </div>
                     
                     </fieldset>
                     </form></div>';
                         
                         
                         
                     }
                     if (@$_GET['q'] == 4 && (@$_GET['step']) == 2) {
                         echo ' 
                     <div class="row">
                     <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
                      <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4 "  method="POST">
                     <fieldset>
                     ';
                         
                         for ($i = 1; $i <= @$_GET['n']; $i++) {
                             echo '<b>Question number&nbsp;' . $i . '&nbsp;:</><br /><!-- Text input-->
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
                       <div class="col-md-12">
                       <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>  
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="' . $i . '1"></label>  
                       <div class="col-md-12">
                       <input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="' . $i . '2"></label>  
                       <div class="col-md-12">
                       <input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="' . $i . '3"></label>  
                       <div class="col-md-12">
                       <input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text">
                         
                       </div>
                     </div>
                     <div class="form-group">
                       <label class="col-md-12 control-label" for="' . $i . '4"></label>  
                       <div class="col-md-12">
                       <input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text">
                         
                       </div>
                     </div>
                     <br />
                     <b>Correct answer</b>:<br />
                     <select id="ans' . $i . '" name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
                        <option value="a">Select answer for question ' . $i . '</option>
                       <option value="a">option a</option>
                       <option value="b">option b</option>
                       <option value="c">option c</option>
                       <option value="d">option d</option> </select><br /><br />';
                         }
                         
                         echo '<div class="form-group">
                       <label class="col-md-12 control-label" for=""></label>
                       <div class="col-md-12"> 
                         <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                       </div>
                     </div>
                     
                     </fieldset>
                     </form></div>';
                         
                         
                         
                     }
                     if (@$_GET['q'] == 5) {
                         
                         $result = mysqli_query($db, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                         echo '<div class="panel"><table class="table table-striped title1">
                     <tr><td style="vertical-align:middle"><b>S.N.</b></td><td style="vertical-align:middle"><b>Topic</b></td><td style="vertical-align:middle"><b>Total question</b></td><td style="vertical-align:middle"><b>Marks</b></td><td style="vertical-align:middle"><b>Time limit</b></td><td style="vertical-align:middle"><b>Action</b></td></tr>';
                         $c = 1;
                         while ($row = mysqli_fetch_array($result)) {
                             $title   = $row['title'];
                             $total   = $row['total'];
                             $correct = $row['correct'];
                             $time    = $row['time'];
                             $eid     = $row['eid'];
                             echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
                       <td style="vertical-align:middle"><b><a href="update.php?q=rmquiz&eid=' . $eid . '" class="btn" style="margin:0px;background:red;color:white"><span class="title1"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;<b>Remove</b></span></a></b></td></tr>';
                         }
                         $c = 0;
                         echo '</table></div>';
                         
                     }
                     ?>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>