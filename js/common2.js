var oTable;

var basehrefs = document.getElementsByTagName('base');
var basehref = basehrefs[0].getAttribute('href') 

var Common = {
		newForm: function(){ 
			$('#form')[0].reset();
			$("#box").hide();
			$("#rightnow").show();
			 
		},
		cancelForm: function(){ 
		
			$("#rightnow").hide();	
			$("#box").show();
					
		},
		showList: function(){
			$("#rightnow").hide();	
			$("#box").show();	
			oTable.fnDraw();
		},
		showMessage: function(title, msg){
			 
			var modal = $('<div title="'+title+'">'+msg+'</div>');					
			//modal.dialog( "destroy" );				
			modal.dialog({
				modal: true,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );  
					}
				}
			});			
		},
		showPopup: function(title, msg){
			 
			var modal = $('<div title="'+title+'">'+msg+'</div>');					
			//modal.dialog( "destroy" );				
			modal.dialog({
				modal: true,
				width: 550
				
			});			
		},		
		clearSearch: function(){
			$("#date_from_search").val('');
			$("#date_to_search").val('');
			$("#date_to_search").val('');
			$("#department_search").val('');
			$("#members_search").html('');
		},
		showRecommendation: function(f){
			this.showPopup('Recommendation', f.title);	
		},
		showMeeting: function(f){
			
		}
}; 

var Form = {
	
	onDeptchange: function(f){ 
		$.ajax({
			type: 'post',
			url: 'controller/ajax_dropdowns',
			dataType: 'json',
			data:{id:f.value,type:'gdm'},
			success: function(json_data){
				var items = [];
				
				$.each(json_data, function(k,v){
					items.push('<option value="'+k+'">'+v+"</option>");
				});
				$("#members").html(items.join(''));
			}
		});
		
	},
	onDeptchangeSearch: function(f){ 
		$.ajax({
			type: 'post',
			url: 'controller/ajax_dropdowns',
			dataType: 'json',
			data:{id:f.value,type:'gdm'},
			success: function(json_data){
				var items = [];
				
				$.each(json_data, function(k,v){
					items.push('<option value="'+k+'">'+v+"</option>");
				});
				$("#members_search").html(items.join(''));
			}
		});
	},
	onDeptchangeSearch2: function(f){ 
		$.ajax({
			type: 'post',
			url: 'controller/ajax_dropdowns',
			dataType: 'json',
			data:{id:f.value,type:'gdm'},
			success: function(json_data){
				var items = [];
				
				$.each(json_data, function(k,v){
					items.push('<option value="'+k+'">'+v+"</option>");
				});
				$("#members_search2").html(items.join(''));
			}
		});
		
	}/* ,	
	onCalltypechange: function(f){ 
		$.ajax({
			type: 'post',
			url: 'controller/ajax_dropdowns',
			dataType: 'json',
			data:{id:f.value,type:'gsct'},
			success: function(json_data){
				var items = [];
				
				$.each(json_data, function(k,v){
					items.push('<option value="'+k+'">'+v+"</option>");
				});
				$("#subcalltype").html(items.join(''));
			}
		})
		
	} */
	 

};

var Calls = {

	submit: function(f){
		
		var d =  $(f.id).serialize();
		 
		$.ajax({
			type: 'post',
			url: 'controller/calllog_submit',
			dataType: 'json',
			data: d,
			success: function(json_data){
				 
				if(typeof json_data == 'object' ){
					if(json_data.status){
						alert(json_data.msg);
						Common.showList();
					}else{
						Common.showMessage('Error', '<p><span class="ui-icon ui-icon-alert""></span></p>'+json_data.msg);
					}
				}else{
					alert('Your Session is expired, Please relogin');
					window.location = basehref;					
				}
			},
			error:  function (req, status, xhr) {
				  
				if( status == 'parsererror' )	{
					alert('Your Session is expired, Please relogin');
					window.location = basehref;		
				}
			}
		});  
		
		return false;
	},
	
	search: function(){
		oTable.fnDraw();
	},
	
	viewDetails: function( id ){
		
		$('<div></div>').load('controller/viewdetails',{'tab':'call', 'id':id}, function(data){
			Common.showPopup('Preview  Call',data);
		});
		
	}
}

var Meeting = {

	submit: function(f){
		
		var d =  $(f.id).serialize();
		 
		$.ajax({
			type: 'post',
			url: 'controller/meeting_submit',
			dataType: 'json',
			data: d,
			success: function(json_data){
			
				if(typeof json_data == 'object' ){
					if(json_data.status){
						alert(json_data.msg);
						Common.showList();
					}else{
						Common.showMessage('Error', '<p><span class="ui-icon ui-icon-alert""></span></p>'+json_data.msg);
					}
				}else{
					
				}
			}
		});  
		
		return false;
	},
	
	search: function(){
		oTable.fnDraw();
	},
	
	viewDetails: function( id ){
		
		$('<div></div>').load('controller/viewdetails',{'tab':'meeting', 'id':id}, function(data){
			Common.showPopup('Preview  Meeting',data);
		});
		
	}	
}

var Recommend = {

	submit: function(f){
		
		var d =  $(f.id).serialize();
		 
		$.ajax({
			type: 'post',
			url: 'controller/recommend_submit',
			dataType: 'json',
			data: d,
			success: function(json_data){
			
				if(typeof json_data == 'object' ){
					if(json_data.status){
						alert(json_data.msg);
						Common.showList();
					}else{
						Common.showMessage('Error', '<p><span class="ui-icon ui-icon-alert""></span></p>'+json_data.msg);
					}
				}else{

				}
			}
		});  
		
		return false;
	},
	
	search: function(){
		oTable.fnDraw();
	},
	
	viewDetails: function( id ){
		
		$('<div></div>').load('controller/viewdetails',{'tab':'recommend', 'id':id}, function(data){
			Common.showPopup('Preview Recommendation',data);
		});
		
	}		
}

var Login = {

	submit: function(f){
		
		var d =  $(f.id).serialize();
		 
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
							window.location = basehref+'calllog';
					}else{
						Common.showMessage('Error', '<p><span class="ui-icon ui-icon-alert""></span></p>'+json_data.msg);
					}
				}else{
					
				}
			}
		});  
		
		return false;
	},
	
	search: function(){
		oTable.fnDraw();
	}
}

var Overview = {

	search: function(f,o){
		
		var d =  $(f).serialize();
		 
		$.ajax({
			type: 'post',
			url: 'controller/search_overview',
			dataType: 'json',
			data: d+'&o='+o,
			success: function(json_data){
			
				if(typeof json_data == 'object' ){
					
					if(o=='week'){
					
						$("#c_w_box").html(json_data.w_call);
						$("#m_w_box").html(json_data.w_meeting);
						$("#r_w_box").html(json_data.w_recommend);					
					
					}
					 
					if(o=='year'){
						$("#c_y2d_box").html(json_data.y_call);
						$("#m_y2d_box").html(json_data.y_meeting);
						$("#m_a_y2d_box").html(json_data.y_evg);
						$("#r_y2d_box").html(json_data.y_recommend);
					}
					 
				}else{
					
				}
			}
		}); 
		
		return false;
	},
	
}

$(document).ready(function(){

	$('#box').hide();
	
});
