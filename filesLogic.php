<?php
// connect to the database
$db = mysqli_connect('localhost', '', '', '');
mysqli_set_charset($db, "utf8");
$sql = "SELECT * FROM files";
$result = mysqli_query($db, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Uploads files
if (isset($_POST['save']))
{
    $months = $_POST['months'];
    // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['selectfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['selectfile']['tmp_name'];
    $size = $_FILES['selectfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'mp3', 'xlsx', 'rar']))
    {
        echo "You file extension must be .zip, .pdf, .mp3, .xlsx, .rar or .docx";
    }
    elseif ($_FILES['selectfile']['size'] > 9000000000)
    { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    }
    else
    {

        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination))
        {
            $sql = "INSERT INTO files (name, size, downloads, month) VALUES ('$filename', $size, 0, $months)";
            if (mysqli_query($db, $sql))
            {
                $_SESSION['message'] = "File uploaded successfully";
                $_SESSION['message-status'] = "success";
                header('location: dashboard.php');
            }
        }
        else
        {

            $_SESSION['message'] = "Failed to upload file.";
            $_SESSION['message-status'] = "error";
            header('location: dashboard.php');
        }
    }
}

// Downloads files
if (isset($_GET['file_id']))
{
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($db, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath))
    {
        ob_end_clean();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($db, $updateQuery);
        exit;
    }

}

?>
