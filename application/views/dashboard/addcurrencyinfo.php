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
        <div class='col-md-6'>
            <div class='box'>
                
                <div class='box-header'>
                    <h3 class='box-title'>Currency Info </h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        
                        <!--<button class="btn btn-default btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
                    </div><!-- /. tools -->

                    
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="box-tools">
                        <p class="lead">Present Currency is: <b><?php 
                        if(!empty($querycurrencytag->currency_tag)){
                        //echo $querycurrencytag->currency_tag;
                        switch($querycurrencytag->currency_tag) {
                            case 'USD':
                                echo "USD - U.S. Dollar";
                                break;

                            case 'AUD':
                                echo "AUD - Australian Dollar";
                                break;

                            case 'BDT':
                                echo "BDT - Taka";
                                break;

                            case 'CAD':
                                echo "CAD - Canadian Dollar";
                                break;

                            case 'CHF':
                                echo "CHF - Swiss Franc";
                                break;

                            case 'CZK':
                                echo "CZK - Czech Koruna";
                                break;

                            case 'DKK':
                                echo "DKK - Danish Krone";
                                break;

                            case 'EUR':
                                echo "EUR - Euro";
                                break;

                            case 'GBP':
                                echo "GBP - Pound Sterling";
                                break;

                            case 'HKD':
                                echo "HKD - Hong Kong Dollar";
                                break;

                            case 'HUF':
                                echo "HUF - Hungarian Forint";
                                break;

                            case 'JPY':
                                echo "JPY - Japanese Yen";
                                break;

                            case 'NOK':
                                echo "NOK - Norwegian Krone";
                                break;

                            case 'NZD':
                                echo "NZD - New Zealand Dollar";
                                break;

                            case 'PLN':
                                echo "PLN - Polish Zloty";
                                break;

                            case 'SEK':
                                echo "SEK - Swedish Krona";
                                break;

                            case 'SGD':
                                echo "SGD - Singapore Dollar";
                                break;

                            case 'ILS':
                                echo "ILS - Israeli New Shekel (ILS)";
                                break;

                            case 'MXN':
                                echo "MXN - Mexican Peso (MXN)";
                                break;

                            case 'BRL':
                                echo "BRL - Brazilian Real (BRL)";
                                break;

                            case 'MYR':
                                echo "MYR - Malaysian Ringgit (MYR)";
                                break;

                            case 'PHP':
                                echo "PHP - Philippine Peso (PHP)";
                                break;

                            case 'TWD':
                                echo "TWD - New Taiwan Dollar (TWD)";
                                break;

                            case 'THB':
                                echo "THB - hai Baht (THB)";
                                break;

                            case 'TRY':
                                echo "TRY - Turkish Lira (TRY)";
                                break;
                        }

                        }

                        ?></b></p>
                    </div>
                    <form action="<?php echo base_url();?>dashboardcontroller/insertcurrencyinfo" method="post">
                        <div class="form-group">
                            <label>Change Currency <sup>*</sup></label>
                            <select name="currency_tag" id="currency_tag" class="form-control">
                                <option value="">--- Select Currency ---</option>

                                <option value="USD">U.S. Dollar</option>
                                <option value="AUD">Australian Dollar</option>
                                <option value="BDT">Taka</option>
                                <option value="CAD">Canadian Dollar</option>
                                <option value="CHF">Swiss Franc</option>
                                <option value="CZK">Czech Koruna</option>
                                <option value="DKK">Danish Krone</option>
                                <option value="EUR">Euro</option>
                                <option value="GBP">Pound Sterling</option>
                                <option value="HKD">Hong Kong Dollar</option>
                                <option value="HUF">Hungarian Forint</option>
                                <option value="JPY">Japanese Yen</option>
                                <option value="NOK">Norwegian Krone</option>
                                <option value="NZD">New Zealand Dollar</option>
                                <option value="PLN">Polish Zloty</option>
                                <option value="SEK">Swedish Krona</option>
                                <option value="SGD">Singapore Dollar</option>
                                <option value="ILS">Israeli New Shekel (ILS)</option>
                                <option value="MXN">Mexican Peso (MXN)</option>
                                <option value="BRL">Brazilian Real (BRL)</option>
                                <option value="MYR">Malaysian Ringgit (MYR)</option>
                                <option value="PHP">Philippine Peso (PHP)</option>
                                <option value="TWD">New Taiwan Dollar (TWD)</option>
                                <option value="THB">Thai Baht (THB)</option>
                                <option value="TRY">Turkish Lira (TRY)</option>
                                
                            </select>
                        </div>
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