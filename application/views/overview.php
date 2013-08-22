	
<script type="text/javascript">
$(document).ready(function(){

	$('#box').show();
	Overview.y2dSearch( "#form_search1", 'week');
	$("#department_search  option:first-child").attr("selected", true)
	$("#department_search2  option:first-child").attr("selected", true)
	
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
                        <span>Look up Goal Tracking this week</span>
						 <br />
					</h3>
					<?php //if( $this->user_access < 3 ): ?>
					<form id="form_search1" name="form_search1" method="post" onsubmit="return Overview.search(this,'week');">		
						
				    <p> 
						 
						<label for="department"><strong>Department :</strong></label> 
						<?php echo form_dropdown('department_search', $department,'', 'id="department_search" onChange="Form.onDeptchangeSearch(this)"'); ?> 	
						 
						
						<label for="members_search"><strong>Name : </strong></label> 
						<select name="members_search" id="members_search">
							 					
						</select>	
						<input id="button2" class="btn_search" type="submit" value="Search"  style="padding: 3px;"/>		
					</p>
					</form>					
					<hr /> 
					<?php //endif; ?>
					<p style="padding:10px 0px;"><h2 style="text-align:center;">- Results for Current Week -</h2></p>	
					<p><em>Notes: weekly results will reset 11pm every sunday and will move automatically to year to date results.</em></p>
				 
					<div id="infowrap">
						<div id="infobox2" style="width: 140px"> 
							<h3>Weekending</h3> 
							<p> <?php echo  date("D M j Y", strtotime("next Sunday") );  ?> </p>					
						</div>					
						<div id="infobox2" class="margin-left" style="width: 240px"> 
							<h3># Calls Monitored this week</h3> 
							<p style="text-align:center" id="c_w_box"><?php echo $w_call; ?></p>					
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
				<?php $prev_monday =  date("Y-m-d", strtotime("last Monday") ); ?>
				<?php $prev_weekending =  date("Y-m-d", strtotime("last Sunday") ); ?>
				<div id="box">
					 <h3 class="reallynow">
                        <span>Look up Goal Tracking Year to Date</span>
						 <br />
					</h3>
					<form id="form_search2" name="form_search2" method="post" onsubmit="return Overview.y2dSearch(this,'year');">
							<p> 				
								<label for="weekending_start"><strong>Weekending</strong> From: </label> <?php echo  form_dropdown('weekending_start', $weekending_start, $prev_monday, 'id="weekending_start"'); ?> 
								<label for="weekending_end">To: </label> <?php echo  form_dropdown('weekending_end', $weekending, $prev_weekending, 'id="weekending_end"'); ?>&nbsp;&nbsp;
								 
								<label for="department"><strong>Department : </strong></label> 
								<?php echo form_dropdown('department_search', $department,'', 'id="department_search2" onChange="Form.onDeptchangeSearch2(this)"'); ?> &nbsp;&nbsp;
							 
								
							 
								<label for="members_search2"><strong>Name : </strong></label>
								<select name="members_search" id="members_search2">  
									 
								</select>	
								 
								<input id="button2" class="btn_search" type="submit" value="Search" style="padding: 3px;"/>		
																	
							</p>
					</form>
					<hr />
					<p id="form2_processing">&nbsp;</p>
					<p style="padding:10px 0px;"><h2 style="text-align:center;">- Results for Year to Date - </h2></p>	
					 
					<div id="infowrap">
							
							<table id="tbl_y2d" style="font-size:13px">	
								<thead>
									 
									<tr>
										<th rowspan="2" scope="col">Name</th>
										<th rowspan="2" scope="col" style="width: 15%">Calls</th>
										<th colspan="3" scope="col" style="width: 40%">Meetings</th>
										<th rowspan="2" scope="col">											
											<a href="recommendationssearch" style="color:green">Recommendation Search</a>
											<hr />
											<a href="recommendationslist">Recommendations</a>
										</th>
									</tr>
									<tr>
										<th>No. of Meetings</th>
										<th>Individual</th>
										<th>Group</th>
									</tr>									
								</thead>
								<tbody>
									 
								</tbody>
							</table>
						 
					</div>	
					<br style="clear:both"/>
					<br />							
				</div>	
				
				<div id="box">
				 
				</div>
		</div>