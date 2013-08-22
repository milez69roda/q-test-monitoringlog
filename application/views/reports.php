			<div id="content">
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>Reports</span>
                         
                        <br />
                    </h3>
				    <p><strong>Search</strong> From: <input name="mettingname" id="mettingname" type="text" tabindex="1" /> To: <input name="mettingname" id="mettingname" type="text" tabindex="1" />
								<label for="department">Department : </label> 
								<?php echo form_dropdown('department_search', $department,'', 'id="department_search" onChange="Form.onDeptchangeSearch(this)"'); ?> 	
								Name: <select name="members_search" id="members_search"></select>					
					</p>
					<!--<table width="100%">
						<thead>
							<tr>
                            	<th width="40px"><a href="#">ID<img src="img/icons/arrow_down_mini.gif" width="16" height="16" align="absmiddle" /></a></th>
                            	<th width="90px"><a href="#">Date</a></th>
                                <th><a href="#">Recommendation</a></th>
                                <th width="150px"><a href="#">Recommended By</a></th> 
                            </tr>
						</thead>
						<tbody>
							<tr>
                            	<td class="a-center">1</td>
                            	<td>Jan 25, 2013</td>
                                <td>this is a sample recommendation</td>
                                <td>John Smith</td>                              
                            </tr>
						 
							  
						</tbody>
					</table>-->					
				</div>
				<br />
				 
				
				<div id="infowrap">
				 
				</div>
		</div>