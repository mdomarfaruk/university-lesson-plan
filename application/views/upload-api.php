
<script type="text/javascript" src="<?php echo base_url().'scripts/upload_js/ajaxupload.3.5.js';?>" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'scripts/upload_js/styles.css'?>" />

<script type="text/javascript" >
    
    $(function()
    {
        var btnUpload=$('#upload');
        var status=$('#status');
        
        
        new AjaxUpload(btnUpload, 
        {
            action: '<?php echo base_url()."upload-api/upload-api.php";?>', 
            name: 'uploadfile',
            data : { 'fileindex':fileindex },
            onSubmit: function(file, ext)
            {
                if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)))
		{ 
                    alert('Only JPG, PNG or GIF files are allowed');  
                    return false;
                }
                if(inc == maxImg)
                {
                    alert('You have upload maximum upload limit');  
                    return false;
                }
                status.show();
            },
            onComplete: function(file,response)
            {
                status.hide();
                if(response!="error")				
                {
                    generator(response); 
                } 
                else
                {
                    alert('fail...');
                }
            }
        });
    });
    
     function generator(response)
    {
          var str = '';
          if(fileindex == 1)
          {
              str = str+'<span id="delete_avatar_'+inc+'" style="margin-top:30px; "><div class="upload_image1" style="width:100px; margin-right:10px; float:left;"><img class="img-thumbnail" width="90" height="100" src="<?php echo base_url()?>uploads/thumb/'+response+'" border="0" >';
              str = str+'<input type="hidden" id="image_'+inc+'"  name="image[]" value="'+response+'"/></div><div style="color: red;cursor: pointer;float: left;font-size: 21px;font-weight: bold;margin-left: -25px;  margin-top: -11px; padding-top:0;" onclick="delete_avatar('+inc+')">X</div></span>'; 
              $('.image_content_area').append(str);
               //$('.previous_image').hide();
              inc++;
          }
          else if(fileindex == 2)
          {
               //alert('ee');
             // BW will work 
             $('#foto_box').html("<img src='<?php echo base_url() ?>uploads/thumb/"+response+"'>");
             $('#logo_input').html( "<input type='hidden' name='logo' id='logo' value='"+response+"'>");
            
          }
          
    }
</script>





