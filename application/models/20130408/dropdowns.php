<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dropdowns extends CI_Model {

	public function __construct(){
		
		parent::__construct();
	
	}		

	public function group_departments_member() {
		
		$this->db->order_by("dept_order", "asc");
		$res = $this->db->get_where('department', array('dept_active'=>1))->result();
		
		//$ar = array(''=>' --- select --- ');
		$ar = '';
		foreach( $res as $row ){
			$ar[$row->dept_id] = $row->dept_desc;
		}
		
		$res = $this->db->get_where('users', array('user_active'=>1, 'user_access !='=>1))->result();		
		//$ar1 = array(''=>' --- select --- ');
		$ar1 = '';
		foreach( $res as $row ){
			$ar1[$row->dept_id][$row->user_id] = $row->user_fullname;
		}		
		
		
		
		$select = '<option value=""> --- select --- </option>';
		
		foreach( $ar as $key=>$value ){
			
			$select .=  '<optgroup label="'.$value.'">';
			foreach($ar1[$key] as $k=>$v){
				$select .=  '<option value="'.$key.':'.$k.'">'.$v.'</option>';
			}
			$select .= ' </optgroup>';
		}
		
		return $select;
	}	
	
	public function departments() {
		
		$res = $this->db->get_where('department', array('dept_active'=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->dept_id] = $row->dept_desc;
		}
		
		return $ar;
	}
	
	public function members_department($dept_id){
	
		$res = $this->db->get_where('users', array('user_active'=>1, 'dept_id'=>$dept_id, 'user_access !='=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->user_id] = $row->user_fullname;
		}
		
		return $ar;	
	}
	
	public function members_to_be_forwarded(){
	
		$res = $this->db->get_where('users', array('user_active'=>1,  'user_access !='=>1, 'user_allowtorecievfor'=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->user_id] = $row->user_fullname;
		}
		
		return $ar;	
	}		
	
	public function members_all(){
		$res = $this->db->get_where('users', array('user_active'=>1,  'user_access !='=>1 ))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->user_id] = $row->user_fullname;
		}
		
		return $ar;		
	}	
	
	public function calltypes(){
	
		$this->db->order_by('ct_desc', 'ASC');
		$res = $this->db->get_where('calltype', array('ct_active'=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->ct_desc] = $row->ct_desc;
		}
		
		return $ar;	
	}
	
	public function calltypes_sub(){
		$this->db->order_by('sct_desc', 'ASC');
		$res = $this->db->get_where('subcalltype', array('sct_active'=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->sct_desc] = $row->sct_desc;
		}
		
		return $ar;	
	}	

	public function centers(){
		$this->db->order_by('centerdesc', 'ASC');
		$res = $this->db->get_where('center', array('center_active'=>1))->result();
		
		$ar = array(''=>' --- select --- ');
		foreach( $res as $row ){
			$ar[$row->centerdesc] = $row->centerdesc;
		}
		
		return $ar;	
	}

	public function weekending(){

		$year = 2013; 
		
		$yd = date('Y')-$year; 
		 
		$last = strtotime("01 jan 2013 last Sunday"); // I have removed the $sunday line because it is not needed for your code
		$num = 54+( $yd*54 );
		$sunarray = '';
		for ($i = 1; $i < $num ;$i++){

				$sunarray[date("Y-m-d", $last)] = date("D M j Y", $last);
				$last = strtotime("+1 Week", $last);				 
		}

		return $sunarray; 
	}

	public function weekending_start(){

		$year = 2013; 
		
		$yd = date('Y')-$year; 
		 
		$last = strtotime("17 dec 2012 next Monday"); // I have removed the $sunday line because it is not needed for your code
		$num = 54+( $yd*54 );
		$sunarray = '';
		for ($i = 1; $i < $num ;$i++){

				$sunarray[date("Y-m-d", $last)] = date("D M j Y", $last);
				$last = strtotime("+1 Week", $last);				 
		}

		return $sunarray; 
	}

	public function getWeekending(){
		
		$weekending =  date("D M j Y", strtotime("next Sunday"));
		
		if( date('l') == 'Sunday' ){
			$weekending = date("D M j Y");
		} 
		
		return $weekending;
	}

	public function getWeekendingondate($datetime){
	
		$weekending =  date("D M j Y", strtotime("next Sunday", strtotime($datetime)));
		
		if( date('l', strtotime($datetime)) == 'Sunday' ){
			$weekending = date("D M j Y",strtotime($datetime));
		} 
		
		return $weekending;	
	}
}

/* End of file dropdowns.php */
/* Location: ./application/controllers/dropdowns.php */