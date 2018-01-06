<?php
 	if(isset($_POST['key'])){
 		
 		$conn = new mysqli('localhost', 'root', '', 'php-ajax');
 		$name = $conn->real_escape_string($_POST['name']);
 		$shortDesc = $conn->real_escape_string($_POST['shortDesc']);
 		$longDesc = $conn->real_escape_string($_POST['longDesc']);

 		if ($_POST['key'] == 'addNew') {
 			$sql = $conn->query("SELECT id FROM country WHERE country_name = '$name'");
 			if($sql->num_rows > 0){
 				exit("Country with this name already exists");
 			}else{
 				$conn->query("INSERT INTO country (country_name, short_description, long_description) VALUES('$name', 'shortDesc', 'longDesc')");
 				exit("Country has been inseretd successfully");
 			}
 		}
 	}
?>