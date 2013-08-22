 
<style>
	
	.ui-dialog-content  p{
		font-size: 11px;
	}
	
</style>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>  
<script type="text/javascript">

$(document).ready(function() {
	 
	
	$("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	$("#call_dateadded").datetimepicker({ "dateFormat": 'yy-mm-dd',
										onSelect: function(selectedDateTime){
											//alert(selectedDateTime);
											$.ajax({
												type:'post',
												data:'t='+selectedDateTime,
												url:'controller/getWeekendingwithdate',
												success: function(xhr){
													$("#weekending").val(xhr);
													//alert(xhr)
												}
											});
										}
								 });	
} );

</script>

 			<div id="content">
				<div id="rightnow">
                    <h3 class="reallynow" style="background-color:orange">
                        <span>Update Call Log</span>
                        <a href="calllog#box"  class="add">Search</a> 
                        <br />
                    </h3>

					
					<form id="form" name="form1" action="" method="post" onSubmit="return Calls.submit(this);">	
							<input type="hidden" name="u_user" value="<?php echo $this->user_id; ?>" />
							<input type="hidden" name="f_id" value="<?php echo $row->call_id; ?>" />
							<input type="hidden" name="ftype" value="edit" />
							<p>
								<label for="weekending">Weekending : </label> 
								<?php //echo form_dropdown('weekending', $weekending, $row->call_weekending, 'id="weekending"'); ?> 
								<?php   
									if( $this->user_access == 1 ){ 
										echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime( $row->call_weekending)), 'id="weekending"'); 
									}else{	
								?>  
								<input type="text" name="weekending" id="weekending" value="<?php echo date("D M j Y", strtotime($row->call_weekending)); ?>" readonly="readonly"/>
								<?php } ?>										
							</p>
							<p>
								<label for="call_dateadded">Date Added : </label> 
								<input name="call_dateadded" id="call_dateadded" type="text" tabindex="1" value="<?php echo $row->call_dateadded ?>" />
							</p>						 
							<p>
								<label for="avaya">PBX ID : </label> 
								<input name="avaya" id="avaya" type="text" tabindex="1" value="<?php echo $row->avaya ?>" />
							</p>	
							<p>
								<label for="center">Center : </label> 
								<?php echo form_dropdown('center', $center, $row->center, 'id="center"'); ?> 
							</p>
							<p>
								<label for="contact">Contact ID : </label> 
								<input name="contact" id="contact" type="text" tabindex="1" value="<?php echo $row->contact ?>"/>
							</p>							
							<p>
								<label for="min">MIN : </label> 
								<input name="min" id="min" type="text" tabindex="1" value="<?php echo $row->call_min ?>"/>
							</p>	
							<p>
								<label for="esn">ESN / IMEI / MEID : </label> 
								<input name="esn" id="esn" type="text" tabindex="1" value="<?php echo $row->call_esn ?>"/>
							</p> 	
							<p>
								<label for="calltype">Calltype : </label> 
								<?php echo form_dropdown('calltype', $calltype, $row->call_type, 'id="calltype" onChange=""'); ?> 
							</p> 	
							<p>
								<label for="calltypes_sub">Call Type Subcategory : </label> 
								<?php echo form_dropdown('calltypes_sub', $calltypes_sub, $row->call_subtype, 'id="calltypes_sub" onChange=""'); ?> 
							</p> 
							
						    <p>
								<label for="calldetails">Call Details <strong style="color:red">*</strong>: </label> 
								<textarea name="calldetails" id="calldetails" tabindex="1"><?php echo $row->call_details ?></textarea>								 
							</p>
							<p> <em>Note: <strong style="color:red">*</strong> are required fields.</em></p>
						 <input id="button1" type="submit" value="Update" />  
						<!--<input id="button2" type="button" value="Cancel" onclick="Common.cancelForm()"/>  -->
					</form>					
					
				
				</div>
 
				
				<div id="infowrap">
				 
				</div>
		</div>