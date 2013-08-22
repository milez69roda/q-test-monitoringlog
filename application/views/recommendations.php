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
			"sAjaxSource": "controller/ajax_recommend_listing",
			"aaSorting": [[ 0, "DESC" ]],
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "date_from_search", "value": $("#date_from_search").val() } );
				aoData.push( { "name": "date_to_search", "value": $("#date_to_search").val() } );
				aoData.push( { "name": "department_search", "value": $("#department_search").val() } );
				aoData.push( { "name": "members_search", "value": $("#members_search").val() } );
				aoData.push( { "name": "owner_only", "value": $("#owner_only").is(":checked") } );
			},
			/* "aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 4 ] }
			], */
			"aLengthMenu": [[25, 50, 100], [25, 50, 100]],
			"iDisplayLength": 25		
		 	
	});
	
	$("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	
	if(window.location.hash) {
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		if( hash == 'box'){
			Common.showList();
		}
	} 	
} );

</script>

			<div id="content">
			
				<a href="<?php echo base_url().'recommendations' ?>" class="add">New</a> 
				<a href="javascript:void(0)" onclick="Common.showList()" class="search">Search</a> 
				
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>New Weekly Recommendation</span>
                        
                        <br />
                    </h3>
				     	 
					<form id="form" action="" method="post" onSubmit="return Recommend.submit(this);">	
							<input type="hidden" name="ftype" value="new" />
							<p>
								<label for="weekending">Weekending : </label> 
								<?php //echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime("next Sunday")), 'id="weekending"'); ?> 
								<!--<input type="text" name="weekending" id="weekending" value="<?php echo $this->dropdowns->getWeekending(); ?>" readonly="readonly"/>-->
								
								<?php if( $this->config->item('recommend_extension') ):   
										echo form_dropdown('weekending', $weekending, $this->dropdowns->getWeekendingondate1(date("Y-m-d")), 'id="weekending"'); 
									else: ?>	
									<input type="text" name="weekending" id="weekending" value="<?php echo $this->dropdowns->getWeekending(); ?>" readonly="readonly"/>
								<?php endif; ?>									
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
								<label for="recommend">My Recommendation for this week: </label> 
								<textarea name="recommend" id="recommend" tabindex="1"></textarea>								 
							</p>
							
							<p style="">
								<label for="forwardedto">Forward To : </label>  
								<?php  
									$x = (int)$this->user_id; 
									unset($members_to_be_forwarded[$x]);  
								?>							
								<?php echo form_dropdown('forwardedto', $members_to_be_forwarded,'', 'id="forwardedto" '); ?> 	
							</p>
							
							<br />
							<input id="button1" type="Submit" value="Save" />  
							<span id="rec_process" style="padding-left: 10px; color: green; font-weight:bold; display:none">Processing...</span>
					</form>					
					
				</div>
				 
				<div id="box">
                    <h3 class="reallynow">
                        <span>Recommendations</span>
                         
                        <br />
                    </h3>
					<fieldset>
					<legend>Search</legend>				
				    <p>
						<!--From: <?php //echo  form_dropdown('date_from_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_from_search"'); ?> 
						To: <?php //echo  form_dropdown('date_to_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_to_search"'); ?>  -->
						
						From <input type="text" name="date_from_search" id="date_from_search" value="<?php echo date('Y-m-d'); ?>" />
						To <input type="text" name="date_to_search" id="date_to_search" value="<?php echo date('Y-m-d'); ?>" />						
						
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
						Display My Recommendations <input type="checkbox" name="owner_only" id="owner_only" value="1"/> 
						
						&nbsp;&nbsp;&nbsp;<input id="button2" class="btn_search" type="button" value="Search" onclick="Recommend.search()"/>
						&nbsp;&nbsp;&nbsp;<input id="button1" class="btn_search" type="button" value="Reset" onclick="Common.clearSearch()"/>
					</p>	
					</fieldset>	
					<table width="100%" id="tablelist">
						<thead>
							<tr>
                            	<th width="20px">ID</th>
                            	<th width="90px">Date</th>
                            	<th>Weekending</th>
                                <!--<th>Recommendation</th>-->
                                <th>Department</th> 
                                <th>Name</th> 
								<th>From</th> 
                                <th >Recommendation Details</th> 
                            </tr>
						</thead>
						<tbody> 
						</tbody>
					</table>	

				</div>
				
				<div id="infowrap">
				 
				</div>
		</div>