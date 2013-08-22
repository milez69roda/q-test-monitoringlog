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
	
	 
} );

</script>

			<div id="content">
				<div id="rightnow">
                    <h3 class="reallynow" style="background-color:orange">
                        <span>Update Recommendation</span>
                        <a href="recommendations#box" class="add">Search</a> 
                        <br />
                    </h3>
				     	 
					<form id="form" action="" method="post" onSubmit="return Recommend.submit(this);">	
							<input type="hidden" name="ftype" value="edit" />
							<input type="hidden" name="f_id" value="<?php echo $row->rec_id; ?>" />						
							<p>
								<label for="weekending">Weekending : </label> 
								<?php //echo form_dropdown('weekending', $weekending, $row->rec_weekending, 'id="weekending"'); ?> 
								<!--<input type="text" name="weekending" id="weekening" value="<?php //echo date("D M j Y", strtotime($row->rec_weekending)); ?>" readonly="readonly"/>-->
								
								<?php   
									if( $this->user_access == 1 ){ 
										echo form_dropdown('weekending', $weekending, date("Y-m-d", strtotime( $row->rec_weekending)), 'id="weekending"'); 
									}else{	
								?>  
								<input type="text" name="weekending" id="weekening" value="<?php echo date("D M j Y", strtotime($row->rec_weekending)); ?>" readonly="readonly"/>
								<?php } ?>									
							</p>
							 
						    <p>
								<label for="recommend">My Recommendation for this week: </label> 
								<textarea name="recommend" id="recommend" tabindex="1"><?php echo $row->rec_text; ?></textarea>								 
							</p>
						 
						 <input id="button1" type="Submit" value="Save" />  
						 
					</form>					
					
				</div>
				 
				 
				
				<div id="infowrap">
				 
				</div>
		</div>