<?php 
include("resize-class.php");
$fileindex = $_POST['fileindex'];
$filename = 'uploadfile';  
$uploaddir = '../upload_files/';

//$randvalue = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 25)), 0, 25);
$uploadfile = time().$_FILES[$filename]['name'];
	
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