
			<div id="content" style="width: 500px;">
			 
					  <table style="font-size: 12px; border: 1px solid #D9E6F0;">						 			
							
							<?php	
								$i = 0;
								foreach(  $rows as $key=>$value ):
								
									if( $key == 'Attendees' ){
										$value = str_replace(array("\r"),"<br />",$value);
									}
							?>
							
							<tr style="<?php echo($i%2==0)?'background: #E2E4FF':''; ?>">
								<th style="text-align:right; width: 180px; padding-right:10px"><?php echo $key ?>  </th> 
								<td><?php echo $value; ?></td> 
							</tr>	
							
							<?php $i++; endforeach; ?>	
						 
					 							
					</table>
		</div>