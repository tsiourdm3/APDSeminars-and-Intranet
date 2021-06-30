<?php
$fileName = $_FILES["selectfile"]["name"]; // The file name
$fileTmpLoc = $_FILES["selectfile"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["selectfile"]["type"]; // The type of file it is
$fileSize = $_FILES["selectfile"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["selectfile"]["error"]; // 0 for false... and 1 for true

if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
if(move_uploaded_file($fileTmpLoc, "uploads/$fileName")){
    echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
}
?>