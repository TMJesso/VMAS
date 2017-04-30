<?php
$host = gethostname();
$t9 = "jcservices-vmas-4694685";

if ($host == $t9) {
	require_once'/home/ubuntu/workspace/includes/initialize.php';
} else {
	require_once '/wamp64/www/VMAS/includes/initialize.php';
}



?>
