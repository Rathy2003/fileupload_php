<?php

function addFile($file) : bool
{
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $filename = time().".".$ext;
    if(move_uploaded_file($file["tmp_name"], "upload/".$filename))
        return true;
    return false;
}

if(isset($_POST['submit'])){
    if(isset($_FILES["file"])){
        $fileName = $_FILES["file"]["name"];
        $fileSize = $_FILES["file"]["size"];
        $fileType = $_FILES["file"]["type"];
        $fileError = $_FILES["file"]["error"];
        $fileTmp = $_FILES["file"]["tmp_name"];

        // get uploaded file extension. ex : jpg, png or jpeg
        $file_ext = pathinfo($fileName,PATHINFO_EXTENSION);

        // allowed images type
        $ext = [" image/png","image/jpg","image/jpeg","image/gif"];

        $maxSize = 2 * 1024 * 1024; // limit file size 2MB

        // handle valid file
        if($fileSize < $maxSize && $fileError == 0){
            if(!in_array($fileType,$ext)){
                echo "<script>alert('Can upload image file only.')</script>";
                header("refresh:0;url=upload.php");
                die();
            }else{ // file upload is valid
                if(addFile($_FILES["file"])){
                    echo "<script>alert('File successfully uploaded.')</script>";
                }else{
                    echo "<script>alert('File failed to upload.')</script>";
                }
            }
        }else{
            echo "<script>alert('Something when wrong.')</script>";
            header("refresh:0;url=upload.php");
            die();
        }
    }
}

?>

<form  action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>
