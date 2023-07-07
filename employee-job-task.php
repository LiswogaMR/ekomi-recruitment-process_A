<?php
	// session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="vendor/css/datatables.min.css"/>
	<script type="text/javascript" src="vendor/js/datatables.min.js"></script>
	<link rel="stylesheet" href="vendor/css/jquery-confirm.min.css">
	<script src="vendor/js/jquery-confirm.min.js"></script>
	<link rel="stylesheet" href="vendor/css/jquery-ui.css">
	<link rel="stylesheet" href="vendor/css/dataTables.jqueryui.min.css">
	<script type="text/javascript" src="vendor/js/dataTables.jqueryui.min.js"></script>

	<link rel="shortcut icon" href="images/ekomi_gold.png" type="image/x-icon">
	<link rel="icon" href="images/ekomi_gold.png" type="image/x-icon">

</head>
<body class="container">
	<!-- header starts here -->
    <?php 

		include('admin-header.php'); 
		$response = '';
		if (isset($_GET['success'])) {
			if($_GET['success'] == 1) {
				$response = "<span style='color: green;'>successfull!</span>";
			}elseif ($_GET['success'] == 0) {
				$response = "<span style='color: Red;'>Error.Task Title/Name Allready Exists!!</span>";
			}
			elseif ($_GET['success'] == 2) {
				$response = "<span style='color: Red;'>Error!! please try again if problem persist contact admin</span>";
			}
		}

	?>
	<!-- header ends here -->
	<!-- page content starts here -->
	<section id="page-container">
		<div id="content-wrap">
			<div class="row">
				<?php echo "<div id='toast_message'> ".$response." </div>"; ?>
			</div>
			<br/>
			<div class="employee">
				<div class="row">
					<div class="pa-tbl-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<table id="task" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Title</th>
									<th>Description</th>
									<th>Created</th>
									<th>Date Updated</th>
									<th>Assigned By</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Title</th>
									<th>Description</th>
									<th>Created</th>
									<th>Date Updated</th>
									<th>Assigned By</th>
									<th>Status</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

			<!-- Update and complete a task Modal -->
			<div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Complete Task</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="functions/functions.php" method="POST" id="formUser">
								<div class="form-group">
									<label for="title" class="col-form-label">Title:</label>
									<input type="text" class="form-control" id="title" name="title" readonly>
								</div>
								<div class="form-group">
									<label for="description" class="col-form-label">Description:</label>
									<textarea class="form-control" id="description" name="description" data-src="description" readonly></textarea>
								</div>
								<div class="form-group">
									<label for="status" class="col-form-label">Status:</label>
									<select class="form-control" id="status" name="status" data-src="status" >
										<option value="Complete">Complete</option>
										<option value="InProgress">In Progress</option>
										<option value="OnHold">On Hold</option>
										<option value="Active">Active</option>
									</select>
								</div>

								<input type="hidden" name="actionType" value="updateTask">
								<input type="hidden"  id="id" name="id">
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" >Complete</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- footer starts here -->
	<?php include('footer.php') ?>
	<!-- footer ends here -->	
	<!-- page content ends here -->
	<script type="text/javascript">
		$(document).ready(function() {
			// var full.order_notes = 'true';
			var taskTable = $('#task').DataTable( {
				"serverSide": true,
				"pagingType": "full_numbers",
				"lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
				"order": [[ 1, "desc" ]],
				"ajax": {
					"url": 'functions/tables/employee-task.php',
					"type": "POST",
				},
				"initComplete": function (settings, json) {
					$('tr.tableLoader').fadeOut('slow');
					$('tr.triggerActions').fadeIn('slow');
				},
					"dom": 'lfrBtip',
					"buttons": ['excel'],
			
				"columns":[
					{ "data": "id", "name": "id", "searchable": true},
					{ "data": "title", "name": "title", "searchable": true},
					{ "data": "description", "name": "description", "searchable": false},
					{ "data": "date_created", "name": "date_created", "searchable": false},
					{ "data": "date_updated", "name": "date_updated", "searchable": false},
					{ "data": "assigned_by", "name": "assigned_by", "searchable": false},
					{ "data": "status", "name": "status", "searchable": false},
					{ "data": "actions", "name": "actions", "searchable": false},

					// {render: function( data, type, full ){if(full.order_notes != null){return full.order_notes+' <button style="cursor:pointer;" class="btn btn-satgreen editComments"><small>Edit</small></button>'}else{return '<button style="cursor:pointer;" class="btn btn-satgreen editComments"><small>Edit</small></button>'}}, "name": "order_notes", "searchable": false, "orderable": false}
				],
				"createdRow": function( row, data){
					$(row).attr("id", data.rowID);
					$(row).attr("rec", data.rec);
				},
			});

			$('.dataTables_filter').addClass('pull-left');
			$('.dataTables_length').addClass('pull-right');

			$('#task').on('click', '.triggerEdit', function(){
				var id = $(this).data('rec');
				var title = $(this).data('title');
				var description = $(this).data('description');
				var date_created = $(this).data('date_created');

				// Populate the form fields with data
				$('#exampleModalEdit #id').val(id);
				$('#exampleModalEdit #title').val(title);
				$('#exampleModalEdit #description').val(description);
				$('#exampleModalEdit #date_created').val(date_created);

				// Open the modal
				$('#exampleModalEdit').modal('show');
			});


            // Delete task
			$('#task').on('click', '.triggerActions', function() {
				let id = $(this).data('rec');

				$.confirm({
					title: 'Confirm Deletion',
					content: 'Are you sure you want to delete this task?',
					buttons: {
						confirm: function() {
							// Delete operation
							$.ajax({
								url: 'functions/functions.php',
								type: 'POST',
								data: {
									actionType: 'deletetask',
									id: id
								},
								success: function(response) {
									location.reload()

								},
							});
						},
						cancel: function(){
							location.reload()
						}
					}
				});
			});

			$('#exampleModal').on('hidden.bs.modal', function () {
				location.reload();
			});
			$('#exampleModalEdit').on('hidden.bs.modal', function () {
				location.reload();
			});
        });
	</script>
</body>
</html>