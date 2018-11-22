<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "authenticationcontroller";
$route['404_override'] = '';
$route['itemReportForm'] = 'new_report/report_controller/itemReportForm';
$route['itemReportByDate'] = 'new_report/report_controller/itemReportByDate';
$route['profitLoss'] = 'new_report/report_controller/profitLoss';
$route['profitLossForm'] = 'new_report/report_controller/profitLossForm';
$route['ext'] = 'trialExpired/trialExpired';

$route['monthlySumForm'] = 'new_report/report_controller/monthlySumForm';
$route['printMonthlySum'] = 'new_report/report_controller/printMonthlySum';


$route['purchaseRepForm'] = 'new_report/report_controller/purchaseRepForm';
$route['printPurchaseRep'] = 'new_report/report_controller/printPurchaseRep';

$route['inventoryRepForm'] = 'new_report/report_controller/inventoryRepForm';
$route['inventoryRepByDate'] = 'new_report/report_controller/inventoryRepByDate';

$route['purIntlRepForm'] = 'purchasecontroller/purIntlRepForm';
$route['purIntlRep'] = 'purchasecontroller/purIntlRep';