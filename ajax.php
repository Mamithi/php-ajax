<?php


 	if(isset($_POST['key'])){
 		
 		$conn = new mysqli('localhost', 'root', '', 'php-ajax');
 		# Select data from database (R part of CRUD)
 		if($_POST['key'] == 'getExistingData'){
 			$start = $conn->real_escape_string($_POST['start']);
 			$limit = $conn->real_escape_string($_POST['limit']);

 			$sql = $conn->query("SELECT id, country_name FROM country LIMIT $start, $limit");
 			if($sql->num_rows > 0){
 				$response = "";
 				while($data = $sql->fetch_array()){
 					$response .= '
 						<tr>
 							<td>' .$data["id"].'</td>
 							<td>' .$data["country_name"] . '</td>
 							<td>
 								<input type="button" value="Edit" class="btn btn-primary">
 								<input type="button" value="View">
 								<input type="button" value="Delete" class="btn btn-danger">
 							</td>
 						</tr>
 					';
 				}
 				exit($response);
 			} else{
 				exit('reachedMax');
 			}
}

# Create data to database (C Part Of CRUD)
 		$name = $conn->real_escape_string($_POST['name']);
 		$shortDesc = $conn->real_escape_string($_POST['shortDesc']);
 		$longDesc = $conn->real_escape_string($_POST['longDesc']);

 		if ($_POST['key'] == 'addNew') {
 			$sql = $conn->query("SELECT id FROM country WHERE country_name = '$name'");
 			if($sql->num_rows > 0){
 				exit("Country with this name already exists");
 			}else{
 				$conn->query("INSERT INTO country (country_name, short_description, long_description) VALUES('$name', '$shortDesc', '$longDesc')");
 				exit("Country has been inseretd successfully");
 			}
 		}
 	}

 
?>