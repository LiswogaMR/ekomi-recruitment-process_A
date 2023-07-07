<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="vendor/css/jquery-confirm.min.css">
	<script src="vendor/js/jquery-confirm.min.js"></script>
	<link rel="stylesheet" href="vendor/css/jquery-ui.css">

	<link rel="shortcut icon" href="images/ekomi_gold.png" type="image/x-icon">
	<link rel="icon" href="images/ekomi_gold.png" type="image/x-icon">

	<script type="text/javascript" src="vendor/js/datatables.min.js"></script>
	<link rel="stylesheet" href="vendor/css/dataTables.jqueryui.min.css">
	<script type="text/javascript" src="vendor/js/dataTables.jqueryui.min.js"></script>
	  
	<link rel="stylesheet" type="text/css" href="vendor/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/css/buttons.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="vendor/js/jquery.dataTables.min.js"/>
	<script type="text/javascript" src="vendor/js/dataTables.select.min.js"></script>
	<script type="text/javascript" src="vendor/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="vendor/js/jszip.min.js"></script>
	<script type="text/javascript" src="vendor/js/pdfmake.min.js"></script>
	<script type="text/javascript" src="vendor/js/vfs_fonts.js"></script>
	<script type="text/javascript" src="vendor/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="vendor/js/buttons.print.min.js"></script>

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
				$response = "<span style='color: Red;'>Error.Email Allready Exists!!</span>";
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
						<table id="users" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Name</th>
									<th>Email</th>
									<th>Surname</th>
									<th>Contact No</th>
									<th>Permission Group</th>
									<th>Created</th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Name</th>
									<th>Email</th>
									<th>Surname</th>
									<th>Contact No</th>
									<th>Permission Group</th>
									<th>Created</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

			<!-- Update and edit User Modal -->
			<div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Update User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="functions/functions.php" method="POST" id="formUser">
								<div class="form-group">
									<label for="name" class="col-form-label">Name:</label>
									<input type="text" class="form-control" id="name" name="name" required>
								</div>
								<div class="form-group">
									<label for="surname" class="col-form-label">Surname:</label>
									<input type="text" class="form-control" id="surname" name="surname" data-src="surname" required>
								</div>
								
								<div class="form-group">
									<label for="email" class="col-form-label">E-mail:</label>
									<input type="text" class="form-control" id="email" name="email" data-src="email" required>
								</div>
								<div class="form-group">
									<label for="contactNo" class="col-form-label">Contact-No:</label>
									<input type="text" class="form-control" id="contactNo" name="contactNo" data-src="contactNo" >
								</div>
								<input type="hidden" name="actionType" value="updateUser">
								<input type="hidden"  id="id" name="id">
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" id="submitUser">Accept</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	<!-- page content ends here -->
	</section>
	<!-- footer starts here -->
	<?php include('footer.php') ?>
	<!-- footer ends here -->	
	<script type="text/javascript">
		$(document).ready(function() {
			// var full.order_notes = 'true';
			var userTable = $('#users').DataTable( {
				"serverSide": true,
				"pagingType": "full_numbers",
				"lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
				"order": [[ 1, "desc" ]],
				"ajax": {
					"url": 'functions/tables/employee-users.php',
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
					{ "data": "name", "name": "name", "searchable": true},
					{ "data": "email", "name": "email", "searchable": false},
					{ "data": "surname", "name": "surname", "searchable": false},
					{ "data": "contactNo", "name": "contactNo", "searchable": false},
					{ "data": "Permission_Name", "name": "Permission_Name", "searchable": false},
					{ "data": "created", "name": "created", "searchable": false},
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

			//move buttons to container
			
			$('#users').on('click', '.triggerEdit', function() {
				var id = $(this).data('rec');
				var name = $(this).data('name');
				var email = $(this).data('email');
				var surname = $(this).data('surname');
				var contactNo = $(this).data('contactno');

				// Populate the form fields with data
				$('#exampleModalEdit #id').val(id);
				$('#exampleModalEdit #name').val(name);
				$('#exampleModalEdit #email').val(email);
				$('#exampleModalEdit #surname').val(surname);
				$('#exampleModalEdit #contactNo').val(contactNo);

				// Open the modal
				$('#exampleModalEdit').modal('show');
			});

			$('#exampleModalEdit').on('hidden.bs.modal', function () {
				location.reload();
			});
        });
	</script>
</body>
</html>