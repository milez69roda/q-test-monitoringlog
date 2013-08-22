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
</style>

<script type="text/javascript">

$(document).ready(function() {
	
	
	oTable = $('#tablelist').dataTable({ 
			"bProcessing": true,
			"bServerSide": true,		
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"sDom": 'T<"clear"><"toolbar">lrtip',
			"sAjaxSource": "controller/ajax_calllog_listing",
			"aaSorting": [[ 0, "DESC" ]],
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "date_from_search", "value": $("#date_from_search").val() } );
				aoData.push( { "name": "date_to_search", "value": $("#date_to_search").val() } );
				aoData.push( { "name": "department_search", "value": $("#department_search").val() } );
				aoData.push( { "name": "members_search", "value": $("#members_search").val() } );
			},
			/* "fnDrawCallback": function ( oSettings ) {
				 
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			}, */
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 7 ] }
			],	
			"aaSorting": [[ 1, 'desc' ]],
			"aLengthMenu": [[25, 50, 100], [25, 50, 100]],
			"iDisplayLength": 25		
		 	
	});
	
	$(".toolbar").html('<input id="button_export" class="btn_search" type="button" onclick="Calls.exporting()" value="Export to Excel">');
	
	$("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	
	if(window.location.hash) {
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		if( hash == 'box'){
			Common.showList();
		}
	} 
	  
});

</script>

 			<div id="content">
			
				<a href="javascript:void(0)" onclick="Common.showList()" class="search">Search</a> 
				<a href="<?php echo base_url().'calllog' ?>" class="add">New</a> 
				
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>New Call Log</span>
                         
                        <br />
                    </h3>

					
					<form id="form" name="form1" action="" method="post" onSubmit="return Calls.submit(this);">	
							<input type="hidden" name="u_user" value="<?php echo $this->user_id; ?>" />
							<input type="hidden" name="ftype" value="new" />
							<p>
								<label for="weekending">Weekending : </label> 
								<?php //echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime("next Sunday")), 'id="weekending"'); ?> 
								<!--<input type="text" name="weekending" id="weekending" value="<?php echo $this->dropdowns->getWeekending(); ?>" readonly="readonly"/>-->
								<?php if( $this->config->item('calls_extension') ):  
										echo form_dropdown('weekending', $weekending, $this->dropdowns->getWeekendingondate1(date("Y-m-d")), 'id="weekending"'); 
									else: ?>
								<input type="text" name="weekending" id="weekending" value="<?php echo $this->dropdowns->getWeekending(); ?>" readonly="readonly"/>
								<?php endif; ?>								
							</p>
							<!--						
							<p>
								<label for="department">Department Name <strong style="color:red">*</strong>: </label>  
								<?php //echo form_dropdown('department', $department,'', 'id="department" onChange=""'); ?> 
								<select name="department" id="department">
									<?php //echo $group_departments_member; ?>
								</select>
							</p>
							 -->
							<!--<p>
								<label for="members">Name : </label> 
								<select name="members" id="members"></select>
							</p>-->
							<p>
								<label for="avaya">PBX ID : </label> 
								<input name="avaya" id="avaya" type="text" tabindex="1" />
							</p>	
							<p>
								<label for="center">Center : </label> 
								<?php echo form_dropdown('center', $center,'', 'id="center"'); ?> 
							</p>
							<p>
								<label for="contact">Contact ID : </label> 
								<input name="contact" id="contact" type="text" tabindex="1" />
							</p>							
							<p>
								<label for="min">MIN : </label> 
								<input name="min" id="min" type="text" tabindex="1" />
							</p>	
							<p>
								<label for="esn">ESN / IMEI / MEID : </label> 
								<input name="esn" id="esn" type="text" tabindex="1" />
							</p> 	
							<p>
								<label for="calltype">Calltype : </label> 
								<?php echo form_dropdown('calltype', $calltype,'', 'id="calltype" onChange=""'); ?> 
							</p> 	
							<!--Calls.subcalltype(this, \'\')-->
							<p>
								<label for="calltypes_sub">Call Type Subcategory : </label> 
								<?php echo form_dropdown('calltypes_sub', $calltypes_sub,'', 'id="calltypes_sub" '); ?> 
								<!--<select name="calltypes_sub" id="calltypes_sub"></select>-->
							</p> 
							
						    <p>
								<label for="calldetails">Call Details <strong style="color:red">*</strong>: </label> 
								<textarea name="calldetails" id="calldetails" tabindex="1"></textarea>								 
							</p>
							<p> <em>Note: <strong style="color:red">*</strong> are required fields.</em></p>
						 <input id="button1" type="submit" value="Save" />  
						<!--<input id="button2" type="button" value="Cancel" onclick="Common.cancelForm()"/>  -->
					</form>					
					
				
				</div>
				
				<div id="box">
					<h3 class="reallynow">
						<span>Calls</span> 
                        
                        <br /> 
					</h3>
					<fieldset>
					<legend>Search</legend>				
				    <p>
						<form name="form_search" id="form_search" action="">
						<!--From: <?php //echo  form_dropdown('date_from_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_from_search"'); ?> 
						To: <?php //echo  form_dropdown('date_to_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_to_search"'); ?> -->
						 
						From <input type="text" name="date_from_search" id="date_from_search" value="<?php echo date('Y-m-d'); ?>" />
						To <input type="text" name="date_to_search" id="date_to_search" value="<?php echo date('Y-m-d'); ?>" />
						
						<label for="department_search">Department : </label> 
						<?php echo form_dropdown('department_search', $department,'', 'id="department_search" onChange="Form.onDeptchangeSearch(this)"'); ?> 	
					  
						<label for="members_search">Name : </label> 
						<select name="members_search" id="members_search"> </select>	
					 
						&nbsp;&nbsp;&nbsp;<input id="button2" class="btn_search" type="button" value="Search" onclick="Calls.search()"/>
						&nbsp;&nbsp;&nbsp;<input id="button1" class="btn_search" type="button" value="Reset" onclick="Common.clearSearch()"/>
						</form>

					</p>	
					</fieldset>		
					<table width="100%" id="tablelist">
						<thead>
							<tr>
                            	<th width="20px">ID</th>
                            	<th width="90px">Date</th>
                            	<th>Weekending</th>
                                <th width="40px">MIN</th>
                                <th>ESN / IMEI / MEID</th>
                                <th width="90px">Department</th>
                                <th>Name</th> 
                                <th>Center</th>      
                                <th>Call Details</th>      
                            </tr>
						</thead>
						<tbody> 
						</tbody>
					</table>						
					
				</div>
				
				<div id="infowrap">
				 
				</div>
		</div>