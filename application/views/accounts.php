<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables_themeroller.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
<style>
	
	.ui-dialog-content  p{
		font-size: 11px;
	}
	
	.toolbar{
		float: right;
	}
	
	.dataTables_filter label{
		font-weight: bold !important;
		font-size: 14px;
	}
	
</style>

<script type="text/javascript">

$(document).ready(function() {
	
	
	oTable = $('#tablelist').dataTable({"bPaginate": false,});
	
});

</script>

 			<div id="content">
		 
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>Accounts</span>
                         
                        <br />
                    </h3>
 
					<table id="tablelist">
						<thead>
							<tr>
								<th>Name</th>
								<th>Password</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $row): ?>
							<tr>
								<td><?php echo $row->user_fullname; ?></td>
								<td><?php echo $row->user_pass; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
 
				</div>
				 
				<div id="infowrap">
				 
				</div>
		</div>