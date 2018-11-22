<?php 
$filename = 'uploadfile';
$uploaddir = '../upload_video/';
//$uploaddir_thumb = '../images/news/thumb/';
$uploadfile = time() . '..........' . $_FILES[$filename]['name'];
	
$image = $_FILES[$filename]['name'];
$image_type = $_FILES[$filename]['type'];
	
if($image != "")
{
    

    if(move_uploaded_file($_FILES[$filename]['tmp_name'], $uploaddir.$uploadfile)) 
    { 
        echo basename($uploadfile);
    } 
}
else 
{
    echo "error";
}
?>