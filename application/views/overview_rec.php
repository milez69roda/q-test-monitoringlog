<style>
	#table11 p{
		padding-left: 10px;
	}
	
	.tags{
		padding: 5px 10px;
	}
	.tags span{
		padding-right: 5px;
		background-color: #AAC5EF;  
		margin: 2px;
		display: block;
		float: left;
	}
	
	.tags a{
		color: #000;
		padding: 5px;
	}
	
	
</style>			
			<div id="content">
				<a name="top"></a>
				<div id="rightnow">
                    <h3 class="reallynow">
                        <span>Recommendation List</span> 
                        <span style="float:right"><a href="<?php echo base_url(); ?>controller/downloadrecommendation" >Export Data</a></span> 
                        <br />
                    </h3> 
				</div>
				<br /> 
				
				<div id="infowrap">
					<div class="tags">
					<?php foreach($names as $rows): ?>
						<span> <a href="<?php echo base_url(); ?>recommendationslist#<?php echo $rows->user_fullname; ?>" /><?php echo $rows->user_fullname; ?></a></span>
					<?php endforeach; ?>
					</div>
					<br clear="both" />
					<table border="1" id="table11">
						<?php
							foreach($results as $key1=>$val1):
						?>
						
						<tr> 
							<th valign="top" style="font-size: 15px;"><a name="<?php echo $key1; ?>"><a/><?php echo $key1; ?></th>
						  
							<td>
								<?php $i=1; foreach($val1 as $key2=>$val2):  ?>
								<div style="<?php echo ($val2['own'])?'background-color:yellow':''; ?>">
								<p style="width:98%; background-color:#ccc; font-weight:bold; display:block;">
								<?php $tkey2 = explode('#', $key2);?>
									<span style="float:left"><?php echo 'ID: #'.$tkey2[1].' &nbsp; Date:'.date('D M j Y', strtotime($tkey2[0])); ?></span>
									<span style="float:left; padding-left: 10px; color:red">
									<?php  
										if($val2['isforwarded']){
											if($val2['forwardTo'] > 0){
												echo 'Forwarded to: '.$val2['forwardName'];
											}else{
												echo 'Forwarded From: '.$val2['forwardByName'];
											}
										}
									?>
									</span>
									<span style="float:right"><?php if($i==1): ?><a href="<?php echo base_url(); ?>recommendationslist#top">back to top</a><?php endif; ?></span><br clear="both" />
								<p>
								<p><span style="float:left; width:5%"><?php echo $val2['count']; ?></span><span style="float:left; width:90%"><?php echo $val2['txt']; ?></span> <br style="clear:both"/><p> 
								</div>
								<?php $i++; endforeach; ?>	
							</td> 
						</tr>
							
						<?php endforeach; ?>
					</table>
					
				 
				</div>
		</div>