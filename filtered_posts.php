
<?php require_once('fuc.php');  

if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
function getPostTopic($topic_id){
	global $db;
	$sql = "SELECT * FROM posts WHERE topic_id=
			(SELECT id FROM topics WHERE id=$topic_id)";
	$result = mysqli_query($db, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}

?>
<?php

	function getPublishedPostsByTopic($topic_id) {
	global $db;
	$sql = "SELECT * FROM posts ps
			WHERE ps.topic_id IN
			(SELECT t.id FROM topics t
				WHERE t.id=$topic_id GROUP BY t.id
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
	// Get posts under a particular topic
	if (isset($_GET['topic'])) {
		$topic_id = $_GET['topic'];
		$posts = getPublishedPostsByTopic($topic_id);
	}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Blog | Αρχική </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: "Lato", sans-serif;
            background-color: #eee;
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
        h1 {
            color: grey;
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
        h1 span {
            color: #5383d3;
        }
        h1 {
            display: block;
            padding: 0;
        }
        #main {
            transition: margin-left .5s;
        }
        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }
            .sidenav a {
                font-size: 18px;
            }
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
        .active,
        .accordion:hover {
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
        .card-body {
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
                <a href="index.php" style="text-decoration:none;">
                    <h1 style="text-align:center;font-size:70px;">Intra-<span>net</span></h1>
                </a>
            </div>

        </div>
    </div>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php">
            <?php if (isset($_SESSION[ 'user'])) : ?>
            <strong><?php echo $_SESSION['user']['username']; ?></strong>

            <small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="logout.php">Αποσύνδεση</a>
					</small>

            <?php endif ?>
        </a>
        <a href="indexblog.php">Forum/ <br>Συζητήσεις</a>
        <a href="account.php">Quiz</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10" style="margin-top:20px;">
                <button type="button" class="btn btn-dark" onclick="history.go(-1);" style="margin-top:10px;margin-bottom:20px;">Επιστροφή </button>
                <div class="card">
                    <div class="card-header" style="background-color:#5383d3; color:white;">
                        Συζητήσεις με θέμα - <u><?php echo getTopicNameById($topic_id); ?></u>

                    </div>

                    <?php foreach ($posts as $post): ?>
                    <div class="col-md-12 col-md-offset-3" style="border-radius: 15px; padding: 10px;min-height: 100px;">
                        <div class="card">
                            <div class="card-header">
                                <h3><?php echo $post['title'] ?></h3>
                                <div class="card-content">

                                    <span><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
                                    <br>
                                    <span class="read_more"><a href="single_post.php?id=<?php echo $post['id']; ?>">Περισσότερα...</a></span>
                                </div>
                                <br>
                                <br>


                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>

                </div>

            </div>

        </div>
    </div>

    <!-- // Footer -->
    <div class="col-sm-12" style="margin-top:20px;">

        <div class="card" style="background-color: #FFFFFF;">
            <div class="card-body">
                <?php if (isset($_SESSION[ 'success'])) : ?>
                <div class="error success">
                    <h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
                </div>
                <?php endif ?>
                <?php if (isset($_SESSION[ 'user'])) : ?>
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
            document.getElementById("main").style.marginLeft = "0";
            document.getElementById("menuspan").style.visibility = "visible";
        }
    </script>
</body>

</html>