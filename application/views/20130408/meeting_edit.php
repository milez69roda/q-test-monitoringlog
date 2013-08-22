 
<style>
	
	.ui-dialog-content  p{
		font-size: 11px;
	}
	
</style>

<script type="text/javascript">

$(document).ready(function() {
	 
	$("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	$("#meetingdate").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	$("#attendees").keyup( function(){
		var text = $(this).val();   
		var lines = text.split("\n");
		var count = lines.length;		
		
		$("#attendees_count").val(count);
	});
	
} );

</script>

			<div id="content">
				<div id="rightnow" >
                    <h3 class="reallynow" style="background-color:orange">
                        <span>Update Meeting</span>
                        <a href="meeting#box" class="add">Search</a> 
                        <br />
                    </h3> 
					
					<form id="form" action="" method="post" onSubmit="return Meeting.submit(this);">	
							<input type="hidden" name="ftype" value="edit" />
							<input type="hidden" name="f_id" value="<?php echo $row->m_id; ?>" />
							<p>
								<label for="weekending">Weekending : </label> 
								<?php //echo form_dropdown('weekending', $weekending, $row->m_weekending, 'id="weekending"'); ?> 
								<?php   
									if( $this->user_access == 1 ){ 
										echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime( $row->m_weekending)), 'id="weekending"'); 
									}else{	
								?>  
								<input type="text" name="weekending" id="weekening" value="<?php echo date("D M j Y", strtotime($row->m_weekending)); ?>" readonly="readonly"/>
								<?php } ?>									
							</p>						
						  							
							<p>
								<label for="mettingname">Meeting Name : </label> 
								<input name="mettingname" id="mettingname" type="text" tabindex="1" value="<?php echo $row->m_title ?>" />
							</p>	
							<p>
								<label for="meetingtype">Meeting Type : </label> 
								<select name="meetingtype">
									<option value=""  <?php echo set_select('meetingtype', '', ($row->m_type=='')?TRUE:FALSE); ?> > --- select ---</option>
									<option value="Group Meeting" <?php echo set_select('meetingtype', 'Group Meeting', ($row->m_type=='Group Meeting')?TRUE:FALSE); ?> >Group Meeting</option> 
									<option value="Individual Meeting" <?php echo set_select('meetingtype', 'Individual Meeting', ($row->m_type=='Individual Meeting')?TRUE:FALSE); ?> >Individual Meeting</option> 
								</select>	
							</p>							
							<p>
								<label for="meetingdate">Meeting Date : </label> 
								<input name="meetingdate" id="meetingdate" type="text" tabindex="1" value="<?php echo $row->m_date ?>" />
							</p> 						
							<p>
								<label for="attendees">Attendees : </label> 
								<textarea name="attendees" id="attendees" tabindex="1"><?php echo $row->m_attend ?></textarea>
								<input style="width: 50px;" readonly name="attendees_count" id="attendees_count" type="text" tabindex="1" value="<?php echo $row->m_no_attend ?>"/>								
							</p>							
							<p>
								<label for="notes">Notes : </label> 
								<textarea name="notes" id="notes" tabindex="1" style="width: 60%"><?php echo $row->m_notes ?></textarea>								 
							</p>
						 
						 <input id="button1" type="submit" value="Save" />  
						 
					</form>					
				
				</div>
				 
 
				
				<div id="infowrap">
				 
				</div>
		</div>