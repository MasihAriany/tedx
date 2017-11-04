<?php

include('connect.php');
// Upload image
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file_name =  $target_dir . md5(basename($_FILES["fileToUpload"]["name"])) .".png";
$target_file_db_name =  md5(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      //  echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_name)) {
	        $sql="insert into Images(Name,Email,PhoneNumber,ImageMD5) values('".$_REQUEST['name']."', '".$_REQUEST['email']."', '".$_REQUEST['phone']."','".$target_file_db_name."')";
$res=mysql_query($sql);
       if($res)
{
//echo "<script type='text/javascript'>alert('Your Nominated Speaker Submitted Successfully')</script>";
echo "<script>setTimeout(\"location.href = 'http://tedxshirazuniversity.com/success.html';\",100);</script>";
}
else
{
echo "<script type='text/javascript'>alert('ERROR!! Try Again')</script>";
echo "<script>setTimeout(\"location.href = 'http://tedxshirazuniversity.com/nomination.html';\",60);</script>";
}
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
}
?> 