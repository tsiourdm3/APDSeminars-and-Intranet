<?php include ("fuc.php") ?>
<?php if (!isset($_SESSION['username'])): ?>
<?php header('Location: indexblog.php'); ?>
<?php
else: ?>
<?php
    if (isset($_POST['postcomment']))
    {
        $userid = $_SESSION['id'];
        $username = $_SESSION['username'];
        $postid = $_POST['id'];
        $comment = $_POST['comment'];
        if ($comment != "")
        {
            $sql = "INSERT INTO comments (user_id,username,post_id,comment) VALUES ('$userid','$username', '$postid', '$comment')";
            $query = mysqli_query($db, $sql);
            if ($query)
            {
                header("Location:single_post.php?id=" . $postid);
            }
        }
    }
?>
<?php
endif; ?>