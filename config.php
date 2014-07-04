<?php	
	$dir       = "/home/tecnomancher/projeto/blogelmundo";	
	function __autoload($class_name) {
			require_once ($dir.'classe/'.$class_name.'.class.php');	
	}
?>
