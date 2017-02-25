<?php
$host = gethostname();
$c9 = "heinzerware-fair-4303040";

if ($host == $c9) {
	require_once'/home/ubuntu/workspace/includes/initialize.php';
} else {
	require_once '/wamp/www/vmas/includes/initialize.php';
}



?>
