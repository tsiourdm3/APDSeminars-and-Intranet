<?php
   include('fuc.php');
   header('Content-Type: text/html; charset=utf-8');
   if (!isLoggedIn()) {
   	$_SESSION['msg'] = "You must log in first";
   	header('location: login.php');
   }
   ?>
<?php include('filesLogic.php'); ?>
<!DOCTYPE html>
<html>
   <head>
      <script language="javascript" type="text/javascript">window.history.forward();</script>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="UTF-8">
      <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-8" style="margin-top:20px;">
               <div class="card">
                  <div class="card-header" style="background-color:#5383d3; color:white;">
                     Περιεχόμενο Σεμιναρίων
                  </div>
                  <div class="card-body">
                     <button class="accordion">Ιανουάριος</button>
                     <div class="panel">
                        <div>
                           <p>Καλωσορίσατε στο διαδικτυακό πρόγραμμα Διαταραχής Ακουστικής Επεξεργασίας.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία τα οποία θα χρειαστεί να χρησιμοποιήσετε για την διεκπεραίωση των υποχρεώσεων σας τον Ιανουάριο. Το online μάθημα μπορείτε να το βρείτε <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EWb6mdUZcw9KqL95WG5TECkB7kheA15nies7zihNwO-s5Q" target="_blank">εδώ</a> και η διάρκεια του είναι 2 ώρες και 27 λεπτά. Οι πληροφορίες που σας δίνονται στο μάθημα σας είναι απαραίτητες για την ορθή χρήση δοκιμασιών και προτείνεται η παρακολούθηση του πριν οποιαδήποτε εργασία και τεστ. </p>
                           <p>Τα αρχεία έχουν κατηγοριοποιηθεί με τον εξής τρόπο : Τα πρώτα τέσσερα αναφέρονται σε γενικές βασικές γνώσεις. Τα επόμενα 4 σχετίζονται με την Ομιλητική ακουομετρία σε ησυχία ενώ στην συνέχεια ακολουθούν 5 αρχεία για την Ομιλητική ακουομετρία σε θόρυβο,τελειώνοντας με 6 αρχεία για την Μνήμη αριθμών.</p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='1'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Φεβρουάριος</button>
                     <div class="panel">
                        <div>
                           <br><br>
                           <p>Την διάλεξη του Φεβρουαρίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EfkuSGQgzqFPmZlJIaYJftkB2CiqpY4OI6TQIdOpfwjv8Q?e=Lg3IN8" target="_blank">σύνδεσμο</a>.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Φεβρουάριο.</p>
                           <br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='2'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Μάρτιος</button>
                     <div class="panel">
                        <div>
                           <br><br>
                           <p>Την διάλεξη του Μαρτίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EW-8O8rKzwFLiKWrUKJSi6ABbWx5Lw42QF4WlH7SzlLIkw?e=fXb7dn" target="_blank">σύνδεσμο</a>.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Μάρτιο.</p>
                           <br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='4'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Απρίλιος</button>
                     <div class="panel">
                        <div>
                           <br><br>
                           <p>Την διάλεξη του Απριλίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EYc4iCd5fPBCu15lMxszKW0BMxjh2F3VspKcpiSQ6bYfUQ?e=5cbwfH" target="_blank">σύνδεσμο</a>.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Απρίλιο.</p>
                           <br><br><br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='5'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Μάϊος</button>
                     <div class="panel">
                        <div>
                           <br><br> 
                           <p>Την διάλεξη του μήνα Μαΐου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://aristotleuniversity-my.sharepoint.com/:v:/g/personal/viliad_office365_auth_gr/EfdyGZXd1DVEl6xexGqQwXIBRbuiq22LC84GWGVxm5eZSg?e=APydDM" target="_blank">σύνδεσμο</a>.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Μάιο.</p>
                           <br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='6'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Ιούνιος</button>
                     <div class="panel">
                        <div>
                           <br><br> 
                           <p>Την διάλεξη του μήνα Ιουνίου θα μπορέσετε να την παρακολουθήσετε online σε αυτό το <a href="https://www.dropbox.com/scl/fi/9cljgthlvh3rjv6uf8n1o/6.m4v?dl=0&oref=e&r=ABZOMhhDVRbIUu_fkWp5KRpTyUd-4_iiVM9jAqQcIy-hHZNMzqTPi6fGgvCik7P0nS0kDQnbcD40jcrt4qVL_8AnU6iM3W4YD_yWmsSgCu1CyVa8ATeS3GbGsC1hkopooMFJMNNit57Ri7P_PELETQFJNBf_lXUGxWfk8a5IhTIa5zH4ntNCyZng2BzL1iwVQA0&sm=1" target="_blank">σύνδεσμο</a>.</p>
                           <p>Παρακάτω θα βρείτε τα αρχεία για τον μήνα Ιουνίου.</p>
                           <br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='7'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Ιούλιος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='8'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Αύγουστος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='9'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Σεπτέμβριος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='10'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Οκτώβριος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='11'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Νοέμβριος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='12'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                     <button class="accordion">Δεκέμβριος</button>
                     <div class="panel">
                        <div>
                           <p></p>
                           <br><br><br>
                           <div class="container-fluid">
                              <?php 
                                 $com_query = "SELECT * FROM files WHERE month='13'";
                                 $coms_results = mysqli_query($db, $com_query) or die("error");
                                 if(mysqli_num_rows($coms_results)>0){
                                 	while($com = mysqli_fetch_assoc($coms_results)){ ?>
                              <ul>
                                 <li><?php echo $com['name']; ?><a href="index.php?file_id=<?php echo $com['id'] ?>" style="float:right"><i class="fas fa-download"></i></a></li>
                              </ul>
                              <?php	} } ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="card" style="margin-top:20px;">
                  <div class="card-header" style="color:white;background-color:#5383d3;">
                     Γενικές Πληροφορίες
                  </div>
                  <div class="card-body">
                     <p style="text-align:justify">Η διαδικτυακή πλατφόρμα Intra-Net προσφέρει στους χρήστες την δυνατότητα παρακολούθησης των σεμιναρίων για την 
                        Διαταραχή Ακουστικής Επεξεργασίας. Επιπλέον, τα quiz test και το blog δίνουν την ευκαιρία στον χρήστη για εξέταση 
                        των γνώσεων του και την σωστή ενημέρωση του. Για οποιοδήποτε πρόβλημα προκύψει κατά την χρήση του, παρακαλώ επικοινωνήστε με το email:<br>
                        <a href="mailto:misaaris@gmail.com">misaaris@gmail.com</a>
                     </p>
                  </div>
                  <div class="card">
                     <div class="card-header" style="color:white;background-color:#5383d3;">
                        Quiz Test
                     </div>
                     <div class="card-body">
                        <p style="text-align:justify">Το παρακάτω quiz είναι διαθέσιμο για όλους τους χρήστες και γίνεται ανανέωση κάθε μήνα, ανάλογα με την ύλη που έχει καλυφθεί.</p>
                        <a class="btn btn-primary" href="quiz/account.php?q=1" role="button">Δοκίμασε τις γνώσεις σου</a>
                     </div>
                     <div class="card" style="margin-top:12px;">
                        <div class="card-header" style="color:white;background-color:#5383d3;">
                           Ανακοινώσεις - Forum
                        </div>
                        <div class="card-body">
                           <p style="text-align:justify">Το Forum είναι ένας εύκολος και γρήγορος τρόπος για την ενημέρωση των χρηστών για θέματα που αφορούν τα σεμινάρια, καθώς και άλλα νέα
                              που αφορούν την κοινότητα μας. Μέσα από το forum οι χρήστες μπορούν να δημιουργούνε συνομιλίες και να σχολιάζουν σε αυτές. 
                           </p>
                           <a class="btn btn-primary" href="indexblog.php" role="button">Ενημερώσου</a>
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
               <a type="button" href="logout.php" name="logout">Αποσύνδεση</a>
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
   </body>
</html>