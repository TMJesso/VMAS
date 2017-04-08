<?php
//require_once  '../../includes/path.php';

return;
if (!$session->is_logged_in()) { redirect_to("login.php"); }

?>
		<?php include_layout_template('vmas_header.php')?>

<!-- MENU -->
<div class="row">
	<div class="large-12 medium-12 small-12 columns">
		<?php echo $breadcrumbs; ?>
		<?php echo navigation(); ?>
	</div>
</div>
<!-- HEADER -->
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<?php echo output_errors($session->errors); ?>
		<?php echo output_message($session->message); ?>
		<h3 class="text-center"><?php echo ((isset($header)) ? $header : ""); ?></h3>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<!-- CONTENT -->
<div class="row">
	<div class="large-6 medium-6 small-8 columns">
		<strong>Business Owners:</strong><br/>
		<ul>
			<li>Mileage used for figuring the auto deduction must include the starting point, destination,
			 total mileage, and business purpose for the miles driven. The odometer reading at the beginning 
			 and end of the year must also be recorded.</li>
			 <li>Meals and entertainment expenses require documentation of who attended and what business was 
			 discussed. This includes dining out, sporting event and theater tickets, and entertaining clients 
			 in your home.</li>
			 <li>Section 179 depreciation deductions for SUVs are limited to $25,000 per year. Note that many 
			 states treat the deduction for SUVs different than under federal rules.</li>
			 <li>If you deduct expenses for business use of your home, the space must be used exclusely for business 
			 use. An exception applies for day care businesses.</li>
			 <li>Self employed taxpayers must keep documentation of income and expenses. This can be done by 
			 depositing all income from the business into a business checking account, paying for all business 
			 expenses with those funds, and keeping all receipts.</li>
		</ul>


		<div class="text-center">
		</div>
	</div>
	<div class="large-6 medium-6 small-8 columns">
		<strong>Individuals:</strong><br/>
		<ul>
			<li>Charitable donation deductions are generally limited to fair market value. Fair market value is ofen 
			determined by cost of the item at a thrift shop. Designer or custom items do not usually receive a higher 
			value than other basic items.</li>
			<li>Mortgage interest on certain motor homes and boats may be deductible as first or second homes if the 
			unit contains cooking, sleeping, and bathroom facilities. Check with your tax professional for qualifications.</li>
			<li>Tax benefits for higher education include tax credits and a deduction for interest paid on student loans.</li>
			<li>Inquiries about the status of a tax refund can be obtained either online or by phone. The taxpayer's Social 
			Security number, filing status, and refund amount will be requested. Phone: 1-800-829-1954. Online: <a href="www.irs.gov">IRS</a>, 
			then follow the link to "Where's My Refund?"</li>
		</ul>
	</div>
</div>
<?php include_layout_template('vmas_footer.php'); ?>

<?php 

	
?>
