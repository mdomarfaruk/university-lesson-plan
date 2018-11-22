<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>	
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
$user_role = $this->session->userdata('shohozit_role');
$failed = $this->session->flashdata('failed');
if ($failed) {
    ?>	
    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-warning">
                <?php
                echo $failed;
                ?>
            </div>
        </div><!-- /.box-body col-md-offset-2-->
    </div>
    <?php
}
?>
<div class="box ">
    <div class="box-header">
        <h3 class="box-title pull-left">Company Information</h3>
    </div>

    <div class="box-body table-responsive">
        <form action="<?php echo base_url(); ?>dashboardcontroller/insertcompany" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2">Name</label>
                <div class="col-md-10">
                    <input name="com_name" type="text" value="<?php echo (isset($companylist->com_name) && ($companylist->com_name!='') )? $companylist->com_name:''; ?>" class="form-control" id="com_name" placeholder="Company" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Address</label>
                <div class="col-md-10">
                    <textarea name="address"  class="form-control" id="address" placeholder="Address" ><?php echo (isset($companylist->address) && ($companylist->address!='') )? $companylist->address:''; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Company Type</label>
                <div class="col-md-4">
                    <select name="company_type" class="form-control">
                        <option value="">Select Company Type</option>
                        <option value="1" <?php echo (isset($companylist->type_company) && ($companylist->type_company==1) )? "selected":'';  ?>>Limited</option>
                        <option value="2" <?php echo (isset($companylist->type_company) && ($companylist->type_company==2) )? "selected":'';  ?>>Propitorship</option>
                        <option value="3" <?php echo (isset($companylist->type_company) && ($companylist->type_company==3) )? "selected":'';  ?>>Partnership</option>
                    </select>
                </div>
                <label class="control-label col-md-2">Special Discount Maximum(%)</label>
                <div class="col-md-4">
                    <input name="special_discount_per" type="text" value="<?php echo (isset($companylist->special_discount_per) && ($companylist->special_discount_per!='') )? $companylist->special_discount_per:''; ?>" class="form-control" id="special_discount_per" placeholder="Special Discount Maximum(%)" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Registration No</label>
                <div class="col-md-4">
                    <input name="reg_no" type="text" value="<?php echo (isset($companylist->reg_no) && ($companylist->reg_no!='') )? $companylist->reg_no:''; ?>" class="form-control" id="reg_no" placeholder="Registration No" required>
                </div>
                <label class="control-label col-md-2">Trade Licence No</label>
                <div class="col-md-4">
                    <input name="trade_licence" type="text" value="<?php echo (isset($companylist->trade_licence) && ($companylist->trade_licence!='') )? $companylist->trade_licence:''; ?>" class="form-control" id="trade_licence" placeholder="Trade Licence No" >
                </div>
            </div>
            <div class="form-group">

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Vat Registration Id</label>
                <div class="col-md-4">
                    <input name="vat_reg_no" type="text" value="<?php echo (isset($companylist->vat_reg_no) && ($companylist->vat_reg_no!='') )? $companylist->vat_reg_no:''; ?>" class="form-control" id="vat_reg_no" placeholder="Vat Registration Id" >
                </div>
                <label class="control-label col-md-2">Tax Registration Id</label>
                <div class="col-md-4">
                    <input name="tax_reg_no" type="text" value="<?php echo (isset($companylist->tax_reg_no) && ($companylist->tax_reg_no!='') )? $companylist->tax_reg_no:''; ?>" class="form-control" id="tax_reg_no" placeholder="Tax Registration Id" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Vat(%)</label>
                <div class="col-md-4">
                    <input name="vat_per" type="text" value="<?php echo (isset($companylist->vat_per) && ($companylist->vat_per!='') )? $companylist->vat_per:''; ?>" class="form-control" id="vat_per" placeholder="Vat(%)" >
                </div>
                <label class="control-label col-md-2">Tax(%)</label>
                <div class="col-md-4">
                    <input name="tax_per" type="text" value="<?php echo (isset($companylist->tax_per) && ($companylist->tax_per!='') )? $companylist->tax_per:''; ?>" class="form-control" id="tax_per" placeholder="Tax(%)" >
                </div>
            </div>

             <div class="form-group">

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Company Sologan</label>
                <div class="col-md-10">
                    <input name="company_sologan" type="text" value="<?php echo (isset($companylist->company_sologan) && ($companylist->company_sologan!='') )? $companylist->company_sologan:''; ?>" class="form-control" id="company_sologan" placeholder="Company Sologan" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Company Logo</label>
                <div class="col-md-10">
                    <input name="comapany_old_logo" type="hidden" value="<?php echo (isset($companylist->company_logo) && ($companylist->company_logo!='') )? $companylist->company_logo:''; ?>" class="form-control" id="comapany_old_logo" placeholder="Company logo" >
                    <input type="file" name="picture" class="form-control" id="picture">
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-2"></label>
                <div class="col-md-10">
                    <img src=" <?php echo (isset($companylist->company_logo) && ($companylist->company_logo!='') && file_exists($companylist->company_logo) )? base_url().$companylist->company_logo:''; ?>" title="Company logo" class="img-thumbnail" style="height:140px;width:140px;">
                </div>

            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-9">
                    <button type="submit" name="saveBtn" class="btn btn-success btn-sm" onclick="return checkadd();"><i class=" glyphicon glyphicon-open"></i> Update Information</button>
                </div>
            </div>

        </form>
    </div><!-- /.box-body -->
</div>

<!-- COMPOSE MESSAGE MODAL -->              





<script type="text/javascript">

    function checkadd() {
        var chk = confirm("Are you sure to add this record ?");
        if (chk) {
            return true;
        } else {
            return false;
        }
    }

</script>						 