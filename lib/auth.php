<?php 
if (!isset($auth)){
	if (!isset($_SESSION['Auth'])){
		header('Location:' . WEBROOT . 'login.php');die();
		
	}
}
