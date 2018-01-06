<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
</head>
<body>
 	<div class="container" style="margin-top: 30px;">

 		<div id="tableManager" class="modal fade">
 			<div class="modal-dialog">
 				<div class="modal-content">
	 				<div class="modal-header">
	 					<h2 class="modal-title">Country Name</h2>
	 				</div>

	 				<div class="modal-body">
	 					<input type="text" class="form-control" placeholder="Country Name..." id="countryName"><br>
	 					<textarea class="form-control" id="shortDesc" placeholder="Country short description..."></textarea><br>
	 					<textarea class="form-control" id="longDesc" placeholder="Country long description..."></textarea><br>
	 				</div>

	 				<div class="modal-footer">
	 					<input type="button" class="btn btn-success" value="Save" onclick="manageData('addNew')">
	 				</div>
 			     </div>

 			</div>
 		</div>

 		<div class="row">
 			<h2>Mysql Table Manager</h2>
 			<div class="col-md-8 col-offset-2">
 				<input type="button" class="btn btn-success" value="Add New" style="float: right;" id="addNew">
 				<br><br>
 				<table class="table table-hover table-bordered">
 					<thead>
 						<tr>
 							<td>Id</td>
 							<td>Country Name</td>
 							<td>Options</td>
 						</tr>
 					</thead>
 				</table>
 			</div>
 		</div>
 	</div>


 	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('#addNew').on('click', function(){
 				$('#tableManager').modal('show');
 			});
 		});

 		function manageData(key){
 				var name = $("#countryName");
 				var shortDesc = $('#shortDesc');
 				var longDesc = $('#longDesc');

 				if(isNotEmpty(name) && isNotEmpty(shortDesc) && isNotEmpty(longDesc)){
 					$.ajax({
 						url : 'create.php',
 						method : 'POST',
 						dataType : 'text',
 						data : {
 							key : key,
 							name : name.val(),
 							shortDesc : shortDesc.val(),
 							longDesc : longDesc.val(),
 						}, success : function(response){
 							alert(response);
 						}
 					});
 				}
 
 			}

 			function isNotEmpty(caller){
 				if(caller.val() == ''){
 					caller.css('border', '1px solid red');
 					return false;
 				} else {
 					caller.css('border', '');
 					return true;
 				}
 			}
 	</script>
</body>
</html>