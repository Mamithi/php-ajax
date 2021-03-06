<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">
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
	 					<div id="editContent">
		 					<input type="text" class="form-control" placeholder="Country Name..." id="countryName"><br>
		 					<textarea class="form-control" id="shortDesc" placeholder="Country short description..."></textarea><br>
		 					<textarea class="form-control" id="longDesc" placeholder="Country long description..."></textarea><br>
		 					<input type="hidden" id="editRowId" value="0"> 
		 				</div>
		 				<div id="showContent" style="display:none;">
		 					<h3>Short Description</h3>
		 					<div id="shortDescView"></div>
		 					<hr>
		 					<h3>Long Description</h3>
		 					<div id="longtDescView" style="overflow-y: scroll; height: 300px"></div>
		 				</div>
	 				</div>

	 				<div class="modal-footer">
	 					<input type="button" class="btn btn-primary" data-dismiss='modal' value="close" id="closeBtn" style="display: none;">

	 					<input type="button" id="manageBtn" class="btn btn-success" value="Save" onclick="manageData('addNew')">
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
 					<tbody>
 						
 					</tbody>
 				</table>
 			</div>
 		</div>
 	</div>


 	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
 	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
 	<script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('#addNew').on('click', function(){
 				$('#tableManager').modal('show');
 			});
 			getExistingData(0, 50);

 			$("#tableManager").on('hidden-.bs.modal', function(){
 				$('#showContent').fadeOut();
 				$('#editContent').fadeIn();
 				$('#editRowId').val(0);
 				$('#longDesc').val('');
 				$('#shortDesc').val('');
 				$('#countryName').val('');
 				$('#closeBtn').fadeOut();
 				$('#manageBtn').attr('value', 'Add').attr('onclick', "manageData('addNew')").fadeIn();
 			});
 		});

 		function deleteRow(rowID){
 			if(confirm('Are you sure??')){
 				$.ajax({
 				url : 'ajax.php',
 				method : 'POST',
 				dataType : 'text',
 				data : {
 					key : 'deleteRow',
 					rowID : rowID,
 				}, success : function(response){
 					$('#country_'+rowID).parent().remove();
 					alert(response);
 					}
 			});
  			}
 		}

 		function viewORedit(rowId, type){
 			$.ajax({
 				url : 'ajax.php',
 				method : 'POST',
 				dataType : 'json',
 				data : {
 					key : 'getRowData',
 					rowId : rowId,
 				}, success : function(response){
 					if(type == 'view'){
 						$('#showContent').fadeIn();
 						$('#editContent').fadeOut();
 						$('#shortDescView').html(response.shortDesc);
 						$('#longtDescView').html(response.longDesc);
 						$('#closeBtn').fadeIn();
 						$('#manageBtn').fadeOut();
 					
 					}else{
 						$('#showContent').fadeOut();
 						$('#editContent').fadeIn();
 						$('#editRowId').val(rowId);
 						$('#countryName').val(response.countryName);
 						$('#shortDesc').val(response.shortDesc);
 						$('#longDesc').val(response.longDesc);
 						$('#closeBtn').fadeOut();
 						$('#manageBtn').attr('value', 'Save Changes').attr('onclick', "manageData('updateRow')").fadeIn();
 					}

 					$('.modal-title').html(response.countryName);
 					$('#tableManager').modal('show');
 					
 				}
 			});
 		}

 		function getExistingData(start,limit){
 			$.ajax({
 				url : 'ajax.php',
 				method : 'POST',
 				dataType : 'text',
 				data : {
 					key :  'getExistingData',
 					start : start,
 					limit : limit
 				}, success : function(response){
 					if(response != "reachedMax"){
 						$('tbody').append(response);
 						start += limit;
 						getExistingData(start, limit);
 					} else{
 						$(".table").dataTable();
 					}
 				}
 			});
 		}

 		function manageData(key, edit){
 				var name = $("#countryName");
 				var shortDesc = $('#shortDesc');
 				var longDesc = $('#longDesc');
 				var editRowId = $('#editRowId');

 				if(isNotEmpty(name) && isNotEmpty(shortDesc) && isNotEmpty(longDesc)){
 					$.ajax({
 						url : 'ajax.php',
 						method : 'POST',
 						dataType : 'text',
 						data : {
 							key : key,
 							name : name.val(),
 							shortDesc : shortDesc.val(),
 							longDesc : longDesc.val(),
 							rowID : editRowId.val(),
 						}, success : function(response){
 							if(response != 'success'){
 								alert(response);
 							}else{	
 								$("#country_"+editRowId.val()).html(name.val());
 								name.val('');
 								shortDesc.val('');
 								longDesc.val('');
 								$('#manageBtn').attr('value', 'Save').attr('onclick', "manageData('addNew')").fadeIn();
 							
 								$("#tableManager").modal('hide');
 								
 							}
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