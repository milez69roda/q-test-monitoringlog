<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>  
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables_themeroller.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
<style>
	
	.ui-dialog-content  p{
		font-size: 11px;
	}
	
	/*#box p label{
		float: left;
		width: 180px;
	}*/	
	
	#box label{
		font-weight: bold;
	}
	
	#box p select{
		width: 155px;
		margin-right: 5px;
	}
</style>

<script type="text/javascript">

$(document).ready(function() {
    customFlag = 0;
	oTable = $('#tablelist').dataTable({ 
			"bProcessing": true,
			"bServerSide": true,		
			"bPaginate": true,
			"sPaginationType": "full_numbers",
			"sDom": 'T<"clear">lrtip',
			"sAjaxSource": "controller/ajax_recommend_overview_search",
			"aaSorting": [[ 0, "DESC" ]],
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "date_from_search", "value": $("#date_from_search").val() } );
				aoData.push( { "name": "date_to_search", "value": $("#date_to_search").val() } );
				aoData.push( { "name": "search_madeby", "value": $("#search_madeby").val() } );
				
				aoData.push( { "name": "date_from_search1", "value": $("#date_from_search1").val() } );
				aoData.push( { "name": "date_to_search1", "value": $("#date_to_search1").val() } );				
				aoData.push( { "name": "search_forwardto", "value": $("#search_forwardto").val() } );
				
				aoData.push( { "name": "flag12", "value": customFlag } );
			}/* ,
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 4 ] }
			] */		
		 	
	});
	
	/* $("#date_from_search").datepicker( { "dateFormat": 'yy-mm-dd'});
	$("#date_to_search").datepicker({ "dateFormat": 'yy-mm-dd'}); */
	$(".date_search").datepicker({ "dateFormat": 'yy-mm-dd'});
	
	
	/* if(window.location.hash) {
		var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		if( hash == 'box'){
			Common.showList();
		}
	}  */

	$("#box").show();
} );

</script>
 
			<div id="content">
				  
				<div id="box">
                    <h3 class="reallynow">
                        <span>Recommendations Search</span>
                         
                        <br />
                    </h3>
					<fieldset>
					<legend>Search</legend>				
				    <p style=" border-bottom: 1px solid #D9E6F0">
						<!--From: <?php //echo form_dropdown('date_from_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_from_search"'); ?> 
						To: <?php //echo form_dropdown('date_to_search', $weekending, date("Y-m-d", strtotime("next Sunday") ), 'id="date_to_search"'); ?>  -->
						<label>Recommendation Made By:</label> <?php echo form_dropdown('search_madeby', $madeby, '', 'id="search_madeby"'); ?> &nbsp;&nbsp;&nbsp;
						<label>Forwarded To: </label><?php echo form_dropdown('search_forwardto', $forwardeto, '', 'id="search_forwardto"'); ?> 
									
						
							
					</p>	
					<p>
						<label>From:  </label> <input type="text" class="date_search" name="date_from_search" id="date_from_search" value="<?php echo date('Y-m-d'); ?>" />
						<label>To: </label> <input type="text" class="date_search" name="date_to_search" id="date_to_search" value="<?php echo date('Y-m-d'); ?>" />							
					 	
						&nbsp;&nbsp;&nbsp;<input id="button2" class="btn_search" type="button" value="Search" onclick="Recommend.search()"/>
						<!--&nbsp;&nbsp;&nbsp;<input id="button1" class="btn_search" type="button" value="Reset" onclick="Common.clearSearch()"/>-->
						<br clear="both" />	
					</p>						
					</fieldset>	
					<table width="100%" id="tablelist">
						<thead>
							<tr>
                            	<th width="10px"></th>
                            	<th width="90px">Date</th>
                                <!--<th>Recommendation</th>-->
                                <th>From Department</th> 
                                <th width="100px">From Name</th> 
                                <th>Forwarded To</th> 
                                <th width="50px">Details</th> 
                            </tr>
						</thead>
						<tbody> 
						</tbody>
					</table>	

				</div>
				
				<div id="infowrap">
				 
				</div>
		</div>