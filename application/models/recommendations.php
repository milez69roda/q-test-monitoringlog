<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recommendations extends CI_Model {

	public function __construct(){
		
		parent::__construct();
	
	}		
	
 	function getlist($user_id, $dept_id, $user_access){

		//echo $this->userId.' asdfa sdf asdf';
		
		
		$aColumns = array( 'rec_id', 'rec_dateadded', 'rec_weekending', 'dept_desc', 'user_fullname', 'forwardByName' );
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "rec_id";
		
		/* DB table to use */
		$sTable = "recommendation";
		$sJoin = "LEFT OUTER JOIN department ON department.dept_id = recommendation.dept_id
					LEFT OUTER JOIN users ON users.user_id = recommendation.user_id";
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
				
			
			//$this->db->limit( $_GET['iDisplayLength'] ),  $_GET['iDisplayStart']  );
		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
			
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					
					
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
						
					//$this->db->order_by($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $_GET['sSortDir_'.$i] );	
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		$sOrder .= " , rec_dateadded asc"; 
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "WHERE  ";
		
			
		
		if( $this->user_access == 3 ){ 
				$sWhere .= " recommendation.user_id  = ". $user_id. ' AND ';
		}		
		
		if( isset($_GET["date_from_search"]) AND $_GET["date_from_search"] != '' ){		
		 
			
			$sWhere .=  " (DATE_FORMAT(rec_dateadded, '%Y-%m-%d') between '".$_GET["date_from_search"]."' AND '".(($_GET["date_to_search"] != '')?$_GET["date_to_search"]:date("Y-m-d"))."')";	
			//$sWhere .=  " (rec_weekending between '".$_GET["date_from_search"]."' AND '".$_GET["date_to_search"]."')";	

			
		}else{
			$sWhere .=  " (DATE_FORMAT(rec_dateadded, '%Y-%m-%d') between '".date("Y-m-d")."' AND '".date("Y-m-d")."')";
		}
		

		
		if( isset($_GET["department_search"]) AND $_GET["department_search"] != '' ){	
			
			$sWhere .= " AND recommendation.dept_id = ".$_GET["department_search"];
		}	 
		
		if( isset($_GET["members_search"]) AND $_GET["members_search"] != '' ){	
			$sWhere .= " AND recommendation.user_id = ".$_GET["members_search"];
		}	 

		/* if( $user_access == 1) {
			if( isset($_GET["department_search"]) AND $_GET["department_search"] != '' ){	
				
				$sWhere .= " AND department.dept_id = ".$_GET["department_search"];
			}
		}elseif( $user_access == 2 ){
			$sWhere .= " AND department.dept_id = $dept_id";
		} */		
		
		/* if( $user_access < 3 ) {
		
			if( isset($_GET["members_search"]) AND $_GET["members_search"] != '' ){	
				$sWhere .= " AND recommendation.user_id = ".$_GET["members_search"];
			}  			
			
		}else{
			$sWhere .= " AND recommendation.user_id = $user_id";
		}	 */		
		
		if( $_GET['owner_only'] == 'true' ){
			$sWhere .= ' AND (forwardBy IS NULL OR forwardBy = recommendation.user_id) ';
		}			
		
		if ( $_GET['sSearch'] != "" ){
			$sWhere .= " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				
				if( $aColumns[$i] == "Points" ){
				
				}else{
			
					$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				}
				/*if( $i == 0 )
					$this->db->like($_GET['sSearch'], 'match');
				else
					$this->db->or_like($_GET['sSearch'], 'match');*/
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else { 
					$sWhere .= " AND";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
		
		
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS 
				rec_id,
				rec_dateadded,
				rec_text, 
				user_fullname,
				dept_desc,
				recommendation.user_id,
				isforwarded,
				forwardTo,
				forwardName,
				forwardByName,
				rec_weekending
			
			FROM   $sTable
			$sJoin
			$sWhere
			$sOrder
			$sLimit
		";
		//ECHO $sQuery; 
		$rResult = $this->db->query($sQuery); 
		
		//echo $this->db->last_query();
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as numrow
			FROM   $sTable
			$sJoin
			$sWhere
		";
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			//"sEcho" => 1,
			"iTotalRecords" => $iTotal,
			//"iTotalDisplayRecords" => $iFilteredTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);
		
		//while ( $aRow = mysql_fetch_array( $rResult ) ){
		
		$rResult = $rResult->result();
		
		$iDisplayStart = $_GET['iDisplayStart']+1;
		
		if( $this->config->item('recommend_extension') ){
			//$cur_week 		= date("Y-m-d", strtotime("last Sunday") );
			$cur_week 		= $this->config->item('back_to_this_date');
		}else{
			$cur_week 		= date("Y-m-d", strtotime("next Sunday") );
		}	 
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->rec_id; 
			
			$rows[] = $iDisplayStart++;  
			$rows[] = date('M j, Y g:i a',strtotime($row->rec_dateadded)); 
			$rows[] = date('M j, Y',strtotime($row->rec_weekending)); 
			//$rows[] = $row->rec_text; 
			$rows[] = $row->dept_desc; 
			$rows[] = $row->user_fullname;    
			
			/*if( $this->user_access == 1 ){ 			
				$rows[] = (($row->isforwarded)?'&nbsp;<span style="color:red">'.(($row->forwardTo > 0)?'To: '.$row->forwardName:'By :'.$row->forwardByName).'</span>':'');  
			 }else{
				$rows[] = $row->forwardName;    
			} */
			
			$rows[] = $row->forwardByName;    
			
			//if( $row->user_id == $user_id  ){
			if( ($row->user_id == $user_id) AND ($row->rec_weekending >= $cur_week) ){
				$rows[] = '<a href="javascript:void(0)" onclick="Recommend.viewDetails('. $row->rec_id.')">Details</a> | <a href="recommendationsedit/'.$row->rec_id.'">Edit</a>'; 
			}else{ 
				if( $this->user_access == 1 ){ 
					$rows[] = '<a href="javascript:void(0)" onclick="Recommend.viewDetails('. $row->rec_id.')">Details</a> | <a href="recommendationsedit/'.$row->rec_id.'">Edit</a>'; 
				}else{
					$rows[] = '<a href="javascript:void(0)" onclick="Recommend.viewDetails('. $row->rec_id.')">Details</a> '; 
				}
			}			
			
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );	
	}	


	
	
 	function getlist2($user_id, $dept_id, $user_access){

		//echo $this->userId.' asdfa sdf asdf';
		
		
		$aColumns = array( 'rec_dateadded', 'rec_text', 'dept_desc', 'user_fullname' );
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "rec_id";
		
		/* DB table to use */
		$sTable = "recommendation";
		$sJoin = "LEFT OUTER JOIN department ON department.dept_id = recommendation.dept_id
					LEFT OUTER JOIN users ON users.user_id = recommendation.user_id";
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
				
			
			//$this->db->limit( $_GET['iDisplayLength'] ),  $_GET['iDisplayStart']  );
		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
			
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					
					
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
						
					//$this->db->order_by($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $_GET['sSortDir_'.$i] );	
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		 
		$sWhere = "WHERE  ";
		
		 
		//recommendation search  at overview link
		$search_madeby = @$_GET['search_madeby'];
		$search_forwardto = @$_GET['search_forwardto'];
		//echo $search_madeby;
		//if( $_GET['flag12'] ==  1){
			$sWhere1[] = " (DATE_FORMAT(rec_dateadded, '%Y-%m-%d') between '".$_GET["date_from_search"]."' AND '".(($_GET["date_to_search"] != '')?$_GET["date_to_search"]:date("Y-m-d"))."') ";	
			
			//echo $search_madeby;
			if($_GET['search_madeby'] > 0){
				$sWhere1[] = " recommendation.user_id  = ".$search_madeby;
			}
			
			if( $search_forwardto > 0){
				$sWhere1[] = " recommendation.forwardTo  = ".$search_forwardto;			
			}	
			
			$sWhere .= implode(' AND ', $sWhere1);
			
		//}
		
		/* if( $_GET['flag12'] ==  2){
			$sWhere .= " (DATE_FORMAT(rec_dateadded, '%Y-%m-%d') between '".$_GET["date_from_search1"]."' AND '".(($_GET["date_to_search1"] != '')?$_GET["date_to_search1"]:date("Y-m-d"))."') ";	
			
			if( $search_forwardto > 0){
				$sWhere .= " AND recommendation.forwardTo  = ".$search_forwardto;			
			}
		}
		
		if( $_GET['flag12'] ==  0 ){
			$sWhere .= " (DATE_FORMAT(rec_dateadded, '%Y-%m-%d') between '".date("Y-m-d")."' AND '".date("Y-m-d")."') ";	
		} */
 	
 
		
		if ( $_GET['sSearch'] != "" ){
			$sWhere .= " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				
				if( $aColumns[$i] == "Points" ){
				
				}else{
			
					$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				}
				/*if( $i == 0 )
					$this->db->like($_GET['sSearch'], 'match');
				else
					$this->db->or_like($_GET['sSearch'], 'match');*/
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else { 
					$sWhere .= " AND";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
		
		 
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS 
				rec_id,
				rec_dateadded,
				rec_text, 
				user_fullname,
				dept_desc,
				recommendation.user_id,
				isforwarded,
				forwardTo,
				forwardName,
				forwardBy,
				forwardByName
			
			FROM   $sTable
			$sJoin
			$sWhere
			$sOrder
			$sLimit
		";
		//ECHO $sQuery; 
		$rResult = $this->db->query($sQuery); 
		
		//echo $this->db->last_query();
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as numrow
			FROM   $sTable
			$sJoin
			$sWhere
		";
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			//"sEcho" => 1,
			"iTotalRecords" => $iTotal,
			//"iTotalDisplayRecords" => $iFilteredTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);
		
		//while ( $aRow = mysql_fetch_array( $rResult ) ){
		
		$rResult = $rResult->result();
		
		$iDisplayStart = $_GET['iDisplayStart']+1;
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->rec_id; 
			
			$rows[] = ($iDisplayStart++).'.';  
			$rows[] = date('M j, Y g:i a',strtotime($row->rec_dateadded)); 
			//$rows[] = $row->rec_text; 
			$rows[] = $row->dept_desc; 
			$rows[] = $row->user_fullname;    
			$rows[] = $row->forwardName;    
			$rows[] = '<a href="javascript:void(0)" onclick="Recommend.viewDetails('. $row->rec_id.')">Details</a> '; 
			 	
			
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );	
	}
	
	
}

/* End of file dropdowns.php */
/* Location: ./application/controllers/dropdowns.php */