<?php  require_once  $_SERVER['DOCUMENT_ROOT'] . '/VMAS/includes/path.php';

//$host = gethostname();
//$t9 = 'jcservices-vmas-4694685';
//echo "It has made it here!<br/>";
//echo substr($_SERVER["DOCUMENT_ROOT"],1,strlen($_SERVER["DOCUMENT_ROOT"])).(($host != $t9 || $host != $c9) ? "/" : "") . '<br/>';
//echo gethostname();
//var_dump($_SERVER);
//echo "<br/>". $_SERVER['DOCUMENT_ROOT'] . '/vmas/includes/';
//var_dump(CSS_PATH, $_SERVER['DOCUMENT_ROOT']);
//return;
?>
<?php include_layout_template('vmas_header.php')?>
<div class="row">
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
	<div class="large-6 medium-6 columns">
	<h4 class="text-center">Generate Tables and Content</h4>
				<div style="line-color: #008000;"><hr/></div>
			<?php //drop, menu, submenu, subsubmenu, master are all that is available at this time. Check database.php->secure_access?>
			<?php $value = array('drop', 'org', 'menu', 'submenu', 'subsubmenu', 'master', 'vehicle'); ?>
			<?php //$value = array(); ?>
			<?php $db->secure_access($value)?>
	</div>
	<div class="large-3 medium-3 columns">
		&nbsp;
	</div>
</div>
<?php include_layout_template('vmas_footer.php'); ?>
		
