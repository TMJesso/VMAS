<?php
$host = gethostname();
$t9 = "jcservices-vmas-448050";
$c9 = "heinzerware-fair-4303040";

if ($host == $c9 || $host == $t9) {
	require_once'/home/ubuntu/workspace/includes/initialize.php';
} else {
	require_once '/wamp/www/vmas/includes/initialize.php';
}



?>
