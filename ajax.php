<?php


 	if(isset($_POST['key'])){
 		
 		$conn = new mysqli('localhost', 'root', '', 'php-ajax');


 		# Updaeting data into the database (U part of CRUD)
 		if($_POST['key'] == 'getRowData'){
 			$rowId = $conn->real_escape_string($_POST['rowId']);
 			$sql = $conn->query("SELECT country_name, short_description, long_description FROM country WHERE id='$rowId'");
 			$data = $sql->fetch_array();
 			$jsonArray = [
 				'countryName' => $data['country_name'],
 				'shortDesc' => $data['short_description'],
 				'longDesc' => $data['long_description'],
 			];

 			exit(json_encode($jsonArray));

 		}


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
 							<td id="country_' .$data["id"].'">' .$data["country_name"] . '</td>
 							<td>
 								<input type="button" value="Edit" onclick="viewORedit('.$data["id"].', \'edit\')" class="btn btn-primary">
 								<input type="button" value="View"  onclick="viewORedit('.$data["id"].', \'view\')">
 								<input type="button" value="Delete" class="btn btn-danger" onclick="deleteRow('.$data["id"].')">
 							</td>
 						</tr>
 					';
 				}
 				exit($response);
 			} else{
 				exit('reachedMax');
 			}
}

		$rowID = $conn->real_escape_string($_POST['rowID']);

		# Deleting a row from the database (D part of CRUD)
		if($_POST['key'] == 'deleteRow'){
			$conn->query("DELETE FROM country WHERE id='$rowID'");
			exit("Country has been deleted");
		}



 		$name = $conn->real_escape_string($_POST['name']);
 		$shortDesc = $conn->real_escape_string($_POST['shortDesc']);
 		$longDesc = $conn->real_escape_string($_POST['longDesc']);
 		


 		# Updating data to the database
 		if($_POST['key'] == 'updateRow'){
 			$conn->query("UPDATE country SET country_name = '$name', short_description = '$shortDesc', long_description = '$longDesc' WHERE id='$rowID'");
 			exit('success');
 		}



 		# Create data to database (C Part Of CRUD)
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