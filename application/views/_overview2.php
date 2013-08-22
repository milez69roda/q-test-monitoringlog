	
<script type="text/javascript">
$(document).ready(function(){

	$('#box').show();
	
});
</script>	
		<div id="content">
				
				<div id="box"> 
				 
					<div id="infowrap">
						<div id="infobox"> 
							<h3>Goal</h3> 
							<p>30+ weeks with all 3 components completed = 5 score</p>
							<p>25-29 weeks with all 3 components completed = 4 score</p>
							<p>20-24 weeks with all 3 components completed = 3 score</p>					
						</div>
						<div id="infobox" class="margin-left">
							<h3>The 3 Components</h3> 
							<p>25 calls logged per person per week</p>
							<p>1 meeting held with center group/individual per week</p>
							<p>1 recommendation logged per week</p>					
						</div>					
					</div>
					<br style="clear:both"/>
				</div>
				<br />
				<div id="box">
					 <h3 class="reallynow">
                        <span>Look up Goal Tracking</span>
						 <br />
					</h3>
					<?php if( $this->user_access < 3 ): ?>
					<form id="form_search1" name="form_search1" method="post" onsubmit="return Overview.search(this,'week');">		
				    <p> 
						<?php if( $this->user_access == 1): ?>
						<label for="department"><strong>Department :</strong></label> 
						<?php echo form_dropdown('department_search', $department,'', 'id="department_search" onChange="Form.onDeptchangeSearch(this)"'); ?> 	
						<?php endif; ?>
						
						<label for="members_search"><strong>Name : </strong></label> 
						<select name="members_search" id="members_search">
							
							<?php
								if( $this->user_access == 2 ):
								foreach($members as $key=>$value): ?>
							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php endforeach; endif;?>						
						</select>	
						<input id="button2" class="btn_search" type="submit" value="Search"  style="padding: 3px;"/>		
					</p>
					</form>					
					<hr /> 
					<?php endif; ?>
					<p style="padding:10px 0px;"><h2 style="text-align:center;">- Results for Current Week -</h2></p>	
					<p><em>Notes: weekly results will reset 11pm every sunday and will move automatically to year to date results.</em></p>
				 
					<div id="infowrap">
						<div id="infobox2" style="width: 140px"> 
							<h3>Weekending</h3> 
							<p> <?php echo  date("D M j Y", strtotime("next Sunday") );  ?> </p>					
						</div>					
						<div id="infobox2" class="margin-left" style="width: 240px"> 
							<h3># Calls Monitored this week</h3> 
							<div style="text-align:center" id="c_w_box"><?php echo $w_call; ?></div>					
						</div>
						<div id="infobox2" class="margin-left" style="width: 310px" >
							<h3>Date Meeting Held this week</h3> 
							<div id="m_w_box">
							<?php foreach( $w_meeting as $row): ?>
							<p><a href="javascript:void(0)" onclick="Common.showMeeting(<?php echo $row->m_id; ?>)"><?php echo  date('M j, Y',strtotime($row->m_date)).' - '.$row->m_type.' <em>-'.$row->user_fullname.'</em>'; ?></a></p>		
							<?php endforeach; ?>						 
							</div>
						</div>
						<div id="infobox2" class="margin-left">
							<h3>Recommendation for this week</h3> 
							<div id="r_w_box">
							<?php foreach( $w_recommend as $row): ?>
							<p><a href="javascript:void(0)" onclick="Common.showRecommendation(this)" title="<?php echo htmlspecialchars('<strong>'.$row->user_fullname.'<br />'.$row->rec_dateadded.'</strong><hr/><br />'.$row->rec_text); ?>"><?php echo $row->user_fullname; ?></a></p>		
							<?php endforeach; ?>						 
							</div>
						</div>					
					</div>						
					<br style="clear:both"/>
					<br />	
					<p></p>					
				</div>
			
				<br style="clear:both"/>				
				<?php $prev_weekending =  date("Y-m-d", strtotime("last Sunday") ); ?>
				<div id="box">
					 <h3 class="reallynow">
                        <span>Look up Goal Tracking</span>
						 <br />
					</h3>
					<form id="form_search2" name="form_search2" method="post" onsubmit="return Overview.search(this,'year');">
							<p> 				
								<label for="weekending_start"><strong>Weekending</strong> From: </label> <?php echo  form_dropdown('weekending_start', $weekending, $prev_weekending, 'id="weekending_start"'); ?> 
								<label for="weekending_end">To: </label> <?php echo  form_dropdown('weekending_end', $weekending, $prev_weekending, 'id="weekending_end"'); ?>&nbsp;&nbsp;
								<?php if( $this->user_access == 1): ?>
								<label for="department"><strong>Department : </strong></label> 
								<?php echo form_dropdown('department_search2', $department,'', 'id="department_search2" onChange="Form.onDeptchangeSearch2(this)"'); ?> &nbsp;&nbsp;
								<?php endif; ?>
								
								<?php if( $this->user_access < 3 ): ?>
								<label for="members_search2"><strong>Name : </strong></label>
								<select name="members_search2" id="members_search2">  
									<?php
										if( $this->user_access == 2 ):
										foreach($members as $key=>$value): ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									<?php endforeach; endif;?>	
								</select>	
								<?php endif; ?>
								<input id="button2" class="btn_search" type="submit" value="Search" style="padding: 3px;"/>										
							</p>
					</form>
					<hr />
					<p style="padding:10px 0px;"><h2 style="text-align:center;">- Results for Year to Date -</h2></p>	
					 
					<div id="infowrap">
						<!--<div id="infobox2" style="width: 140px"> 
							<h3>Weekending</h3>  
							<?php   echo form_dropdown('weekending', array_reverse($weekending), $prev_weekending, 'id="weekending"'); ?> 
						</div>-->						
						
						<div id="infobox2" class="margin-left" style="width: 140px"> 
							<h3># Calls Monitored</h3>  
							<p id="c_y2d_box" style="text-align:center"> <?php echo $y_call; ?> </p>					
						</div>
						<div id="infobox2" class="margin-left" style="width: 320px">
							<h3>Date Meeting Held</h3> 
							<div id="m_y2d_box">
								<?php foreach( $y_meeting as $row): ?>
								<p><?php echo  date('M j, Y',strtotime($row->m_date)).' - '.$row->m_type.' <em>-'.$row->user_fullname.'</em>'; ?></p>		
								<?php endforeach; ?>
							</div>
						</div>
						<div id="infobox2" class="margin-left" style="">
							<h3>Name - Individual(%) - Group(%)</h3> 
							<div id="m_a_y2d_box">
								<?php foreach( $y_evg as $row): ?>
								<p><?php echo  $row->user_fullname.' - '.$row->individual.'% - '.$row->group.'%'; ?></p>		
								<?php endforeach; ?>
							</div>
						</div>						
						<div id="infobox2" class="margin-left">
							<h3>Recommendations</h3> 
							<div id="r_y2d_box">
							<?php foreach( $y_recommend as $row): ?>
							<p><a href="javascript:void(0)" onclick="Common.showRecommendation(this)" title="<?php echo htmlspecialchars($row->user_fullname.'<br />'.$row->rec_dateadded.'<br />'.$row->rec_text); ?>"><?php echo $row->user_fullname; ?></a></p>		
							<?php endforeach; ?>
							</div>
						</div>					
					</div>	
					<br style="clear:both"/>
					<br />							
				</div>	
				
				<div id="box">
				 
				</div>
		</div>