<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calls extends CI_Model {

	public function __construct(){
		
		parent::__construct();
	
	}		
	
 	function getlist($user_id, $dept_id, $user_access){

		//echo $this->userId.' asdfa sdf asdf';
		
		
		//$aColumns = array( 'call_dateadded', 'call_min', 'call_esn', 'dept_desc', 'user_fullname', 'avaya', 'center', 'contact', 'call_type', 'call_subtype', 'call_details' );
		$aColumns = array( 'call_id','call_dateadded', 'call_min', 'call_esn', 'dept_desc', 'user_fullname', 'center', '');
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "call_id";
		
		/* DB table to use */
		$sTable = "calllog";
		$sJoin = "LEFT OUTER JOIN department ON department.dept_id = calllog.dept_id
					LEFT OUTER JOIN users ON users.user_id =calllog.user_id";
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
		
		
		if( isset($_GET["date_from_search"]) AND $_GET["date_from_search"] != '' ){		 
			$sWhere .=  " (DATE_FORMAT(call_dateadded, '%Y-%m-%d') between '".$_GET["date_from_search"]."' AND '".(($_GET["date_to_search"] != '')?$_GET["date_to_search"]:date("Y-m-d"))."')";	
			//$sWhere .=  " (call_weekending between '".$_GET["date_from_search"]."' AND '".$_GET["date_to_search"]."')";	 
		}else{
			$sWhere .=  " (DATE_FORMAT(call_dateadded, '%Y-%m-%d') between '".date("Y-m-d")."' AND '".date("Y-m-d")."')";
		}
		 
		if( isset($_GET["department_search"]) AND $_GET["department_search"] != '' ){				
			$sWhere .= " AND department.dept_id = ".$_GET["department_search"];
		} 
		
		if( isset($_GET["members_search"]) AND $_GET["members_search"] != '' ){	
			$sWhere .= " AND calllog.user_id = ".$_GET["members_search"];
		} 
		
		/* if( $user_access == 1) {
			if( isset($_GET["department_search"]) AND $_GET["department_search"] != '' ){	
				
				$sWhere .= " AND department.dept_id = ".$_GET["department_search"];
			}
		}elseif( $user_access == 2 ){
			$sWhere .= " AND department.dept_id = $dept_id";
		}		
		
		if( $user_access < 3 ) {
		
			if( isset($_GET["members_search"]) AND $_GET["members_search"] != '' ){	
				$sWhere .= " AND calllog.user_id = ".$_GET["members_search"];
			}  			
			
		}else{
			$sWhere .= " AND calllog.user_id = $user_id";
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
				call_id,
				call_dateadded,
				call_min,
				call_esn,
				dept_desc,
				user_fullname,
				avaya,
				center,
				contact,			
				call_type,
				call_subtype,
				call_details,
				calllog.user_id,
				call_weekending	
			
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
		
		//print_r($rResult);
		$iDisplayStart 	= $_GET['iDisplayStart']+1;
		//$cur_week 		= date("Y-m-d", strtotime("next Sunday") );
		$cur_week 		= date("Y-m-d", strtotime("last Sunday") );
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->call_id; 
			
			$rows[] = $iDisplayStart++; 
			$rows[] = date('M j, Y, g:i a',strtotime($row->call_dateadded)); 
			$rows[] = $row->call_min; 
			$rows[] = $row->call_esn; 
			$rows[] = $row->dept_desc; 
			$rows[] = $row->user_fullname; 
			//$rows[] = $row->avaya; 
			$rows[] = $row->center; 
			//$rows[] = $row->contact; 
			//$rows[] = $row->call_type; 
			//$rows[] = $row->call_subtype; 
			//$rows[] = $row->call_details;  
			
			
			//if( ($row->user_id == $user_id) AND ($cur_week == $row->call_weekending) ){
			if( ($row->user_id == $user_id) AND ($row->call_weekending >= $cur_week) ){
				$rows[] = '<a href="javascript:void(0)" onclick="Calls.viewDetails('. $row->call_id.')">Details</a> | <a href="calllogedit/'.$row->call_id.'">Edit</a>'; 
			}else{
				 
				if( $this->user_access == 1 ){
					$rows[] = '<a href="javascript:void(0)" onclick="Calls.viewDetails('. $row->call_id.')">Details</a> | <a href="calllogedit/'.$row->call_id.'">Edit</a>'; 
				}else{
					$rows[] = '<a href="javascript:void(0)" onclick="Calls.viewDetails('. $row->call_id.')">Details</a> '; 
				}
			}
			
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );	
	}	
	
}

/* End of file dropdowns.php */
/* Location: ./application/controllers/dropdowns.php */