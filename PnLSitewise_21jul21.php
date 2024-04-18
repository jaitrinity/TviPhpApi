<?php
$conn=mysqli_connect("localhost","root","Tr!n!ty#321","TVIBilling");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
$period=$_REQUEST['period'];
// $period = 'Apr2020';

$deleteSql = "delete from `P&L Sitewise` where `UploadMonth` = '$period' ";
mysqli_query($conn,$deleteSql);

$firstDate = date('01-m-Y', strtotime($period));
$lastDate = date('t-m-Y', strtotime($period));
$datediff = (strtotime($lastDate) - strtotime($firstDate));
$noOfDays = round($datediff / (60 * 60 * 24)) +1;


$sql = "select t1.*, 
(case when t1.airtel_bts1_type = 'Indoor' || t1.airtel_bts2_type = 'Indoor' || t1.airtel_bts3_type = 'Indoor' || t1.airtel_bts4_type = 'Indoor' || t1.airtel_bts5_type = 'Indoor' || 
t1.airtel_bts6_type = 'Indoor' then 'Yes' else 'No' end) as airtel_have_ID, 
(case when t1.bsnl_bts1_type = 'Indoor' || t1.bsnl_bts2_type = 'Indoor' || t1.bsnl_bts3_type = 'Indoor' || t1.bsnl_bts4_type = 'Indoor' || t1.bsnl_bts5_type = 'Indoor' || 
t1.bsnl_bts6_type = 'Indoor' then 'Yes' else 'No' end) as bsnl_have_ID, 
(case when t1.idea_bts1_type = 'Indoor' || t1.idea_bts2_type = 'Indoor' || t1.idea_bts3_type = 'Indoor' || t1.idea_bts4_type = 'Indoor' || t1.idea_bts5_type = 'Indoor' || 
t1.idea_bts6_type = 'Indoor' then 'Yes' else 'No' end) as idea_have_ID, 
(case when t1.pbHfcl_bts1_type = 'Indoor' || t1.pbHfcl_bts2_type = 'Indoor' || t1.pbHfcl_bts3_type = 'Indoor' || t1.pbHfcl_bts4_type = 'Indoor' || t1.pbHfcl_bts5_type = 'Indoor' || 
t1.pbHfcl_bts6_type = 'Indoor' then 'Yes' else 'No' end) as pbHfcl_have_ID, 
(case when t1.rjio_bts1_type = 'Indoor' || t1.rjio_bts2_type = 'Indoor' || t1.rjio_bts3_type = 'Indoor' || t1.rjio_bts4_type = 'Indoor' || t1.rjio_bts5_type = 'Indoor' || 
t1.rjio_bts6_type = 'Indoor' then 'Yes' else 'No' end) as rjio_have_ID, 
(case when t1.sify_bts1_type = 'Indoor' || t1.sify_bts2_type = 'Indoor' || t1.sify_bts3_type = 'Indoor' || t1.sify_bts4_type = 'Indoor' || t1.sify_bts5_type = 'Indoor' || 
t1.sify_bts6_type = 'Indoor' then 'Yes' else 'No' end) as sify_have_ID, 
(case when t1.tclIot_bts1_type = 'Indoor' || t1.tclIot_bts2_type = 'Indoor' || t1.tclIot_bts3_type = 'Indoor' || t1.tclIot_bts4_type = 'Indoor' || t1.tclIot_bts5_type = 'Indoor' || 
t1.tclIot_bts6_type = 'Indoor' then 'Yes' else 'No' end) as tclIot_have_ID, 
(case when t1.tclNld_bts1_type = 'Indoor' || t1.tclNld_bts2_type = 'Indoor' || t1.tclNld_bts3_type = 'Indoor' || t1.tclNld_bts4_type = 'Indoor' || t1.tclNld_bts5_type = 'Indoor' || 
t1.tclNld_bts6_type = 'Indoor' then 'Yes' else 'No' end) as tclNld_have_ID, 
(case when t1.tclRedwin_bts1_type = 'Indoor' || t1.tclRedwin_bts2_type = 'Indoor' || t1.tclRedwin_bts3_type = 'Indoor' || t1.tclRedwin_bts4_type = 'Indoor' || t1.tclRedwin_bts5_type = 'Indoor' || 
t1.tclRedwin_bts6_type = 'Indoor' then 'Yes' else 'No' end) as tclRedwin_have_ID, 
(case when t1.tclWimax_bts1_type = 'Indoor' || t1.tclWimax_bts2_type = 'Indoor' || t1.tclWimax_bts3_type = 'Indoor' || t1.tclWimax_bts4_type = 'Indoor' || t1.tclWimax_bts5_type = 'Indoor' || 
t1.tclWimax_bts6_type = 'Indoor' then 'Yes' else 'No' end) as tclWimax_have_ID, 
(case when t1.ttslCdma_bts1_type = 'Indoor' || t1.ttslCdma_bts2_type = 'Indoor' || t1.ttslCdma_bts3_type = 'Indoor' || t1.ttslCdma_bts4_type = 'Indoor' || t1.ttslCdma_bts5_type = 'Indoor' || 
t1.ttslCdma_bts6_type = 'Indoor' then 'Yes' else 'No' end) as ttslCdma_have_ID, 
(case when t1.ttsl_bts1_type = 'Indoor' || t1.ttsl_bts2_type = 'Indoor' || t1.ttsl_bts3_type = 'Indoor' || t1.ttsl_bts4_type = 'Indoor' || t1.ttsl_bts5_type = 'Indoor' || 
t1.ttsl_bts6_type = 'Indoor' then 'Yes' else 'No' end) as ttsl_have_ID, 
(case when t1.vodafone_bts1_type = 'Indoor' || t1.vodafone_bts2_type = 'Indoor' || t1.vodafone_bts3_type = 'Indoor' || t1.vodafone_bts4_type = 'Indoor' || t1.vodafone_bts5_type = 'Indoor' || 
t1.vodafone_bts6_type = 'Indoor' then 'Yes' else 'No' end) as vodafone_have_ID 
from (
select (case when max(t.site_id) = '..' then '' else max(t.site_id) end) as site_id, (case when max(t.site_name) = '..' then '' else max(t.site_name) end) as site_name, 
(case when max(t.opco_circle_name) = '..' then '' else max(t.opco_circle_name) end) as opco_circle_name,
(case when max(t.airtel_on_air_date) = '..' then '' else max(t.airtel_on_air_date) end) as airtel_on_air_date,
(case when max(t.airtel_off_date) = '..' then '' else max(t.airtel_off_date) end) as airtel_off_date, 
(case when max(t.airtel_load) = '..' then '' else max(t.airtel_load) end ) as airtel_load,
(case when max(t.bsnl_on_air_date) = '..' then '' else max(t.bsnl_on_air_date) end) as bsnl_on_air_date, 
(case when max(t.bsnl_off_date) = '..' then '' else max(t.bsnl_off_date) end) as bsnl_off_date, 
(case when max(t.bsnl_load) = '..' then '' else max(t.bsnl_load) end) as bsnl_load,
(case when max(t.idea_on_air_date) = '..' then '' else max(t.idea_on_air_date) end) as idea_on_air_date, 
(case when max(t.idea_off_date) = '..' then '' else max(t.idea_off_date) end) as idea_off_date, 
(case when max(t.idea_load) = '..' then '' else max(t.idea_load) end) as idea_load,
(case when max(t.pbHFCL_on_air_date) = '..' then '' else max(t.pbHFCL_on_air_date) end) as pbHFCL_on_air_date, 
(case when max(t.pbHFCL_off_date) = '..' then '' else max(t.pbHFCL_off_date) end) as pbHFCL_off_date, 
(case when max(t.pbHFCL_load) = '..' then '' else max(t.pbHFCL_load) end) as pbHFCL_load,
(case when max(t.rjio_on_air_date) = '..' then '' else max(t.rjio_on_air_date) end) as rjio_on_air_date, 
(case when max(t.rjio_off_date) = '..' then '' else max(t.rjio_off_date) end) as rjio_off_date, 
(case when max(t.rjio_load) = '..' then '' else max(t.rjio_load) end) as rjio_load,
(case when max(t.sify_on_air_date) = '..' then '' else max(t.sify_on_air_date) end) as sify_on_air_date, 
(case when max(t.sify_off_date) = '..' then '' else max(t.sify_off_date) end) as sify_off_date, 
(case when max(t.sify_load) = '..' then '' else max(t.sify_load) end) as sify_load,
(case when max(t.tclIot_on_air_date) = '..' then '' else max(t.tclIot_on_air_date) end) as tclIot_on_air_date, 
(case when max(t.tclIot_off_date) = '..' then '' else max(t.tclIot_off_date) end) as tclIot_off_date, 
(case when max(t.tcIOT_load) = '..' then '' else max(t.tcIOT_load) end) as tcIOT_load,
(case when max(t.tclNld_on_air_date) = '..' then '' else max(t.tclNld_on_air_date) end) as tclNld_on_air_date, 
(case when max(t.tclNld_off_date) = '..' then '' else max(t.tclNld_off_date) end) as tclNld_off_date, 
(case when max(t.tclNLD_load) = '..' then '' else max(t.tclNLD_load) end) as tclNLD_load,
(case when max(t.tclRedwin_on_air_date) = '..' then '' else max(t.tclRedwin_on_air_date) end) as tclRedwin_on_air_date, 
(case when max(t.tclRedwin_off_date) = '..' then '' else max(t.tclRedwin_off_date) end) as tclRedwin_off_date, 
(case when max(t.tclRedwin_load) = '..' then '' else max(t.tclRedwin_load) end) as tclRedwin_load,
(case when max(t.tclWimax_on_air_date) = '..' then '' else max(t.tclWimax_on_air_date) end) as tclWimax_on_air_date, 
(case when max(t.tclWimax_off_date) = '..' then '' else max(t.tclWimax_off_date) end) as tclWimax_off_date, 
(case when max(t.tclWimax_load) = '..' then '' else max(t.tclWimax_load) end) as tclWimax_load,
(case when max(t.ttslCDMA_on_air_date) = '..' then '' else max(t.ttslCDMA_on_air_date) end) as ttslCDMA_on_air_date, 
(case when max(t.ttslCDMA_off_date) = '..' then '' else max(t.ttslCDMA_off_date) end) as ttslCDMA_off_date, 
(case when max(t.ttslCDMA_load) = '..' then '' else max(t.ttslCDMA_load) end) as ttslCDMA_load,
(case when max(t.ttsl_on_air_date) = '..' then '' else max(t.ttsl_on_air_date) end) as ttsl_on_air_date, 
(case when max(t.ttsl_off_date) = '..' then '' else max(t.ttsl_off_date) end) as ttsl_off_date, 
(case when max(t.ttsl_load) = '..' then '' else max(t.ttsl_load) end) as ttsl_load,
(case when max(t.vodafone_on_air_date) = '..' then '' else max(t.vodafone_on_air_date) end) as vodafone_on_air_date, 
(case when max(t.vodafone_off_date) = '..' then '' else max(t.vodafone_off_date) end) as vodafone_off_date, 
(case when max(t.vodafone_load) = '..' then '' else max(t.vodafone_load) end) as vodafone_load,
(case when max(t.Airtel_Aircon_Load_in_KW) = '..' then '' else max(t.Airtel_Aircon_Load_in_KW) end) as Airtel_Aircon_Load_in_KW, 
(case when max(t.BSNL_Aircon_Load_in_KW) = '..' then '' else max(t.BSNL_Aircon_Load_in_KW) end) as BSNL_Aircon_Load_in_KW, 
(case when max(t.IDEA_Aircon_Load_in_KW) = '..' then '' else max(t.IDEA_Aircon_Load_in_KW) end) as IDEA_Aircon_Load_in_KW, 
(case when max(t.HFCL_Aircon_Load_in_KW) = '..' then '' else max(t.HFCL_Aircon_Load_in_KW) end) as HFCL_Aircon_Load_in_KW, 
(case when max(t.RJIO_Aircon_Load_in_KW) = '..' then '' else max(t.RJIO_Aircon_Load_in_KW) end) as RJIO_Aircon_Load_in_KW, 
(case when max(t.Sify_Aircon_Load_in_KW) = '..' then '' else max(t.Sify_Aircon_Load_in_KW) end) as Sify_Aircon_Load_in_KW, 
(case when max(t.tclIot_Aircon_Load_in_KW) = '..' then '' else max(t.tclIot_Aircon_Load_in_KW) end) as tclIot_Aircon_Load_in_KW, 
(case when max(t.tclNld_Aircon_Load_in_KW) = '..' then '' else max(t.tclNld_Aircon_Load_in_KW) end) as tclNld_Aircon_Load_in_KW, 
(case when max(t.tclRedwin_Aircon_Load_in_KW) = '..' then '' else max(t.tclRedwin_Aircon_Load_in_KW) end) as tclRedwin_Aircon_Load_in_KW, 
(case when max(t.tclWinmax_Aircon_Load_in_KW) = '..' then '' else max(t.tclWinmax_Aircon_Load_in_KW) end) as tclWinmax_Aircon_Load_in_KW, 
(case when max(t.ttslCdma_Aircon_Load_in_KW) = '..' then '' else max(t.ttslCdma_Aircon_Load_in_KW) end) as ttslCdma_Aircon_Load_in_KW, 
(case when max(t.ttsl_Aircon_Load_in_KW) = '..' then '' else max(t.ttsl_Aircon_Load_in_KW) end) as ttsl_Aircon_Load_in_KW, 
(case when max(t.vadafone_Aircon_Load_in_KW) = '..'  then '' else max(t.vadafone_Aircon_Load_in_KW) end) as vadafone_Aircon_Load_in_KW,
(case when max(t.dieselBillingFromDate) = '..' then '' else max(t.dieselBillingFromDate) end) as dieselBillingFromDate, 
(case when max(t.dieselBillingUpToDate) = '..' then '' else max(t.dieselBillingUpToDate) end) as dieselBillingUpToDate, 
(case when max(t.dieselNoOfDays) = '..' then '' else max(t.dieselNoOfDays) end) as dieselNoOfDays, 
(case when max(t.dieselCost) = '..' then '' else max(t.dieselCost) end) as dieselCost,
(case when max(t.ebCost) = '..' then '' else max(t.ebCost) end) as ebCost, 
(case when max(t.energyCost) = '..' then '' else max(t.energyCost) end) as energyCost, 
(case when max(t.airtelDays) = '..' then '' else max(t.airtelDays) end) as airtelDays,
(case when max(t.bsnlDays) = '..' then '' else max(t.bsnlDays) end) as bsnlDays,
(case when max(t.ideaDays) = '..' then '' else max(t.ideaDays) end) as ideaDays,
(case when max(t.pbHFCLDays) = '..' then '' else max(t.pbHFCLDays) end) as pbHFCLDays,
(case when max(t.rjioDays) = '..' then '' else max(t.rjioDays) end) as rjioDays,
(case when max(t.sifyDays) = '..' then '' else max(t.sifyDays) end) as sifyDays,
(case when max(t.tclIotDays) = '..' then '' else max(t.tclIotDays) end) as tclIotDays,
(case when max(t.tclNldDays) = '..' then '' else max(t.tclNldDays) end) as tclNldDays,
(case when max(t.tclRedwinDays) = '..' then '' else max(t.tclRedwinDays) end) as tclRedwinDays,
(case when max(t.tclWimaxDays) = '..' then '' else max(t.tclWimaxDays) end) as tclWimaxDays,
(case when max(t.ttslCdmaDays) = '..' then '' else max(t.ttslCdmaDays) end) as ttslCdmaDays,
(case when max(t.ttslDays) = '..' then '' else max(t.ttslDays) end) as ttslDays,
(case when max(t.vodafoneDays) = '..' then '' else max(t.vodafoneDays) end) as vodafoneDays,
(case when max(t.rjio_dg_amount) = '..' then null else sum(t.rjio_dg_amount) end) as rjio_dg_amount, 
(case when max(t.rjio_eb_amount)= '..' then null else sum(t.rjio_eb_amount) end) as rjio_eb_amount, 
(case when max(t.no_of_tenancy) = '..' then '' else max(t.no_of_tenancy) end) as no_of_tenancy, 
(case when max(t.siteType) = '..' then '' else max(t.siteType) end) as siteType,
(case when max(t.ebStatus) = '..' then '' else max(t.ebStatus) end) as ebStatus, 
(case when max(t.airtel_dg_amount) = '..' then null else sum(t.airtel_dg_amount) end) as airtel_dg_amount, 
(case when max(t.airtel_eb_amount) = '..' then null else sum(airtel_eb_amount) end) as airtel_eb_amount, 
(case when max(t.bsnl_dg_amount) = '..' then null else sum(bsnl_dg_amount) end) as bsnl_dg_amount, 
(case when max(t.bsnl_eb_amount) = '..' then null else sum(bsnl_eb_amount) end) as bsnl_eb_amount, 
(case when max(t.tclIot_dg_amount) = '..' then null else sum(tclIot_dg_amount) end) as tclIot_dg_amount, 
(case when max(t.tclIot_eb_amount) = '..' then null else sum(tclIot_eb_amount) end) as tclIot_eb_amount, 
(case when max(t.tclNld_dg_amount) = '..' then null else sum(tclNld_dg_amount) end) as tclNld_dg_amount, 
(case when max(t.tclNld_eb_amount) = '..' then null else sum(tclNld_eb_amount) end) as tclNld_eb_amount, 
(case when max(t.tclRedwin_dg_amount) = '..' then null else sum(tclRedwin_dg_amount) end) as tclRedwin_dg_amount, 
(case when max(t.tclRedwin_eb_amount) = '..' then null else sum(tclRedwin_eb_amount) end) as tclRedwin_eb_amount,
(case when max(t.tclWimax_dg_amount) = '..' then null else sum(tclWimax_dg_amount) end) as tclWimax_dg_amount, 
(case when max(t.tclWimax_eb_amount) = '..' then null else sum(tclWimax_eb_amount) end) as tclWimax_eb_amount, 
(case when max(t.idea_dg_amount) = '..' then null else sum(idea_dg_amount) end) as idea_dg_amount, 
(case when max(t.idea_eb_amount) = '..' then null else sum(idea_eb_amount) end) as idea_eb_amount, 
(case when max(t.vodafone_dg_amount) = '..' then null else sum(vodafone_dg_amount) end) as vodafone_dg_amount, 
(case when max(t.vodafone_eb_amount) = '..' then null else sum(vodafone_eb_amount) end) as vodafone_eb_amount, 
(case when max(t.ttslCdma_dg_amount) = '..' then null else sum(ttslCdma_dg_amount) end) as ttslCdma_dg_amount, 
(case when max(t.ttslCdma_eb_amount) = '..' then null else sum(ttslCdma_eb_amount) end) as ttslCdma_eb_amount, 
(case when max(t.ttsl_dg_amount) = '..' then null else sum(ttsl_dg_amount) end) as ttsl_dg_amount, 
(case when max(t.ttsl_eb_amount) = '..' then null else sum(ttsl_eb_amount) end) as ttsl_eb_amount, 
(case when max(t.airtel_bts1_off_date) = '..' then '' else max(t.airtel_bts1_off_date) end) as airtel_bts1_off_date, 
(case when max(t.airtel_bts2_off_date) = '..' then '' else max(t.airtel_bts2_off_date) end) as airtel_bts2_off_date, 
(case when max(t.airtel_bts3_off_date) = '..' then '' else max(t.airtel_bts3_off_date) end) as airtel_bts3_off_date, 
(case when max(t.airtel_bts4_off_date) = '..' then '' else max(t.airtel_bts4_off_date) end) as airtel_bts4_off_date, 
(case when max(t.airtel_bts5_off_date) = '..' then '' else max(t.airtel_bts5_off_date) end) as airtel_bts5_off_date, 
(case when max(t.airtel_bts6_off_date) = '..' then '' else max(t.airtel_bts6_off_date) end) as airtel_bts6_off_date,

(case when max(t.bsnl_bts1_off_date) = '..' then '' else max(t.bsnl_bts1_off_date) end) as bsnl_bts1_off_date, 
(case when max(t.bsnl_bts2_off_date) = '..' then '' else max(t.bsnl_bts2_off_date) end) as bsnl_bts2_off_date, 
(case when max(t.bsnl_bts3_off_date) = '..' then '' else max(t.bsnl_bts3_off_date) end) as bsnl_bts3_off_date, 
(case when max(t.bsnl_bts4_off_date) = '..' then '' else max(t.bsnl_bts4_off_date) end) as bsnl_bts4_off_date, 
(case when max(t.bsnl_bts5_off_date) = '..' then '' else max(t.bsnl_bts5_off_date) end) as bsnl_bts5_off_date, 
(case when max(t.bsnl_bts6_off_date) = '..' then '' else max(t.bsnl_bts6_off_date) end) as bsnl_bts6_off_date,

(case when max(t.idea_bts1_off_date) = '..' then '' else max(t.idea_bts1_off_date) end) as idea_bts1_off_date, 
(case when max(t.idea_bts2_off_date) = '..' then '' else max(t.idea_bts2_off_date) end) as idea_bts2_off_date, 
(case when max(t.idea_bts3_off_date) = '..' then '' else max(t.idea_bts3_off_date) end) as idea_bts3_off_date, 
(case when max(t.idea_bts4_off_date) = '..' then '' else max(t.idea_bts4_off_date) end) as idea_bts4_off_date, 
(case when max(t.idea_bts5_off_date) = '..' then '' else max(t.idea_bts5_off_date) end) as idea_bts5_off_date, 
(case when max(t.idea_bts6_off_date) = '..' then '' else max(t.idea_bts6_off_date) end) as idea_bts6_off_date,

(case when max(t.pbHfcl_bts1_off_date) = '..' then '' else max(t.pbHfcl_bts1_off_date) end) as pbHfcl_bts1_off_date, 
(case when max(t.pbHfcl_bts2_off_date) = '..' then '' else max(t.pbHfcl_bts2_off_date) end) as pbHfcl_bts2_off_date, 
(case when max(t.pbHfcl_bts3_off_date) = '..' then '' else max(t.pbHfcl_bts3_off_date) end) as pbHfcl_bts3_off_date, 
(case when max(t.pbHfcl_bts4_off_date) = '..' then '' else max(t.pbHfcl_bts4_off_date) end) as pbHfcl_bts4_off_date, 
(case when max(t.pbHfcl_bts5_off_date) = '..' then '' else max(t.pbHfcl_bts5_off_date) end) as pbHfcl_bts5_off_date, 
(case when max(t.pbHfcl_bts6_off_date) = '..' then '' else max(t.pbHfcl_bts6_off_date) end) as pbHfcl_bts6_off_date,

(Case when max(t.rjio_bts1_off_date) = '..' then '' else max(t.rjio_bts1_off_date) end) as rjio_bts1_off_date, 
(Case when max(t.rjio_bts2_off_date) = '..' then '' else max(t.rjio_bts2_off_date) end) as rjio_bts2_off_date,
(Case when max(t.rjio_bts3_off_date) = '..' then '' else max(t.rjio_bts3_off_date) end) as rjio_bts3_off_date,
(Case when max(t.rjio_bts4_off_date) = '..' then '' else max(t.rjio_bts4_off_date) end) as rjio_bts4_off_date,
(Case when max(t.rjio_bts5_off_date) = '..' then '' else max(t.rjio_bts5_off_date) end) as rjio_bts5_off_date,
(Case when max(t.rjio_bts6_off_date) = '..' then '' else max(t.rjio_bts6_off_date) end) as rjio_bts6_off_date,

(case when max(t.sify_bts1_off_date) = '..' then '' else max(t.sify_bts1_off_date) end) as sify_bts1_off_date, 
(case when max(t.sify_bts2_off_date) = '..' then '' else max(t.sify_bts2_off_date) end) as sify_bts2_off_date,
(case when max(t.sify_bts3_off_date) = '..' then '' else max(t.sify_bts3_off_date) end) as sify_bts3_off_date,
(case when max(t.sify_bts4_off_date) = '..' then '' else max(t.sify_bts4_off_date) end) as sify_bts4_off_date,
(case when max(t.sify_bts5_off_date) = '..' then '' else max(t.sify_bts5_off_date) end) as sify_bts5_off_date,
(case when max(t.sify_bts6_off_date) = '..' then '' else max(t.sify_bts6_off_date) end) as sify_bts6_off_date,

(case when max(t.tclIot_bts1_off_date) = '..' then '' else max(t.tclIot_bts1_off_date) end) as tclIot_bts1_off_date, 
(case when max(t.tclIot_bts2_off_date) = '..' then '' else max(t.tclIot_bts2_off_date) end) as tclIot_bts2_off_date,
(case when max(t.tclIot_bts3_off_date) = '..' then '' else max(t.tclIot_bts3_off_date) end) as tclIot_bts3_off_date,
(case when max(t.tclIot_bts4_off_date) = '..' then '' else max(t.tclIot_bts4_off_date) end) as tclIot_bts4_off_date,
(case when max(t.tclIot_bts5_off_date) = '..' then '' else max(t.tclIot_bts5_off_date) end) as tclIot_bts5_off_date,
(case when max(t.tclIot_bts6_off_date) = '..' then '' else max(t.tclIot_bts6_off_date) end) as tclIot_bts6_off_date,

(case when max(t.tclNld_bts1_off_date) = '..' then '' else max(t.tclNld_bts1_off_date) end) as tclNld_bts1_off_date, 
(case when max(t.tclNld_bts2_off_date) = '..' then '' else max(t.tclNld_bts2_off_date) end) as tclNld_bts2_off_date,
(case when max(t.tclNld_bts3_off_date) = '..' then '' else max(t.tclNld_bts3_off_date) end) as tclNld_bts3_off_date,
(case when max(t.tclNld_bts4_off_date) = '..' then '' else max(t.tclNld_bts4_off_date) end) as tclNld_bts4_off_date,
(case when max(t.tclNld_bts5_off_date) = '..' then '' else max(t.tclNld_bts5_off_date) end) as tclNld_bts5_off_date,
(case when max(t.tclNld_bts6_off_date) = '..' then '' else max(t.tclNld_bts6_off_date) end) as tclNld_bts6_off_date,

(case when max(t.tclRedwin_bts1_off_date) = '..' then '' else max(t.tclRedwin_bts1_off_date) end) as tclRedwin_bts1_off_date, 
(case when max(t.tclRedwin_bts2_off_date) = '..' then '' else max(t.tclRedwin_bts2_off_date) end) as tclRedwin_bts2_off_date, 
(case when max(t.tclRedwin_bts3_off_date) = '..' then '' else max(t.tclRedwin_bts3_off_date) end) as tclRedwin_bts3_off_date, 
(case when max(t.tclRedwin_bts4_off_date) = '..' then '' else max(t.tclRedwin_bts4_off_date) end) as tclRedwin_bts4_off_date, 
(case when max(t.tclRedwin_bts5_off_date) = '..' then '' else max(t.tclRedwin_bts5_off_date) end) as tclRedwin_bts5_off_date, 
(case when max(t.tclRedwin_bts6_off_date) = '..' then '' else max(t.tclRedwin_bts6_off_date) end) as tclRedwin_bts6_off_date, 

(case when max(t.tclWimax_bts1_off_date) = '..' then '' else max(t.tclWimax_bts1_off_date) end) as tclWimax_bts1_off_date, 
(case when max(t.tclWimax_bts2_off_date) = '..' then '' else max(t.tclWimax_bts2_off_date) end) as tclWimax_bts2_off_date, 
(case when max(t.tclWimax_bts3_off_date) = '..' then '' else max(t.tclWimax_bts3_off_date) end) as tclWimax_bts3_off_date, 
(case when max(t.tclWimax_bts4_off_date) = '..' then '' else max(t.tclWimax_bts4_off_date) end) as tclWimax_bts4_off_date, 
(case when max(t.tclWimax_bts5_off_date) = '..' then '' else max(t.tclWimax_bts5_off_date) end) as tclWimax_bts5_off_date, 
(case when max(t.tclWimax_bts6_off_date) = '..' then '' else max(t.tclWimax_bts6_off_date) end) as tclWimax_bts6_off_date, 

(case when max(t.ttslCdma_bts1_off_date) = '..' then '' else max(t.ttslCdma_bts1_off_date) end) as ttslCdma_bts1_off_date, 
(case when max(t.ttslCdma_bts2_off_date) = '..' then '' else max(t.ttslCdma_bts2_off_date) end) as ttslCdma_bts2_off_date, 
(case when max(t.ttslCdma_bts3_off_date) = '..' then '' else max(t.ttslCdma_bts3_off_date) end) as ttslCdma_bts3_off_date, 
(case when max(t.ttslCdma_bts4_off_date) = '..' then '' else max(t.ttslCdma_bts4_off_date) end) as ttslCdma_bts4_off_date, 
(case when max(t.ttslCdma_bts5_off_date) = '..' then '' else max(t.ttslCdma_bts5_off_date) end) as ttslCdma_bts5_off_date, 
(case when max(t.ttslCdma_bts6_off_date) = '..' then '' else max(t.ttslCdma_bts6_off_date) end) as ttslCdma_bts6_off_date, 

(case when max(t.ttsl_bts1_off_date) = '..' then '' else max(t.ttsl_bts1_off_date) end) as ttsl_bts1_off_date, 
(case when max(t.ttsl_bts2_off_date) = '..' then '' else max(t.ttsl_bts2_off_date) end) as ttsl_bts2_off_date, 
(case when max(t.ttsl_bts3_off_date) = '..' then '' else max(t.ttsl_bts3_off_date) end) as ttsl_bts3_off_date, 
(case when max(t.ttsl_bts4_off_date) = '..' then '' else max(t.ttsl_bts4_off_date) end) as ttsl_bts4_off_date, 
(case when max(t.ttsl_bts5_off_date) = '..' then '' else max(t.ttsl_bts5_off_date) end) as ttsl_bts5_off_date, 
(case when max(t.ttsl_bts6_off_date) = '..' then '' else max(t.ttsl_bts6_off_date) end) as ttsl_bts6_off_date,

(case when max(t.vodafone_bts1_off_date) = '..' then '' else max(t.vodafone_bts1_off_date) end) as vodafone_bts1_off_date, 
(case when max(t.vodafone_bts2_off_date) = '..' then '' else max(t.vodafone_bts2_off_date) end) as vodafone_bts2_off_date, 
(case when max(t.vodafone_bts3_off_date) = '..' then '' else max(t.vodafone_bts3_off_date) end) as vodafone_bts3_off_date, 
(case when max(t.vodafone_bts4_off_date) = '..' then '' else max(t.vodafone_bts4_off_date) end) as vodafone_bts4_off_date, 
(case when max(t.vodafone_bts5_off_date) = '..' then '' else max(t.vodafone_bts5_off_date) end) as vodafone_bts5_off_date, 
(case when max(t.vodafone_bts6_off_date) = '..' then '' else max(t.vodafone_bts6_off_date) end) as vodafone_bts6_off_date, 

(case when max(t.airtel_bts1_type) = '..' then '' else max(t.airtel_bts1_type) end) as airtel_bts1_type, 
(case when max(t.airtel_bts2_type) = '..' then '' else max(t.airtel_bts2_type) end) as airtel_bts2_type, 
(case when max(t.airtel_bts3_type) = '..' then '' else max(t.airtel_bts3_type) end) as airtel_bts3_type, 
(case when max(t.airtel_bts4_type) = '..' then '' else max(t.airtel_bts4_type) end) as airtel_bts4_type, 
(case when max(t.airtel_bts5_type) = '..' then '' else max(t.airtel_bts5_type) end) as airtel_bts5_type, 
(case when max(t.airtel_bts6_type) = '..' then '' else max(t.airtel_bts6_type) end) as airtel_bts6_type, 

(case when max(t.bsnl_bts1_type) = '..' then '' else max(t.bsnl_bts1_type) end) as bsnl_bts1_type, 
(case when max(t.bsnl_bts2_type) = '..' then '' else max(t.bsnl_bts2_type) end) as bsnl_bts2_type, 
(case when max(t.bsnl_bts3_type) = '..' then '' else max(t.bsnl_bts3_type) end) as bsnl_bts3_type, 
(case when max(t.bsnl_bts4_type) = '..' then '' else max(t.bsnl_bts4_type) end) as bsnl_bts4_type, 
(case when max(t.bsnl_bts5_type) = '..' then '' else max(t.bsnl_bts5_type) end) as bsnl_bts5_type, 
(case when max(t.bsnl_bts6_type) = '..' then '' else max(t.bsnl_bts6_type) end) as bsnl_bts6_type, 

(case when max(t.idea_bts1_type) = '..' then '' else max(t.idea_bts1_type) end) as idea_bts1_type, 
(case when max(t.idea_bts2_type) = '..' then '' else max(t.idea_bts2_type) end) as idea_bts2_type, 
(case when max(t.idea_bts3_type) = '..' then '' else max(t.idea_bts3_type) end) as idea_bts3_type, 
(case when max(t.idea_bts4_type) = '..' then '' else max(t.idea_bts4_type) end) as idea_bts4_type, 
(case when max(t.idea_bts5_type) = '..' then '' else max(t.idea_bts5_type) end) as idea_bts5_type, 
(case when max(t.idea_bts6_type) = '..' then '' else max(t.idea_bts6_type) end) as idea_bts6_type, 

(case when max(t.pbHfcl_bts1_type) = '..' then '' else max(t.pbHfcl_bts1_type) end) as pbHfcl_bts1_type, 
(case when max(t.pbHfcl_bts2_type) = '..' then '' else max(t.pbHfcl_bts2_type) end) as pbHfcl_bts2_type, 
(case when max(t.pbHfcl_bts3_type) = '..' then '' else max(t.pbHfcl_bts3_type) end) as pbHfcl_bts3_type, 
(case when max(t.pbHfcl_bts4_type) = '..' then '' else max(t.pbHfcl_bts4_type) end) as pbHfcl_bts4_type, 
(case when max(t.pbHfcl_bts5_type) = '..' then '' else max(t.pbHfcl_bts5_type) end) as pbHfcl_bts5_type, 
(case when max(t.pbHfcl_bts6_type) = '..' then '' else max(t.pbHfcl_bts6_type) end) as pbHfcl_bts6_type,  

(case when max(t.rjio_bts1_type) = '..' then '' else max(t.rjio_bts1_type) end) as rjio_bts1_type, 
(case when max(t.rjio_bts2_type) = '..' then '' else max(t.rjio_bts2_type) end) as rjio_bts2_type, 
(case when max(t.rjio_bts3_type) = '..' then '' else max(t.rjio_bts3_type) end) as rjio_bts3_type, 
(case when max(t.rjio_bts4_type) = '..' then '' else max(t.rjio_bts4_type) end) as rjio_bts4_type, 
(case when max(t.rjio_bts5_type) = '..' then '' else max(t.rjio_bts5_type) end) as rjio_bts5_type, 
(case when max(t.rjio_bts6_type) = '..' then '' else max(t.rjio_bts6_type) end) as rjio_bts6_type,   

(case when max(t.sify_bts1_type) = '..' then '' else max(t.sify_bts1_type) end) as sify_bts1_type, 
(case when max(t.sify_bts2_type) = '..' then '' else max(t.sify_bts2_type) end) as sify_bts2_type, 
(case when max(t.sify_bts3_type) = '..' then '' else max(t.sify_bts3_type) end) as sify_bts3_type, 
(case when max(t.sify_bts4_type) = '..' then '' else max(t.sify_bts4_type) end) as sify_bts4_type, 
(case when max(t.sify_bts5_type) = '..' then '' else max(t.sify_bts5_type) end) as sify_bts5_type, 
(case when max(t.sify_bts6_type) = '..' then '' else max(t.sify_bts6_type) end) as sify_bts6_type,   

(case when max(t.tclIot_bts1_type) = '..' then '' else max(t.tclIot_bts1_type) end) as tclIot_bts1_type, 
(case when max(t.tclIot_bts2_type) = '..' then '' else max(t.tclIot_bts2_type) end) as tclIot_bts2_type, 
(case when max(t.tclIot_bts3_type) = '..' then '' else max(t.tclIot_bts3_type) end) as tclIot_bts3_type, 
(case when max(t.tclIot_bts4_type) = '..' then '' else max(t.tclIot_bts4_type) end) as tclIot_bts4_type, 
(case when max(t.tclIot_bts5_type) = '..' then '' else max(t.tclIot_bts5_type) end) as tclIot_bts5_type, 
(case when max(t.tclIot_bts6_type) = '..' then '' else max(t.tclIot_bts6_type) end) as tclIot_bts6_type, 

(case when max(t.tclNld_bts1_type) = '..' then '' else max(t.tclNld_bts1_type) end) as tclNld_bts1_type, 
(case when max(t.tclNld_bts2_type) = '..' then '' else max(t.tclNld_bts2_type) end) as tclNld_bts2_type, 
(case when max(t.tclNld_bts3_type) = '..' then '' else max(t.tclNld_bts3_type) end) as tclNld_bts3_type, 
(case when max(t.tclNld_bts4_type) = '..' then '' else max(t.tclNld_bts4_type) end) as tclNld_bts4_type, 
(case when max(t.tclNld_bts5_type) = '..' then '' else max(t.tclNld_bts5_type) end) as tclNld_bts5_type, 
(case when max(t.tclNld_bts6_type) = '..' then '' else max(t.tclNld_bts6_type) end) as tclNld_bts6_type,  

(case when max(t.tclRedwin_bts1_type) = '..' then '' else max(t.tclRedwin_bts1_type) end) as tclRedwin_bts1_type, 
(case when max(t.tclRedwin_bts2_type) = '..' then '' else max(t.tclRedwin_bts2_type) end) as tclRedwin_bts2_type, 
(case when max(t.tclRedwin_bts3_type) = '..' then '' else max(t.tclRedwin_bts3_type) end) as tclRedwin_bts3_type, 
(case when max(t.tclRedwin_bts4_type) = '..' then '' else max(t.tclRedwin_bts4_type) end) as tclRedwin_bts4_type, 
(case when max(t.tclRedwin_bts5_type) = '..' then '' else max(t.tclRedwin_bts5_type) end) as tclRedwin_bts5_type, 
(case when max(t.tclRedwin_bts6_type) = '..' then '' else max(t.tclRedwin_bts6_type) end) as tclRedwin_bts6_type,  

(case when max(t.tclWimax_bts1_type) = '..' then '' else max(t.tclWimax_bts1_type) end) as tclWimax_bts1_type, 
(case when max(t.tclWimax_bts2_type) = '..' then '' else max(t.tclWimax_bts2_type) end) as tclWimax_bts2_type, 
(case when max(t.tclWimax_bts3_type) = '..' then '' else max(t.tclWimax_bts3_type) end) as tclWimax_bts3_type, 
(case when max(t.tclWimax_bts4_type) = '..' then '' else max(t.tclWimax_bts4_type) end) as tclWimax_bts4_type, 
(case when max(t.tclWimax_bts5_type) = '..' then '' else max(t.tclWimax_bts5_type) end) as tclWimax_bts5_type, 
(case when max(t.tclWimax_bts6_type) = '..' then '' else max(t.tclWimax_bts6_type) end) as tclWimax_bts6_type, 

(case when max(t.ttslCdma_bts1_type) = '..' then '' else max(t.ttslCdma_bts1_type) end) as ttslCdma_bts1_type, 
(case when max(t.ttslCdma_bts2_type) = '..' then '' else max(t.ttslCdma_bts2_type) end) as ttslCdma_bts2_type, 
(case when max(t.ttslCdma_bts3_type) = '..' then '' else max(t.ttslCdma_bts3_type) end) as ttslCdma_bts3_type, 
(case when max(t.ttslCdma_bts4_type) = '..' then '' else max(t.ttslCdma_bts4_type) end) as ttslCdma_bts4_type, 
(case when max(t.ttslCdma_bts5_type) = '..' then '' else max(t.ttslCdma_bts5_type) end) as ttslCdma_bts5_type, 
(case when max(t.ttslCdma_bts6_type) = '..' then '' else max(t.ttslCdma_bts6_type) end) as ttslCdma_bts6_type,   

(case when max(t.ttsl_bts1_type) = '..' then '' else max(t.ttsl_bts1_type) end) as ttsl_bts1_type, 
(case when max(t.ttsl_bts2_type) = '..' then '' else max(t.ttsl_bts2_type) end) as ttsl_bts2_type, 
(case when max(t.ttsl_bts3_type) = '..' then '' else max(t.ttsl_bts3_type) end) as ttsl_bts3_type, 
(case when max(t.ttsl_bts4_type) = '..' then '' else max(t.ttsl_bts4_type) end) as ttsl_bts4_type, 
(case when max(t.ttsl_bts5_type) = '..' then '' else max(t.ttsl_bts5_type) end) as ttsl_bts5_type, 
(case when max(t.ttsl_bts6_type) = '..' then '' else max(t.ttsl_bts6_type) end) as ttsl_bts6_type,   

(case when max(t.vodafone_bts1_type) = '..' then '' else max(t.vodafone_bts1_type) end) as vodafone_bts1_type, 
(case when max(t.vodafone_bts2_type) = '..' then '' else max(t.vodafone_bts2_type) end) as vodafone_bts2_type, 
(case when max(t.vodafone_bts3_type) = '..' then '' else max(t.vodafone_bts3_type) end) as vodafone_bts3_type, 
(case when max(t.vodafone_bts4_type) = '..' then '' else max(t.vodafone_bts4_type) end) as vodafone_bts4_type, 
(case when max(t.vodafone_bts5_type) = '..' then '' else max(t.vodafone_bts5_type) end) as vodafone_bts5_type, 
(case when max(t.vodafone_bts6_type) = '..' then '' else max(t.vodafone_bts6_type) end) as vodafone_bts6_type, 

(case when max(t.airtel_bts2_on_date) = '..' then '' else max(t.airtel_bts2_on_date) end) as airtel_bts2_on_date, 
(case when max(t.airtel_bts3_on_date) = '..' then '' else max(t.airtel_bts3_on_date) end) as airtel_bts3_on_date, 
(case when max(t.airtel_bts4_on_date) = '..' then '' else max(t.airtel_bts4_on_date) end) as airtel_bts4_on_date,
(case when max(t.airtel_bts5_on_date) = '..' then '' else max(t.airtel_bts5_on_date) end) as airtel_bts5_on_date, 
(case when max(t.airtel_bts6_on_date) = '..' then '' else max(t.airtel_bts6_on_date) end) as airtel_bts6_on_date,  

(case when max(t.bsnl_bts2_on_date) = '..' then '' else max(t.bsnl_bts2_on_date) end) as bsnl_bts2_on_date, 
(case when max(t.bsnl_bts3_on_date) = '..' then '' else max(t.bsnl_bts3_on_date) end) as bsnl_bts3_on_date, 
(case when max(t.bsnl_bts4_on_date) = '..' then '' else max(t.bsnl_bts4_on_date) end) as bsnl_bts4_on_date, 
(case when max(t.bsnl_bts5_on_date) = '..' then '' else max(t.bsnl_bts5_on_date) end) as bsnl_bts5_on_date, 
(case when max(t.bsnl_bts6_on_date) = '..' then '' else max(t.bsnl_bts6_on_date) end) as bsnl_bts6_on_date, 

(case when max(t.idea_bts2_on_date) = '..' then '' else max(t.idea_bts2_on_date) end) as idea_bts2_on_date, 
(case when max(t.idea_bts3_on_date) = '..' then '' else max(t.idea_bts3_on_date) end) as idea_bts3_on_date, 
(case when max(t.idea_bts4_on_date) = '..' then '' else max(t.idea_bts4_on_date) end) as idea_bts4_on_date, 
(case when max(t.idea_bts5_on_date) = '..' then '' else max(t.idea_bts5_on_date) end) as idea_bts5_on_date, 
(case when max(t.idea_bts6_on_date) = '..' then '' else max(t.idea_bts6_on_date) end) as idea_bts6_on_date,   

(case when max(t.pbHfcl_bts2_on_date) = '..' then '' else max(t.pbHfcl_bts2_on_date) end) as pbHfcl_bts2_on_date, 
(case when max(t.pbHfcl_bts3_on_date) = '..' then '' else max(t.pbHfcl_bts3_on_date) end) as pbHfcl_bts3_on_date, 
(case when max(t.pbHfcl_bts4_on_date) = '..' then '' else max(t.pbHfcl_bts4_on_date) end) as pbHfcl_bts4_on_date, 
(case when max(t.pbHfcl_bts5_on_date) = '..' then '' else max(t.pbHfcl_bts5_on_date) end) as pbHfcl_bts5_on_date, 
(case when max(t.pbHfcl_bts6_on_date) = '..' then '' else max(t.pbHfcl_bts6_on_date) end) as pbHfcl_bts6_on_date, 

(case when max(t.rjio_bts2_on_date) = '..' then '' else max(t.rjio_bts2_on_date) end) as rjio_bts2_on_date, 
(case when max(t.rjio_bts3_on_date) = '..' then '' else max(t.rjio_bts3_on_date) end) as rjio_bts3_on_date, 
(case when max(t.rjio_bts4_on_date) = '..' then '' else max(t.rjio_bts4_on_date) end) as rjio_bts4_on_date, 
(case when max(t.rjio_bts5_on_date) = '..' then '' else max(t.rjio_bts5_on_date) end) as rjio_bts5_on_date, 
(case when max(t.rjio_bts6_on_date) = '..' then '' else max(t.rjio_bts6_on_date) end) as rjio_bts6_on_date, 

(case when max(t.sify_bts2_on_date) = '..' then '' else max(t.sify_bts2_on_date) end) as sify_bts2_on_date, 
(case when max(t.sify_bts3_on_date) = '..' then '' else max(t.sify_bts3_on_date) end) as sify_bts3_on_date, 
(case when max(t.sify_bts4_on_date) = '..' then '' else max(t.sify_bts4_on_date) end) as sify_bts4_on_date, 
(case when max(t.sify_bts5_on_date) = '..' then '' else max(t.sify_bts5_on_date) end) as sify_bts5_on_date, 
(case when max(t.sify_bts6_on_date) = '..' then '' else max(t.sify_bts6_on_date) end) as sify_bts6_on_date, 

(case when max(t.tclIot_bts2_on_date) = '..' then '' else max(t.tclIot_bts2_on_date) end) as tclIot_bts2_on_date, 
(case when max(t.tclIot_bts3_on_date) = '..' then '' else max(t.tclIot_bts3_on_date) end) as tclIot_bts3_on_date, 
(case when max(t.tclIot_bts4_on_date) = '..' then '' else max(t.tclIot_bts4_on_date) end) as tclIot_bts4_on_date, 
(case when max(t.tclIot_bts5_on_date) = '..' then '' else max(t.tclIot_bts5_on_date) end) as tclIot_bts5_on_date, 
(case when max(t.tclIot_bts6_on_date) = '..' then '' else max(t.tclIot_bts6_on_date) end) as tclIot_bts6_on_date, 

(case when max(t.tclNld_bts2_on_date) = '..' then '' else max(t.tclNld_bts2_on_date) end) as tclNld_bts2_on_date, 
(case when max(t.tclNld_bts3_on_date) = '..' then '' else max(t.tclNld_bts3_on_date) end) as tclNld_bts3_on_date, 
(case when max(t.tclNld_bts4_on_date) = '..' then '' else max(t.tclNld_bts4_on_date) end) as tclNld_bts4_on_date, 
(case when max(t.tclNld_bts5_on_date) = '..' then '' else max(t.tclNld_bts5_on_date) end) as tclNld_bts5_on_date, 
(case when max(t.tclNld_bts6_on_date) = '..' then '' else max(t.tclNld_bts6_on_date) end) as tclNld_bts6_on_date, 

(case when max(t.tclRedwin_bts2_on_date) = '..' then '' else max(t.tclRedwin_bts2_on_date) end) as tclRedwin_bts2_on_date, 
(case when max(t.tclRedwin_bts3_on_date) = '..' then '' else max(t.tclRedwin_bts3_on_date) end) as tclRedwin_bts3_on_date, 
(case when max(t.tclRedwin_bts4_on_date) = '..' then '' else max(t.tclRedwin_bts4_on_date) end) as tclRedwin_bts4_on_date, 
(case when max(t.tclRedwin_bts5_on_date) = '..' then '' else max(t.tclRedwin_bts5_on_date) end) as tclRedwin_bts5_on_date, 
(case when max(t.tclRedwin_bts6_on_date) = '..' then '' else max(t.tclRedwin_bts6_on_date) end) as tclRedwin_bts6_on_date, 

(case when max(t.tclWimax_bts2_on_date) = '..' then '' else max(t.tclWimax_bts2_on_date) end) as tclWimax_bts2_on_date, 
(case when max(t.tclWimax_bts3_on_date) = '..' then '' else max(t.tclWimax_bts3_on_date) end) as tclWimax_bts3_on_date, 
(case when max(t.tclWimax_bts4_on_date) = '..' then '' else max(t.tclWimax_bts4_on_date) end) as tclWimax_bts4_on_date, 
(case when max(t.tclWimax_bts5_on_date) = '..' then '' else max(t.tclWimax_bts5_on_date) end) as tclWimax_bts5_on_date, 
(case when max(t.tclWimax_bts6_on_date) = '..' then '' else max(t.tclWimax_bts6_on_date) end) as tclWimax_bts6_on_date, 

(case when max(t.ttslCdma_bts2_on_date) = '..' then '' else max(t.ttslCdma_bts2_on_date) end) as ttslCdma_bts2_on_date, 
(case when max(t.ttslCdma_bts3_on_date) = '..' then '' else max(t.ttslCdma_bts3_on_date) end) as ttslCdma_bts3_on_date, 
(case when max(t.ttslCdma_bts4_on_date) = '..' then '' else max(t.ttslCdma_bts4_on_date) end) as ttslCdma_bts4_on_date, 
(case when max(t.ttslCdma_bts5_on_date) = '..' then '' else max(t.ttslCdma_bts5_on_date) end) as ttslCdma_bts5_on_date, 
(case when max(t.ttslCdma_bts6_on_date) = '..' then '' else max(t.ttslCdma_bts6_on_date) end) as ttslCdma_bts6_on_date, 

(case when max(t.ttsl_bts2_on_date) = '..' then '' else max(t.ttsl_bts2_on_date) end) as ttsl_bts2_on_date, 
(case when max(t.ttsl_bts2_on_date) = '..' then '' else max(t.ttsl_bts3_on_date) end) as ttsl_bts3_on_date, 
(case when max(t.ttsl_bts3_on_date) = '..' then '' else max(t.ttsl_bts4_on_date) end) as ttsl_bts4_on_date, 
(case when max(t.ttsl_bts4_on_date) = '..' then '' else max(t.ttsl_bts5_on_date) end) as ttsl_bts5_on_date, 
(case when max(t.ttsl_bts5_on_date) = '..' then '' else max(t.ttsl_bts6_on_date) end) as ttsl_bts6_on_date, 

(case when max(t.vodafone_bts2_on_date) = '..' then '' else max(t.vodafone_bts2_on_date) end) as vodafone_bts2_on_date, 
(case when max(t.vodafone_bts3_on_date) = '..' then '' else max(t.vodafone_bts3_on_date) end) as vodafone_bts3_on_date, 
(case when max(t.vodafone_bts4_on_date) = '..' then '' else max(t.vodafone_bts4_on_date) end) as vodafone_bts4_on_date, 
(case when max(t.vodafone_bts5_on_date) = '..' then '' else max(t.vodafone_bts5_on_date) end) as vodafone_bts5_on_date, 
(case when max(t.vodafone_bts6_on_date) = '..' then '' else max(t.vodafone_bts6_on_date) end) as vodafone_bts6_on_date, 

(case when max(t.pbHfcl_dg_amount) = '..' then null else sum(pbHfcl_dg_amount) end) as pbHfcl_dg_amount, 
(case when max(t.pbHfcl_eb_amount) = '..' then null else sum(pbHfcl_eb_amount) end) as pbHfcl_eb_amount, 
'48' as siteVoltage, 
(case when max(t.airtel_link_on_date) = '..' then '' else max(t.airtel_link_on_date) end) as airtel_link_on_date, 
(case when max(t.bsnl_link_on_date) = '..' then '' else max(t.bsnl_link_on_date) end) as bsnl_link_on_date, 
(case when max(t.idea_link_on_date) = '..' then '' else max(t.idea_link_on_date) end) as idea_link_on_date, 
(case when max(t.pbHfcl_link_on_date) = '..' then '' else max(t.pbHfcl_link_on_date) end) as pbHfcl_link_on_date, 
(case when max(t.rjio_link_on_date) = '..' then '' else max(t.rjio_link_on_date) end) as rjio_link_on_date, 
(case when max(t.sify_link_on_date) = '..' then '' else max(t.sify_link_on_date) end) as sify_link_on_date, 
(case when max(t.tclIot_link_on_date) = '..' then '' else max(t.tclIot_link_on_date) end) as tclIot_link_on_date, 
(case when max(t.tclNld_link_on_date) = '..' then '' else max(t.tclNld_link_on_date) end) as tclNld_link_on_date, 
(case when max(t.tclRedwin_link_on_date) = '..' then '' else max(t.tclRedwin_link_on_date) end) as tclRedwin_link_on_date, 
(case when max(t.tclWimax_link_on_date) = '..' then '' else max(t.tclWimax_link_on_date) end) as tclWimax_link_on_date, 
(case when max(t.ttslCdma_link_on_date) = '..' then '' else max(t.ttslCdma_link_on_date) end) as ttslCdma_link_on_date, 
(case when max(t.ttsl_link_on_date) = '..' then '' else max(t.ttsl_link_on_date) end) as ttsl_link_on_date, 
(case when max(t.vodafone_link_on_date) = '..' then '' else max(t.vodafone_link_on_date) end) as vodafone_link_on_date,

(case when max(t.airtel_link_off_date) = '..' then '' else max(t.airtel_link_off_date) end) as airtel_link_off_date, 
(case when max(t.bsnl_link_off_date) = '..' then '' else max(t.bsnl_link_off_date) end) as bsnl_link_off_date, 
(case when max(t.idea_link_off_date) = '..' then '' else max(t.idea_link_off_date) end) as idea_link_off_date, 
(case when max(t.pbHfcl_link_off_date) = '..' then '' else max(t.pbHfcl_link_off_date) end) as pbHfcl_link_off_date, 
(case when max(t.rjio_link_off_date) = '..' then '' else max(t.rjio_link_off_date) end) as rjio_link_off_date, 
(case when max(t.sify_link_off_date) = '..' then '' else max(t.sify_link_off_date) end) as sify_link_off_date, 
(case when max(t.tclIot_link_off_date) = '..' then '' else max(t.tclIot_link_off_date) end) as tclIot_link_off_date, 
(case when max(t.tclNld_link_off_date) = '..' then '' else max(t.tclNld_link_off_date) end) as tclNld_link_off_date, 
(case when max(t.tclRedwin_link_off_date) = '..' then '' else max(t.tclRedwin_link_off_date) end) as tclRedwin_link_off_date, 
(case when max(t.tclWimax_link_off_date) = '..' then '' else max(t.tclWimax_link_off_date) end) as tclWimax_link_off_date, 
(case when max(t.ttslCdma_link_off_date) = '..' then '' else max(t.ttslCdma_link_off_date) end) as ttslCdma_link_off_date, 
(case when max(t.ttsl_link_off_date) = '..' then '' else max(t.ttsl_link_off_date) end) as ttsl_link_off_date, 
(case when max(t.vodafone_link_off_date) = '..' then '' else max(t.vodafone_link_off_date) end) as vodafone_link_off_date  

from (
SELECT `Site ID ( SAP ID)` as site_id, `VIL_Site_Master`.`Site Name` as site_name, `Telecom Circle Name` as opco_circle_name, 
(case when `Operator Name` = 'Airtel' then `BTS1_BTS on air Date` else '..' end) as airtel_on_air_date, '..' as airtel_off_date, (case when `Operator Name` = 'Airtel' then `VIL_Site_Master`.`Total Load` else '..' end) as airtel_load, 
(case when `Operator Name` = 'BSNL' then `BTS1_BTS on air Date` else '..' end) as bsnl_on_air_date, '..' as bsnl_off_date, (case when `Operator Name` = 'BSNL' then `VIL_Site_Master`.`Total Load` else '..' end) as bsnl_load, 
(case when `Operator Name` = 'IDEA' then `BTS1_BTS on air Date` else '..' end) as idea_on_air_date, '..' as idea_off_date, (case when `Operator Name` = 'IDEA' then `VIL_Site_Master`.`Total Load` else '..' end) as idea_load, 
(case when `Operator Name` = 'PB(HFCL)' then `BTS1_BTS on air Date` else '..' end) as pbHFCL_on_air_date, '..' as pbHFCL_off_date, (case when `Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`Total Load` else '..' end) as pbHFCL_load, 
(case when `Operator Name` = 'RJIO' then `BTS1_BTS on air Date` else '..' end) as rjio_on_air_date, '..' as rjio_off_date, (case when `Operator Name` = 'RJIO' then `VIL_Site_Master`.`Total Load` else '..' end) as rjio_load, 
(case when `Operator Name` = 'Sify' then `BTS1_BTS on air Date` else '..' end) as sify_on_air_date, '..' as sify_off_date, (case when `Operator Name` = 'Sify' then `VIL_Site_Master`.`Total Load` else '..' end) as sify_load, 
(case when `Operator Name` = 'TCL-IOT' then `BTS1_BTS on air Date` else '..' end) as tclIot_on_air_date, '..' as tclIot_off_date, (case when `Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`Total Load` else '..' end) as tcIOT_load, 
(case when `Operator Name` = 'TCL-NLD' then `BTS1_BTS on air Date` else '..' end) as tclNld_on_air_date, '..' as tclNld_off_date, (case when `Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`Total Load` else '..' end) as tclNLD_load, 
(case when `Operator Name` = 'TCL-Redwin' then `BTS1_BTS on air Date` else '..' end) as tclRedwin_on_air_date, '..' as tclRedwin_off_date, (case when `Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`Total Load` else '..' end) as tclRedwin_load, 
(case when `Operator Name` = 'TCL-Wimax' then `BTS1_BTS on air Date` else '..' end) as tclWimax_on_air_date, '..' as tclWimax_off_date, (case when `Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`Total Load` else '..' end) as tclWimax_load, 
(case when `Operator Name` = 'TTSL-CDMA' then `BTS1_BTS on air Date` else '..' end) as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, (case when `Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`Total Load` else '..' end) as ttslCDMA_load, 
(case when `Operator Name` = 'TTSL' then `BTS1_BTS on air Date` else '..' end) as ttsl_on_air_date, '..' as ttsl_off_date, (case when `Operator Name` = 'TTSL' then `VIL_Site_Master`.`Total Load` else '..' end)  as ttsl_load,
(case when `Operator Name` = 'Vodafone' then `BTS1_BTS on air Date` else '..' end) as vodafone_on_air_date, '..' as vodafone_off_date, (case when `Operator Name` = 'Vodafone' then `VIL_Site_Master`.`Total Load` else '..' end) as vodafone_load,
(case when `Operator Name` = 'Airtel' then `Total Average Aircon Load at Site` else '..' end) as Airtel_Aircon_Load_in_KW,
(case when `Operator Name` = 'BSNL' then `Total Average Aircon Load at Site` else '..' end) as BSNL_Aircon_Load_in_KW,
(case when `Operator Name` = 'IDEA' then `Total Average Aircon Load at Site` else '..' end) as IDEA_Aircon_Load_in_KW,
(case when `Operator Name` = 'PB(HFCL)' then `Total Average Aircon Load at Site` else '..' end) as HFCL_Aircon_Load_in_KW,
(case when `Operator Name` = 'RJIO' then `Total Average Aircon Load at Site` else '..' end) as RJIO_Aircon_Load_in_KW,
(case when `Operator Name` = 'Sify' then `Total Average Aircon Load at Site` else '..' end) as Sify_Aircon_Load_in_KW,
(case when `Operator Name` = 'TCL-IOT' then `Total Average Aircon Load at Site` else '..' end) as tclIot_Aircon_Load_in_KW,
(case when `Operator Name` = 'TCL-NLD' then `Total Average Aircon Load at Site` else '..' end) as tclNld_Aircon_Load_in_KW,
(case when `Operator Name` = 'TCL-Redwin' then `Total Average Aircon Load at Site` else '..' end) as tclRedwin_Aircon_Load_in_KW,
(case when `Operator Name` = 'TCL-Wimax' then `Total Average Aircon Load at Site` else '..' end) as tclWinmax_Aircon_Load_in_KW,
(case when `Operator Name` = 'TTSL-CDMA' then `Total Average Aircon Load at Site` else '..' end) as ttslCdma_Aircon_Load_in_KW,
(case when `Operator Name` = 'TTSL' then `Total Average Aircon Load at Site` else '..' end) as ttsl_Aircon_Load_in_KW,
(case when `Operator Name` = 'Vodafone' then `Total Average Aircon Load at Site` else '..' end) as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays,  
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, `VIL_Site_Master`.`GBT/RTT/Pole` as siteType, `VIL_Site_Master`.`EB Conn Date` as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) airtel_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) airtel_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) airtel_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) airtel_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) airtel_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) airtel_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) bsnl_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) bsnl_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) bsnl_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) bsnl_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) bsnl_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) bsnl_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) idea_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) idea_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) idea_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) idea_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) idea_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) idea_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) pbHfcl_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) pbHfcl_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) pbHfcl_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) pbHfcl_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) pbHfcl_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) pbHfcl_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) rjio_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) rjio_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) rjio_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) rjio_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) rjio_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) rjio_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) sify_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) sify_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) sify_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) sify_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) sify_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) sify_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) tclIot_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) tclIot_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) tclIot_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) tclIot_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) tclIot_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) tclIot_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) tclNld_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) tclNld_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) tclNld_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) tclNld_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) tclNld_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) tclNld_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) tclRedwin_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) tclRedwin_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) tclRedwin_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) tclRedwin_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) tclRedwin_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) tclRedwin_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) tclWimax_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) tclWimax_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) tclWimax_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) tclWimax_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) tclWimax_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) tclWimax_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) ttslCdma_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) ttslCdma_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) ttslCdma_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) ttslCdma_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) ttslCdma_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) ttslCdma_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) ttsl_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) ttsl_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) ttsl_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) ttsl_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) ttsl_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) ttsl_bts6_off_date,

(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS1_BTS OFF Date` end) vodafone_bts1_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS2_BTS OFF Date` end) vodafone_bts2_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS3_BTS OFF Date` end) vodafone_bts3_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS4_BTS OFF Date` end) vodafone_bts4_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS5_BTS OFF Date` end) vodafone_bts5_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS6_BTS OFF Date` end) vodafone_bts6_off_date, 

(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) airtel_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) airtel_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) airtel_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) airtel_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) airtel_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) airtel_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) bsnl_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) bsnl_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) bsnl_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) bsnl_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) bsnl_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) bsnl_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) idea_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) idea_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) idea_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) idea_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) idea_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) idea_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) pbHfcl_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) pbHfcl_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) pbHfcl_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) pbHfcl_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) pbHfcl_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) pbHfcl_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) rjio_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) rjio_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) rjio_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) rjio_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) rjio_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) rjio_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) sify_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) sify_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) sify_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) sify_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) sify_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) sify_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) tclIot_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) tclIot_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) tclIot_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) tclIot_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) tclIot_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) tclIot_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) tclNld_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) tclNld_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) tclNld_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) tclNld_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) tclNld_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) tclNld_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) tclRedwin_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) tclRedwin_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) tclRedwin_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) tclRedwin_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) tclRedwin_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) tclRedwin_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) tclWimax_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) tclWimax_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) tclWimax_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) tclWimax_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) tclWimax_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) tclWimax_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) ttslCdma_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) ttslCdma_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) ttslCdma_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) ttslCdma_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) ttslCdma_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) ttslCdma_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) ttsl_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) ttsl_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) ttsl_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) ttsl_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) ttsl_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) ttsl_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS1_BTS type (ID/OD)` end) vodafone_bts1_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS2_BTS type (ID/OD)` end) vodafone_bts2_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS3_BTS type (ID/OD)` end) vodafone_bts3_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS4_BTS type (ID/OD)` end) vodafone_bts4_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS5_BTS type (ID/OD)` end) vodafone_bts5_type,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS6_BTS type (ID/OD)` end) vodafone_bts6_type,

(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) airtel_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) airtel_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) airtel_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) airtel_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) airtel_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) bsnl_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) bsnl_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) bsnl_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) bsnl_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) bsnl_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) idea_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) idea_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) idea_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) idea_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) idea_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) pbHfcl_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) pbHfcl_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) pbHfcl_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) pbHfcl_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) pbHfcl_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) rjio_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) rjio_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) rjio_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) rjio_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) rjio_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) sify_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) sify_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) sify_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) sify_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) sify_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) tclIot_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) tclIot_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) tclIot_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) tclIot_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) tclIot_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) tclNld_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) tclNld_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) tclNld_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) tclNld_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) tclNld_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) tclRedwin_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) tclRedwin_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) tclRedwin_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) tclRedwin_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) tclRedwin_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) tclWimax_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) tclWimax_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) tclWimax_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) tclWimax_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) tclWimax_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) ttslCdma_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) ttslCdma_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) ttslCdma_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) ttslCdma_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) ttslCdma_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) ttsl_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) ttsl_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) ttsl_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) ttsl_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) ttsl_bts6_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS2_BTS on air Date` end) vodafone_bts2_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS3_BTS on air Date` end) vodafone_bts3_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS4_BTS on air Date` end) vodafone_bts4_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS5_BTS on air Date` end) vodafone_bts5_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`BTS6_BTS on air Date` end) vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`Link on air Date` end) airtel_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`Link on air Date` end) bsnl_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`Link on air Date` end) idea_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`Link on air Date` end) pbHfcl_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`Link on air Date` end) rjio_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`Link on air Date` end) sify_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`Link on air Date` end) tclIot_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`Link on air Date` end) tclNld_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`Link on air Date` end) tclRedwin_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`Link on air Date` end) tclWimax_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`Link on air Date` end) ttslCdma_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`Link on air Date` end) ttsl_link_on_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`Link on air Date` end) vodafone_link_on_date,

(case when `VIL_Site_Master`.`Operator Name` = 'Airtel' then `VIL_Site_Master`.`Link OFF Date` end) airtel_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'BSNL' then `VIL_Site_Master`.`Link OFF Date` end) bsnl_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'IDEA' then `VIL_Site_Master`.`Link OFF Date` end) idea_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'PB(HFCL)' then `VIL_Site_Master`.`Link OFF Date` end) pbHfcl_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'RJIO' then `VIL_Site_Master`.`Link OFF Date` end) rjio_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Sify' then `VIL_Site_Master`.`Link OFF Date` end) sify_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-IOT' then `VIL_Site_Master`.`Link OFF Date` end) tclIot_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-NLD' then `VIL_Site_Master`.`Link OFF Date` end) tclNld_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Redwin' then `VIL_Site_Master`.`Link OFF Date` end) tclRedwin_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TCL-Wimax' then `VIL_Site_Master`.`Link OFF Date` end) tclWimax_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL-CDMA' then `VIL_Site_Master`.`Link OFF Date` end) ttslCdma_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'TTSL' then `VIL_Site_Master`.`Link OFF Date` end) ttsl_link_off_date,
(case when `VIL_Site_Master`.`Operator Name` = 'Vodafone' then `VIL_Site_Master`.`Link OFF Date` end) vodafone_link_off_date 
FROM `VIL_Site_Master` WHERE `VIL_Site_Master`.`Period` = '$period' 
union 
SELECT `VIL_Site_Energy_Cost`.`TVI Site ID` as site_id, `VIL_Site_Energy_Cost`.`TVI Site Name` as site_name, `VIL_Site_Energy_Cost`.`Circle Name` as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
`VIL_Site_Energy_Cost`.`From Date` as dieselBillingFromDate, `VIL_Site_Energy_Cost`.`Upto Date` as dieselBillingUpToDate, 
`VIL_Site_Energy_Cost`.`No of Days Consumption` as dieselNoOfDays,  `VIL_Site_Energy_Cost`.`Approved Diesel Cost` as dieselCost, 
`VIL_Site_Energy_Cost`.`Normalized EB cost the month` as ebCost, `VIL_Site_Energy_Cost`.`Total Energy Cost for the month (Diesel+EB)` as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays,
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `VIL_Site_Energy_Cost` where `VIL_Site_Energy_Cost`.`Period` = '$period' 
union 
SELECT `Airtel_Output_April`.`Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
sum(`Airtel_Output_April`.`Airtel Diesel Amount`) as airtel_dg_amount, 
sum(`Airtel_Output_April`.`Airtel EB Amount`) as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,
'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `Airtel_Output_April` where `Airtel_Output_April`.`Period` = '$period' group by `Airtel_Output_April`.`Site ID`  
UNION 
SELECT `BSNL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
sum(`BSNL_Output_April`.`Total Diesel cost`) as bsnl_dg_amount, 
sum(`BSNL_Output_April`.`Total EB cost`) as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,
'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `BSNL_Output_April` where `BSNL_Output_April`.`Period` = '$period' group by `BSNL_Output_April`.`IP Site ID`
union 
SELECT `vil_output_consol`.`TVI Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
sum(`vil_output_consol`.`IDEA Diesel Share` + `vil_output_consol`.`Idea Link Diesel Share`) as idea_dg_amount, 
sum(`vil_output_consol`.`IDEA EB Share` + `vil_output_consol`.`Idea Link EB Share`) as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `vil_output_consol` where `vil_output_consol`.`IDEA EB Share` is not null and `vil_output_consol`.`BillCycleMonth` = '$period' group by `vil_output_consol`.`TVI Site ID` 
UNION 
SELECT `RJIO_Output_April`.`TVI Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
SUM(`DG_CPH_Cabex` * `DGRate` * `DGHrs` * `NoOfDays` + `DG_Billing_Amt`) as rjio_dg_amount, SUM(`EB_CPH_Cabex` * `EBRate` * `EBHrs` * `NoOfDays` + `EB_Billing_Amt`) as rjio_eb_amount, 
'0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `RJIO_Output_April` where `RJIO_Output_April`.`Period` = '$period' and `EffectiveStartDate` like '%$period' group by `RJIO_Output_April`.`TVI Site ID` 
UNION 
SELECT `TCL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
sum(`TCL_Output_April`.`DG Billable Amt`) as tclIot_dg_amount,
sum(`TCL_Output_April`.`EB Billable Amt`) as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `TCL_Output_April` where `TCL_Output_April`.`CustomerName` = 'TCL-IOT' and `TCL_Output_April`.`Period` = '$period' group by `TCL_Output_April`.`IP Site ID` 
UNION  
SELECT `TCL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
sum(`TCL_Output_April`.`DG Billable Amt`) as tclNld_dg_amount,
sum(`TCL_Output_April`.`EB Billable Amt`) as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `TCL_Output_April` where `TCL_Output_April`.`CustomerName` = 'TCL - NLD' and `TCL_Output_April`.`Period` = '$period' group by `TCL_Output_April`.`IP Site ID` 
UNION 
SELECT `TCL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
sum(`TCL_Output_April`.`DG Billable Amt`) as tclRedwin_dg_amount,
sum(`TCL_Output_April`.`EB Billable Amt`) as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `TCL_Output_April` where `TCL_Output_April`.`CustomerName` = 'TCL - Redwin' and `TCL_Output_April`.`Period` = '$period' group by `TCL_Output_April`.`IP Site ID` 
UNION 
SELECT `TCL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
sum(`TCL_Output_April`.`DG Billable Amt`) as tclWimax_dg_amount,
sum(`TCL_Output_April`.`EB Billable Amt`) as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `TCL_Output_April` where `TCL_Output_April`.`CustomerName` = 'TCL-Wimax' and `TCL_Output_April`.`Period` = '$period' group by `TCL_Output_April`.`IP Site ID` 
UNION 
SELECT `vil_output_consol`.`TVI Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
sum(`vil_output_consol`.`Vodafone Diesel Share` + `vil_output_consol`.`VodaLink Diesel Share`) as vodafone_dg_amount,
sum(`vil_output_consol`.`Vodafone EB Share` + `vil_output_consol`.`VodaLink EB Share`) as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `vil_output_consol`  where `vil_output_consol`.`Vodafone EB Share` is not null and `vil_output_consol`.`BillCycleMonth` = '$period' group by `vil_output_consol`.`TVI Site ID` 
union 
SELECT `PBHFCL_Output_April`.`IP Site ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount, 
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
'..' as ttsl_dg_amount,
'..' as ttsl_eb_amount,
'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date,
'..' as vodafone_bts3_on_date,
'..' as vodafone_bts4_on_date,
'..' as vodafone_bts5_on_date,
'..' as vodafone_bts6_on_date,
sum(`PBHFCL_Output_April`.`DG Billable Amt`) as pbHfcl_dg_amount,
sum(`PBHFCL_Output_April`.`EB Billable Amt`) as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `PBHFCL_Output_April` WHERE `PBHFCL_Output_April`.`Period` = '$period'  group by `PBHFCL_Output_April`.`IP Site ID` 
union 
SELECT `TTSL_Output_April`.`SITE ID` as site_id, '..' as site_name, '..' as opco_circle_name, 
'..' as airtel_on_air_date, '..' as airtel_off_date, '..' as airtel_load,
'..' as bsnl_on_air_date, '..' as bsnl_off_date, '..' as bsnl_load,
'..' as idea_on_air_date, '..' as idea_off_date, '..' as idea_load,
'..' as pbHFCL_on_air_date, '..' as pbHFCL_off_date, '..' as pbHFCL_load,
'..' as rjio_on_air_date, '..' as rjio_off_date, '..' as rjio_load,
'..' as sily_on_air_date, '..' as sify_off_date, '..' as sify_load,
'..' as tclIot_on_air_date, '..' as tclIot_off_date, '..' as tcIOT_load,
'..' as tclNld_on_air_date, '..' as tclNld_off_date, '..' as tclNLD_load,
'..' as tclRedwin_on_air_date, '..' as tclRedwin_off_date, '..' as tclRedwin_load,
'..' as tclWimax_on_air_date, '..' as tclWimax_off_date, '..' as tclWimax_load,
'..' as ttslCDMA_on_air_date, '..' as ttslCDMA_off_date, '..' as ttslCDMA_load,
'..' as ttsl_on_air_date, '..' as ttsl_off_date, '..' as ttsl_load,
'..' as vodafone_on_air_date, '..' as vodafone_off_date, '..' as vodafone_load,
'..' as Airtel_Aircon_Load_in_KW,
'..' as BSNL_Aircon_Load_in_KW,
'..' as IDEA_Aircon_Load_in_KW,
'..' as HFCL_Aircon_Load_in_KW,
'..' as RJIO_Aircon_Load_in_KW,
'..' as Sify_Aircon_Load_in_KW,
'..' as tclIot_Aircon_Load_in_KW,
'..' as tclNld_Aircon_Load_in_KW,
'..' as tclRedwin_Aircon_Load_in_KW,
'..' as tclWinmax_Aircon_Load_in_KW,
'..' as ttslCdma_Aircon_Load_in_KW,
'..' as ttsl_Aircon_Load_in_KW,
'..' as vadafone_Aircon_Load_in_KW,
'..' as dieselBillingFromDate, '..' as dieselBillingUpToDate, 
'..' as dieselNoOfDays, '..' as dieselCost, 
'..' as ebCost, '..' as energyCost,
'..' as airtelDays,  
'..' as bsnlDays,  
'..' as ideaDays,  
'..' as pbHFCLDays,  
'..' as rjioDays,  
'..' as sifyDays,  
'..' as tclIotDays,  
'..' as tclNldDays,  
'..' as tclRedwinDays,  
'..' as tclWimaxDays,  
'..' as ttslCdmaDays,  
'..' as ttslDays,  
'..' as vodafoneDays, 
'..' as rjio_dg_amount, '..' as rjio_eb_amount, '0' as no_of_tenancy, '..' as siteType, '..' as ebStatus,
'..' as airtel_dg_amount,
'..' as airtel_eb_amount,
'..' as bsnl_dg_amount,
'..' as bsnl_eb_amount,
'..' as tclIot_dg_amount,
'..' as tclIot_eb_amount,
'..' as tclNld_dg_amount,
'..' as tclNld_eb_amount,
'..' as tclRedwin_dg_amount,
'..' as tclRedwin_eb_amount,
'..' as tclWimax_dg_amount,
'..' as tclWimax_eb_amount,
'..' as idea_dg_amount,
'..' as idea_eb_amount,
'..' as vodafone_dg_amount,
'..' as vodafone_eb_amount,
'..' as ttslCdma_dg_amount,
'..' as ttslCdma_eb_amount,
sum(`TTSL_Output_April`.`Total Diesel Share`) as ttsl_dg_amount,
sum(`TTSL_Output_April`.`Total EB Share`) as ttsl_eb_amount,

'..' as airtel_bts1_off_date,
'..' as airtel_bts2_off_date,
'..' as airtel_bts3_off_date,
'..' as airtel_bts4_off_date,
'..' as airtel_bts5_off_date,
'..' as airtel_bts6_off_date,

'..' as bsnl_bts1_off_date,
'..' as bsnl_bts2_off_date,
'..' as bsnl_bts3_off_date,
'..' as bsnl_bts4_off_date,
'..' as bsnl_bts5_off_date,
'..' as bsnl_bts6_off_date,

'..' as idea_bts1_off_date,
'..' as idea_bts2_off_date,
'..' as idea_bts3_off_date,
'..' as idea_bts4_off_date,
'..' as idea_bts5_off_date,
'..' as idea_bts6_off_date,

'..' as pbHfcl_bts1_off_date,
'..' as pbHfcl_bts2_off_date,
'..' as pbHfcl_bts3_off_date,
'..' as pbHfcl_bts4_off_date,
'..' as pbHfcl_bts5_off_date,
'..' as pbHfcl_bts6_off_date,

'..' as rjio_bts1_off_date,
'..' as rjio_bts2_off_date,
'..' as rjio_bts3_off_date,
'..' as rjio_bts4_off_date,
'..' as rjio_bts5_off_date,
'..' as rjio_bts6_off_date,

'..' as sify_bts1_off_date,
'..' as sify_bts2_off_date,
'..' as sify_bts3_off_date,
'..' as sify_bts4_off_date,
'..' as sify_bts5_off_date,
'..' as sify_bts6_off_date,

'..' as tclIot_bts1_off_date,
'..' as tclIot_bts2_off_date,
'..' as tclIot_bts3_off_date,
'..' as tclIot_bts4_off_date,
'..' as tclIot_bts5_off_date,
'..' as tclIot_bts6_off_date,

'..' as tclNld_bts1_off_date,
'..' as tclNld_bts2_off_date,
'..' as tclNld_bts3_off_date,
'..' as tclNld_bts4_off_date,
'..' as tclNld_bts5_off_date,
'..' as tclNld_bts6_off_date,

'..' as tclRedwin_bts1_off_date,
'..' as tclRedwin_bts2_off_date,
'..' as tclRedwin_bts3_off_date,
'..' as tclRedwin_bts4_off_date,
'..' as tclRedwin_bts5_off_date,
'..' as tclRedwin_bts6_off_date,

'..' as tclWimax_bts1_off_date,
'..' as tclWimax_bts2_off_date,
'..' as tclWimax_bts3_off_date,
'..' as tclWimax_bts4_off_date,
'..' as tclWimax_bts5_off_date,
'..' as tclWimax_bts6_off_date,

'..' as ttslCdma_bts1_off_date,
'..' as ttslCdma_bts2_off_date,
'..' as ttslCdma_bts3_off_date,
'..' as ttslCdma_bts4_off_date,
'..' as ttslCdma_bts5_off_date,
'..' as ttslCdma_bts6_off_date,

'..' as ttsl_bts1_off_date,
'..' as ttsl_bts2_off_date,
'..' as ttsl_bts3_off_date,
'..' as ttsl_bts4_off_date,
'..' as ttsl_bts5_off_date,
'..' as ttsl_bts6_off_date,

'..' as vodafone_bts1_off_date,
'..' as vodafone_bts2_off_date,
'..' as vodafone_bts3_off_date,
'..' as vodafone_bts4_off_date,
'..' as vodafone_bts5_off_date,
'..' as vodafone_bts6_off_date,

'..' as airtel_bts1_type,
'..' as airtel_bts2_type,
'..' as airtel_bts3_type,
'..' as airtel_bts4_type,
'..' as airtel_bts5_type,
'..' as airtel_bts6_type,

'..' as bsnl_bts1_type,
'..' as bsnl_bts2_type,
'..' as bsnl_bts3_type,
'..' as bsnl_bts4_type,
'..' as bsnl_bts5_type,
'..' as bsnl_bts6_type,

'..' as idea_bts1_type,
'..' as idea_bts2_type,
'..' as idea_bts3_type,
'..' as idea_bts4_type,
'..' as idea_bts5_type,
'..' as idea_bts6_type,

'..' as pbHfcl_bts1_type,
'..' as pbHfcl_bts2_type,
'..' as pbHfcl_bts3_type,
'..' as pbHfcl_bts4_type,
'..' as pbHfcl_bts5_type,
'..' as pbHfcl_bts6_type,

'..' as rjio_bts1_type,
'..' as rjio_bts2_type,
'..' as rjio_bts3_type,
'..' as rjio_bts4_type,
'..' as rjio_bts5_type,
'..' as rjio_bts6_type,

'..' as sify_bts1_type,
'..' as sify_bts2_type,
'..' as sify_bts3_type,
'..' as sify_bts4_type,
'..' as sify_bts5_type,
'..' as sify_bts6_type,

'..' as tclIot_bts1_type,
'..' as tclIot_bts2_type,
'..' as tclIot_bts3_type,
'..' as tclIot_bts4_type,
'..' as tclIot_bts5_type,
'..' as tclIot_bts6_type,

'..' as tclNld_bts1_type,
'..' as tclNld_bts2_type,
'..' as tclNld_bts3_type,
'..' as tclNld_bts4_type,
'..' as tclNld_bts5_type,
'..' as tclNld_bts6_type,

'..' as tclRedwin_bts1_type,
'..' as tclRedwin_bts2_type,
'..' as tclRedwin_bts3_type,
'..' as tclRedwin_bts4_type,
'..' as tclRedwin_bts5_type,
'..' as tclRedwin_bts6_type,

'..' as tclWimax_bts1_type,
'..' as tclWimax_bts2_type,
'..' as tclWimax_bts3_type,
'..' as tclWimax_bts4_type,
'..' as tclWimax_bts5_type,
'..' as tclWimax_bts6_type,

'..' as ttslCdma_bts1_type,
'..' as ttslCdma_bts2_type,
'..' as ttslCdma_bts3_type,
'..' as ttslCdma_bts4_type,
'..' as ttslCdma_bts5_type,
'..' as ttslCdma_bts6_type,

'..' as ttsl_bts1_type,
'..' as ttsl_bts2_type,
'..' as ttsl_bts3_type,
'..' as ttsl_bts4_type,
'..' as ttsl_bts5_type,
'..' as ttsl_bts6_type,

'..' as vodafone_bts1_type,
'..' as vodafone_bts2_type,
'..' as vodafone_bts3_type,
'..' as vodafone_bts4_type,
'..' as vodafone_bts5_type,
'..' as vodafone_bts6_type,

'..' as airtel_bts2_on_date,
'..' as airtel_bts3_on_date,
'..' as airtel_bts4_on_date,
'..' as airtel_bts5_on_date,
'..' as airtel_bts6_on_date,

'..' as bsnl_bts2_on_date,
'..' as bsnl_bts3_on_date,
'..' as bsnl_bts4_on_date,
'..' as bsnl_bts5_on_date,
'..' as bsnl_bts6_on_date,

'..' as idea_bts2_on_date,
'..' as idea_bts3_on_date,
'..' as idea_bts4_on_date,
'..' as idea_bts5_on_date,
'..' as idea_bts6_on_date,

'..' as pbHfcl_bts2_on_date,
'..' as pbHfcl_bts3_on_date,
'..' as pbHfcl_bts4_on_date,
'..' as pbHfcl_bts5_on_date,
'..' as pbHfcl_bts6_on_date,

'..' as rjio_bts2_on_date,
'..' as rjio_bts3_on_date,
'..' as rjio_bts4_on_date,
'..' as rjio_bts5_on_date,
'..' as rjio_bts6_on_date,

'..' as sify_bts2_on_date,
'..' as sify_bts3_on_date,
'..' as sify_bts4_on_date,
'..' as sify_bts5_on_date,
'..' as sify_bts6_on_date,

'..' as tclIot_bts2_on_date,
'..' as tclIot_bts3_on_date,
'..' as tclIot_bts4_on_date,
'..' as tclIot_bts5_on_date,
'..' as tclIot_bts6_on_date,

'..' as tclNld_bts2_on_date,
'..' as tclNld_bts3_on_date,
'..' as tclNld_bts4_on_date,
'..' as tclNld_bts5_on_date,
'..' as tclNld_bts6_on_date,

'..' as tclRedwin_bts2_on_date,
'..' as tclRedwin_bts3_on_date,
'..' as tclRedwin_bts4_on_date,
'..' as tclRedwin_bts5_on_date,
'..' as tclRedwin_bts6_on_date,

'..' as tclWimax_bts2_on_date,
'..' as tclWimax_bts3_on_date,
'..' as tclWimax_bts4_on_date,
'..' as tclWimax_bts5_on_date,
'..' as tclWimax_bts6_on_date,

'..' as ttslCdma_bts2_on_date,
'..' as ttslCdma_bts3_on_date,
'..' as ttslCdma_bts4_on_date,
'..' as ttslCdma_bts5_on_date,
'..' as ttslCdma_bts6_on_date,

'..' as ttsl_bts2_on_date,
'..' as ttsl_bts3_on_date,
'..' as ttsl_bts4_on_date,
'..' as ttsl_bts5_on_date,
'..' as ttsl_bts6_on_date,

'..' as vodafone_bts2_on_date, '..' as vodafone_bts3_on_date, '..' as vodafone_bts4_on_date, '..' as vodafone_bts5_on_date,'..' as vodafone_bts6_on_date,

'..' as pbHfcl_dg_amount,
'..' as pbHfcl_eb_amount,
'..' airtel_link_on_date, '..' bsnl_link_on_date, '..' idea_link_on_date, '..' pbHfcl_link_on_date, '..' rjio_link_on_date, '..' sify_link_on_date, '..' tclIot_link_on_date, '..' tclNld_link_on_date, '..' tclRedwin_link_on_date, '..' tclWimax_link_on_date, '..' ttslCdma_link_on_date, '..' ttsl_link_on_date, '..' vodafone_link_on_date,

'..' airtel_link_off_date, '..' bsnl_link_off_date, '..' idea_link_off_date, '..' pbHfcl_link_off_date, '..' rjio_link_off_date, '..' sify_link_off_date, '..' tclIot_link_off_date, '..' tclNld_link_off_date, '..' tclRedwin_link_off_date, '..' tclWimax_link_off_date, '..' ttslCdma_link_off_date, '..' ttsl_link_off_date, '..' vodafone_link_off_date 
FROM `TTSL_Output_April` where `TTSL_Output_April`.`Period` = '$period' group by `TTSL_Output_April`.`SITE ID`) t group by t.site_id ) t1";


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=PnLSitewise.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Site Id', 'Site Name', 'Circle Name', 'Airtel_Min of Operator on Date ('.$period.')', 'Airtel_Max of Billing stop Date('.$period.')', 'Airtel_Sum of Load', 'BSNL_Min of Operator on Date ('.$period.')', 'BSNL_Max of Billing stop Date('.$period.')', 'BSNL_Sum of Load', 'IDEA_Min of Operator on Date ('.$period.')', 'IDEA_Max of Billing stop Date('.$period.')', 'IDEA_Sum of Load', 'PB(HFCL)_Min of Operator on Date ('.$period.')', 'PB(HFCL)_Max of Billing stop Date('.$period.')', 'PB(HFCL)_Sum of Load', 'RJIO_Min of Operator on Date ('.$period.')', 'RJIO_Max of Billing stop Date('.$period.')', 'RJIO_Sum of Load', 'Sify_Min of Operator on Date ('.$period.')', 'Sify_Max of Billing stop Date('.$period.')', 'Sify_Sum of Load', 'TCL-IOT_Min of Operator on Date ('.$period.')', 'TCL-IOT_Max of Billing stop Date('.$period.')', 'TCL-IOT_Sum of Load', 'TCL-NLD_Min of Operator on Date ('.$period.')', 'TCL-NLD_Max of Billing stop Date('.$period.')', 'TCL-NLD_Sum of Load', 'TCL-Redwin_Min of Operator on Date ('.$period.')', 'TCL-Redwin_Max of Billing stop Date('.$period.')', 'TCL-Redwin_Sum of Load', 'TCL-Wimax_Min of Operator on Date ('.$period.')', 'TCL-Wimax_Max of Billing stop Date('.$period.')', 'TCL-Wimax_Sum of Load', 'TTSL-CDMA_Min of Operator on Date ('.$period.')', 'TTSL-CDMA_Max of Billing stop Date('.$period.')', 'TTSL-CDMA_Sum of Load', 'TTSL_Min of Operator on Date ('.$period.')', 'TTSL_Max of Billing stop Date('.$period.')', 'TTSL_Sum of Load', 'Vodafone_Min of Operator on Date ('.$period.')', 'Vodafone_Max of Billing stop Date('.$period.')', 'Vodafone_Sum of Load', 'Voltage', 'Airtel(BTS Load in KWH)', 'BSNL(BTS Load in KWH)', 'IDEA(BTS Load in KWH)', 'HFCL (BTS Load in KWH)', 'RJIO(BTS Load in KWH)', 'Sify(BTS Load in KWH)', 'TCL-IOT (BTS Load in KWH)', 'TCL-NLD (BTS Load in KWH)', 'TCL-Redwin(BTS Load in KWH)', 'TCL-Wimax(BTS Load in KWH)', 'TTSL-CDMA (BTS Load in KWH)', 'TTS-GSM (BTS Load in KWH)', 'Vodafone (BTS Load in KWH)', 'Total Load BTS in KW(BTS Load in KWH)', 'Airtel(Aircon Load in KW)', 'BSNL(Aircon Load in KW)', 'IDEA(Aircon Load in KW)', 'HFCL (Aircon Load in KW)', 'RJIO(Aircon Load in KW)', 'Sify(Aircon Load in KW)', 'TCL-IOT (Aircon Load in KW)', 'TCL-NLD (Aircon Load in KW)', 'TCL-Redwin(Aircon Load in KW)', 'TCL-Wimax(Aircon Load in KW)', 'TTSL-CDMA (Aircon Load in KW)', 'TTS-GSM (Aircon Load in KW)', 'Vodafone (Aircon Load in KW)', 'Total Aircon Load in KW(Aircon Load)', 'Airtel(BTS+AC Load)', 'BSNL(BTS+AC Load)', 'IDEA(BTS+AC Load)', 'HFCL (BTS+AC Load)', 'RJIO(BTS+AC Load)', 'Sify(BTS+AC Load)', 'TCL-IOT (BTS+AC Load)', 'TCL-NLD (BTS+AC Load)', 'TCL-Redwin(BTS+AC Load)', 'TCL-Wimax(BTS+AC Load)', 'TTSL-CDMA (BTS+AC Load)', 'TTS-GSM (BTS+AC Load)', 'Vodafone (BTS+AC Load)', 'Total BTS_AC Load', 'Diesel Billing from Date', 'Diesel Billing Upto Date', 'Diesel No of Days', 'Diesel Cost', 'EB Cost', 'Energy Cost', 'Airtel_Days', 'BSNL_Days', 'IDEA_Days', 'HFCL_Days', 'RJIO_Days', 'Sify_Days', 'TCL-IOT_Days', 'TCL-NLD_Days', 'TCL-Redwin)_Days', 'TCL-Wimax_Days', 'TTSL-CDMA_Days', 'TTS-GSM_Days', 'Vodafone_Days', 'Airtel(%)', 'BSNL(%)', 'IDEA(%)', 'HFCL(%)', 'RJIO(%)', 'Sify(%)', 'TCL-IOT(%)', 'TCL-NLD(%)', 'TCL-Redwin(%)', 'TCL-Wimax(%)', 'TTSL-CDMA(%)', 'TTS-GSM(%)', 'Vodafone(%)', 'Total %', 'Airtel(Diesel Cost)', 'BSNL(Diesel Cost)', 'IDEA(Diesel Cost)', 'HFCL (Diesel Cost)', 'RJIO(Diesel Cost)', 'Sify(Diesel Cost)', 'TCL-IOT (Diesel Cost)', 'TCL-NLD (Diesel Cost)', 'TCL-Redwin(Diesel Cost)', 'TCL-Wimax(Diesel Cost)', 'TTSL-CDMA (Diesel Cost)', 'TTS-GSM (Diesel Cost)', 'Vodafone (Diesel Cost)', 'ZTS Diesel Cost', 'Total Diesel Cost Share', 'Airtel(EB Cost)', 'BSNL(EB Cost)', 'IDEA(EB Cost)', 'HFCL (EB Cost)', 'RJIO(EB Cost)', 'Sify(EB Cost)', 'TCL-IOT (EB Cost)', 'TCL-NLD (EB Cost)', 'TCL-Redwin(EB Cost)', 'TCL-Wimax(EB Cost)', 'TTSL-CDMA (EB Cost)', 'TTS-GSM (EB Cost)', 'Vodafone (EB Cost)', 'ZTS EB Cost', 'Total EB Cost', 'Airtel(Energy Cost)', 'BSNL(Energy Cost)', 'IDEA(Energy Cost)', 'HFCL (Energy Cost)', 'RJIO(Energy Cost)', 'Sify(Energy Cost)', 'TCL-IOT (Energy Cost)', 'TCL-NLD (Energy Cost)', 'TCL-Redwin(Energy Cost)', 'TCL-Wimax(Energy Cost)', 'TTSL-CDMA (Energy Cost)', 'TTS-GSM (Energy Cost)', 'Vodafone (Energy Cost)', 'ZTS Energy Cost', 'Total Energy Cost Share', 'Airtel(Diesel Revenue)', 'BSNL(Diesel Revenue)', 'IDEA(Diesel Revenue)', 'HFCL (Diesel Revenue)', 'RJIO(Diesel Revenue)', 'Sify(Diesel Revenue)', 'TCL-IOT (Diesel Revenue)', 'TCL-NLD (Diesel Revenue)', 'TCL-Redwin(Diesel Revenue)', 'TCL-Wimax(Diesel Revenue)', 'TTSL-CDMA (Diesel Revenue)', 'TTS-GSM (Diesel Revenue)', 'Vodafone (Diesel Revenue)', 'ZTS Diesel Revenue', 'Total Diesel Revenue', 'Airtel(EB Revenue)', 'BSNL(EB Revenue)', 'IDEA(EB Revenue)', 'HFCL (EB Revenue)', 'RJIO(EB Revenue)', 'Sify(EB Revenue)', 'TCL-IOT (EB Revenue)', 'TCL-NLD (EB Revenue)', 'TCL-Redwin(EB Revenue)', 'TCL-Wimax(EB Revenue)', 'TTSL-CDMA (EB Revenue)', 'TTS-GSM (EB Revenue)', 'Vodafone (EB Revenue)', 'ZTS EB Revenue', 'Total EB Revenue Share', 'Airtel(Energy Revenue)', 'BSNL(Energy Revenue)', 'IDEA(Energy Revenue)', 'HFCL (Energy Revenue)', 'RJIO(Energy Revenue)', 'Sify(Energy Revenue)', 'TCL-IOT (Energy Revenue)', 'TCL-NLD (Energy Revenue)', 'TCL-Redwin(Energy Revenue)', 'TCL-Wimax(Energy Revenue)', 'TTSL-CDMA (Energy Revenue)', 'TTS-GSM (Energy Revenue)', 'Vodafone (Energy Revenue)', 'ZTS Energy Revenue', 'Total Energy Revenue Share', 'Airtel(Margin)', 'BSNL(Margin)', 'IDEA(Margin)', 'HFCL (Margin)', 'RJIO(Margin)', 'Sify(Margin)', 'TCL-IOT (Margin)', 'TCL-NLD (Margin)', 'TCL-Redwin(Margin)', 'TCL-Wimax(Margin)', 'TTSL-CDMA (Margin)', 'TTS-GSM (Margin)', 'Vodafone (Margin)', 'ZTS Margin', 'Total Margin Share', 'No of Tenancy', 'Operational Status', 'Site Category', 'Site Type', 'FEM', 
	'NON-FEM', 'EB Status'));
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){

	$siteVoltage = $row["siteVoltage"];
	$airtel_load = $row["airtel_load"]; $bsnl_load = $row["bsnl_load"]; $idea_load = $row["idea_load"]; $pbHFCL_load = $row["pbHFCL_load"]; $rjio_load = $row["rjio_load"];
	$sify_load = $row["sify_load"]; $tcIOT_load = $row["tcIOT_load"]; $tclNLD_load = $row["tclNLD_load"]; $tclRedwin_load = $row["tclRedwin_load"];
	$tclWimax_load = $row["tclWimax_load"]; $ttslCDMA_load = $row["ttslCDMA_load"]; $ttsl_load = $row["ttsl_load"]; $vodafone_load = $row["vodafone_load"];

	$airtelKwh = convertInKWH($airtel_load, $siteVoltage);
	$bsnlKwh = convertInKWH($bsnl_load, $siteVoltage);
	$ideaKwh = convertInKWH($idea_load, $siteVoltage);
	$pbHFClKwh = convertInKWH($pbHFCL_load, $siteVoltage);
	$rjioKwh = convertInKWH($rjio_load, $siteVoltage);
	$sifyKwh = convertInKWH($sify_load, $siteVoltage);
	$tclIotKwh = convertInKWH($tcIOT_load, $siteVoltage);
	$tclNldKwh = convertInKWH($tclNLD_load, $siteVoltage);
	$tclRedwinKwh = convertInKWH($tclRedwin_load, $siteVoltage);
	$tclWimaxKwh = convertInKWH($tclWimax_load, $siteVoltage);
	$ttslCdmaKwh = convertInKWH($ttslCDMA_load, $siteVoltage);
	$ttslKwh = convertInKWH($ttsl_load, $siteVoltage);
	$vodafoneKwh = convertInKWH($vodafone_load, $siteVoltage);

	$totalKwh = $airtelKwh + $bsnlKwh + $ideaKwh + $pbHFClKwh + $rjioKwh + $sifyKwh + 
						$tclIotKwh + $tclNldKwh + $tclRedwinKwh + $tclWimaxKwh + $ttslCdmaKwh + $ttslKwh + $vodafoneKwh;

	$dieselCost = $row["dieselCost"] == '-' || $row["dieselCost"] == '' ? 0 : $row["dieselCost"];
	$ebCost = $row["ebCost"] == '-' || $row["ebCost"] == '' ? 0 : $row["ebCost"];
	$energyCost = $row["energyCost"] == '-' || $row["energyCost"] == '' ? 0 : $row["energyCost"];


	$airtelDieselRevenue = $row["airtel_dg_amount"]; 
	$bsnlDieselRevenue = $row["bsnl_dg_amount"]; 
	$ideaDieselRevenue = $row["idea_dg_amount"];
	$pbHfclDieselRevenue = $row["pbHfcl_dg_amount"]; 
	$rjioDieselRevenue = $row["rjio_dg_amount"]; 
	$sifyDieselRevenue = null;
	$tclIotDieselRevenue = $row["tclIot_dg_amount"]; 
	$tclNldDieselRevenue = $row["tclNld_dg_amount"]; 
	$tclRedwinDieselRevenue = $row["tclRedwin_dg_amount"];
	$tclWimaxDieselRevenue = $row["tclWimax_dg_amount"]; 
	$ttslCdmaDieselRevenue = $row["ttslCdma_dg_amount"]; 
	$ttslDieselRevenue = $row["ttsl_dg_amount"];
	$vodafoneDieselRevenue = $row["vodafone_dg_amount"];
	$ztsDieselRevenue = null;

	$totalDieselRevenue = 0.0;
	if($airtelDieselRevenue != null) $totalDieselRevenue +=$airtelDieselRevenue;
	if($bsnlDieselRevenue != null) $totalDieselRevenue +=$bsnlDieselRevenue;
	if($ideaDieselRevenue != null) $totalDieselRevenue +=$ideaDieselRevenue;
	if($pbHfclDieselRevenue != null) $totalDieselRevenue +=$pbHfclDieselRevenue;
	if($rjioDieselRevenue != null) $totalDieselRevenue +=$rjioDieselRevenue;
	if($sifyDieselRevenue != null) $totalDieselRevenue +=$sifyDieselRevenue;
	if($tclIotDieselRevenue != null) $totalDieselRevenue +=$tclIotDieselRevenue;
	if($tclNldDieselRevenue != null) $totalDieselRevenue +=$tclNldDieselRevenue;
	if($tclRedwinDieselRevenue != null) $totalDieselRevenue +=$tclRedwinDieselRevenue;
	if($tclWimaxDieselRevenue != null) $totalDieselRevenue +=$tclWimaxDieselRevenue;
	if($ttslCdmaDieselRevenue != null) $totalDieselRevenue +=$ttslCdmaDieselRevenue;
	if($ttslDieselRevenue != null) $totalDieselRevenue +=$ttslDieselRevenue;
	if($vodafoneDieselRevenue != null) $totalDieselRevenue +=$vodafoneDieselRevenue;
	if($ztsDieselRevenue != null) $totalDieselRevenue +=$ztsDieselRevenue;

	$airtelEbRevenue = $row["airtel_eb_amount"]; 
	$bsnlEbRevenue = $row["bsnl_eb_amount"]; 
	$ideaEbRevenue = $row["idea_eb_amount"];
	$pbHfclEbRevenue = $row["pbHfcl_eb_amount"]; 
	$rjioEbRevenue = $row["rjio_eb_amount"]; 
	$sifyEbRevenue = null;
	$tclIotEbRevenue = $row["tclIot_eb_amount"]; 
	$tclNldEbRevenue = $row["tclNld_eb_amount"]; 
	$tclRedwinEbRevenue = $row["tclRedwin_eb_amount"];
	$tclWimaxEbRevenue = $row["tclWimax_eb_amount"]; 
	$ttslCdmaEbRevenue = $row["ttslCdma_eb_amount"]; 
	$ttslEbRevenue = $row["ttsl_eb_amount"];
	$vodafoneEbRevenue = $row["vodafone_eb_amount"];
	$ztsEbRevenue = null;

	$totalEbRevenue = 0.0;
	if($airtelEbRevenue != null) $totalEbRevenue +=$airtelEbRevenue;
	if($bsnlEbRevenue != null) $totalEbRevenue +=$bsnlEbRevenue;
	if($ideaEbRevenue != null) $totalEbRevenue +=$ideaEbRevenue;
	if($pbHfclEbRevenue != null) $totalEbRevenue +=$pbHfclEbRevenue;
	if($rjioEbRevenue != null) $totalEbRevenue +=$rjioEbRevenue;
	if($sifyEbRevenue != null) $totalEbRevenue +=$sifyEbRevenue;
	if($tclIotEbRevenue != null) $totalEbRevenue +=$tclIotEbRevenue;
	if($tclNldEbRevenue != null) $totalEbRevenue +=$tclNldEbRevenue;
	if($tclRedwinEbRevenue != null) $totalEbRevenue +=$tclRedwinEbRevenue;
	if($tclWimaxEbRevenue != null) $totalEbRevenue +=$tclWimaxEbRevenue;
	if($ttslCdmaEbRevenue != null) $totalEbRevenue +=$ttslCdmaEbRevenue;
	if($ttslEbRevenue != null) $totalEbRevenue +=$ttslEbRevenue;
	if($vodafoneEbRevenue != null) $totalEbRevenue +=$vodafoneEbRevenue;
	if($ztsEbRevenue != null) $totalEbRevenue +=$ztsEbRevenue;

	$airtelEnergyRevenue =  prepareOperatorEnergyRevenue($airtelDieselRevenue, $airtelEbRevenue);
	$bsnlEnergyRevenue = prepareOperatorEnergyRevenue($bsnlDieselRevenue, $bsnlEbRevenue);
	$ideaEnergyRevenue = prepareOperatorEnergyRevenue($ideaDieselRevenue, $ideaEbRevenue);
	$pbHfclEnergyRevenue = prepareOperatorEnergyRevenue($pbHfclDieselRevenue, $pbHfclEbRevenue);
	$rjioEnergyRevenue = prepareOperatorEnergyRevenue($rjioDieselRevenue, $rjioEbRevenue);
	$sifyEnergyRevenue = prepareOperatorEnergyRevenue($sifyDieselRevenue, $sifyEbRevenue);
	$tclIotEnergyRevenue = prepareOperatorEnergyRevenue($tclIotDieselRevenue, $tclIotEbRevenue);
	$tclNldEnergyRevenue = prepareOperatorEnergyRevenue($tclNldDieselRevenue, $tclNldEbRevenue);
	$tclRedwinEnergyRevenue = prepareOperatorEnergyRevenue($tclRedwinDieselRevenue, $tclRedwinEbRevenue);
	$tclWimaxEnergyRevenue = prepareOperatorEnergyRevenue($tclWimaxDieselRevenue, $tclWimaxEbRevenue);
	$ttslCdmaEnergyRevenue = prepareOperatorEnergyRevenue($ttslCdmaDieselRevenue, $ttslCdmaEbRevenue);
	$ttslEnergyRevenue = prepareOperatorEnergyRevenue($ttslDieselRevenue, $ttslEbRevenue);
	$vodafoneEnergyRevenue = prepareOperatorEnergyRevenue($vodafoneDieselRevenue, $vodafoneEbRevenue);
	$ztsEnergyRevenue = prepareOperatorEnergyRevenue($ztsDieselRevenue, $ztsEbRevenue);

	$totalEnergyRevenue = 0.0;
	if($airtelEnergyRevenue != null) $totalEnergyRevenue += $airtelEnergyRevenue;
	if($bsnlEnergyRevenue != null) $totalEnergyRevenue += $bsnlEnergyRevenue;
	if($ideaEnergyRevenue != null) $totalEnergyRevenue += $ideaEnergyRevenue;
	if($pbHfclEnergyRevenue != null) $totalEnergyRevenue += $pbHfclEnergyRevenue;
	if($rjioEnergyRevenue != null) $totalEnergyRevenue += $rjioEnergyRevenue;
	if($sifyEnergyRevenue != null) $totalEnergyRevenue += $sifyEnergyRevenue;
	if($tclIotEnergyRevenue != null) $totalEnergyRevenue += $tclIotEnergyRevenue;
	if($tclNldEnergyRevenue != null) $totalEnergyRevenue += $tclNldEnergyRevenue;
	if($tclRedwinEnergyRevenue != null) $totalEnergyRevenue += $tclRedwinEnergyRevenue;
	if($tclWimaxEnergyRevenue != null) $totalEnergyRevenue += $tclWimaxEnergyRevenue;
	if($ttslCdmaEnergyRevenue != null) $totalEnergyRevenue += $ttslCdmaEnergyRevenue;
	if($ttslEnergyRevenue != null) $totalEnergyRevenue += $ttslEnergyRevenue;
	if($vodafoneEnergyRevenue != null) $totalEnergyRevenue += $vodafoneEnergyRevenue;
	if($ztsEnergyRevenue != null) $totalEnergyRevenue += $ztsEnergyRevenue;

	$siteType = $row["siteType"];
	$ebStatus = $ebCost <= 0 ? "Non EB" : "EB";

	$airtel_bts1_type = $row["airtel_bts1_type"];
	$airtel_bts2_type = $row["airtel_bts2_type"];
	$airtel_bts3_type = $row["airtel_bts3_type"];
	$airtel_bts4_type = $row["airtel_bts4_type"];
	$airtel_bts5_type = $row["airtel_bts5_type"];
	$airtel_bts6_type = $row["airtel_bts6_type"];

	$airtel_bts1_on_date = $row["airtel_on_air_date"];
	$airtel_bts2_on_date = $row["airtel_bts2_on_date"];
	$airtel_bts3_on_date = $row["airtel_bts3_on_date"];
	$airtel_bts4_on_date = $row["airtel_bts4_on_date"];
	$airtel_bts5_on_date = $row["airtel_bts5_on_date"];
	$airtel_bts6_on_date = $row["airtel_bts6_on_date"];
	$airtel_link_on_date = $row["airtel_link_on_date"];

	$airtel_bts1_off_date = $row["airtel_bts1_off_date"];
	$airtel_bts2_off_date = $row["airtel_bts2_off_date"];
	$airtel_bts3_off_date = $row["airtel_bts3_off_date"];
	$airtel_bts4_off_date = $row["airtel_bts4_off_date"];
	$airtel_bts5_off_date = $row["airtel_bts5_off_date"];
	$airtel_bts6_off_date = $row["airtel_bts6_off_date"];
	$airtel_link_off_date = $row["airtel_link_off_date"];


	$airtel_on_date = prepareOperatorOnDate($airtel_bts1_on_date,$airtel_bts2_on_date,$airtel_bts3_on_date,$airtel_bts4_on_date,$airtel_bts5_on_date,$airtel_bts6_on_date,
						$airtel_bts1_off_date,$airtel_bts2_off_date,$airtel_bts3_off_date,$airtel_bts4_off_date,$airtel_bts5_off_date,$airtel_bts6_off_date,$airtel_link_on_date, 
						$airtel_link_off_date);

	$airtelOffDate = prepareOperatorOffDate($airtel_bts1_on_date,$airtel_bts2_on_date,$airtel_bts3_on_date,$airtel_bts4_on_date,$airtel_bts5_on_date,$airtel_bts6_on_date,
						$airtel_bts1_off_date,$airtel_bts2_off_date,$airtel_bts3_off_date,$airtel_bts4_off_date,$airtel_bts5_off_date,$airtel_bts6_off_date,$airtel_link_on_date,
						$airtel_link_off_date);

	$airtelNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $airtel_on_date, $airtelOffDate);

	$bsnl_bts1_type = $row["bsnl_bts1_type"];
	$bsnl_bts2_type = $row["bsnl_bts2_type"];
	$bsnl_bts3_type = $row["bsnl_bts3_type"];
	$bsnl_bts4_type = $row["bsnl_bts4_type"];
	$bsnl_bts5_type = $row["bsnl_bts5_type"];
	$bsnl_bts6_type = $row["bsnl_bts6_type"];

	$bsnl_bts1_on_date = $row["bsnl_on_air_date"];
	$bsnl_bts2_on_date = $row["bsnl_bts2_on_date"];
	$bsnl_bts3_on_date = $row["bsnl_bts3_on_date"];
	$bsnl_bts4_on_date = $row["bsnl_bts4_on_date"];
	$bsnl_bts5_on_date = $row["bsnl_bts5_on_date"];
	$bsnl_bts6_on_date = $row["bsnl_bts6_on_date"];
	$bsnl_link_on_date = $row["bsnl_link_on_date"];

	$bsnl_bts1_off_date = $row["bsnl_bts1_off_date"];
	$bsnl_bts2_off_date = $row["bsnl_bts2_off_date"];
	$bsnl_bts3_off_date = $row["bsnl_bts3_off_date"];
	$bsnl_bts4_off_date = $row["bsnl_bts4_off_date"];
	$bsnl_bts5_off_date = $row["bsnl_bts5_off_date"];
	$bsnl_bts6_off_date = $row["bsnl_bts6_off_date"];
	$bsnl_link_off_date = $row["bsnl_link_off_date"];

	$bsnl_on_date = prepareOperatorOnDate($bsnl_bts1_on_date,$bsnl_bts2_on_date,$bsnl_bts3_on_date,$bsnl_bts4_on_date,$bsnl_bts5_on_date,$bsnl_bts6_on_date,
						$bsnl_bts1_off_date,$bsnl_bts2_off_date,$bsnl_bts3_off_date,$bsnl_bts4_off_date,$bsnl_bts5_off_date,$bsnl_bts6_off_date,$bsnl_link_on_date, 
						$bsnl_link_off_date);

	$bsnlOffDate = prepareOperatorOffDate($bsnl_bts1_on_date,$bsnl_bts2_on_date,$bsnl_bts3_on_date,$bsnl_bts4_on_date,$bsnl_bts5_on_date,$bsnl_bts6_on_date,
						$bsnl_bts1_off_date,$bsnl_bts2_off_date,$bsnl_bts3_off_date,$bsnl_bts4_off_date,$bsnl_bts5_off_date,$bsnl_bts6_off_date,$bsnl_link_on_date,
						$bsnl_link_off_date);

	$bsnlNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $bsnl_on_date, $bsnlOffDate);

	$idea_bts1_type = $row["idea_bts1_type"];
	$idea_bts2_type = $row["idea_bts2_type"];
	$idea_bts3_type = $row["idea_bts3_type"];
	$idea_bts4_type = $row["idea_bts4_type"];
	$idea_bts5_type = $row["idea_bts5_type"];
	$idea_bts6_type = $row["idea_bts6_type"];

	$idea_bts1_on_date = $row["idea_on_air_date"];
	$idea_bts2_on_date = $row["idea_bts2_on_date"];
	$idea_bts3_on_date = $row["idea_bts3_on_date"];
	$idea_bts4_on_date = $row["idea_bts4_on_date"];
	$idea_bts5_on_date = $row["idea_bts5_on_date"];
	$idea_bts6_on_date = $row["idea_bts6_on_date"];
	$idea_link_on_date = $row["idea_link_on_date"];

	$idea_bts1_off_date = $row["idea_bts1_off_date"];
	$idea_bts2_off_date = $row["idea_bts2_off_date"];
	$idea_bts3_off_date = $row["idea_bts3_off_date"];
	$idea_bts4_off_date = $row["idea_bts4_off_date"];
	$idea_bts5_off_date = $row["idea_bts5_off_date"];
	$idea_bts6_off_date = $row["idea_bts6_off_date"];
	$idea_link_off_date = $row["idea_link_off_date"];

	$idea_on_date = prepareOperatorOnDate($idea_bts1_on_date,$idea_bts2_on_date,$idea_bts3_on_date,$idea_bts4_on_date,$idea_bts5_on_date,$idea_bts6_on_date,
						$idea_bts1_off_date,$idea_bts2_off_date,$idea_bts3_off_date,$idea_bts4_off_date,$idea_bts5_off_date,$idea_bts6_off_date,$idea_link_on_date, 
						$idea_link_off_date);

	$ideaOffDate = prepareOperatorOffDate($idea_bts1_on_date,$idea_bts2_on_date,$idea_bts3_on_date,$idea_bts4_on_date,$idea_bts5_on_date,$idea_bts6_on_date,
						$idea_bts1_off_date,$idea_bts2_off_date,$idea_bts3_off_date,$idea_bts4_off_date,$idea_bts5_off_date,$idea_bts6_off_date,$idea_link_on_date,
						$idea_link_off_date);

	$ideaNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $idea_on_date, $ideaOffDate);

	$pbHFCL_bts1_type = $row["pbHfcl_bts1_type"];
	$pbHFCL_bts2_type = $row["pbHfcl_bts2_type"];
	$pbHFCL_bts3_type = $row["pbHfcl_bts3_type"];
	$pbHFCL_bts4_type = $row["pbHfcl_bts4_type"];
	$pbHFCL_bts5_type = $row["pbHfcl_bts5_type"];
	$pbHFCL_bts6_type = $row["pbHfcl_bts6_type"];

	$pbHFCL_bts1_on_date = $row["pbHFCL_on_air_date"];
	$pbHFCL_bts2_on_date = $row["pbHfcl_bts2_on_date"];
	$pbHFCL_bts3_on_date = $row["pbHfcl_bts3_on_date"];
	$pbHFCL_bts4_on_date = $row["pbHfcl_bts4_on_date"];
	$pbHFCL_bts5_on_date = $row["pbHfcl_bts5_on_date"];
	$pbHFCL_bts6_on_date = $row["pbHfcl_bts6_on_date"];
	$pbHFCL_link_on_date = $row["pbHfcl_link_on_date"];

	$pbHFCL_bts1_off_date = $row["pbHfcl_bts1_off_date"];
	$pbHFCL_bts2_off_date = $row["pbHfcl_bts2_off_date"];
	$pbHFCL_bts3_off_date = $row["pbHfcl_bts3_off_date"];
	$pbHFCL_bts4_off_date = $row["pbHfcl_bts4_off_date"];
	$pbHFCL_bts5_off_date = $row["pbHfcl_bts5_off_date"];
	$pbHFCL_bts6_off_date = $row["pbHfcl_bts6_off_date"];
	$pbHFCL_link_off_date = $row["pbHfcl_link_off_date"];

	$pbHFCL_on_date = prepareOperatorOnDate($pbHFCL_bts1_on_date,$pbHFCL_bts2_on_date,$pbHFCL_bts3_on_date,$pbHFCL_bts4_on_date,$pbHFCL_bts5_on_date,$pbHFCL_bts6_on_date,
						$pbHFCL_bts1_off_date,$pbHFCL_bts2_off_date,$pbHFCL_bts3_off_date,$pbHFCL_bts4_off_date,$pbHFCL_bts5_off_date,$pbHFCL_bts6_off_date,$pbHFCL_link_on_date, 
						$pbHFCL_link_off_date);

	$pbHFCLOffDate = prepareOperatorOffDate($pbHFCL_bts1_on_date,$pbHFCL_bts2_on_date,$pbHFCL_bts3_on_date,$pbHFCL_bts4_on_date,$pbHFCL_bts5_on_date,$pbHFCL_bts6_on_date,
						$pbHFCL_bts1_off_date,$pbHFCL_bts2_off_date,$pbHFCL_bts3_off_date,$pbHFCL_bts4_off_date,$pbHFCL_bts5_off_date,$pbHFCL_bts6_off_date,$pbHFCL_link_on_date,
						$pbHFCL_link_off_date);

	$pbHfclNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $pbHFCL_on_date, $pbHFCLOffDate);

	$rjio_bts1_type = $row["rjio_bts1_type"];
	$rjio_bts2_type = $row["rjio_bts2_type"];
	$rjio_bts3_type = $row["rjio_bts3_type"];
	$rjio_bts4_type = $row["rjio_bts4_type"];
	$rjio_bts5_type = $row["rjio_bts5_type"];
	$rjio_bts6_type = $row["rjio_bts6_type"];

	$rjio_bts1_on_date = $row["rjio_on_air_date"];
	$rjio_bts2_on_date = $row["rjio_bts2_on_date"];
	$rjio_bts3_on_date = $row["rjio_bts3_on_date"];
	$rjio_bts4_on_date = $row["rjio_bts4_on_date"];
	$rjio_bts5_on_date = $row["rjio_bts5_on_date"];
	$rjio_bts6_on_date = $row["rjio_bts6_on_date"];
	$rjio_link_on_date = $row["rjio_link_on_date"];

	$rjio_bts1_off_date = $row["rjio_bts1_off_date"];
	$rjio_bts2_off_date = $row["rjio_bts2_off_date"];
	$rjio_bts3_off_date = $row["rjio_bts3_off_date"];
	$rjio_bts4_off_date = $row["rjio_bts4_off_date"];
	$rjio_bts5_off_date = $row["rjio_bts5_off_date"];
	$rjio_bts6_off_date = $row["rjio_bts6_off_date"];
	$rjio_link_off_date = $row["rjio_link_off_date"];

	$rjio_on_date = prepareOperatorOnDate($rjio_bts1_on_date,$rjio_bts2_on_date,$rjio_bts3_on_date,$rjio_bts4_on_date,$rjio_bts5_on_date,$rjio_bts6_on_date,
						$rjio_bts1_off_date,$rjio_bts2_off_date,$rjio_bts3_off_date,$rjio_bts4_off_date,$rjio_bts5_off_date,$rjio_bts6_off_date,$rjio_link_on_date, 
						$rjio_link_off_date);

	$rjioOffDate = prepareOperatorOffDate($rjio_bts1_on_date,$rjio_bts2_on_date,$rjio_bts3_on_date,$rjio_bts4_on_date,$rjio_bts5_on_date,$rjio_bts6_on_date,
						$rjio_bts1_off_date,$rjio_bts2_off_date,$rjio_bts3_off_date,$rjio_bts4_off_date,$rjio_bts5_off_date,$rjio_bts6_off_date,$rjio_link_on_date,
						$rjio_link_off_date);

	$rjioNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $rjio_on_date, $rjioOffDate);

	$sify_bts1_type = $row["sify_bts1_type"];
	$sify_bts2_type = $row["sify_bts2_type"];
	$sify_bts3_type = $row["sify_bts3_type"];
	$sify_bts4_type = $row["sify_bts4_type"];
	$sify_bts5_type = $row["sify_bts5_type"];
	$sify_bts6_type = $row["sify_bts6_type"];

	$sify_bts1_on_date = $row["sify_on_air_date"];
	$sify_bts2_on_date = $row["sify_bts2_on_date"];
	$sify_bts3_on_date = $row["sify_bts3_on_date"];
	$sify_bts4_on_date = $row["sify_bts4_on_date"];
	$sify_bts5_on_date = $row["sify_bts5_on_date"];
	$sify_bts6_on_date = $row["sify_bts6_on_date"];
	$sify_link_on_date = $row["sify_link_on_date"];

	$sify_bts1_off_date = $row["sify_bts1_off_date"];
	$sify_bts2_off_date = $row["sify_bts2_off_date"];
	$sify_bts3_off_date = $row["sify_bts3_off_date"];
	$sify_bts4_off_date = $row["sify_bts4_off_date"];
	$sify_bts5_off_date = $row["sify_bts5_off_date"];
	$sify_bts6_off_date = $row["sify_bts6_off_date"];
	$sify_link_off_date = $row["sify_link_off_date"];

	$sify_on_date = prepareOperatorOnDate($sify_bts1_on_date,$sify_bts2_on_date,$sify_bts3_on_date,$sify_bts4_on_date,$sify_bts5_on_date,$sify_bts6_on_date,
						$sify_bts1_off_date,$sify_bts2_off_date,$sify_bts3_off_date,$sify_bts4_off_date,$sify_bts5_off_date,$sify_bts6_off_date,$sify_link_on_date, 
						$sify_link_off_date);

	$sifyOffDate = prepareOperatorOffDate($sify_bts1_on_date,$sify_bts2_on_date,$sify_bts3_on_date,$sify_bts4_on_date,$sify_bts5_on_date,$sify_bts6_on_date,
						$sify_bts1_off_date,$sify_bts2_off_date,$sify_bts3_off_date,$sify_bts4_off_date,$sify_bts5_off_date,$sify_bts6_off_date,$sify_link_on_date,
						$sify_link_off_date);

	$sifyNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $sify_on_date, $sifyOffDate);

	$tclIot_bts1_type = $row["tclIot_bts1_type"];
	$tclIot_bts2_type = $row["tclIot_bts2_type"];
	$tclIot_bts3_type = $row["tclIot_bts3_type"];
	$tclIot_bts4_type = $row["tclIot_bts4_type"];
	$tclIot_bts5_type = $row["tclIot_bts5_type"];
	$tclIot_bts6_type = $row["tclIot_bts6_type"];

	$tclIot_bts1_on_date = $row["tclIot_on_air_date"];
	$tclIot_bts2_on_date = $row["tclIot_bts2_on_date"];
	$tclIot_bts3_on_date = $row["tclIot_bts3_on_date"];
	$tclIot_bts4_on_date = $row["tclIot_bts4_on_date"];
	$tclIot_bts5_on_date = $row["tclIot_bts5_on_date"];
	$tclIot_bts6_on_date = $row["tclIot_bts6_on_date"];
	$tclIot_link_on_date = $row["tclIot_link_on_date"];

	$tclIot_bts1_off_date = $row["tclIot_bts1_off_date"];
	$tclIot_bts2_off_date = $row["tclIot_bts2_off_date"];
	$tclIot_bts3_off_date = $row["tclIot_bts3_off_date"];
	$tclIot_bts4_off_date = $row["tclIot_bts4_off_date"];
	$tclIot_bts5_off_date = $row["tclIot_bts5_off_date"];
	$tclIot_bts6_off_date = $row["tclIot_bts6_off_date"];
	$tclIot_link_off_date = $row["tclIot_link_off_date"];

	$tclIot_on_date = prepareOperatorOnDate($tclIot_bts1_on_date,$tclIot_bts2_on_date,$tclIot_bts3_on_date,$tclIot_bts4_on_date,$tclIot_bts5_on_date,$tclIot_bts6_on_date,
						$tclIot_bts1_off_date,$tclIot_bts2_off_date,$tclIot_bts3_off_date,$tclIot_bts4_off_date,$tclIot_bts5_off_date,$tclIot_bts6_off_date,$tclIot_link_on_date, 
						$tclIot_link_off_date);

	$tclIotOffDate = prepareOperatorOffDate($tclIot_bts1_on_date,$tclIot_bts2_on_date,$tclIot_bts3_on_date,$tclIot_bts4_on_date,$tclIot_bts5_on_date,$tclIot_bts6_on_date,
						$tclIot_bts1_off_date,$tclIot_bts2_off_date,$tclIot_bts3_off_date,$tclIot_bts4_off_date,$tclIot_bts5_off_date,$tclIot_bts6_off_date,$tclIot_link_on_date,
						$tclIot_link_off_date);

	$tclIotNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $tclIot_on_date, $tclIotOffDate);
	
	$tclNld_bts1_type = $row["tclNld_bts1_type"];
	$tclNld_bts2_type = $row["tclNld_bts2_type"];
	$tclNld_bts3_type = $row["tclNld_bts3_type"];
	$tclNld_bts4_type = $row["tclNld_bts4_type"];
	$tclNld_bts5_type = $row["tclNld_bts5_type"];
	$tclNld_bts6_type = $row["tclNld_bts6_type"];

	$tclNld_bts1_on_date = $row["tclNld_on_air_date"];
	$tclNld_bts2_on_date = $row["tclNld_bts2_on_date"];
	$tclNld_bts3_on_date = $row["tclNld_bts3_on_date"];
	$tclNld_bts4_on_date = $row["tclNld_bts4_on_date"];
	$tclNld_bts5_on_date = $row["tclNld_bts5_on_date"];
	$tclNld_bts6_on_date = $row["tclNld_bts6_on_date"];
	$tclNld_link_on_date = $row["tclNld_link_on_date"];

	$tclNld_bts1_off_date = $row["tclNld_bts1_off_date"];
	$tclNld_bts2_off_date = $row["tclNld_bts2_off_date"];
	$tclNld_bts3_off_date = $row["tclNld_bts3_off_date"];
	$tclNld_bts4_off_date = $row["tclNld_bts4_off_date"];
	$tclNld_bts5_off_date = $row["tclNld_bts5_off_date"];
	$tclNld_bts6_off_date = $row["tclNld_bts6_off_date"];
	$tclNld_link_off_date = $row["tclNld_link_off_date"];

	$tclNld_on_date = prepareOperatorOnDate($tclNld_bts1_on_date,$tclNld_bts2_on_date,$tclNld_bts3_on_date,$tclNld_bts4_on_date,$tclNld_bts5_on_date,$tclNld_bts6_on_date,
						$tclNld_bts1_off_date,$tclNld_bts2_off_date,$tclNld_bts3_off_date,$tclNld_bts4_off_date,$tclNld_bts5_off_date,$tclNld_bts6_off_date,$tclNld_link_on_date, 
						$tclNld_link_off_date);

	$tclNldOffDate = prepareOperatorOffDate($tclNld_bts1_on_date,$tclNld_bts2_on_date,$tclNld_bts3_on_date,$tclNld_bts4_on_date,$tclNld_bts5_on_date,$tclNld_bts6_on_date,
						$tclNld_bts1_off_date,$tclNld_bts2_off_date,$tclNld_bts3_off_date,$tclNld_bts4_off_date,$tclNld_bts5_off_date,$tclNld_bts6_off_date,$tclNld_link_on_date,
						$tclNld_link_off_date);

	$tclNldNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $tclNld_on_date, $tclNldOffDate);

	$tclRedwin_bts1_type = $row["tclRedwin_bts1_type"];
	$tclRedwin_bts2_type = $row["tclRedwin_bts2_type"];
	$tclRedwin_bts3_type = $row["tclRedwin_bts3_type"];
	$tclRedwin_bts4_type = $row["tclRedwin_bts4_type"];
	$tclRedwin_bts5_type = $row["tclRedwin_bts5_type"];
	$tclRedwin_bts6_type = $row["tclRedwin_bts6_type"];
	
	$tclRedwin_bts1_on_date = $row["tclRedwin_on_air_date"];
	$tclRedwin_bts2_on_date = $row["tclRedwin_bts2_on_date"];
	$tclRedwin_bts3_on_date = $row["tclRedwin_bts3_on_date"];
	$tclRedwin_bts4_on_date = $row["tclRedwin_bts4_on_date"];
	$tclRedwin_bts5_on_date = $row["tclRedwin_bts5_on_date"];
	$tclRedwin_bts6_on_date = $row["tclRedwin_bts6_on_date"];
	$tclRedwin_link_on_date = $row["tclRedwin_link_on_date"];

	$tclRedwin_bts1_off_date = $row["tclRedwin_bts1_off_date"];
	$tclRedwin_bts2_off_date = $row["tclRedwin_bts2_off_date"];
	$tclRedwin_bts3_off_date = $row["tclRedwin_bts3_off_date"];
	$tclRedwin_bts4_off_date = $row["tclRedwin_bts4_off_date"];
	$tclRedwin_bts5_off_date = $row["tclRedwin_bts5_off_date"];
	$tclRedwin_bts6_off_date = $row["tclRedwin_bts6_off_date"];
	$tclRedwin_link_off_date = $row["tclRedwin_link_off_date"];

	$tclRedwin_on_date = prepareOperatorOnDate($tclRedwin_bts1_on_date,$tclRedwin_bts2_on_date,$tclRedwin_bts3_on_date,$tclRedwin_bts4_on_date,$tclRedwin_bts5_on_date,
		$tclRedwin_bts6_on_date, $tclRedwin_bts1_off_date,$tclRedwin_bts2_off_date,$tclRedwin_bts3_off_date,$tclRedwin_bts4_off_date,$tclRedwin_bts5_off_date,$tclRedwin_bts6_off_date,
		$tclRedwin_link_on_date, $tclRedwin_link_off_date);

	$tclRedwinOffDate = prepareOperatorOffDate($tclRedwin_bts1_on_date,$tclRedwin_bts2_on_date,$tclRedwin_bts3_on_date,$tclRedwin_bts4_on_date,$tclRedwin_bts5_on_date,
		$tclRedwin_bts6_on_date,$tclRedwin_bts1_off_date,$tclRedwin_bts2_off_date,$tclRedwin_bts3_off_date,$tclRedwin_bts4_off_date,$tclRedwin_bts5_off_date,$tclRedwin_bts6_off_date,
		$tclRedwin_link_on_date,$tclRedwin_link_off_date);

	$tclRedwinNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $tclRedwin_on_date, $tclRedwinOffDate);

	$tclWimax_bts1_type = $row["tclWimax_bts1_type"];
	$tclWimax_bts2_type = $row["tclWimax_bts2_type"];
	$tclWimax_bts3_type = $row["tclWimax_bts3_type"];
	$tclWimax_bts4_type = $row["tclWimax_bts4_type"];
	$tclWimax_bts5_type = $row["tclWimax_bts5_type"];
	$tclWimax_bts6_type = $row["tclWimax_bts6_type"];

	$tclWimax_bts1_on_date = $row["tclWimax_on_air_date"];
	$tclWimax_bts2_on_date = $row["tclWimax_bts2_on_date"];
	$tclWimax_bts3_on_date = $row["tclWimax_bts3_on_date"];
	$tclWimax_bts4_on_date = $row["tclWimax_bts4_on_date"];
	$tclWimax_bts5_on_date = $row["tclWimax_bts5_on_date"];
	$tclWimax_bts6_on_date = $row["tclWimax_bts6_on_date"];
	$tclWimax_link_on_date = $row["tclWimax_link_on_date"];

	$tclWimax_bts1_off_date = $row["tclWimax_bts1_off_date"];
	$tclWimax_bts2_off_date = $row["tclWimax_bts2_off_date"];
	$tclWimax_bts3_off_date = $row["tclWimax_bts3_off_date"];
	$tclWimax_bts4_off_date = $row["tclWimax_bts4_off_date"];
	$tclWimax_bts5_off_date = $row["tclWimax_bts5_off_date"];
	$tclWimax_bts6_off_date = $row["tclWimax_bts6_off_date"];
	$tclWimax_link_off_date = $row["tclWimax_link_off_date"];

	$tclWimax_on_date = prepareOperatorOnDate($tclWimax_bts1_on_date,$tclWimax_bts2_on_date,$tclWimax_bts3_on_date,$tclWimax_bts4_on_date,$tclWimax_bts5_on_date,$tclWimax_bts6_on_date,
						$tclWimax_bts1_off_date,$tclWimax_bts2_off_date,$tclWimax_bts3_off_date,$tclWimax_bts4_off_date,$tclWimax_bts5_off_date,$tclWimax_bts6_off_date,
						$tclWimax_link_on_date, $tclWimax_link_off_date);

	$tclWimaxOffDate = prepareOperatorOffDate($tclWimax_bts1_on_date,$tclWimax_bts2_on_date,$tclWimax_bts3_on_date,$tclWimax_bts4_on_date,$tclWimax_bts5_on_date,$tclWimax_bts6_on_date,
						$tclWimax_bts1_off_date,$tclWimax_bts2_off_date,$tclWimax_bts3_off_date,$tclWimax_bts4_off_date,$tclWimax_bts5_off_date,$tclWimax_bts6_off_date,
						$tclWimax_link_on_date,$tclWimax_link_off_date);

	$tclWimaxNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $tclWimax_on_date, $tclWimaxOffDate);

	$ttslCdma_bts1_type = $row["ttslCdma_bts1_type"];
	$ttslCdma_bts2_type = $row["ttslCdma_bts2_type"];
	$ttslCdma_bts3_type = $row["ttslCdma_bts3_type"];
	$ttslCdma_bts4_type = $row["ttslCdma_bts4_type"];
	$ttslCdma_bts5_type = $row["ttslCdma_bts5_type"];
	$ttslCdma_bts6_type = $row["ttslCdma_bts6_type"];

	$ttslCdma_bts1_on_date = $row["ttslCDMA_on_air_date"];
	$ttslCdma_bts2_on_date = $row["ttslCdma_bts2_on_date"];
	$ttslCdma_bts3_on_date = $row["ttslCdma_bts3_on_date"];
	$ttslCdma_bts4_on_date = $row["ttslCdma_bts4_on_date"];
	$ttslCdma_bts5_on_date = $row["ttslCdma_bts5_on_date"];
	$ttslCdma_bts6_on_date = $row["ttslCdma_bts6_on_date"];
	$ttslCdma_link_on_date = $row["ttslCdma_link_on_date"];

	$ttslCdma_bts1_off_date = $row["ttslCdma_bts1_off_date"];
	$ttslCdma_bts2_off_date = $row["ttslCdma_bts2_off_date"];
	$ttslCdma_bts3_off_date = $row["ttslCdma_bts3_off_date"];
	$ttslCdma_bts4_off_date = $row["ttslCdma_bts4_off_date"];
	$ttslCdma_bts5_off_date = $row["ttslCdma_bts5_off_date"];
	$ttslCdma_bts6_off_date = $row["ttslCdma_bts6_off_date"];
	$ttslCdma_link_off_date = $row["ttslCdma_link_off_date"];

	$ttslCdma_on_date = prepareOperatorOnDate($ttslCdma_bts1_on_date,$ttslCdma_bts2_on_date,$ttslCdma_bts3_on_date,$ttslCdma_bts4_on_date,$ttslCdma_bts5_on_date,$ttslCdma_bts6_on_date,
						$ttslCdma_bts1_off_date,$ttslCdma_bts2_off_date,$ttslCdma_bts3_off_date,$ttslCdma_bts4_off_date,$ttslCdma_bts5_off_date,$ttslCdma_bts6_off_date,
						$ttslCdma_link_on_date, $ttslCdma_link_off_date);

	$ttslCdmaOffDate = prepareOperatorOffDate($ttslCdma_bts1_on_date,$ttslCdma_bts2_on_date,$ttslCdma_bts3_on_date,$ttslCdma_bts4_on_date,$ttslCdma_bts5_on_date,$ttslCdma_bts6_on_date,
						$ttslCdma_bts1_off_date,$ttslCdma_bts2_off_date,$ttslCdma_bts3_off_date,$ttslCdma_bts4_off_date,$ttslCdma_bts5_off_date,$ttslCdma_bts6_off_date,
						$ttslCdma_link_on_date,$ttslCdma_link_off_date);

	$ttslCdmaNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $ttslCdma_on_date, $ttslCdmaOffDate);

	$ttsl_bts1_type = $row["ttsl_bts1_type"];
	$ttsl_bts2_type = $row["ttsl_bts2_type"];
	$ttsl_bts3_type = $row["ttsl_bts3_type"];
	$ttsl_bts4_type = $row["ttsl_bts4_type"];
	$ttsl_bts5_type = $row["ttsl_bts5_type"];
	$ttsl_bts6_type = $row["ttsl_bts6_type"];

	$ttsl_bts1_on_date = $row["ttsl_on_air_date"];
	$ttsl_bts2_on_date = $row["ttsl_bts2_on_date"];
	$ttsl_bts3_on_date = $row["ttsl_bts3_on_date"];
	$ttsl_bts4_on_date = $row["ttsl_bts4_on_date"];
	$ttsl_bts5_on_date = $row["ttsl_bts5_on_date"];
	$ttsl_bts6_on_date = $row["ttsl_bts6_on_date"];
	$ttsl_link_on_date = $row["ttsl_link_on_date"];

	$ttsl_bts1_off_date = $row["ttsl_bts1_off_date"];
	$ttsl_bts2_off_date = $row["ttsl_bts2_off_date"];
	$ttsl_bts3_off_date = $row["ttsl_bts3_off_date"];
	$ttsl_bts4_off_date = $row["ttsl_bts4_off_date"];
	$ttsl_bts5_off_date = $row["ttsl_bts5_off_date"];
	$ttsl_bts6_off_date = $row["ttsl_bts6_off_date"];
	$ttsl_link_off_date = $row["ttsl_link_off_date"];

	$ttsl_on_date = prepareOperatorOnDate($ttsl_bts1_on_date,$ttsl_bts2_on_date,$ttsl_bts3_on_date,$ttsl_bts4_on_date,$ttsl_bts5_on_date,$ttsl_bts6_on_date,
						$ttsl_bts1_off_date,$ttsl_bts2_off_date,$ttsl_bts3_off_date,$ttsl_bts4_off_date,$ttsl_bts5_off_date,$ttsl_bts6_off_date,$ttsl_link_on_date, 
						$ttsl_link_off_date);

	$ttslOffDate = prepareOperatorOffDate($ttsl_bts1_on_date,$ttsl_bts2_on_date,$ttsl_bts3_on_date,$ttsl_bts4_on_date,$ttsl_bts5_on_date,$ttsl_bts6_on_date,
						$ttsl_bts1_off_date,$ttsl_bts2_off_date,$ttsl_bts3_off_date,$ttsl_bts4_off_date,$ttsl_bts5_off_date,$ttsl_bts6_off_date,$ttsl_link_on_date,
						$ttsl_link_off_date);

	$ttslNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $ttsl_on_date, $ttslOffDate);

	$vodafone_bts1_type = $row["vodafone_bts1_type"];
	$vodafone_bts2_type = $row["vodafone_bts2_type"];
	$vodafone_bts3_type = $row["vodafone_bts3_type"];
	$vodafone_bts4_type = $row["vodafone_bts4_type"];
	$vodafone_bts5_type = $row["vodafone_bts5_type"];
	$vodafone_bts6_type = $row["vodafone_bts6_type"];

	$vodafone_bts1_on_date = $row["vodafone_on_air_date"];
	$vodafone_bts2_on_date = $row["vodafone_bts2_on_date"];
	$vodafone_bts3_on_date = $row["vodafone_bts3_on_date"];
	$vodafone_bts4_on_date = $row["vodafone_bts4_on_date"];
	$vodafone_bts5_on_date = $row["vodafone_bts5_on_date"];
	$vodafone_bts6_on_date = $row["vodafone_bts6_on_date"];
	$vodafone_link_on_date = $row["vodafone_link_on_date"];

	$vodafone_bts1_off_date = $row["vodafone_bts1_off_date"];
	$vodafone_bts2_off_date = $row["vodafone_bts2_off_date"];
	$vodafone_bts3_off_date = $row["vodafone_bts3_off_date"];
	$vodafone_bts4_off_date = $row["vodafone_bts4_off_date"];
	$vodafone_bts5_off_date = $row["vodafone_bts5_off_date"];
	$vodafone_bts6_off_date = $row["vodafone_bts6_off_date"];
	$vodafone_link_off_date = $row["vodafone_link_off_date"];

	$vodafone_on_date = prepareOperatorOnDate($vodafone_bts1_on_date,$vodafone_bts2_on_date,$vodafone_bts3_on_date,$vodafone_bts4_on_date,$vodafone_bts5_on_date,$vodafone_bts6_on_date,
						$vodafone_bts1_off_date,$vodafone_bts2_off_date,$vodafone_bts3_off_date,$vodafone_bts4_off_date,$vodafone_bts5_off_date,$vodafone_bts6_off_date,
						$vodafone_link_on_date, $vodafone_link_off_date);

	$vodafoneOffDate = prepareOperatorOffDate($vodafone_bts1_on_date,$vodafone_bts2_on_date,$vodafone_bts3_on_date,$vodafone_bts4_on_date,$vodafone_bts5_on_date,$vodafone_bts6_on_date,
						$vodafone_bts1_off_date,$vodafone_bts2_off_date,$vodafone_bts3_off_date,$vodafone_bts4_off_date,$vodafone_bts5_off_date,$vodafone_bts6_off_date,
						$vodafone_link_on_date, $vodafone_link_off_date);

	$vodafoneNoOfDays = prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $vodafone_on_date, $vodafoneOffDate);

	// $isAirtelHaveId = haveIdOnBts($airtel_bts1_on_date,$airtel_bts2_on_date,$airtel_bts3_on_date,$airtel_bts4_on_date,$airtel_bts5_on_date,$airtel_bts6_on_date, 
	// 	$airtel_bts1_type, $airtel_bts2_type, $airtel_bts3_type, $airtel_bts4_type, $airtel_bts5_type, $airtel_bts6_type);

	// $isBsnlHaveId = haveIdOnBts($bsnl_bts1_on_date,$bsnl_bts2_on_date,$bsnl_bts3_on_date,$bsnl_bts4_on_date,$bsnl_bts5_on_date,$bsnl_bts6_on_date,$bsnl_bts1_type,$bsnl_bts2_type,
	// 	$bsnl_bts3_type,$bsnl_bts4_type,$bsnl_bts5_type,$bsnl_bts6_type);

	// $isIdeaHaveId = haveIdOnBts($idea_bts1_on_date,$idea_bts2_on_date,$idea_bts3_on_date,$idea_bts4_on_date,$idea_bts5_on_date,$idea_bts6_on_date,$idea_bts1_type,$idea_bts2_type,
	// 	$idea_bts3_type,$idea_bts4_type,$idea_bts5_type,$idea_bts6_type);

	// $isPbHfclHaveId = haveIdOnBts($pbHfcl_bts1_on_date,$pbHfcl_bts2_on_date,$pbHfcl_bts3_on_date,$pbHfcl_bts4_on_date,$pbHfcl_bts5_on_date,$pbHfcl_bts6_on_date,$pbHfcl_bts1_type,
	// 	$pbHfcl_bts2_type,$pbHfcl_bts3_type,$pbHfcl_bts4_type,$pbHfcl_bts5_type,$pbHfcl_bts6_type);

	// $isRjioHaveId = haveIdOnBts($rjio_bts1_on_date,$rjio_bts2_on_date,$rjio_bts3_on_date,$rjio_bts4_on_date,$rjio_bts5_on_date,$rjio_bts6_on_date,$rjio_bts1_type,$rjio_bts2_type,
	// 	$rjio_bts3_type,$rjio_bts4_type,$rjio_bts5_type,$rjio_bts6_type);

	// $isSifyHaveId = haveIdOnBts($sify_bts1_on_date,$sify_bts2_on_date,$sify_bts3_on_date,$sify_bts4_on_date,$sify_bts5_on_date,$sify_bts6_on_date,$sify_bts1_type,$sify_bts2_type,
	// 	$sify_bts3_type,$sify_bts4_type,$sify_bts5_type,$sify_bts6_type);

	// $isTclIotHaveId = haveIdOnBts($tclIot_bts1_on_date,$tclIot_bts2_on_date,$tclIot_bts3_on_date,$tclIot_bts4_on_date,$tclIot_bts5_on_date,$tclIot_bts6_on_date,$tclIot_bts1_type,
	// 	$tclIot_bts2_type,$tclIot_bts3_type,$tclIot_bts4_type,$tclIot_bts5_type,$tclIot_bts6_type);

	// $isTclNldHaveId = haveIdOnBts($tclNld_bts1_on_date,$tclNld_bts2_on_date,$tclNld_bts3_on_date,$tclNld_bts4_on_date,$tclNld_bts5_on_date,$tclNld_bts6_on_date,$tclNld_bts1_type,
	// 	$tclNld_bts2_type,$tclNld_bts3_type,$tclNld_bts4_type,$tclNld_bts5_type,$tclNld_bts6_type);

	// $isTclRedwinHaveId = haveIdOnBts($tclRedwin_bts1_on_date,$tclRedwin_bts2_on_date,$tclRedwin_bts3_on_date,$tclRedwin_bts4_on_date,$tclRedwin_bts5_on_date,$tclRedwin_bts6_on_date,
	// 	$tclRedwin_bts1_type,$tclRedwin_bts2_type,$tclRedwin_bts3_type,$tclRedwin_bts4_type,$tclRedwin_bts5_type,$tclRedwin_bts6_type);

	// $istclWimaxHaveId = haveIdOnBts($tclWimax_bts1_on_date,$tclWimax_bts2_on_date,$tclWimax_bts3_on_date,$tclWimax_bts4_on_date,$tclWimax_bts5_on_date,$tclWimax_bts6_on_date,
	// 	$tclWimax_bts1_type,$tclWimax_bts2_type,$tclWimax_bts3_type,$tclWimax_bts4_type,$tclWimax_bts5_type,$tclWimax_bts6_type);

	// $isTtslCdmaHaveId = haveIdOnBts($ttslCdma_bts1_on_date,$ttslCdma_bts2_on_date,$ttslCdma_bts3_on_date,$ttslCdma_bts4_on_date,$ttslCdma_bts5_on_date,$ttslCdma_bts6_on_date,
	// 	$ttslCdma_bts1_type,$ttslCdma_bts2_type,$ttslCdma_bts3_type,$ttslCdma_bts4_type,$ttslCdma_bts5_type,$ttslCdma_bts6_type);

	// $isTtslHaveId = haveIdOnBts($ttsl_bts1_on_date,$ttsl_bts2_on_date,$ttsl_bts3_on_date,$ttsl_bts4_on_date,$ttsl_bts5_on_date,$ttsl_bts6_on_date,$ttsl_bts1_type,$ttsl_bts2_type,
	// 	$ttsl_bts3_type,$ttsl_bts4_type,$ttsl_bts5_type,$ttsl_bts6_type);

	// $isVodafoneHaveId = haveIdOnBts($vodafone_bts1_on_date,$vodafone_bts2_on_date,$vodafone_bts3_on_date,$vodafone_bts4_on_date,$vodafone_bts5_on_date,$vodafone_bts6_on_date,
	// 	$vodafone_bts1_type,$vodafone_bts2_type,$vodafone_bts3_type,$vodafone_bts4_type,$vodafone_bts5_type,$vodafone_bts6_type);

	$isAirtelHaveId = $row["airtel_have_ID"];

	$isBsnlHaveId = $row["bsnl_have_ID"];

	$isIdeaHaveId = $row["idea_have_ID"];

	$isPbHfclHaveId = $row["pbHfcl_have_ID"];

	$isRjioHaveId = $row["rjio_have_ID"];

	$isSifyHaveId = $row["sify_have_ID"];

	$isTclIotHaveId = $row["tclIot_have_ID"];

	$isTclNldHaveId = $row["tclNld_have_ID"];

	$isTclRedwinHaveId = $row["tclRedwin_have_ID"];

	$istclWimaxHaveId = $row["tclWimax_have_ID"];

	$isTtslCdmaHaveId = $row["ttslCdma_have_ID"];

	$isTtslHaveId = $row["ttsl_have_ID"];

	$isVodafoneHaveId = $row["vodafone_have_ID"];

	// $airtelAircon = if($isAirtelHaveId == 'Yes') $row["Airtel_Aircon_Load_in_KW"];
	$airtelAircon = $isAirtelHaveId == 'No' || $row["Airtel_Aircon_Load_in_KW"] == '' ? 0 : $row["Airtel_Aircon_Load_in_KW"];
	$bsnlAircon = $isBsnlHaveId == 'No' || $row["BSNL_Aircon_Load_in_KW"] == ''  ? 0 : $row["BSNL_Aircon_Load_in_KW"];
	$ideaAircon = $isIdeaHaveId == 'No' || $row["IDEA_Aircon_Load_in_KW"] == ''  ? 0 : $row["IDEA_Aircon_Load_in_KW"];
	$pbHfclAircon = $isPbHfclHaveId == 'No' || $row["HFCL_Aircon_Load_in_KW"] == ''  ? 0 : $row["HFCL_Aircon_Load_in_KW"];
	$rjioAircon = $isRjioHaveId == '' || $row["RJIO_Aircon_Load_in_KW"] == ''  ? 0 : $row["RJIO_Aircon_Load_in_KW"];
	$sifyAircon = $isSifyHaveId == 'No' || $row["Sify_Aircon_Load_in_KW"] == ''  ? 0 : $row["Sify_Aircon_Load_in_KW"];
	$tclIotAircon = $isTclIotHaveId == 'No' || $row["tclIot_Aircon_Load_in_KW"] == ''  ? 0 : $row["tclIot_Aircon_Load_in_KW"];
	$tclNldAircon = $isTclNldHaveId == 'No' || $row["tclNld_Aircon_Load_in_KW"] == ''  ? 0 : $row["tclNld_Aircon_Load_in_KW"];
	$tclRedwinAircon = $isTclRedwinHaveId == 'No' || $row["tclRedwin_Aircon_Load_in_KW"] == ''  ? 0 : $row["tclRedwin_Aircon_Load_in_KW"];
	$tclWimaxAircon = $istclWimaxHaveId == 'No' || $row["tclWinmax_Aircon_Load_in_KW"] == ''  ? 0 : $row["tclWinmax_Aircon_Load_in_KW"];
	$ttslCdmaAircon = $isTtslCdmaHaveId == 'No' || $row["ttslCdma_Aircon_Load_in_KW"] == ''  ? 0 : $row["ttslCdma_Aircon_Load_in_KW"];
	$ttslAircon = $isTtslHaveId == 'No' || $row["ttsl_Aircon_Load_in_KW"] == ''  ? 0 : $row["ttsl_Aircon_Load_in_KW"];
	$vodafoneAircon = $isVodafoneHaveId == 'No' || $row["vadafone_Aircon_Load_in_KW"] == ''  ? 0 : $row["vadafone_Aircon_Load_in_KW"];

	$totalAircon = $airtelAircon + $bsnlAircon + $ideaAircon + $pbHfclAircon + $rjioAircon + $sifyAircon + $tclIotAircon + $tclNldAircon + $tclRedwinAircon + $tclWimaxAircon + 
	$ttslCdmaAircon + $ttslAircon + $vodafoneAircon;

	$airtelBtsAcLoad = ($airtelKwh + $airtelAircon) * $airtelNoOfDays;
	$bsnlBtsAcLoad = ($bsnlKwh + $bsnlAircon) * $bsnlNoOfDays;
	$ideaBtsAcLoad = ($ideaKwh + $ideaAircon) * $ideaNoOfDays;
	$pbHfclBtsAcLoad = ($pbHFClKwh + $pbHfclAircon) * $pbHfclNoOfDays;
	$rjioBtsAcLoad = ($rjioKwh + $rjioAircon) * $rjioNoOfDays;
	$sifyBtsAcLoad = ($sifyKwh + $sifyAircon) * $sifyNoOfDays;
	$tclIotBtsAcLoad = ($tclIotKwh + $tclIotAircon) * $tclIotNoOfDays;
	$tclNldBtsAcLoad = ($tclNldKwh + $tclNldAircon) * $tclNldNoOfDays;
	$tclRedwinBtsAcLoad = ($tclRedwinKwh + $tclRedwinAircon) * $tclRedwinNoOfDays;
	$tclWimaxBtsAcLoad = ($tclWimaxKwh + $tclWimaxAircon) * $tclWimaxNoOfDays;
	$ttslCdmaBtsAcLoad = ($ttslCdmaKwh + $ttslCdmaAircon) * $ttslCdmaNoOfDays;
	$ttslBtsAcLoad = ($ttslKwh + $ttslAircon) * $ttslNoOfDays;
	$vodafoneBtsAcLoad = ($vodafoneKwh + $vodafoneAircon) * $vodafoneNoOfDays;

	$totalAcBtsLoad = $airtelBtsAcLoad + $bsnlBtsAcLoad + $ideaBtsAcLoad + $pbHfclBtsAcLoad + 
						$rjioBtsAcLoad + $sifyBtsAcLoad + $tclIotBtsAcLoad + $tclNldBtsAcLoad + $tclRedwinBtsAcLoad + 
						$tclWimaxBtsAcLoad + $ttslCdmaBtsAcLoad + $ttslBtsAcLoad + $vodafoneBtsAcLoad;

	$airtelPercentage = $totalAcBtsLoad == '' ? 0 : ($airtelBtsAcLoad * 100) / $totalAcBtsLoad;
	$bsnlPercentage = $totalAcBtsLoad == '' ? 0 : ($bsnlBtsAcLoad * 100) / $totalAcBtsLoad;
	$ideaPercentage = $totalAcBtsLoad == '' ? 0 : ($ideaBtsAcLoad * 100) / $totalAcBtsLoad;
	$pbHFCLPercentage = $totalAcBtsLoad == '' ? 0 : ($pbHfclBtsAcLoad * 100) / $totalAcBtsLoad;
	$rjioPercentage = $totalAcBtsLoad == '' ? 0 : ($rjioBtsAcLoad * 100) / $totalAcBtsLoad;
	$sifyPercentage = $totalAcBtsLoad == '' ? 0 : ($sifyBtsAcLoad * 100) / $totalAcBtsLoad;
	$tclIotPercentage = $totalAcBtsLoad == '' ? 0 : ($tclIotBtsAcLoad * 100) / $totalAcBtsLoad;
	$tclNldPercentage = $totalAcBtsLoad == '' ? 0 : ($tclNldBtsAcLoad * 100) / $totalAcBtsLoad;
	$tclRedwinPercentage = $totalAcBtsLoad == '' ? 0 : ($tclRedwinBtsAcLoad * 100) / $totalAcBtsLoad;
	$tclWimaxPercentage = $totalAcBtsLoad == '' ? 0 : ($tclWimaxBtsAcLoad * 100) / $totalAcBtsLoad;
	$ttslCdmaPercentage = $totalAcBtsLoad == '' ? 0 : ($ttslCdmaBtsAcLoad * 100) / $totalAcBtsLoad;
	$ttslPercentage = $totalAcBtsLoad == '' ? 0 : ($ttslBtsAcLoad * 100) / $totalAcBtsLoad;
	$vodafonePercentage = $totalAcBtsLoad == '' ? 0 : ($vodafoneBtsAcLoad * 100) / $totalAcBtsLoad;
	
	$totalPercentage = $airtelPercentage + $bsnlPercentage + $ideaPercentage + $pbHFCLPercentage +
			$rjioPercentage + $sifyPercentage + $tclIotPercentage + $tclNldPercentage + $tclRedwinPercentage +
			$tclWimaxPercentage + $ttslCdmaPercentage + $ttslPercentage + $vodafonePercentage;

	$airtelTenancy = prepareNoOfTenancy($firstDate, $airtel_on_date, $airtelOffDate, $airtelEnergyRevenue);
	$bsnlTenancy = prepareNoOfTenancy($firstDate, $bsnl_on_date, $bsnlOffDate, $bsnlEnergyRevenue);
	$ideaTenancy = prepareNoOfTenancy($firstDate, $idea_on_date, $ideaOffDate, $ideaEnergyRevenue);
	$pbHfclTenancy = prepareNoOfTenancy($firstDate, $pbHFCL_on_date, $pbHFCLOffDate, $pbHfclEnergyRevenue);
	$rjioTenancy = prepareNoOfTenancy($firstDate, $rjio_on_date, $rjioOffDate, $rjioEnergyRevenue);
	$sifyTenancy = prepareNoOfTenancy($firstDate, $sify_on_date, $sifyOffDate, $sifyEnergyRevenue);
	$tclIotTenancy = prepareNoOfTenancy($firstDate, $tclIot_on_date, $tclIotOffDate, $tclIotEnergyRevenue);
	$tclNldTenancy = prepareNoOfTenancy($firstDate, $tclNld_on_date, $tclNldOffDate, $tclNldEnergyRevenue);
	$tclRedwinTenancy = prepareNoOfTenancy($firstDate, $tclRedwin_on_date, $tclRedwinOffDate, $tclRedwinEnergyRevenue);
	$tclWimaxTenancy = prepareNoOfTenancy($firstDate, $tclWimax_on_date, $tclWimaxOffDate, $tclWimaxEnergyRevenue);
	$ttslCdmaTenancy = prepareNoOfTenancy($firstDate, $ttslCdma_on_date, $ttslCdmaOffDate, $ttslCdmaEnergyRevenue);
	$ttslTenancy = prepareNoOfTenancy($firstDate, $ttsl_on_date, $ttslOffDate, $ttslEnergyRevenue);
	$vodafoneTenancy = prepareNoOfTenancy($firstDate, $vodafone_on_date, $vodafoneOffDate, $vodafoneEnergyRevenue);

	$noOfTenancy = $airtelTenancy + $bsnlTenancy + $ideaTenancy + $pbHfclTenancy + $rjioTenancy + $sifyTenancy + $tclIotTenancy + 
						$tclNldTenancy + $tclRedwinTenancy + $tclWimaxTenancy + $ttslCdmaTenancy + $ttslTenancy + $vodafoneTenancy;	

	$airtelDieselCost = ($dieselCost * $airtelPercentage) / 100;
	$bsnlDieselCost = ($dieselCost * $bsnlPercentage) / 100;
	$ideaDieselCost = ($dieselCost * $ideaPercentage) / 100;
	$pbHfclDieselCost = ($dieselCost * $pbHFCLPercentage) / 100;
	$rjioDieselCost = ($dieselCost * $rjioPercentage) / 100;
	$sifyDieselCost = ($dieselCost * $sifyPercentage) / 100;
	$tclIotDieselCost = ($dieselCost * $tclIotPercentage) / 100;
	$tclNldDieselCost = ($dieselCost * $tclNldPercentage) / 100;
	$tclRedwinDieselCost = ($dieselCost * $tclRedwinPercentage) / 100;
	$tclWimaxDieselCost = ($dieselCost * $tclWimaxPercentage) / 100;
	$ttslCdmaDieselCost = ($dieselCost * $ttslCdmaPercentage) / 100;
	$ttslDieselCost = ($dieselCost * $ttslPercentage) / 100;
	$vodafoneDieselCost = ($dieselCost * $vodafonePercentage) / 100;
	$ztsDieselCost = ($noOfTenancy == 0 && $dieselCost != 0.0) ? $dieselCost : 0;

	$totalDieselCost = $airtelDieselCost + $bsnlDieselCost + $ideaDieselCost + $pbHfclDieselCost + $rjioDieselCost +
						$sifyDieselCost + $tclIotDieselCost + $tclNldDieselCost + $tclRedwinDieselCost + $tclWimaxDieselCost +
						$ttslCdmaDieselCost + $ttslDieselCost + $vodafoneDieselCost + $ztsDieselCost;

	$airtelEbCost = ($ebCost * $airtelPercentage) / 100;
	$bsnlEbCost = ($ebCost * $bsnlPercentage) / 100;
	$ideaEbCost = ($ebCost * $ideaPercentage) / 100;
	$pbHfclEbCost = ($ebCost * $pbHFCLPercentage) / 100;
	$rjioEbCost = ($ebCost * $rjioPercentage) / 100;
	$sifyEbCost = ($ebCost * $sifyPercentage) / 100;
	$tclIotEbCost = ($ebCost * $tclIotPercentage) / 100;
	$tclNldEbCost = ($ebCost * $tclNldPercentage) / 100;
	$tclRedwinEbCost = ($ebCost * $tclRedwinPercentage) / 100;
	$tclWimaxEbCost = ($ebCost * $tclWimaxPercentage) / 100;
	$ttslCdmaEbCost = ($ebCost * $ttslCdmaPercentage) / 100;
	$ttslEbCost = ($ebCost * $ttslPercentage) / 100;
	$vodafoneEbCost = ($ebCost * $vodafonePercentage) / 100;
	$ztsEbCost = ($noOfTenancy == 0 && $ebCost != 0.0) ? $ebCost : 0;

	$totalEbCost = $airtelEbCost + $bsnlEbCost + $ideaEbCost + $pbHfclEbCost + $rjioEbCost +
						$sifyEbCost + $tclIotEbCost + $tclNldEbCost + $tclRedwinEbCost + $tclWimaxEbCost + 
						$ttslCdmaEbCost + $ttslEbCost + $vodafoneEbCost + $ztsEbCost;

	$airtelEnergyCost = ($energyCost * $airtelPercentage) / 100;
	$bsnlEnergyCost = ($energyCost * $bsnlPercentage) / 100;
	$ideaEnergyCost = ($energyCost * $ideaPercentage) / 100;
	$pbHfclEnergyCost = ($energyCost * $pbHFCLPercentage) / 100;
	$rjioEnergyCost = ($energyCost * $rjioPercentage) / 100;
	$sifyEnergyCost = ($energyCost * $sifyPercentage) / 100;
	$tclIotEnergyCost = ($energyCost * $tclIotPercentage) / 100;
	$tclNldEnergyCost = ($energyCost * $tclNldPercentage) / 100;
	$tclRedwinEnergyCost = ($energyCost * $tclRedwinPercentage) / 100;
	$tclWimaxEnergyCost = ($energyCost * $tclWimaxPercentage) / 100;
	$ttslCdmaEnergyCost = ($energyCost * $ttslCdmaPercentage) / 100;
	$ttslEnergyCost = ($energyCost * $ttslPercentage) / 100;
	$vodafoneEnergyCost = ($energyCost * $vodafonePercentage) / 100;
	$ztsEnergyCost = ($noOfTenancy == 0 && $energyCost != 0.0) ? $energyCost : 0;

	$totalEnergyCost = $airtelEnergyCost + $bsnlEnergyCost + $ideaEnergyCost + $pbHfclEnergyCost + $rjioEnergyCost +
						$sifyEnergyCost + $tclIotEnergyCost + $tclNldEnergyCost + $tclRedwinEnergyCost + $tclWimaxEnergyCost + 
						$ttslCdmaEnergyCost + $ttslEnergyCost + $vodafoneEnergyCost + $ztsEnergyCost;

	$airtelMargin = prepareOperatorMargin($airtelEnergyRevenue, $airtelEnergyCost);
	$bsnlMargin = prepareOperatorMargin($bsnlEnergyRevenue, $bsnlEnergyCost);
	$ideaMargin = prepareOperatorMargin($ideaEnergyRevenue, $ideaEnergyCost);
	$pbHfclMargin = prepareOperatorMargin($pbHfclEnergyRevenue, $pbHfclEnergyCost);
	$rjioMargin = prepareOperatorMargin($rjioEnergyRevenue, $rjioEnergyCost);
	$sifyMargin = prepareOperatorMargin($sifyEnergyRevenue, $sifyEnergyCost);
	$tclIotMargin = prepareOperatorMargin($tclIotEnergyRevenue, $tclIotEnergyCost);
	$tclNldMargin = prepareOperatorMargin($tclNldEnergyRevenue, $tclNldEnergyCost);
	$tclRedwinMargin = prepareOperatorMargin($tclRedwinEnergyRevenue, $tclRedwinEnergyCost);
	$tclWimaxMargin = prepareOperatorMargin($tclWimaxEnergyRevenue, $tclWimaxEnergyCost);
	$ttslCdmaMargin = prepareOperatorMargin($ttslCdmaEnergyRevenue, $ttslCdmaEnergyCost);
	$ttslMargin = prepareOperatorMargin($ttslEnergyRevenue, $ttslEnergyCost);
	$vodafoneMargin = prepareOperatorMargin($vodafoneEnergyRevenue, $vodafoneEnergyCost);
	$ztsMargin = prepareOperatorMargin($ztsEnergyRevenue, $ztsEnergyCost);

	$totalMargin = 0.0;
	if($airtelMargin != null) $totalMargin += $airtelMargin;
	if($bsnlMargin != null) $totalMargin += $bsnlMargin;
	if($ideaMargin != null) $totalMargin += $ideaMargin;
	if($pbHfclMargin != null) $totalMargin += $pbHfclMargin;
	if($rjioMargin != null) $totalMargin += $rjioMargin;
	if($sifyMargin != null) $totalMargin += $sifyMargin;
	if($tclIotMargin != null) $totalMargin += $tclIotMargin;
	if($tclNldMargin != null) $totalMargin += $tclNldMargin;
	if($tclRedwinMargin != null) $totalMargin += $tclRedwinMargin;
	if($tclWimaxMargin != null) $totalMargin += $tclWimaxMargin;
	if($ttslCdmaMargin != null) $totalMargin += $ttslCdmaMargin;
	if($ttslMargin != null) $totalMargin += $ttslMargin;
	if($vodafoneMargin != null) $totalMargin += $vodafoneMargin;
	if($ztsMargin != null) $totalMargin += $ztsMargin;

	$fem="";
	$nonFem="";
	$siteCategory = $totalMargin < 0 ? "Loss Making Site" : "Normal site";
	$operationStatus = $noOfTenancy == 0 ? "ZTS" : "Operational"; 

	$site_id = $row["site_id"]; $site_name = str_replace("'", "", $row["site_name"]); $opco_circle_name = $row["opco_circle_name"];

	$dieselBillingFromDate = $row["dieselBillingFromDate"]; $dieselBillingUpToDate = $row["dieselBillingUpToDate"]; $dieselNoOfDays = $row["dieselNoOfDays"];
	
	$jsonData = array('col1' => $site_id, 'col2' => $site_name, 'col3' => $opco_circle_name, 'col4' => $airtel_on_date, 'col5' => $airtelOffDate, 
		'col6' => $airtel_load, 'col7' => $bsnl_on_date, 'col8' => $bsnlOffDate, 'col9' => $bsnl_load, 'col10' => $idea_on_date, 
		'col11' => $ideaOffDate, 'col12' => $idea_load, 'col13' => $pbHFCL_on_date, 'col14' => $pbHFCLOffDate, 'col15' => $pbHFCL_load, 'col16' => $rjio_on_date, 'col17' => $rjioOffDate, 'col18' => $rjio_load, 'col19' => $sify_on_date, 'col20' => $sifyOffDate, 
		'col21' => $sify_load, 'col22' => $tclIot_on_date, 'col23' => $tclIotOffDate, 'col24' => $tcIOT_load, 'col25' => $tclNld_on_date, 'col26' => $tclNldOffDate, 
		'col27' => $tclNLD_load, 'col28' => $tclRedwin_on_date, 'col29' => $tclRedwinOffDate, 'col30' => $tclRedwin_load, 
		'col31' => $tclWimax_on_date, 'col32' => $tclWimaxOffDate, 'col33' => $tclWimax_load, 'col34' => $ttslCdma_on_date, 'col35' => $ttslCdmaOffDate, 'col36' => $ttslCDMA_load, 
		'col37' => $ttsl_on_date, 'col38' => $ttslOffDate, 'col39' => $ttsl_load, 'col40' => $vodafone_on_date, 
		'col41' => $vodafoneOffDate, 'col42' => $vodafone_load, 'col43' => $siteVoltage, 'col44' => $airtelKwh, 'col45' => $bsnlKwh, 'col46' => $ideaKwh, 'col47' => $pbHFClKwh, 
		'col48' => $rjioKwh, 'col49' => $sifyKwh, 'col50' => $tclIotKwh, 
		'col51' => $tclNldKwh, 'col52' => $tclRedwinKwh, 'col53' => $tclWimaxKwh, 'col54' => $ttslCdmaKwh, 'col55' => $ttslKwh, 'col56' => $vodafoneKwh, 'col57' => $totalKwh, 
		'col58' => $airtelAircon, 'col59' => $bsnlAircon, 'col60' => $ideaAircon, 
		'col61' => $pbHfclAircon, 'col62' => $rjioAircon, 'col63' => $sifyAircon, 'col64' => $tclIotAircon, 'col65' => $tclNldAircon, 'col66' => $tclRedwinAircon, 
		'col67' => $tclWimaxAircon, 'col68' => $ttslCdmaAircon, 'col69' => $ttslAircon, 'col70' => $vodafoneAircon, 
		'col71' => $totalAircon, 'col72' => $airtelBtsAcLoad, 'col73' => $bsnlBtsAcLoad, 'col74' => $ideaBtsAcLoad, 'col75' => $pbHfclBtsAcLoad, 'col76' => $rjioBtsAcLoad, 
		'col77' => $sifyBtsAcLoad, 'col78' => $tclIotBtsAcLoad, 'col79' => $tclNldBtsAcLoad, 'col80' => $tclRedwinBtsAcLoad, 
		'col81' => $tclWimaxBtsAcLoad, 'col82' => $ttslCdmaBtsAcLoad, 'col83' => $ttslBtsAcLoad, 'col84' => $vodafoneBtsAcLoad, 'col85' => $totalAcBtsLoad, 
		'col86' => $dieselBillingFromDate, 'col87' => $dieselBillingUpToDate, 'col88' => $dieselNoOfDays, 'col89' => $dieselCost, 'col90' => $ebCost, 
		'col91' => $energyCost, 'col92' => $airtelNoOfDays, 'col93' => $bsnlNoOfDays, 'col94' => $ideaNoOfDays, 'col95' => $pbHfclNoOfDays, 'col96' => $rjioNoOfDays, 
		'col97' => $sifyNoOfDays, 'col98' => $tclIotNoOfDays, 'col99' => $tclNldNoOfDays, 'col100' => $tclRedwinNoOfDays,

		'col101' => $tclWimaxNoOfDays, 'col102' => $ttslCdmaNoOfDays, 'col103' => $ttslNoOfDays, 'col104' => $vodafoneNoOfDays, 'col105' => $airtelPercentage, 
		'col106' => $bsnlPercentage, 'col107' => $ideaPercentage, 'col108' => $pbHFCLPercentage, 'col109' => $rjioPercentage, 'col110' => $sifyPercentage, 
		'col111' => $tclIotPercentage, 'col112' => $tclNldPercentage, 'col113' => $tclRedwinPercentage, 'col114' => $tclWimaxPercentage, 'col115' => $ttslCdmaPercentage, 
		'col116' => $ttslPercentage, 'col117' => $vodafonePercentage, 'col118' => $totalPercentage, 'col119' => $airtelDieselCost, 'col120' => $bsnlDieselCost, 
		'col121' => $ideaDieselCost, 'col122' => $pbHfclDieselCost, 'col123' => $rjioDieselCost, 'col124' => $sifyDieselCost, 'col125' => $tclIotDieselCost, 
		'col126' => $tclNldDieselCost, 'col127' => $tclRedwinDieselCost, 'col128' => $tclWimaxDieselCost, 'col129' => $ttslCdmaDieselCost, 'col130' => $ttslDieselCost, 
		'col131' => $vodafoneDieselCost, 'col132' => $ztsDieselCost, 'col133' => $totalDieselCost, 'col134' => $airtelEbCost, 'col135' => $bsnlEbCost, 'col136' => $ideaEbCost, 
		'col137' => $pbHfclEbCost, 'col138' => $rjioEbCost, 'col139' => $sifyEbCost, 'col140' => $tclIotEbCost, 
		'col141' => $tclNldEbCost, 'col142' => $tclRedwinEbCost, 'col143' => $tclWimaxEbCost, 'col144' => $ttslCdmaEbCost, 'col145' => $ttslEbCost, 'col146' => $vodafoneEbCost, 
		'col147' => $ztsEbCost, 'col148' => $totalEbCost, 'col149' => $airtelEnergyCost, 'col150' => $bsnlEnergyCost, 
		'col151' => $ideaEnergyCost, 'col152' => $pbHfclEnergyCost, 'col153' => $rjioEnergyCost, 'col154' => $sifyEnergyCost, 'col155' => $tclIotEnergyCost, 
		'col156' => $tclNldEnergyCost, 'col157' => $tclRedwinEnergyCost, 'col158' => $tclWimaxEnergyCost, 'col159' => $ttslCdmaEnergyCost, 'col160' => $ttslEnergyCost, 
		'col161' => $vodafoneEnergyCost, 'col162' => $ztsEnergyCost, 'col163' => $totalEnergyCost, 'col164' => $airtelDieselRevenue, 'col165' => $bsnlDieselRevenue, 'col166' => $ideaDieselRevenue, 'col167' => $pbHfclDieselRevenue, 'col168' => $rjioDieselRevenue, 'col169' => $sifyDieselRevenue, 'col170' => $tclIotDieselRevenue, 
		'col171' => $tclNldDieselRevenue, 'col172' => $tclRedwinDieselRevenue, 'col173' => $tclWimaxDieselRevenue, 'col174' => $ttslCdmaDieselRevenue, 'col175' => $ttslDieselRevenue, 'col176' => $vodafoneDieselRevenue, 'col177' => $ztsDieselRevenue, 'col178' => $totalDieselRevenue, 'col179' => $airtelEbRevenue, 'col180' => $bsnlEbRevenue, 
		'col181' => $ideaEbRevenue, 'col182' => $pbHfclEbRevenue, 'col183' => $rjioEbRevenue, 'col184' => $sifyEbRevenue, 'col185' => $tclIotEbRevenue, 'col186' => $tclNldEbRevenue, 'col187' => $tclRedwinEbRevenue, 'col188' => $tclWimaxEbRevenue, 'col189' => $ttslCdmaEbRevenue, 'col190' => $ttslEbRevenue, 
		'col191' => $vodafoneEbRevenue, 'col192' => $ztsEbRevenue, 'col193' => $totalEbRevenue, 'col194' => $airtelEnergyRevenue, 'col195' => $bsnlEnergyRevenue, 'col196' => $ideaEnergyRevenue, 'col197' => $pbHfclEnergyRevenue, 'col198' => $rjioEnergyRevenue, 'col199' => $sifyEnergyRevenue, 'col200' => $tclIotEnergyRevenue, 

		'col201' => $tclNldEnergyRevenue, 'col202' => $tclRedwinEnergyRevenue, 'col203' => $tclWimaxEnergyRevenue, 'col204' => $ttslCdmaEnergyRevenue, 'col205' => $ttslEnergyRevenue, 
		'col206' => $vodafoneEnergyRevenue, 'col207' => $ztsEnergyRevenue, 'col208' => $totalEnergyRevenue, 'col209' => $airtelMargin, 'col210' => $bsnlMargin, 
		'col211' => $ideaMargin, 'col212' => $pbHfclMargin, 'col213' => $rjioMargin, 'col214' => $sifyMargin, 'col215' => $tclIotMargin, 'col216' => $tclNldMargin, 
		'col217' => $tclRedwinMargin, 'col218' => $tclWimaxMargin, 'col219' => $ttslCdmaMargin, 'col220' => $ttslMargin, 
		'col221' => $vodafoneMargin, 'col222' => $ztsMargin, 'col223' => $totalMargin, 'col224' => $noOfTenancy, 'col225' => $operationStatus, 'col226' => $siteCategory, 
		'col227' => $siteType, 'col228' => $fem, 'col229' => $nonFem, 'col230' => $ebStatus

	);

	fputcsv($output, $jsonData);
	

	$table = "insert into `P&L Sitewise` ";

	$columns = "(`Site ID`, `Site Name`, `Circle Name`, `Billing Circle Name`, `Billing State`, 
	`Airtel_Min of Operator on Date ('April'20)`, `Airtel_Max of Billing stop Date('April'20`, `Airtel_Sum of Load`, 
	`BSNL_Min of Operator on Date ('April'20)`, `BSNL_Max of Billing stop Date('April'20`, `BSNL_Sum of Load`, 
	`IDEA_Min of Operator on Date ('April'20)`, `IDEA_Max of Billing stop Date('April'20`, `IDEA_Sum of Load`, 
	`PB_HFCL_Min of Operator on Date ('April'20)`, `PB_HFCL_Max of Billing stop Date('April'20`, `PB_HFCL_Sum of Load`, 
	`RJIO_Min of Operator on Date ('April'20)`, `RJIO_Max of Billing stop Date('April'20`, `RJIO_Sum of Load`, 
	`Sify_Min of Operator on Date ('April'20)`, `Sify_Max of Billing stop Date('April'20`, `Sify_Sum of Load`, 
	`TCL_IOT_Min of Operator on Date ('April'20)`, `TCL_IOT_Max of Billing stop Date('April'20`, `TCL_IOT_Sum of Load`, 
	`TCL_NLD_Min of Operator on Date ('April'20)`, `TCL_NLD_Max of Billing stop Date('April'20`, `TCL_NLD_Sum of Load`, 
	`TCL_Redwin_Min of Operator on Date ('April'20)`, `TCL_Redwin_Max of Billing stop Date('April'20`, `TCL_Redwin_Sum of Load`, 
	`TCL_Wimax_Min of Operator on Date ('April'20)`, `TCL_Wimax_Max of Billing stop Date('April'20`, `TCL_Wimax_Sum of Load`, 
	`TTSL_CDMA_Min of Operator on Date ('April'20)`, `TTSL_CDMA_Max of Billing stop Date('April'20`, `TTSL_CDMA_Sum of Load`, 
	`TTSL_Min of Operator on Date ('April'20)`, `TTSL_Max of Billing stop Date('April'20`, `TTSL_Sum of Load`, 
	`Vodafone_Min of Operator on Date ('April'20)`, `Vodafone_Max of Billing stop Date('April'20`, `Vodafone_Sum of Load`, 
	`voltage`, 

	`Airtel(BTS Load in KWH)`, `BSNL(BTS Load in KWH)`, `IDEA(BTS Load in KWH)`, `HFCL (BTS Load in KWH)`, `RJIO(BTS Load in KWH)`, `Sify(BTS Load in KWH)`, 
	`TCL-IOT (BTS Load in KWH)`, `TCL-NLD (BTS Load in KWH)`, `TCL-Redwin(BTS Load in KWH)`, `TCL-Wimax(BTS Load in KWH)`, `TTSL-CDMA (BTS Load in KWH)`, 
	`TTS-GSM (BTS Load in KWH)`, `Vodafone (BTS Load in KWH)`, `Total Load BTS in KW(BTS Load in KWH)`, 

	`Airtel(Aircon Load in KW)`, `BSNL(Aircon Load in KW)`, `IDEA(Aircon Load in KW)`, `HFCL (Aircon Load in KW)`, `RJIO(Aircon Load in KW)`, `Sify(Aircon Load in KW)`, 
	`TCL-IOT (Aircon Load in KW)`, `TCL-NLD (Aircon Load in KW)`, `TCL-Redwin(Aircon Load in KW)`, `TCL-Wimax(Aircon Load in KW)`, `TTSL-CDMA (Aircon Load in KW)`, 
	`TTS-GSM (Aircon Load in KW)`, `Vodafone (Aircon Load in KW)`, `Total Aircon Load in KW(Aircon Load)`, 

	`Airtel(BTS+AC Load)`, `BSNL(BTS+AC Load)`, `IDEA(BTS+AC Load)`, `HFCL (BTS+AC Load)`, `RJIO(BTS+AC Load)`, `Sify(BTS+AC Load)`, `TCL-IOT (BTS+AC Load)`, 
	`TCL-NLD (BTS+AC Load)`, `TCL-Redwin(BTS+AC Load)`, `TCL-Wimax(BTS+AC Load)`, `TTSL-CDMA (BTS+AC Load)`, `TTS-GSM (BTS+AC Load)`, `Vodafone (BTS+AC Load)`, `Total BTS_AC Load`, 

	`Diesel Billing from Date`, `Diesel Billing Upto Date`, `Diesel No of Days`, `Diesel Cost`, `EB Cost`, `Energy Cost`, 

	`Airtel_Days`, `BSNL_Days`, `IDEA_Days`, `HFCL _Days`, `RJIO_Days`, `Sify_Days`, `TCL-IOT _Days`, `TCL-NLD _Days`, `TCL-Redwin_Days`, `TCL-Wimax_Days`, `TTSL-CDMA _Days`, 
	`TTS-GSM _Days`, `Vodafone _Days`, 

	`Airtel(%)`, `BSNL(%)`, `idea(%)`, `HFCL (%)`, `RJIO(%)`, `Sify(%)`, `TCL-IOT (%)`, `TCL-NLD (%)`, `TCL-Redwin(%)`, `TCL-Wimax(%)`, `TTSL-CDMA (%)`, `TTS-GSM (%)`, 
	`Vodafone (%)`, `Total %`, 

	`Airtel(Diesel Cost)`, `BSNL(Diesel Cost)`, `IDEA(Diesel Cost)`, `HFCL (Diesel Cost)`, `RJIO(Diesel Cost)`, `Sify(Diesel Cost)`, `TCL-IOT (Diesel Cost)`, 
	`TCL-NLD (Diesel Cost)`, `TCL-Redwin(Diesel Cost)`, `TCL-Wimax(Diesel Cost)`, `TTSL-CDMA (Diesel Cost)`, `TTS-GSM (Diesel Cost)`, `Vodafone (Diesel Cost)`, `ZTS Diesel Cost`, 
	`Total Diesel Cost Share`, 

	`Airtel(EB Cost)`, `BSNL(EB Cost)`, `IDEA(EB Cost)`, `HFCL (EB Cost)`, `RJIO(EB Cost)`, `Sify(EB Cost)`, `TCL-IOT (EB Cost)`, `TCL-NLD (EB Cost)`, `TCL-Redwin(EB Cost)`, 
	`TCL-Wimax(EB Cost)`, `TTSL-CDMA (EB Cost)`, `TTS-GSM (EB Cost)`, `Vodafone (EB Cost)`, `ZTS EB Cost`, `Total EB Cost`, 

	`Airtel(Energy Cost)`, `BSNL(Energy Cost)`, `IDEA(Energy Cost)`, `HFCL (Energy Cost)`, `RJIO(Energy Cost)`, `Sify(Energy Cost)`, `TCL-IOT (Energy Cost)`, 
	`TCL-NLD (Energy Cost)`, `TCL-Redwin(Energy Cost)`, `TCL-Wimax(Energy Cost)`, `TTSL-CDMA (Energy Cost)`, `TTS-GSM (Energy Cost)`, `Vodafone (Energy Cost)`, `ZTS Energy Cost`, 
	`Total Energy Cost Share`, 

	`Airtel(Diesel Revenue)`, `BSNL(Diesel Revenue)`, `IDEA(Diesel Revenue)`, `HFCL (Diesel Revenue)`, `RJIO(Diesel Revenue)`, `Sify(Diesel Revenue)`, 
	`TCL-IOT (Diesel Revenue)`, `TCL-NLD (Diesel Revenue)`, `TCL-Redwin(Diesel Revenue)`, `TCL-Wimax(Diesel Revenue)`, `TTSL-CDMA (Diesel Revenue)`, `TTS-GSM (Diesel Revenue)`, 
	`Vodafone (Diesel Revenue)`, `ZTS Diesel Revenue`, `Total Diesel Revenue`, 

	`Airtel(EB Revenue)`, `BSNL(EB Revenue)`, `IDEA(EB Revenue)`, `HFCL (EB Revenue)`, `RJIO(EB Revenue)`, `Sify(EB Revenue)`, `TCL-IOT (EB Revenue)`, `TCL-NLD (EB Revenue)`, 
	`TCL-Redwin(EB Revenue)`, `TCL-Wimax(EB Revenue)`, `TTSL-CDMA (EB Revenue)`, `TTS-GSM (EB Revenue)`, `Vodafone (EB Revenue)`, `ZTS EB Revenue`, `Total EB Revenue Share`, 

	 `Airtel(Energy Revenue)`, `BSNL(Energy Revenue)`, `IDEA(Energy Revenue)`, `HFCL (Energy Revenue)`, `RJIO(Energy Revenue)`, `Sify(Energy Revenue)`, 
	 `TCL-IOT (Energy Revenue)`, `TCL-NLD (Energy Revenue)`, `TCL-Redwin(Energy Revenue)`, `TCL-Wimax(Energy Revenue)`, `TTSL-CDMA (Energy Revenue)`, 
	 `TTS-GSM (Energy Revenue)`, `Vodafone (Energy Revenue)`, `ZTS Energy Revenue`, `Total Energy Revenue Share`, 

	 `Airtel(Margin)`, `BSNL(Margin)`, `IDEA(Margin)`, `HFCL (Margin)`, `RJIO(Margin)`, `Sify(Margin)`, `TCL-IOT (Margin)`, `TCL-NLD (Margin)`, `TCL-Redwin(Margin)`, 
	 `TCL-Wimax(Margin)`, `TTSL-CDMA (Margin)`, `TTS-GSM (Margin)`, `Vodafone (Margin)`, `ZTS Margin`, `Total Margin Share`, 

	 `No of Tenancy`, `airtel_Tenancy`, `bsnl_Tenancy`, `idea_Tenancy`, `pbHfcl_Tenancy`, `rjio_Tenancy`, `sify_Tenancy`, `tclIot_Tenancy`, `tclNld_Tenancy`, 
	 `tclRedwin_Tenancy`, `tclWimax_Tenancy`, `ttslCdma_Tenancy`, `ttsl_Tenancy`, `vodafone_Tenancy`, 

	 `Operational Status`, `Site Category`, `Site Type`, `FEM`, `NON-FEM`, `EB Status`, `UploadMonth`) ";

	$columnsValue = " ('$site_id', '$site_name', '$opco_circle_name', '', '', 
	".returnDateAsNull($airtel_on_date).", ".returnDateAsNull($airtelOffDate).", ".returnAsNull($airtel_load).", 
	".returnDateAsNull($bsnl_on_date).", ".returnDateAsNull($bsnlOffDate).", ".returnAsNull($bsnl_load).", 
	".returnDateAsNull($idea_on_date).", ".returnDateAsNull($ideaOffDate).", ".returnAsNull($idea_load).", 
	".returnDateAsNull($pbHFCL_on_date).", ".returnDateAsNull($pbHFCLOffDate).", ".returnAsNull($pbHFCL_load).", 
	".returnDateAsNull($rjio_on_date).", ".returnDateAsNull($rjioOffDate).", ".returnAsNull($rjio_load).", 
	".returnDateAsNull($sify_on_date).", ".returnDateAsNull($sifyOffDate).", ".returnAsNull($sify_load).", 
	".returnDateAsNull($tclIot_on_date).", ".returnDateAsNull($tclIotOffDate).", ".returnAsNull($tcIOT_load).", 
	".returnDateAsNull($tclNld_on_date).", ".returnDateAsNull($tclNldOffDate).", ".returnAsNull($tclNLD_load).", 
	".returnDateAsNull($tclRedwin_on_date).", ".returnDateAsNull($tclRedwinOffDate).", ".returnAsNull($tclRedwin_load).", 
	".returnDateAsNull($tclWimax_on_date).", ".returnDateAsNull($tclWimaxOffDate).", ".returnAsNull($tclWimax_load).", 
	".returnDateAsNull($ttslCdma_on_date).", ".returnDateAsNull($ttslCdmaOffDate).", ".returnAsNull($ttslCDMA_load).", 
	".returnDateAsNull($ttsl_on_date).", ".returnDateAsNull($ttslOffDate).", ".returnAsNull($ttsl_load).", 
	".returnDateAsNull($vodafone_on_date).", ".returnDateAsNull($vodafoneOffDate).", ".returnAsNull($vodafone_load).",
	$siteVoltage,  
	".returnAsNull($airtelKwh).", ".returnAsNull($bsnlKwh).", ".returnAsNull($ideaKwh).", ".returnAsNull($pbHFClKwh).",
	".returnAsNull($rjioKwh).", ".returnAsNull($sifyKwh).", ".returnAsNull($tclIotKwh).", ".returnAsNull($tclNldKwh).", ".returnAsNull($tclRedwinKwh).", ".returnAsNull($tclWimaxKwh).", 
	".returnAsNull($ttslCdmaKwh).", ".returnAsNull($ttslKwh).", ".returnAsNull($vodafoneKwh).", ".returnAsNull($totalKwh).", 

	".returnAsNull($airtelAircon).", ".returnAsNull($bsnlAircon).", ".returnAsNull($ideaAircon).", ".returnAsNull($pbHfclAircon).", ".returnAsNull($rjioAircon).", 
	 ".returnAsNull($sifyAircon).", ".returnAsNull($tclIotAircon).", ".returnAsNull($tclNldAircon).", ".returnAsNull($tclRedwinAircon).", ".returnAsNull($tclWimaxAircon).", 
	 ".returnAsNull($ttslCdmaAircon).", ".returnAsNull($ttslAircon).", ".returnAsNull($vodafoneAircon).", ".returnAsNull($totalAircon).", 

	 ".returnAsNull($airtelBtsAcLoad).", ".returnAsNull($bsnlBtsAcLoad).", ".returnAsNull($ideaBtsAcLoad).", ".returnAsNull($pbHfclBtsAcLoad).", ".returnAsNull($rjioBtsAcLoad).", 
	 ".returnAsNull($sifyBtsAcLoad).", ".returnAsNull($tclIotBtsAcLoad).", ".returnAsNull($tclNldBtsAcLoad).", ".returnAsNull($tclRedwinBtsAcLoad).", 
	 ".returnAsNull($tclWimaxBtsAcLoad).", ".returnAsNull($ttslCdmaBtsAcLoad).", ".returnAsNull($ttslBtsAcLoad).", ".returnAsNull($vodafoneBtsAcLoad).", 
	 ".returnAsNull($totalAcBtsLoad).", 

	 ".returnDateAsNull($dieselBillingFromDate).", ".returnDateAsNull($dieselBillingUpToDate).", ".returnAsNull($dieselNoOfDays).", ".returnAsNull($dieselCost).", 
	 ".returnAsNull($ebCost).", ".returnAsNull($energyCost).", 

	 ".returnAsNull($airtelNoOfDays).", ".returnAsNull($bsnlNoOfDays).", ".returnAsNull($ideaNoOfDays).", ".returnAsNull($pbHfclNoOfDays).", 
	 ".returnAsNull($rjioNoOfDays).", ".returnAsNull($sifyNoOfDays).", ".returnAsNull($tclIotNoOfDays).", ".returnAsNull($tclNldNoOfDays).", 
	 ".returnAsNull($tclRedwinNoOfDays).", ".returnAsNull($tclWimaxNoOfDays).", ".returnAsNull($ttslCdmaNoOfDays).", ".returnAsNull($ttslNoOfDays).", 
	 ".returnAsNull($vodafoneNoOfDays).", 

	 ".returnAsNull($airtelPercentage).", ".returnAsNull($bsnlPercentage).", ".returnAsNull($ideaPercentage).", ".returnAsNull($pbHFCLPercentage).", ".returnAsNull($rjioPercentage).", 
	 ".returnAsNull($sifyPercentage).", ".returnAsNull($tclIotPercentage).", ".returnAsNull($tclNldPercentage).", ".returnAsNull($tclRedwinPercentage).", 
	 ".returnAsNull($tclWimaxPercentage).", 
	 ".returnAsNull($ttslCdmaPercentage).", ".returnAsNull($ttslPercentage).", ".returnAsNull($vodafonePercentage).", ".returnAsNull($totalPercentage).", 

	 ".returnAsNull($airtelDieselCost).", ".returnAsNull($bsnlDieselCost).", ".returnAsNull($ideaDieselCost).", ".returnAsNull($pbHfclDieselCost).", ".returnAsNull($rjioDieselCost).", 
	 ".returnAsNull($sifyDieselCost).", ".returnAsNull($tclIotDieselCost).", ".returnAsNull($tclNldDieselCost).", ".returnAsNull($tclRedwinDieselCost).", 
	 ".returnAsNull($tclWimaxDieselCost).", 
	 ".returnAsNull($ttslCdmaDieselCost).", ".returnAsNull($ttslDieselCost).", ".returnAsNull($vodafoneDieselCost).", ".returnAsNull($ztsDieselCost).", 
	 ".returnAsNull($totalDieselCost).", 

	 ".returnAsNull($airtelEbCost).", ".returnAsNull($bsnlEbCost).", ".returnAsNull($ideaEbCost).", ".returnAsNull($pbHfclEbCost).", ".returnAsNull($rjioEbCost).", 
	 ".returnAsNull($sifyEbCost).", ".returnAsNull($tclIotEbCost).", ".returnAsNull($tclNldEbCost).", ".returnAsNull($tclRedwinEbCost).", ".returnAsNull($tclWimaxEbCost).", 
	 ".returnAsNull($ttslCdmaEbCost).", ".returnAsNull($ttslEbCost).", ".returnAsNull($vodafoneEbCost).", ".returnAsNull($ztsEbCost).", ".returnAsNull($totalEbCost).", 

	 ".returnAsNull($airtelEnergyCost).", ".returnAsNull($bsnlEnergyCost).", ".returnAsNull($ideaEnergyCost).", ".returnAsNull($pbHfclEnergyCost).", ".returnAsNull($rjioEnergyCost).", 
	 ".returnAsNull($sifyEnergyCost).", ".returnAsNull($tclIotEnergyCost).", ".returnAsNull($tclNldEnergyCost).", ".returnAsNull($tclRedwinEnergyCost).", 
	 ".returnAsNull($tclWimaxEnergyCost).", 
	 ".returnAsNull($ttslCdmaEnergyCost).", ".returnAsNull($ttslEnergyCost).", ".returnAsNull($vodafoneEnergyCost).", ".returnAsNull($ztsEnergyCost).", 
	 ".returnAsNull($totalEnergyCost).", 

	 ".returnAsNull($airtelDieselRevenue).", ".returnAsNull($bsnlDieselRevenue).", ".returnAsNull($ideaDieselRevenue).", ".returnAsNull($pbHfclDieselRevenue).", 
	 ".returnAsNull($rjioDieselRevenue).", 
	 ".returnAsNull($sifyDieselRevenue).", ".returnAsNull($tclIotDieselRevenue).", ".returnAsNull($tclNldDieselRevenue).", ".returnAsNull($tclRedwinDieselRevenue).", 
	 ".returnAsNull($tclWimaxDieselRevenue).", 
	 ".returnAsNull($ttslCdmaDieselRevenue).", ".returnAsNull($ttslDieselRevenue).", ".returnAsNull($vodafoneDieselRevenue).", ".returnAsNull($ztsDieselRevenue).", 
	 ".returnAsNull($totalDieselRevenue).", 

	 ".returnAsNull($airtelEbRevenue).", ".returnAsNull($bsnlEbRevenue).", ".returnAsNull($ideaEbRevenue).", ".returnAsNull($pbHfclEbRevenue).", 
	 ".returnAsNull($rjioEbRevenue).", 
	 ".returnAsNull($sifyEbRevenue).", ".returnAsNull($tclIotEbRevenue).", ".returnAsNull($tclNldEbRevenue).", ".returnAsNull($tclRedwinEbRevenue).", 
	 ".returnAsNull($tclWimaxEbRevenue).", 
	 ".returnAsNull($ttslCdmaEbRevenue).", ".returnAsNull($ttslEbRevenue).", ".returnAsNull($vodafoneEbRevenue).", ".returnAsNull($ztsEbRevenue).", 
	 ".returnAsNull($totalEbRevenue).", 

	 ".returnAsNull($airtelEnergyRevenue).", ".returnAsNull($bsnlEnergyRevenue).", ".returnAsNull($ideaEnergyRevenue).", ".returnAsNull($pbHfclEnergyRevenue).", 
	 ".returnAsNull($rjioEnergyRevenue).", 
	 ".returnAsNull($sifyEnergyRevenue).", ".returnAsNull($tclIotEnergyRevenue).", ".returnAsNull($tclNldEnergyRevenue).", ".returnAsNull($tclRedwinEnergyRevenue).", 
	 ".returnAsNull($tclWimaxEnergyRevenue).", 
	 ".returnAsNull($ttslCdmaEnergyRevenue).", ".returnAsNull($ttslEnergyRevenue).", ".returnAsNull($vodafoneEnergyRevenue).", ".returnAsNull($ztsEnergyRevenue).", 
	 ".returnAsNull($totalEnergyRevenue).", 

	 ".returnAsNull($airtelMargin).", ".returnAsNull($bsnlMargin).", ".returnAsNull($ideaMargin).", ".returnAsNull($pbHfclMargin).", 
	 ".returnAsNull($rjioMargin).", 
	 ".returnAsNull($sifyMargin).", ".returnAsNull($tclIotMargin).", ".returnAsNull($tclNldMargin).", ".returnAsNull($tclRedwinMargin).", 
	 ".returnAsNull($tclWimaxMargin).", 
	 ".returnAsNull($ttslCdmaMargin).", ".returnAsNull($ttslMargin).", ".returnAsNull($vodafoneMargin).", ".returnAsNull($ztsMargin).", 
	 ".returnAsNull($totalMargin).", 

	 ".returnAsNull($noOfTenancy).", ".returnAsNull($airtelTenancy).", ".returnAsNull($bsnlTenancy).", ".returnAsNull($ideaTenancy).", ".returnAsNull($pbHfclTenancy).", 
	 ".returnAsNull($rjioTenancy).", ".returnAsNull($sifyTenancy).", ".returnAsNull($tclIotTenancy).", ".returnAsNull($tclNldTenancy).", ".returnAsNull($tclRedwinTenancy).", 
	 ".returnAsNull($tclWimaxTenancy).", 
	 ".returnAsNull($ttslCdmaTenancy).", ".returnAsNull($ttslTenancy).", ".returnAsNull($vodafoneTenancy).", 

	 '$operationStatus', '$siteCategory', '$siteType', '$fem', '$nonFem', '$ebStatus', '$period') ";

	$insertSql = $table.$columns.' values '.$columnsValue;

	// echo $insertSql.'<br>';

	mysqli_query($conn,$insertSql);

}

?>

<?php
function returnDateAsNull($dateValue){
	$dateValue = date("Y-m-d", strtotime($dateValue));
	
	if(trim($dateValue) == '1970-01-01'){
		return 'null';
	}
	return "'".$dateValue."'";

}

function returnAsNull($dataValue){
	
	if(trim($dataValue) == ''){
		return 'null';
	}
	return $dataValue;

}

function prepareNoOfTenancy($firstDate, $onDate, $offDate, $energyRevenue) {
	if($onDate != '' && $offDate == '' && $energyRevenue == ''){
		return 1;
	}
	else if($onDate != '' && $offDate != '' && $energyRevenue == ''){

	}
	else if($onDate != '' && $offDate != '' && $energyRevenue != ''){

	}
	else if($onDate != '' && $offDate == '' && $energyRevenue != ''){
		return 1;
	}
}

function convertInKWH($amp, $voltage){
	if($amp != ''){
		return ($amp * $voltage) / 1000;
	}
}

function prepareOperatorEnergyRevenue($dieselRevenue, $ebRevenue){
	return ($dieselRevenue + $ebRevenue);
}

function prepareOperatorOnDate($bts1_on_date,$bts2_on_date,$bts3_on_date,$bts4_on_date,$bts5_on_date,$bts6_on_date,
						$bts1_off_date,$bts2_off_date,$bts3_off_date,$bts4_off_date,$bts5_off_date,$bts6_off_date,$link_on_date, $link_off_date){
	

	$onCount = 0;
	if($bts1_on_date != '') $onCount++;
	if($bts2_on_date != '') $onCount++;
	if($bts3_on_date != '') $onCount++;
	if($bts4_on_date != '') $onCount++;
	if($bts5_on_date != '') $onCount++;
	if($bts6_on_date != '') $onCount++;
	
	$offCount = 0;
	if($bts1_off_date != '') $offCount++;
	if($bts2_off_date != '') $offCount++;
	if($bts3_off_date != '') $offCount++;
	if($bts4_off_date != '') $offCount++;
	if($bts5_off_date != '') $offCount++;
	if($bts6_off_date != '') $offCount++;

	if($onCount == $offCount && $link_on_date != '' && $link_off_date == ''){
		return $link_on_date;
	}

	else if($onCount != 0){
		$btsOnDateList = array();
		if($bts1_on_date != '')
			array_push($btsOnDateList,$bts1_on_date);
		if($bts2_on_date != '')
			array_push($btsOnDateList,$bts2_on_date);
		if($bts3_on_date != '')
			array_push($btsOnDateList,$bts3_on_date);
		if($bts4_on_date != '')
			array_push($btsOnDateList,$bts4_on_date);
		if($bts5_on_date != '')
			array_push($btsOnDateList,$bts5_on_date);
		if($bts6_on_date != '')
			array_push($btsOnDateList,$bts6_on_date);
		if($link_on_date != '')
			array_push($btsOnDateList,$link_on_date);

		//return min($btsOnDateList);

		$index = 0;

		usort($btsOnDateList, function($a, $b) {
		    $dateTimestamp1 = strtotime($a);
		    $dateTimestamp2 = strtotime($b);

		    $index = $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
		});
			
		return $btsOnDateList[$index];
	}

}

function prepareOperatorOffDate($bts1_on_date, $bts2_on_date, $bts3_on_date, 
			$bts4_on_date, $bts5_on_date, $bts6_on_date, 
			$bts1_off_date, $bts2_off_date, $bts3_off_date, 
			$bts4_off_date, $bts5_off_date, $bts6_off_date,
			$link_on_date, $link_off_date){

	$onCount = 0;
	if($bts1_on_date != '') $onCount++;
	if($bts2_on_date != '') $onCount++;
	if($bts3_on_date != '') $onCount++;
	if($bts4_on_date != '') $onCount++;
	if($bts5_on_date != '') $onCount++;
	if($bts6_on_date != '') $onCount++;
	if($link_on_date != '') $onCount++;
	
	$offCount = 0;
	if($bts1_off_date != '') $offCount++;
	if($bts2_off_date != '') $offCount++;
	if($bts3_off_date != '') $offCount++;
	if($bts4_off_date != '') $offCount++;
	if($bts5_off_date != '') $offCount++;
	if($bts6_off_date != '') $offCount++;
	if($link_off_date != '') $offCount++;

	if($onCount !=0 && $offCount !=0 && $onCount == $offCount){
		$btsOffDateList = array();
		if($bts1_off_date != '')
			array_push($btsOffDateList,$bts1_off_date);
		if($bts2_off_date != '')
			array_push($btsOffDateList,$bts2_off_date);
		if($bts3_off_date != '')
			array_push($btsOffDateList,$bts3_off_date);
		if($bts4_off_date != '')
			array_push($btsOffDateList,$bts4_off_date);
		if($bts5_off_date != '')
			array_push($btsOffDateList,$bts5_off_date);
		if($bts6_off_date != '')
			array_push($btsOffDateList,$bts6_off_date);
		if($link_off_date != '')
			array_push($btsOffDateList,$link_off_date);

		$index = 0;

		usort($btsOffDateList, function($a, $b) {
		    $dateTimestamp1 = strtotime($a);
		    $dateTimestamp2 = strtotime($b);

		    $index = $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
		});
			
		return $btsOffDateList[count($btsOffDateList) - 1];
	}

	// return max($btsOffDateList);

}

function prepareOperatorNoOfDays($firstDate, $lastDate, $noOfDays, $onDate, $offDate){
	if($onDate == '' && $offDate == ''){
		return 0;
	}
	else if($onDate != '' && $offDate == ''){
		if(strtotime($onDate) < strtotime($firstDate)){
			return $noOfDays;
		}
		else{
			$operatorDateDiff = (strtotime($lastDate) - strtotime($onDate));
			$operatorNoOfDays = round($operatorDateDiff / (60 * 60 * 24)) +1;
			return $operatorNoOfDays;
		}
	}

	else if($onDate != '' && $offDate != ''){
		if(strtotime($offDate) < strtotime($firstDate)){
			return 0;
		}
		else{
			$operatorDateDiff = (strtotime($offDate) - strtotime($firstDate));
			$operatorNoOfDays = round($operatorDateDiff / (60 * 60 * 24)) +1;
			return $operatorNoOfDays;
		}
	}

	
	// $operatorDateDiff = (strtotime($offDate) - strtotime($onDate));
	// $operatorNoOfDays = round($operatorDateDiff / (60 * 60 * 24)) +1;
	// if($operatorNoOfDays >= $noOfDays){
	// 	return $noOfDays;
	// }
	// else{
	// 	return $operatorNoOfDays;
	// }
}

// function haveIdOnBts($bts1_on_date, $bts2_on_date, $bts3_on_date, $bts4_on_date, $bts5_on_date, $bts6_on_date, 
// 			$bts1_type, $bts2_type, $bts3_type, $bts4_type, $bts5_type, $bts6_type){
// 	if($bts1_on_date != '' && $bts1_type == 'ID')
// 		return true;
// 	else if($bts2_on_date != '' && $bts2_type == 'ID')
// 		return true;
// 	else if($bts3_on_date != '' && $bts3_type == 'ID')
// 		return true;
// 	else if($bts4_on_date != '' && $bts4_type == 'ID')
// 		return true;
// 	else if($bts5_on_date != '' && $bts4_type == 'ID')
// 		return true;
// 	else if($bts6_on_date != '' && $bts6_type == 'ID')
// 		return true;
// 	else return false;

// } 

function prepareOperatorMargin($energyRevenue, $energyCost) {
	if($energyRevenue != '' && $energyCost != '')
		return $energyRevenue - $energyCost;
	else if($energyRevenue == '' && $energyCost != '')
		return  -$energyCost;
	else if($energyRevenue != '' && $energyCost == '')
		return $energyRevenue;
}
?>