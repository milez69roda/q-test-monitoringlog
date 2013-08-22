	
<script type="text/javascript">
$(document).ready(function(){

	$('#box').show();
	$('#form1').submit(function(){
		var d=$(this).serialize();
		$.ajax({
			type: 'post',
			url: 'login/isLogin',
			dataType: 'json',
			data: d,
			success: function(json_data){
			
				if(typeof json_data == 'object' ){
					if(json_data.status){
							/* basehrefs = document.getElementsByTagName('base');
							basehref = basehrefs[0].getAttribute('href') */
							//console.log(basehref);
							window.location = 'calllog';
					}else{
						alert('Login Failed');
					}
				}else{
					
				}
			}
		});  
		
		return false;
	});
});
</script>	
		<div id="content">
				 
				<div id="box"> 
					<div id="infowrap">
						 <form id="form1" name="form1" action="" method="post" >	
							
							<p>	
								<label for="login">Login : </label>
								<!--<select name="department" id="department">
									<?php //echo $group_departments_member; ?>
								</select>-->									 
								<input name="login" id="login" type="password" tabindex="1" />
								<input id="button1" type="submit" value="Login" />  
							</p>
							
						</form>						 
					</div>	
					<br style="clear:both"/>
					<br />							
				</div>	
		</div>