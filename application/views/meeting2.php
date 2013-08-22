<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables_themeroller.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
<style>
	
	.ui-dialog-content  p{
		font-size: 11px;
	}
	
</style>

<script type="text/javascript">

$(document).ready(function() {
	
	
	oTable = $('#tablelist').dataTable({ 
			"bProcessing": true,
			"bServerSide": true,		
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"sDom": 'T<"clear">lrtip',
			"sAjaxSource": "controller/ajax_meeting_listing",
			"aaSorting": [[ 0, "DESC" ]],
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "date_from_search", "value": $("#date_from_search").val() } );
				aoData.push( { "name": "date_to_search", "value": $("#date_to_search").val() } );
				aoData.push( { "name": "department_search", "value": $("#department_search").val() } );
				aoData.push( { "name": "members_search", "value": $("#members_search").val() } );
			},
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 7 ] }
			]		
		 	
	});
	
	$("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	$("#meetingdate").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	$("#attendees").keyup( function(){
		var text = $(this).val();   
		var lines = text.split("\n");
		var count = lines.length;		
		
		$("#attendees_count").val(count);
	});
	
	
	if(window.location.hash) {
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		if( hash == 'box'){
			Common.showList();
		}
	}	 
	
});

</script>

			<div id="content">
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>New Meeting</span>
                        <a href="javascript:void(0)" onclick="Common.showList()" class="add">Search</a> 
                        <br />
                    </h3> 
					
					<form id="form" action="" method="post" onSubmit="return Meeting.submit(this);">	
							<input type="hidden" name="ftype" value="new" />
							<p>
								<label for="weekending">Weekending : </label> 
								<?php   echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime("next Sunday")), 'id="weekending"'); ?> 
							</p>						
						 			
							<!--<p>
								<label for="department">Department : </label> 
								<select name="department" id="department">
									<?php //echo $group_departments_member; ?>
								</select>	
							</p>-->	
							<!--<p>
								<label for="mettingname"> Name : </label> 
								<select name="members" id="members"></select>
							</p>-->								
							<p>
								<label for="mettingname">Meeting Name : </label> 
								<input name="mettingname" id="mettingname" type="text" tabindex="1" />
							</p>	
							<p>
								<label for="meetingtype">Meeting Type : </label> 
								<select name="meetingtype">
									<option selected="selected"   value=""> --- select ---</option>
									<option value="Group Meeting">Group Meeting</option> 
									<option value="Individual Meeting">Individual Meeting</option> 
								</select>	
							</p>							
							<p>
								<label for="meetingdate">Meeting Date : </label> 
								<input name="meetingdate" id="meetingdate" type="text" tabindex="1" />
							</p> 						
							<p>
								<label for="attendees">Attendees : </label> 
								<textarea name="attendees" id="attendees" tabindex="1"></textarea>
								<input style="width: 50px;" readonly name="attendees_count" id="attendees_count" type="text" tabindex="1" />								
							</p>							
							<p>
								<label for="notes">Notes : </label> 
								<textarea name="notes" id="notes" tabindex="1" style="width: 60%"></textarea>								 
							</p>
							<!--<p>
								<label for="actionitems">Action Items : </label> 
								<textarea name="actionitems" id="actionitems" tabindex="1" style="width: 60%"></textarea>								 
							</p>-->							
					 
						 <input id="button1" type="submit" value="Save" />  
						 
					</form>					
				
				</div>
				 
				 
				<div id="box">
					<h3 class="reallynow">
						<span>Meetings</span> 
                        <a href="<?php echo base_url().'meeting' ?>" class="add">New</a> 
                        <br /> 
					</h3>
					<fieldset>
					<legend>Search</legend>
				    <p> 
						From: <?php echo  form_dropdown('date_from_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_from_search"'); ?> 
						To: <?php echo  form_dropdown('date_to_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_to_search"'); ?>  
						
						<?php if( $this->user_access == 1): ?>
						<label for="department_search">Department : </label> 
						<?php echo form_dropdown('department_search', $department,'', 'id="department_search" onChange="Form.onDeptchangeSearch(this)"'); ?> 	
						<?php endif; ?>
								
						<?php if( $this->user_access < 3 ): ?>
						<label for="members_search">Name : </label> 
						<select name="members_search" id="members_search">  
							<?php
								if( $this->user_access == 2 ):
								foreach($members as $key=>$value): ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php endforeach; endif;?>	
						</select>	
						<?php endif; ?>	
						
						&nbsp;&nbsp;&nbsp;<input id="button2" class="btn_search" type="button" value="Search" onclick="Meeting.search()"/>
						&nbsp;&nbsp;&nbsp;<input id="button1" class="btn_search" type="button" value="Reset" onclick="Common.clearSearch()"/>
					</p>
					</fieldset>
					<table width="100%" id="tablelist">
						<thead>
							<tr>
                            	<th width="20px">ID</th>
                            	<th>Meeting Name</th>
                                <th width="50px">Meeting Date</th>
                                <th width="30px"># of <br/>Attendees</th>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Meeting Type</th>
                                <th>Meeting Details</th>  
                            </tr>
						</thead>
						<tbody>
							 
						</tbody>
					</table>	
				</div>
				
				<div id="infowrap">
				 
				</div>
		</div>