<?php 
include("resize-class.php");
$fileindex = $_POST['fileindex'];
$filename = 'uploadfile';  

$uploaddir = '../images/category_img/';
$uploaddir_thumb = '../images/category_img/thumb/'; 

$randvalue = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 25)), 0, 25);
$uploadfile = $randvalue.$_FILES[$filename]['name'];
	
$image = $_FILES[$filename]['name'];
$image_type = $_FILES[$filename]['type'];
	
if($image != "")
{
    $w_h = getimagesize($_FILES[$filename]['tmp_name']);
    $o_width = $w_h[0];
    $o_height = $w_h[1];
    
    if(move_uploaded_file($_FILES[$filename]['tmp_name'], $uploaddir.$uploadfile))
    {          
        $thumbs_width = 208;
        $thumbs_height = $o_height*($thumbs_width/$o_width);
        
        $resizeObj = new resize($uploaddir.$uploadfile);
        $resizeObj -> resizeImage($thumbs_width, $thumbs_height, 'crop');
        $resizeObj -> saveImage($uploaddir_thumb.$uploadfile, 100);
        
        
       
        echo basename($uploadfile);
    }    
}
else 
{
    echo "error";
}
?>