<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="favicon.ico" type="image/icon" sizes="16x16">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Intra-Quiz</title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
 
  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<?php
if (@$_GET['w']) {
    echo '<script>alert("' . @$_GET['w'] . '");</script>';
}
?>

</head>
	<style>
	@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

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
	
	tr { border: 1px solid #ccc; }
	
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
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
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
<?php
include_once 'dbConnection.php';
?>
	<?php
include_once 'dbConnection.php';
session_start();
if (!(isset($_SESSION['username']))) {
    header("location:index.php");
} else {
    
    $username = $_SESSION['username'];
    
    
}
?>
<body>

	 
<div class="container-fullwidth">
<nav class="navbar navbar-expand-sm navbar-default">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Intra-Quiz</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php
if (@$_GET['q'] == 1)
    echo 'class="active"';
?> ><a href="account.php?q=1"><span aria-hidden="true"><i class="fas fa-home"></i></span>&nbsp;Αρχική<span class="sr-only">(current)</span></a></li>
        <li <?php
if (@$_GET['q'] == 2)
    echo 'class="active"';
?>><a href="account.php?q=2"><span aria-hidden="true"><i class="fas fa-history"></i></span>&nbsp;Ιστορικό</a></li>
    <li <?php
if (@$_GET['q'] == 3)
    echo 'class="active"';
?>><a href="account.php?q=3"><span aria-hidden="true"><i class="fas fa-chart-bar"></i></span>&nbsp;Βαθμολογίες</a></li>
		  <li <?php
if (@$_GET['q'] == 4)
    echo 'class="active"';
?>><a href="../index.php"><span aria-hidden="true"><i class="fas fa-door-open"></i></span>&nbsp;Έξοδος</a></li>
		</ul>
            
      </div>
</nav>
<div class="container">
<div class="row">
<div class="col-md-12">
<?php
if (@$_GET['q'] == 1) {
    
    $result = mysqli_query($con, "SELECT * FROM quiz WHERE status = 'enabled' ORDER BY date DESC") or die('Error');
    echo '<div class="panel"><h2 style="text-align:center;">Quiz</h2><table class="table table-striped title1"  style="vertical-align:middle;margin-top:20px;">
<tr><td style="vertical-align:middle"><b>Nο.</b></td><td style="vertical-align:middle"><b>Μήνας</b></td><td style="vertical-align:middle"><b>Σύνολο Ερωτήσεων</b></td><td style="vertical-align:middle"><b>Σωστές Απαντήσεις</b></td><td style="vertical-align:middle"><b>Λάθος Απαντήσεις</b></td><td style="vertical-align:middle"><b>Σύνολο Βαθμών</b></td><td style="vertical-align:middle"><b>Διαθέσιμος Χρόνος</b></td><td style="vertical-align:middle"><b>Ενέργεια</b></td></tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title   = $row['title'];
        $total   = $row['total'];
        $correct = $row['correct'];
        $wrong   = $row['wrong'];
        $time    = $row['time'];
        $eid     = $row['eid'];
        $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND username='$username'") or die('Error98');
        $rowcount = mysqli_num_rows($q12);
        if ($rowcount == 0) {
            echo '<tr><td style="vertical-align:middle;">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
  <td style="vertical-align:middle"><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="color:#FFFFFF;background:darkgreen;font-size:13px;"><span aria-hidden="true"><i class="far fa-file"></i></span>&nbsp;<span>&nbsp;&nbsp;&nbsp;<b>Πάμε !</b></span></a></b></td></tr>';
        } else {
            $q = mysqli_query($con, "SELECT * FROM history WHERE username='$_SESSION[username]' AND eid='$eid' ") or die('Error197');
            while ($row = mysqli_fetch_array($q)) {
                $timec  = $row['timestamp'];
                $status = $row['status'];
            }
            $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error197');
            while ($row = mysqli_fetch_array($q)) {
                $ttimec  = $row['time'];
                $qstatus = $row['status'];
            }
            $remaining = (($ttimec * 60) - ((time() - $timec)));
            if ($remaining > 0 && $qstatus == "enabled" && $status == "ongoing") {
                echo '<tr style="color:darkgreen"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '&nbsp;<span title="This quiz is already solve by you" aria-hidden="true"><i class="fas fa-check"></i></span></td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
  <td style="vertical-align:middle"><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="margin:0px;background:darkorange;color:white">&nbsp;<span class="title1"><b>Συνέχεια</b></span></a></b></td></tr>';
            } else {
                echo '<tr style="color:darkgreen"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle">' . $title . '&nbsp;<span title="This quiz is already solve by you" aria-hidden="true"><i class="fas fa-check"></i></span></td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">+' . $correct . '</td><td style="vertical-align:middle">-' . $wrong . '</td><td style="vertical-align:middle">' . $correct * $total . '</td><td style="vertical-align:middle">' . $time . '&nbsp;min</td>
  <td style="vertical-align:middle"><b><a href="account.php?q=result&eid=' . $eid . '" class="btn" style="margin:0px;background:darkred;color:white">&nbsp;<span class="title1"><b>Αποτελέσματα</b></span></a></b></td></tr>';
            }
        }
    }
    $c = 0;
    echo '</table></div><div class="panel" style="text-align:left;background-color:white;"><h3 align="center">Οδηγίες για την χρήση του Quiz</h3><br /><ul type="circle"><font style="font-size:16px;font-family:calibri"><li><p>Μπορείτε να αρχίσετε το quiz όποτε θέλετε. Το χρονόμετρο θα αρχίσει να μετρά από την στιγμή που θα ξεκινήσετε το quiz. Ωστόσο ο διαχειριστής του συστήματος μπορεί οποιαδήποτε στιγμή να απενεργοποιήσει το quiz με αποτέλεσμα να μην είναι διαθέσιμο σους χρήστες.</p></li><li><p>Μπορείτε να δείτε την πορεία που πραγματοποιήσατε και τα αποτελέσματα σας για το συγκεκριμένο quiz στο "History".</p></li><li><p>Για να αρχίστε το quiz, πιέστε το κουμπί "Πάμε!".</p></li><li><p>Εφόσον έχετε αρχίσει το quiz προτείνετε να μην κάνετε αποσύνδεση μέχρι την απάντηση όλων των ερωτήσεων για λόγους ασφαλείας και διατήρησης των αποτελεσμάτων του quiz.</p></li><li><p>Για να απαντήσετε σε μια ερώτηση θα πρέπει να πιέσετε το κουμπί "Lock", σφραγίζοντας την απάντηση και δημιουργώντας πράσινο φόντο στην ερώτηση.</p></li><li><p>Για την διαγραφή μίας απάντησης πιέστε το κουμπί <span style="color:red:font-size:12px">&nbsp;<i class="fas fa-trash"></i></span>.</p></li><li><p>Εφόσον έχετε επιλέξει μια απάντηση, πατώντας τα βελάκια θα έχετε την δυνατότητα να μεταβείτε σε παλιές και νέες ερωτήσεις του quiz με τα βελάκια.</p></li><li><p>Οι βαθμοί για σωστές και λάθος απαντήσεις βρίσκονται παραπάνω. Μηδέν βαθμοί θα δοθούν για μια ερώτηση η οποία δεν έχει απαντηθεί (μη πατώντας το λοκ ή μην επιλογή απάντησης).</p></li><li><p>Εάν προκύψει κάποιο σφάλμα παρακαλώ αποστείλετε email στο <a href="mailto:misaaris@gmail.com">misaaris@gmail.com</a></p></li></lu></font></div>';
}
?>
<?php
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['6e447159425d2d']) && $_SESSION['6e447159425d2d'] == "6e447159425d2d" && isset($_GET['endquiz'])== 'end') {
    unset($_SESSION['6e447159425d2d']);
    $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$_GET[eid]' AND username='$_SESSION[username]'") or die('Error156');
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $scorestatus = $row['score_updated'];
                }
                 if($scorestatus=="false"){
                    $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE username='$username'") or die('Error161');
                    $rowcount = mysqli_num_rows($q);
                    if ($rowcount == 0) {
                        $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$username','$s',NOW())") or die('Error165');
                    } else {
                        while ($row = mysqli_fetch_array($q)) {
                            $sun = $row['score'];
                        }
                        
                        $sun = $s + $sun;
                        $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE username= '$username'") or die('Error174');
                    }
                }
            header('location:account.php?q=result&eid=' . $_GET[eid]);
}

if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_GET['start']) && $_GET['start'] == "start" && (!isset($_SESSION['6e447159425d2d']))) {
    $q = mysqli_query($con, "SELECT * FROM history WHERE username='$username' AND eid='$_GET[eid]' ") or die('Error197');
    
    if (mysqli_num_rows($q) > 0) {
        $q = mysqli_query($con, "SELECT * FROM history WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $timel  = $row['timestamp'];
            $status = $row['status'];
        }
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$_GET[eid]' ") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $ttimel  = $row['time'];
            $qstatus = $row['status'];
        }
        $remaining = (($ttimel * 60) - ((time() - $timel)));
        if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
            $_SESSION['6e447159425d2d'] = "6e447159425d2d";
            header('location:account.php?q=quiz&step=2&eid=' . $_GET[eid] . '&n=' . $_GET[n] . '&t=' . $_GET[t]);
            
        } else {
                $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$_GET[eid]' AND username='$_SESSION[username]'") or die('Error156');
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $scorestatus = $row['score_updated'];
                }
                 if($scorestatus=="false"){
                    $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE username='$username'") or die('Error161');
                    $rowcount = mysqli_num_rows($q);
                    if ($rowcount == 0) {
                        $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$username','$s',NOW())") or die('Error165');
                    } else {
                        while ($row = mysqli_fetch_array($q)) {
                            $sun = $row['score'];
                        }
                        
                        $sun = $s + $sun;
                        $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE username= '$username'") or die('Error174');
                    }
                }
            header('location:account.php?q=result&eid=' . $_GET[eid]);
        }
        
    } else {
        $time = time();
        $q = mysqli_query($con, "INSERT INTO history VALUES(NULL,'$username','$_GET[eid]' ,'0','0','0','0',NOW(),'$time','ongoing','false')") or die('Error137');
        $_SESSION['6e447159425d2d'] = "6e447159425d2d";
        header('location:account.php?q=quiz&step=2&eid=' . $_GET["eid"] . '&n=' . $_GET["n"] . '&t=' . $_GET["t"]);
    }
}


if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2 && isset($_SESSION['6e447159425d2d']) && $_SESSION['6e447159425d2d'] == "6e447159425d2d") {
    $q = mysqli_query($con, "SELECT * FROM history WHERE username='$username' AND eid='$_GET[eid]' ") or die('Error197');
    
    if (mysqli_num_rows($q) > 0) {
        $q = mysqli_query($con, "SELECT * FROM history WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $time   = $row['timestamp'];
            $status = $row['status'];
        }
        $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$_GET[eid]' ") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $ttime   = $row['time'];
            $qstatus = $row['status'];
        }
        $remaining = (($ttime * 60) - ((time() - $time)));
        if ($status == "ongoing" && $remaining > 0 && $qstatus == "enabled") {
            $q = mysqli_query($con, "SELECT * FROM history WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
            while ($row = mysqli_fetch_array($q)) {
                $time = $row['timestamp'];
            }
            $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$_GET[eid]' ") or die('Error197');
            while ($row = mysqli_fetch_array($q)) {
                $ttime = $row['time'];
            }
            $remaining = (($ttime * 60) - ((time() - $time)));
            echo '<script>
var seconds = ' . $remaining . ' ;
function end(){
  data = prompt("Είστε σίγουρος/η ότι θέλετε να τερματίσεται το quiz? Εάν επιλέξετε να τελείωσεται εδώ, θα πρέπει να γνωρίζεται ότι το quiz δεν γίνεται να το επαναλάβεται και τα αποτελέσματα σας θα αποθηκευτούν. Αν συμφωνείται με τα παραπάνω, παρακαλώ γράψτε \\"yes\\" και πιέστε enter. Σε περίπτωση που δεν γράψεται τίποτα το quiz τερματίζεται αυτόματα με την λήξη του χρόνου.");
  if(data=="yes"){
    window.location ="account.php?q=quiz&step=2&eid=' . $_GET["eid"] . '&n=' . $_GET["n"] . '&t=' . isset($_GET["total"]) . '&endquiz=end";
  }
}
function enable(){
  document.getElementById("sbutton").removeAttribute("disabled");

}
function frmreset(){
  document.getElementById("sbutton").setAttribute("disabled","true");
  document.getElementById("qform").reset();
}
    function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById(\'countdown\').innerHTML = minutes + ":" +    remainingSeconds;
    if (seconds <= 0) {
        clearInterval(countdownTimer);
        document.getElementById(\'countdown\').innerHTML = "Buzz Buzz...";
        window.location ="account.php?q=quiz&step=2&eid=' . $_GET["eid"] . '&n=' . $_GET["n"] . '&t=' . isset($_GET["total"]) . '&endquiz=end";
    } else {    
        seconds--;
    }
    }
var countdownTimer = setInterval(\'secondPassed()\', 1000);
</script>';
            echo '<font size="3" style="margin-left:100px;font-family:\'typo\' font-size:20px; font-weight:bold;color:darkred">Time Left : </font><span class="timer btn btn-default" style="margin-left:20px;"><font style="font-family:\'typo\';font-size:20px;font-weight:bold;color:darkblue" id="countdown"></font></span><span class="timer btn btn-primary" style="margin-left:50px" onclick="end()"><span><i class="fas fa-power-off"></i></span>&nbsp;&nbsp;<font style="font-size:12px;font-weight:bold">Finish Quiz</font></span>';
            $eid   = @$_GET['eid'];
            $sn    = @$_GET['n'];
            $total = @$_GET['t'];
            $q     = mysqli_query($con, "SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' ");
            echo '<div class="panel" style="margin-right:5%;margin-left:5%;margin-top:10px;border-radius:10px">';
            while ($row = mysqli_fetch_array($q)) {
                $qns = stripslashes($row['qns']);
                $qid = $row['qid'];
                echo '<b><div style="background-color:white"><div style="text-align:left;font-size:20px;font-weight:bold;font-family:calibri;margin:10px">' . $sn . ' : ' . $qns . '</div></div></b>';
            }
            
            echo '<form id="qform" action="update.php?q=quiz&step=2&eid=' . $eid . '&n=' . $sn . '&t=' . $total . '&qid=' . $qid . '" method="POST"  class="form-horizontal">
<br />';
            $q = mysqli_query($con, "SELECT * FROM user_answer WHERE qid='$qid' AND username='$_SESSION[username]' AND eid='$_GET[eid]'") or die("Error222");
            if (mysqli_num_rows($q) > 0) {
                $row = mysqli_fetch_array($q);
                $ans = $row['ans'];
                $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' AND optionid='$ans'") or die("Error222");
                $row = mysqli_fetch_array($q);
                $ans = $row['option'];
            } else {
                $ans = "";
            }
            if (strlen($ans) > 0) {
                echo "<font style=\"color:green;font-size:12px;font-weight:bold\">Επιλέξατε: </font><font style=\"color:#565252;font-size:12px;\">" . $ans . "</font>&nbsp;&nbsp;<a href=update.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total&qid=$qid&delanswer=delanswer><span style=\"font-size:12px;color:darkred\"><i class=\"fas fa-trash\"></i></span></a><br /><br />";
            }
            echo '<div class="funkyradio">';
            $q = mysqli_query($con, "SELECT * FROM options WHERE qid='$qid' ");
            while ($row = mysqli_fetch_array($q)) {
                $option   = stripslashes($row['option']);
                $optionid = $row['optionid'];
                echo '<div class="funkyradio-success"><input type="radio" id="' . $optionid . '" name="ans" value="' . $optionid . '" onclick="enable()"><label for="' . $optionid . '" style="width:100%"><div style="color:black;font:arial;font-size:12px;margin-left:42px;word-wrap: break-word">' . $option . '</div></label></div>';
            }
            echo '</div>';
            if ($_GET["t"] > $_GET["n"] && $_GET["n"] != 1) {
                echo '<br /><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn - 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span  aria-hidden="true"  style="font-size:12px"><i class="fas fa-arrow-left"></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span style="font-size:12px" aria-hidden="true"><i class="fas fa-lock"></i></span><font style="font-size:12px;font-weight:bold"> Lock</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn + 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span aria-hidden="true"  style="font-size:12px"><i class="fas fa-arrow-right"></i></span></a></form><br><br>';
            } else if ($_GET["t"] == $_GET["n"]) {
                echo '<br /><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn - 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span  aria-hidden="true"  style="font-size:12px"><i class="fas fa-arrow-left"></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span style="font-size:12px" aria-hidden="true"><i class="fas fa-lock"></i></span><font style="font-size:12px;font-weight:bold"> Lock</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;</form><br><br>';
            } else if ($_GET["t"] > $_GET["n"] && $_GET["n"] == 1) {
                echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-default" disabled="true" id="sbutton" style="height:30px"><span style="font-size:12px" aria-hidden="true"><i class="fas fa-lock"></i></span><font style="font-size:12px;font-weight:bold"> Lock<font></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="frmreset()" style="height:30px"></span><font style="font-size:12px;font-weight:bold">Reset</font></button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . ($sn + 1) . '&t=' . $total . '" class="btn btn-primary" style="height:30px"><span aria-hidden="true"  style="font-size:12px"><i class="fas fa-arrow-right"></i></span></a></form><br><br>';
            } else {
            }
            echo '</div>';
            echo '<div class="panel" style="text-align:center">';
            $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$_GET[eid]'") or die("Error222");
            $i = 1;
            while ($row = mysqli_fetch_array($q)) {
                $ques[$row['qid']] = $i;
                $i++;
            }
            $q = mysqli_query($con, "SELECT * FROM user_answer WHERE eid='$_GET[eid]' AND username='$_SESSION[username]'") or die("Error222a");
            $i = 1;
            while ($row = mysqli_fetch_array($q)) {
                if (isset($ques[$row['qid']])) {
                    $quesans[$ques[$row['qid']]] = true;
                }
            }
            for ($i = 1; $i <= $total; $i++) {
                echo '<a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=' . $i . '&t=' . $total . '"  style="margin:5px;padding:5px;background-color:';
                if ($quesans[$i]) {
                    echo "darkgreen";
                } else {
                    echo "darkred";
                }
                echo ';color:white;font-size:16px;font-family:calibri;border-radius:4px">&nbsp;' . $i . '&nbsp;</a>';
            }
        } else {
            unset($_SESSION['6e447159425d2d']);
            $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$_GET[eid]' AND username='$_SESSION[username]'") or die('Error156');
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $scorestatus = $row['score_updated'];
                }
                 if($scorestatus=="false"){
                    $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE username='$username'") or die('Error161');
                    $rowcount = mysqli_num_rows($q);
                    if ($rowcount == 0) {
                        $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$username','$s',NOW())") or die('Error165');
                    } else {
                        while ($row = mysqli_fetch_array($q)) {
                            $sun = $row['score'];
                        }
                        
                        $sun = $s + $sun;
                        $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE username= '$username'") or die('Error174');
                    }
                }
            header('location:account.php?q=result&eid=' . $_GET[eid]);
        }
    } else {
        unset($_SESSION['6e447159425d2d']);
        $q = mysqli_query($con, "UPDATE history SET status='finished' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
        $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$_GET[eid]' AND username='$_SESSION[username]'") or die('Error156');
                while ($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $scorestatus = $row['score_updated'];
                }
                if($scorestatus=="false"){
                    $q = mysqli_query($con, "UPDATE history SET score_updated='true' WHERE username='$_SESSION[username]' AND eid='$_GET[eid]' ") or die('Error197');
                    $q = mysqli_query($con, "SELECT * FROM rank WHERE username='$username'") or die('Error161');
                    $rowcount = mysqli_num_rows($q);
                    if ($rowcount == 0) {
                        $q2 = mysqli_query($con, "INSERT INTO rank VALUES(NULL,'$username','$s',NOW())") or die('Error165');
                    } else {
                        while ($row = mysqli_fetch_array($q)) {
                            $sun = $row['score'];
                        }
                        
                        $sun = $s + $sun;
                        $q = mysqli_query($con, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE username= '$username'") or die('Error174');
                    }
                }
            header('location:account.php?q=result&eid=' . $_GET[eid]);
    }
}
if (@$_GET['q'] == 'result' && @$_GET['eid']) {
    $eid = @$_GET['eid'];
    $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error157');
    while ($row = mysqli_fetch_array($q)) {
        $total = $row['total'];
    }
    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND username='$username' ") or die('Error157');
    
    while ($row = mysqli_fetch_array($q)) {
        $s      = $row['score'];
        $w      = $row['wrong'];
        $r      = $row['correct'];
        $status = $row['status'];
    }
    if ($status == "finished") {
        echo '<div class="panel">
<center><h1 class="title" style="color:#660033">Αποτελέσματα</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
        echo '<tr style="color:darkblue"><td style="vertical-align:middle">Σύνολο Ερωτήσεων</td><td style="vertical-align:middle">' . $total . '</td></tr>
      <tr style="color:darkgreen"><td style="vertical-align:middle">Σωστές Απαντήσεις&nbsp;<span aria-hidden="true"><i class="fas fa-check"></i></span></td><td style="vertical-align:middle">' . $r . '</td></tr> 
    <tr style="color:red"><td style="vertical-align:middle">Λάθος Απαντήσεις&nbsp;<span aria-hidden="true"><i class="far fa-times-circle"></i></span></td><td style="vertical-align:middle">' . $w . '</td></tr>
    <tr style="color:orange"><td style="vertical-align:middle">Αναπάντητα Ερωτήματα &nbsp;<span aria-hidden="true"><i class="far fa-ban"></i></span></td><td style="vertical-align:middle">' . ($total - $r - $w) . '</td></tr>
    <tr style="color:darkblue"><td style="vertical-align:middle">Βαθμοί&nbsp;<span aria-hidden="true"><i class="fas fa-chart-bar"></i></span></td><td style="vertical-align:middle">' . $s . '</td></tr>';
        $q = mysqli_query($con, "SELECT * FROM rank WHERE  username='$username' ") or die('Error157');
        while ($row = mysqli_fetch_array($q)) {
            $s = $row['score'];
            echo '<tr style="color:#990000"><td style="vertical-align:middle">Σύνολο Βαθμών Χρήστη &nbsp;<span aria-hidden="true"><i class="fas fa-chart-bar"></i></span></td><td style="vertical-align:middle">' . $s . '</td></tr>';
        }
        echo '<tr></tr></table></div><div class="panel"><br /><h2 align="center">Αναλυτικές Πληροφορίες</h2><br /><ol style="font-size:20px;font-weight:bold;font-family:calibri;margin-top:20px">';
        $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$_GET[eid]'") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $question = $row['qns'];
            $qid      = $row['qid'];
            $q2 = mysqli_query($con, "SELECT * FROM user_answer WHERE eid='$_GET[eid]' AND qid='$qid' AND username='$_SESSION[username]'") or die('Error197');
            if (mysqli_num_rows($q2) > 0) {
                $row1         = mysqli_fetch_array($q2);
                $ansid        = $row1['ans'];
                $correctansid = $row1['correctans'];
                $q3 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$ansid'") or die('Error197');
                $q4 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$correctansid'") or die('Error197');
                $row2       = mysqli_fetch_array($q3);
                $row3       = mysqli_fetch_array($q4);
                $ans        = $row2['option'];
                $correctans = $row3['option'];
            } else {
                $q3 = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid'") or die('Error197');
                $row1         = mysqli_fetch_array($q3);
                $correctansid = $row1['ansid'];
                $q4 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$correctansid'") or die('Error197');
                $row2       = mysqli_fetch_array($q4);
                $correctans = $row2['option'];
                $ans        = "Unanswered";
            }
            if ($correctans == $ans && $ans != "Unanswered") {
                echo '<li><div style="font-size:20px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:lightgreen;padding:10px;word-wrap:break-word;border:2px solid darkgreen;border-radius:10px;">' . $question . ' <span style="color:darkgreen"><i class="fas fa-check"></i></span></div><br />';
                echo '<font style="font-size:18px;color:darkgreen"><b>Επιλέχθηκε: </b></font><font style="font-size:18px;">' . $ans . '</font><br />';
                echo '<font style="font-size:18px;color:darkgreen"><b>Σωστή Απάντηση: </b></font><font style="font-size:18px;">' . $correctans . '</font><br />';
            } 
            else if ($ans == "Unanswered") {
                echo '<li><div style="font-size:20px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:#f7f576;padding:10px;word-wrap:break-word;border:2px solid #b75a0e;border-radius:10px;">' . $question . ' </div><br />';
                echo '<font style="font-size:18px;color:darkgreen"><b>Correct Answer: </b></font><font style="font-size:18px;">' . $correctans . '</font><br />';
            } 
            else {
                echo '<li><div style="font-size:20px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:#f99595;padding:10px;word-wrap:break-word;border:2px solid darkred;border-radius:10px;">' . $question . ' <span style="color:red"><i class="far fa-times-circle"></i></span></div><br />';
                echo '<font style="font-size:18px;color:red"><b>Επιλέχθηκε: </b></font><font style="font-size:18px;">' . $ans . '</font><br />';
                echo '<font style="font-size:18px;color:darkgreen"><b>Σωστή Απάντηση: </b></font><font style="font-size:18px;">' . $correctans . '</font><br />';
                
            }
            echo "<br /></li>";
        }
        echo '</ol>';
        echo "</div>";
    } else {
        die("Thats a 404 Error bro. You are trying to access a wrong page");
    }
}
if (@$_GET['q'] == 2) {
    $q = mysqli_query($con, "SELECT * FROM history WHERE username='$username' AND status='finished' ORDER BY date DESC ") or die('Error197');
    echo '<div class="panel title"><h2 style="text-align:center;">Αποτελέσματα</h2>
<table class="table table-striped title1" style="margin-top:20px;" >
<tr><td style="vertical-align:middle"><b>Nο.</b></td><td style="vertical-align:middle"><b>Quiz</b></td><td style="vertical-align:middle"><b>Σύνολο Ερωτήσεων</b></td><td style="vertical-align:middle"><b>Σωστές</b></td><td style="vertical-align:middle"><b>Λάθος<b></td><td style="vertical-align:middle"><b>Αναπάντητες<b></td><td style="vertical-align:middle"><b>Βαθμοί</b></td><td style="vertical-align:middle"><b>Αποτελέσματα<b></td></tr>';
    $c = 0;
    while ($row = mysqli_fetch_array($q)) {
        $eid = $row['eid'];
        $s   = $row['score'];
        $w   = $row['wrong'];
        $r   = $row['correct'];
        $q23 = mysqli_query($con, "SELECT * FROM quiz WHERE  eid='$eid' ") or die('Error208');
        while ($row = mysqli_fetch_array($q23)) {
            $title = $row['title'];
            $total = $row['total'];
        }
        $c++;
        echo '<tr><td style="vertical-align:middle">' . $c . '</td><td style="vertical-align:middle">' . $title . '</td><td style="vertical-align:middle">' . $total . '</td><td style="vertical-align:middle">' . $r . '</td><td style="vertical-align:middle">' . $w . '</td><td style="vertical-align:middle">' . ($total - $r - $w) . '</td><td style="vertical-align:middle">' . $s . '</td><td style="vertical-align:middle"><b><a href="account.php?q=result&eid=' . $eid . '" class="btn" style="margin:0px;background:darkred;color:white">&nbsp;<span class="title1"><b>Αποτέλεσμα</b></td></tr>';
    }
    echo '</table></div>';
}
if (@$_GET['q'] == 3) {
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
    $q = mysqli_query($con, "SELECT * FROM rank") or die('Error223');
    echo '<div class="panel title"><h2 style="text-align:center;">Βαθμολογία</h2>
<table class="table table-striped title1" style="margin-top:20px;" >
<tr><td style="vertical-align:middle"><b>Θέση</b></td><td style="vertical-align:middle"><b>Όνομα</b></td><td style="vertical-align:middle"><b>Επίθετο</b></td><td style="vertical-align:middle"><b>Username</b></td><td style="vertical-align:middle"><b>Βαθμοί</b></td></tr>';
    $c = $showfrom-1;
    $total = mysqli_num_rows($q);
    if($total >= $showfrom){
        $q = mysqli_query($con, "SELECT * FROM rank ORDER BY score DESC, time ASC LIMIT ".($showfrom-1).",10") or die('Error223');
        while ($row = mysqli_fetch_array($q)) {
            $e = $row['username'];
            $s = $row['score'];
            $q12 = mysqli_query($con, "SELECT * FROM users WHERE username='$e' ") or die('Error231');
            while ($row = mysqli_fetch_array($q12)) {
                $name     = $row['first_name'];
                $branch   = $row['last_name'];
                $username = $row['username'];
            }
            $c++;
            echo '<tr><td style="color:#99cc32"><b>' . $c . '</b></td><td style="vertical-align:middle">' . $name . '</td><td style="vertical-align:middle">' . $branch . '</td><td style="vertical-align:middle">' . $username . '</td><td style="vertical-align:middle">' . $s . '</td>';
        }
    }
    else{
    }
    echo '</table></div>';
    echo '<div class="panel title"><table class="table table-striped title1" ><tr>';
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
            echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
            $i++;
        }
        echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.($show+1).'">&nbsp;>>&nbsp;</a></td>';
    }
    else if($show != 1 && $show==$total){
        echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.($show-1).'">&nbsp;<<&nbsp;</a></td>';

        $i = 1;
        while($i<=$total){
            echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
            $i++;
        }
    }
    else{
        echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.($show-1).'">&nbsp;<<&nbsp;</a></td>';
        $i = 1;
        while($i<=$total){
            echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.$i.'">&nbsp;'.$i.'&nbsp;</a></td>';
            $i++;
        }
        echo '<td style="vertical-align:middle;text-align:center"><a style="font-size:14px;font-family:typo;font-weight:bold" href="account.php?q=3&show='.($show+1).'">&nbsp;>>&nbsp;</a></td>';
    }
    echo '</tr></table></div>';
}
?>
</div></div></div></div>
</body>
</html>
