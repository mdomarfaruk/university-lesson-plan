<?php 
$success = $this->session->flashdata('success');
if($success){?> 

    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-info">
                <?php 
                    echo $success;
                ?>
            </div>
        </div><!-- /.box-body -->
    </div>

<?php

}
?>
<?php 
$failed = $this->session->flashdata('failed');
if($failed){?>

    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-warning">
                <?php 
                    echo $failed;
                ?>
            </div>
        </div><!-- /.box-body -->
    </div>
 
<?php

}
?>
<section class="content">

    <div class='row'>
        <div class='col-md-12'>
            <div class='box'>
                
                <div class='box-header'>
                    <h3 class='box-title'>Store Info <small>Add Information about the company and Logo URL!!!</small></h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        
                        <!--<button class="btn btn-default btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
                    </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <form action="<?php echo base_url();?>dashboardcontroller/insertstoreinfo" method="post">
                        <textarea name="company_info" class="textareawysihtml5" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        <button style="margin:10px 0px; padding: 10px;" type="submit" class="btn btn-primary" onclick="return checkadd();">Submit</button>
                    </form>
                </div>
                
            </div>
        </div><!-- /.col-->
    </div><!-- ./row -->



</section><!-- /.content -->
<script type="text/javascript">
    function checkadd(){
        var chk = confirm("Are you sure to add this record ?");
        if (chk) {
            return true;
        } else{
            return false;
        };
    }
</script>