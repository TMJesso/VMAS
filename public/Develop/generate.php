<?php
require_once  '../../includes/path.php';
?>
<?php include_layout_template('vmas_header.php')?>
<div class="row">
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 small-8 columns">
	<h4 class="text-center">Generate Tables and Content</h4>
				<div style="line-color: #008000;"><hr/></div>
			<?php //drop, menu, submenu, subsubmenu, master are all that is available at this time. Check database.php->secure_access?>
			<?php $value = array('drop', 'menu', 'submenu', 'subsubmenu', 'master', 'vehicle'); ?>
			<?php //$value = array(); ?>
			<?php $db->secure_access($value)?>
	</div>
	<div class="large-3 medium-3 small-2 columns">
		&nbsp;
	</div>
</div>
<?php include_layout_template('vmas_footer.php'); ?>
		
