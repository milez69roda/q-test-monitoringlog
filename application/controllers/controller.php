<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controller extends CI_Controller {

	public $user_id;
	public $dept_id;
	public $user_access;
	public $user_fullname;
	
	public function __construct(){
	
		parent::__construct();
		
  
		if( !$this->session->userdata('islogin') AND  $this->session->userdata('u_m_id') == '' ){
			redirect(base_url());
		}
		
		$this->user_id = $this->session->userdata('u_m_id');
		$this->user_access = $this->session->userdata('u_access');
		$this->dept_id = $this->session->userdata('u_d_id');
		$this->user_fullname = $this->session->userdata('u_m_full');
		 
	}
	 
	public function index() {
		//$this->load->view('welcome_message');
		redirect('overview');
	}
	
	private function _x_week_range($date) {
		$ts = strtotime($date); 
		$w = date('w', $ts);
		$start = ($w == 1) ? $ts : strtotime('last monday', $ts);
		 
		return array(date('Y-m-d', $start),
					 date('Y-m-d', strtotime('next sunday', $ts)).' 23:00:00');
	}

	public function getWeekendingwithdate(){
		$date = $this->input->post('t');
		echo $this->dropdowns->getWeekendingondate($date);
		
	}
	
	public function getWeekendingwithdate1(){
		$date = $this->input->post('t');
		echo $this->dropdowns->getWeekendingondate1($date);
		
	}	
	
	public function overview(){
	
		//weekly
		//$w_range = $this->_x_week_range(date('Y-m-d'));
		$w_where = " AND ov.dept_id = $this->dept_id AND ov.user_id = $this->user_id";
		$current_weekending = date("Y-m-d", strtotime("next Sunday") );
		
		$w_call_sql = "SELECT COUNT(*) as num FROM calllog ov WHERE (call_weekending = '".$current_weekending."')".$w_where;
		$data['w_call'] = $this->db->query($w_call_sql)->row()->num;
	
		$w_meeting_sql = "SELECT m_id, m_date, m_type, user_fullname FROM meeting ov
							LEFT OUTER JOIN users ON users.user_id = ov.user_id
							WHERE (m_weekending = '".$current_weekending."')".$w_where;
		$data['w_meeting'] = $this->db->query($w_meeting_sql)->result();
		
		$w_recommend_sql = "SELECT user_fullname, rec_text, rec_dateadded FROM recommendation ov
							LEFT OUTER JOIN users ON users.user_id = ov.user_id
							WHERE (rec_weekending = '".$current_weekending."')".$w_where;
		$data['w_recommend'] = $this->db->query($w_recommend_sql)->result();		
		/* $data['w_call']		= '';
		$data['w_meeting']  = '';
		$data['w_recommend']= ''; */
		
		//y2d
		$prev_weekending_sun =  date("Y-m-d", strtotime("last Sunday") );		
		$prev_weekending_mon =  date("Y-m-d", strtotime("$prev_weekending_sun last monday") );		
		
		$_where = '';
		/* if( $this->user_access == 3 ){
			$_where .= " AND ov.user_id = $this->user_id ";
		}elseif( $this->user_access == 2){			
			$_where .= " AND ov.dept_id = $this->dept_id ";
		}else{		
		
		} */
		
		
		$y_call_sql = "SELECT COUNT(*) as num FROM calllog ov WHERE call_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun' ".$_where;
		$data['y_call'] = $this->db->query($y_call_sql)->row()->num;
	
		$y_meeting_sql = "SELECT m_date, m_type, user_fullname FROM meeting as ov
							LEFT OUTER JOIN users ON users.user_id = ov.user_id
							WHERE m_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun' ".$_where;
		//echo $y_meeting_sql;
		$data['y_meeting'] = $this->db->query($y_meeting_sql)->result();
		
		$y_evg_sql = "SELECT user_fullname, 
				ROUND((SUM(IF(m_type='Individual Meeting', 1, 0)) / 15) * 100, 2)  AS 'individual',
				ROUND((SUM(IF(m_type='Group Meeting', 1, 0)) / 15)*100, 2) AS 'group' 
				FROM meeting ov
				LEFT OUTER JOIN users  ON users.user_id  = ov.user_id
				WHERE m_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun' ".$_where."
				GROUP BY ov.user_id";		
		$data['y_evg'] = $this->db->query($y_evg_sql)->result();
		
		$y_recommend_sql = "SELECT user_fullname, rec_text, rec_dateadded FROM recommendation ov
							LEFT OUTER JOIN users ON users.user_id = ov.user_id
							WHERE rec_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun' ".$_where;
							
		$data['weekending_start'] = $this->dropdowns->weekending_start(); 
		$data['weekending'] = $this->dropdowns->weekending(); 
		$data['y_recommend'] = $this->db->query($y_recommend_sql)->result();		
		 
		$data['department'] = $this->dropdowns->departments(); 
		$data['members'] = $this->dropdowns->members_department($this->dept_id); 
			

		
		$this->load->view('header');
		$this->load->view('overview', $data);
		$this->load->view('footer');
	}
	
	
	
	
	public function search_overview(){
		 
		$data = '';
		
		$type = $this->input->post('o');
		
		if( $type == 'week' ){
		
			$_where = '';
			if( @$this->input->post('department_search') != '' ){
				$_where .= ' AND ov.dept_id = '.$this->input->post('department_search');
			}		
			if( @$this->input->post('members_search') != '' ){
				$_where .= ' AND ov.user_id = '.$this->input->post('members_search');
			}
			 
			//$_where = "  AND ov.user_id =  $this->user_id AND ov.dept_id = $this->dept_id ";
			
			//$w_range = $this->_x_week_range(date('Y-m-d'));
			$current_weekending = date("Y-m-d", strtotime("next Sunday") );
			
			$w_call_sql = "SELECT COUNT(*) as num FROM calllog as ov WHERE (call_weekending = '".$current_weekending."') ".$_where;
			//echo $w_call_sql;
			$data['w_call'] = $this->db->query($w_call_sql)->row()->num;
			 
			 
			$w_meeting_sql = "SELECT m_id, m_date, m_type, user_fullname FROM meeting as ov
								LEFT OUTER JOIN users ON users.user_id = ov.user_id
								WHERE (m_date BETWEEN DATE_ADD(m_weekending, INTERVAL -6 DAY) AND m_weekending ) AND (m_weekending = '".$current_weekending."') ".$_where."
								 ORDER BY m_date ASC
								";
			 					
			$y_meeting_res = $this->db->query($w_meeting_sql)->result();
			$y_meeting_text = '';
			foreach( $y_meeting_res as $row ){
				$y_meeting_text .= '<p><a href="javascript:void(0)" onclick="Common.showMeeting(this)">'.date('M j, Y',strtotime($row->m_date)).' - '.$row->m_type.' -<em>'.$row->user_fullname.'</em></a></p> ';
			}
			$data['w_meeting'] = $y_meeting_text;								
								 
			
			$w_recommend_sql = "SELECT user_fullname, rec_text, rec_dateadded FROM recommendation as ov
								LEFT OUTER JOIN users ON users.user_id = ov.user_id
								WHERE (rec_weekending = '".$current_weekending."') ".$_where."
								 ORDER BY user_fullname ASC
								";
			 

			$y_recommend_res = $this->db->query($w_recommend_sql)->result();
			$y_recommend_text = '';
			foreach( $y_recommend_res as $row ){ 
				$y_recommend_text .='<p><a href="javascript:void(0)" onclick="Common.showRecommendation(this)" title="'.htmlspecialchars('<strong>'.$row->user_fullname.'<br />'.$row->rec_dateadded.'</strong><hr/><br />'.$row->rec_text).'">'.$row->user_fullname.'</a></p>';
			}
			$data['w_recommend'] = $y_recommend_text;			
		
		}
		
		if( $type == 'year' ){
			$_where = '';
			
			/* if( $this->user_access == 3 ){
				$_where .= " AND ov.dept_id = $this->dept_id AND ov.user_id = $this->user_id ";
			}elseif( $this->user_access == 2){			
				if( @$this->input->post('members_search2') != '' ){
					$_where .= ' AND ov.user_id = '.$this->input->post('members_search2');
				}
			}else{
				
				if( @$this->input->post('department_search2') != '' ){
					$_where .= ' AND ov.dept_id = '.$this->input->post('department_search2');
				}		
				if( @$this->input->post('members_search2') != '' ){
					$_where .= ' AND ov.user_id = '.$this->input->post('members_search2');
				}
			} */
			 
				
			if( @$this->input->post('department_search2') != '' ){
				$_where .= ' AND ov.dept_id = '.$this->input->post('department_search2');
			}		
			if( @$this->input->post('members_search2') != '' ){
				$_where .= ' AND ov.user_id = '.$this->input->post('members_search2');
			}			 
			
			$prev_weekending_mon =  $this->input->post('weekending_start');
			$prev_weekending_sun =  $this->input->post('weekending_end');		
		
			$y_call_sql = "SELECT COUNT(*) as num FROM calllog as ov WHERE (call_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun') ".$_where;
			$data['y_call'] = '<a href="javascript:void(0)" onclick="Overview.viewCalls();" >'.$this->db->query($y_call_sql)->row()->num.'</a>';
		
			
			
			$y_meeting_sql = "SELECT m_id, m_date, m_type, user_fullname 
								FROM meeting as ov 
								LEFT OUTER JOIN users ON users.user_id = ov.user_id
								WHERE (m_weekending BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun') ".$_where."
								 ORDER BY m_date ASC
								";
								//(m_date BETWEEN DATE_ADD(m_weekending, INTERVAL -6 DAY) AND m_weekending ) AND 
			$y_meeting_res = $this->db->query($y_meeting_sql)->result();
			$y_meeting_text = '';
			foreach( $y_meeting_res as $row ){
				$y_meeting_text .= '<p><a href="javascript:void(0)" onclick="Common.showMeeting(this)">'.date('M j, Y',strtotime($row->m_date)).' - '.$row->m_type.' -<em>'.$row->user_fullname.'</em></a></p> ';
			}
			$data['y_meeting'] = $y_meeting_text;
			
			$y_evg_sql = "SELECT user_fullname, 
					ROUND((SUM(IF(m_type='Individual Meeting', 1, 0)) / 15) * 100, 2)  AS 'individual',
					ROUND((SUM(IF(m_type='Group Meeting', 1, 0)) / 15)*100, 2) AS 'group' 
					FROM meeting as ov 
					LEFT OUTER JOIN users ON users.user_id  = ov.user_id
					WHERE (m_weekending BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun') ".$_where.
					" GROUP BY ov.user_id
					  ORDER BY user_fullname ASC	
					";		
			echo $y_evg_sql;
					//(m_date BETWEEN DATE_ADD(m_weekending, INTERVAL -6 DAY) AND m_weekending ) AND 
			$y_evg_res = $this->db->query($y_evg_sql)->result();	
			$y_evg_text = '';			
			foreach( $y_evg_res as $row ){
				$y_evg_text .= '<p>'.$row->user_fullname.' - '.$row->individual.'% - '.$row->group.'% </p> ';
			}			
			$data['y_evg'] = $y_evg_text;		
			
			$y_recommend_sql = "SELECT user_fullname, rec_text, rec_dateadded 
								FROM recommendation as ov
								LEFT OUTER JOIN users ON users.user_id = ov.user_id
								WHERE (rec_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun') ".$_where."
								ORDER BY user_fullname ASC
								";
		 
			$y_recommend_res = $this->db->query($y_recommend_sql)->result();
			$y_recommend_text = '';
			foreach( $y_recommend_res as $row ){ 
				$y_recommend_text .='<p><a href="javascript:void(0)" onclick="Common.showRecommendation(this)" title="'.htmlspecialchars('<strong>'.$row->user_fullname.'<br />'.$row->rec_dateadded.'</strong><hr/><br />'.$row->rec_text).'">'.$row->user_fullname.'</a></p>';
			}
			$data['y_recommend'] = $y_recommend_text;		
		}
		echo json_encode($data);
	}
	
	public function searchy2doverview(){
	
	}
	 
	
	public function calllog(){
	
		//$data['group_departments_member'] = $this->dropdowns->group_departments_member();
		$data['department'] = $this->dropdowns->departments();
		$data['center'] = $this->dropdowns->centers();
		$data['calltype'] = $this->dropdowns->calltypes();
		$data['calltypes_sub'] = $this->dropdowns->calltypes_sub();
		$data['weekending'] = $this->dropdowns->weekending(); 
		$data['members'] = $this->dropdowns->members_department($this->dept_id); 
		
		$this->load->view('header');
		$this->load->view('calllog', $data);
		$this->load->view('footer');
	}
	
	public function calllogedit(){
	
		$result = $this->db->get_where( 'calllog', array('call_id'=>$this->uri->segment(2)) );
		$data['row'] = $result->row();		
		$cur_week 		= date("Y-m-d", strtotime("next Sunday") );
		
		if( $this->config->item('calls_extension') ){ 
			//$cur_week 		= date("Y-m-d", strtotime("last Sunday") );
			$cur_week 		= $this->config->item('back_to_this_date');
		}
		
		if( $this->config->item('calls_extension') ){
			
			if( $result->num_rows() > 0 AND ( $data['row']->call_weekending >= $cur_week) ){
			
				$data['department'] = $this->dropdowns->departments();
				$data['center'] = $this->dropdowns->centers();
				$data['calltype'] = $this->dropdowns->calltypes();
				$data['calltypes_sub'] = $this->dropdowns->calltypes_sub();
				$data['weekending'] = $this->dropdowns->weekending(); 
				//$data['members'] = $this->dropdowns->members_department($this->dept_id); 
								 
				$this->load->view('header');
				$this->load->view('calllog_edit', $data);
				$this->load->view('footer');			
			}

		}else{	
		
			if( ( ($result->num_rows() > 0) AND ($data['row']->call_weekending == $cur_week) ) OR $this->user_access == 1 ){
			
				$data['department'] = $this->dropdowns->departments();
				$data['center'] = $this->dropdowns->centers();
				$data['calltype'] = $this->dropdowns->calltypes();
				$data['calltypes_sub'] = $this->dropdowns->calltypes_sub();
				$data['weekending'] = $this->dropdowns->weekending(); 
				//$data['members'] = $this->dropdowns->members_department($this->dept_id); 
								 
				$this->load->view('header');
				$this->load->view('calllog_edit', $data);
				$this->load->view('footer');
			
			}else{
				redirect(base_url().'calllog#box');
			}		
		
		}
		 
	}	
	
	public function calllog_submit(){
		
		$json = array('status'=>false, 'msg'=>"");
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('weekending', 'Weekending', 'required|callback_check_call_morethan_weekending['.$this->input->post('ftype').']');
		
		 
		//$this->form_validation->set_rules('department', 'Department', 'required|callback_check_call_morethan_weekending['.$this->input->post('weekending').']');
		 
		
		//$this->form_validation->set_rules('u_user', 'Member', 'callback_check_call_morethan_weekending['.$this->input->post('weekending').']');
		$this->form_validation->set_rules('avaya', 'Avaya', 'trim');
		$this->form_validation->set_rules('center', 'Center', 'trim');
		$this->form_validation->set_rules('contact', 'Contact', 'trim');
		$this->form_validation->set_rules('min', 'MIN', 'trim');
		$this->form_validation->set_rules('esn', 'ESN / IMEI / MEID', 'trim');
		$this->form_validation->set_rules('calltype', 'Calltype', 'trim');
		$this->form_validation->set_rules('calltypes_sub', 'Call Type Subcategory', 'trim');
		$this->form_validation->set_rules('calldetails', 'Call Details', 'required');
		
		if( $this->form_validation->run() ){
			
			//$dn = explode(':',$this->input->post('department'));
			
							
			
			$set['call_weekending'] = date('Y-m-d', strtotime($this->input->post('weekending')));	
			$set['avaya'] 			= $this->input->post('avaya');	
			$set['center'] 			= $this->input->post('center');	
			$set['contact'] 		= $this->input->post('contact');	
			$set['call_min'] 		= $this->input->post('min');	
			$set['call_esn'] 		= $this->input->post('esn');	
			$set['call_type'] 		= $this->input->post('calltype');	
			$set['call_subtype'] 	= $this->input->post('calltypes_sub');	
			$set['call_details'] 	= $this->input->post('calldetails');	
			
			/* if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
				$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip_address = $_SERVER['REMOTE_ADDR'];
			} */			
			
			$set['call_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
			
			if( $this->input->post('ftype') == 'new')	{
				if( $this->config->item('calls_extension') ){
					if( $this->dropdowns->getWeekendingondate1(date("Y-m-d")) != $set['call_weekending'] ){
						$set['call_dateadded'] 	= $set['call_weekending'];	
					}
				}						
				$set['user_id'] 		= $this->user_id;
				$set['dept_id'] 		= $this->dept_id;
				
				if( $this->db->insert('calllog', $set) ){
					$json['status'] = true;
					$json['msg']	= 'Successfully Save';
					$json['ftype']  = 'new';
				}
				
			}else{	
				 
				$set['call_updatedby'] 		= $this->user_id; 
				$set['call_dateupdated'] 	= date('Y-m-d H:i:s');	
				
				if( $this->config->item('calls_extension') ){
					$set['call_dateadded'] 	= $this->input->post('call_dateadded');	
				}
				
				$this->db->where("call_id",$this->input->post('f_id'));
				
				if( $this->db->update('calllog', $set) ){
					$json['status'] = true;
					$json['msg']	= 'Update Successfully Save';
					$json['ftype']  = 'edit';
				}			
			}
			
		}else{
			$json['status']		=  false;
			$json['msg'] 		= validation_errors();
		}
		
		echo json_encode($json);
	}
	
	public function check_call_morethan_weekending($weekending, $ftype){
		//echo $ftype;
		$weekending = date('Y-m-d', strtotime($weekending));
		if( $ftype == 'new' ){
		 
			$sql = "SELECT COUNT(*) AS num FROM calllog WHERE call_weekending = '".$weekending."' AND user_id = ".$this->user_id;
			//echo $sql ; 
			$res = $this->db->query($sql)->row()->num;
			if( $res < 25 ){
				return TRUE;
			}else{
				$this->form_validation->set_message('check_call_morethan_weekending', 'Max of 25 calls logged per person per week' );
				return FALSE;
			}
		}else{
			return TRUE;
		}
		 
	}	
	
	public function ajax_calllog_listing(){
		
		$this->load->model('Calls');	
		$this->Calls->getlist($this->user_id, $this->dept_id, $this->user_access);
	}	

	public function meeting(){
		
		//$data['group_departments_member'] = $this->dropdowns->group_departments_member();
		$data['department'] = $this->dropdowns->departments();
		$data['weekending'] = $this->dropdowns->weekending(); 
		$data['members'] 	= $this->dropdowns->members_department($this->dept_id); 
		
		$this->load->view('header');
		$this->load->view('meeting', $data);
		$this->load->view('footer');
	}
	
	public function downloadcalls(){ 
	 
		
		if( isset($_GET['date_from_search']) ) {
			$this->db->where(' DATE_FORMAT(call_dateadded, \'%Y-%m-%d\') BETWEEN ', "'".$_GET['date_from_search']."' AND '".$_GET['date_to_search']."'", false); 
		}
		
		if( isset($_GET['department_search']) AND $_GET['department_search']!=''){
			$this->db->where('department.dept_id', $_GET['department_search']);
		}
		
		if( isset($_GET['members_search']) AND $_GET['members_search'] != ''){
			$this->db->where('users.user_id', $_GET['members_search']);
		}
		
		$this->db->select('call_dateadded, users.user_fullname, department.dept_desc, avaya, center, contact, call_min, call_esn, call_type, call_subtype, call_details'); 	
		$this->db->join('users', 'users.user_id = calllog.user_id', 'LEFT OUTER');
		$this->db->join('department', 'department.dept_id = calllog.dept_id', 'LEFT OUTER');
		$records = $this->db->get('calllog')->result(); 
		 
		$this->load->library('ExportDataExcel'); 
		//echo $this->db->last_query();
		 			 
		$excel = new ExportDataExcel('browser');
		$excel->filename = 'monitoring_calls_'.strtotime('now').".xls";

		$header = array('Date', 'Name', 'Department', 'PBX ID', 'Center', 'Contact ID', 'MIN', 'ESN / IMEI / MEID', 'Calltype', 'Call Type Subcategory', 'Call Details'); 
		$excel->initialize();
		$excel->addRow($header);
		foreach($records as $row) {
			$excel->addRow($row);
		}
		$excel->finalize();
		
	}	
	
	public function meetingedit(){
		
		$result = $this->db->get_where( 'meeting', array('m_id'=>$this->uri->segment(2)) );
		$data['row'] 	= $result->row();		
		
		if( $this->config->item('calls_extension') ){ 
			//$cur_week 		= date("Y-m-d", strtotime("last Sunday") );				
			$cur_week 		= $this->config->item('back_to_this_date');
		}else{
			$cur_week 		= date("Y-m-d", strtotime("next Sunday") );				
		}
		
		
		if( $this->config->item('calls_extension') ){
			
			if( $result->num_rows() > 0 AND ( $data['row']->m_weekending >= $cur_week) ){ 
			  
				$data['department'] = $this->dropdowns->departments();
				$data['weekending'] = $this->dropdowns->weekending(); 
				$data['members'] 	= $this->dropdowns->members_department($this->dept_id); 
				//$data['row']		= $result->row();
				
				$this->load->view('header');
				$this->load->view('meeting_edit', $data);
				$this->load->view('footer');
			
			}else{
				redirect(base_url().'meeting#box');
			}		
		
		}else{
		
			if( ( ($result->num_rows() > 0) AND ($data['row']->m_weekending == $cur_week) ) OR $this->user_access == 1 ){
			
				$data['department'] = $this->dropdowns->departments();
				$data['weekending'] = $this->dropdowns->weekending(); 
				$data['members'] 	= $this->dropdowns->members_department($this->dept_id); 
				//$data['row']		= $result->row();
				
				$this->load->view('header');
				$this->load->view('meeting_edit', $data);
				$this->load->view('footer');
			
			}else{
				redirect(base_url().'meeting#box');
			}		
		
		}
		

	}	
	
	public function meeting_submit(){
		
		$json = array('status'=>false, 'msg'=>"");
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('weekending', 'Weekending', 'required|callback_check_meeting_morethan_weekending['.$this->input->post('ftype').']');
		//$this->form_validation->set_rules('department', 'Department', 'required');
		//$this->form_validation->set_rules('department', 'Department', 'required|callback_check_meeting_morethan_weekending['.$this->input->post('weekending').']');
		//$this->form_validation->set_rules('members', 'Name', 'required');
		$this->form_validation->set_rules('mettingname', 'Meeting Name', 'required');
		$this->form_validation->set_rules('meetingdate', 'Meeting Date', 'required');
		$this->form_validation->set_rules('meetingtype', 'Type', 'required');
		$this->form_validation->set_rules('attendees', 'Attendees', 'xss_clean');
		$this->form_validation->set_rules('notes', 'Notes', 'trim|xss_clean');
		$this->form_validation->set_rules('actionitems', 'Action Items', 'trim|xss_clean');
		
		if( $this->form_validation->run() ){
			//$dn = explode(':',$this->input->post('department')); 
			
			$set['m_weekending'] 	= date('Y-m-d', strtotime($this->input->post('weekending')));	
			$set['m_title'] 		= $this->input->post('mettingname');	
			$set['m_type'] 			= $this->input->post('meetingtype');	
			$set['m_date'] 			= $this->input->post('meetingdate');	
			$set['m_attend'] 		= $this->input->post('attendees');	
			$set['m_no_attend'] 	= $this->input->post('attendees_count');	
			$set['m_notes'] 		= $this->input->post('notes');	
			$set['m_action_items'] 	= $this->input->post('actionitems');			 
			$set['m_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
			 
			/* if( $this->db->insert('meeting', $set) ){
				$json['status'] = true;
				$json['msg']	= 'Successfully Save';
			} */
			
			if( $this->input->post('ftype') == 'new')	{
				if( $this->config->item('meeting_extension') ){
					if( $this->dropdowns->getWeekendingondate1(date("Y-m-d")) != $set['m_weekending'] ){
						$set['m_dateadded'] 	= $set['m_weekending'];	
					}
				}				
				$set['user_id'] 			= $this->user_id;	
				$set['dept_id'] 			= $this->dept_id;			
				
				if( $this->db->insert('meeting', $set) ){
					$json['status'] 		= true;
					$json['msg']			= 'Successfully Save';
					$json['ftype']  		= 'new';
				}
				
			}else{	
				
				$set['m_updatedby'] 		= $this->user_id;	
				$set['m_updated'] 			= date('Y-m-d H:i:s');	
				
				if( $this->config->item('meeting_extension') ){
					$set['m_dateadded'] 	= $this->input->post('m_dateadded');			
				}
				
				$this->db->where("m_id", $this->input->post('f_id'));				
				if( $this->db->update('meeting', $set) ){
					$json['status'] 		= true;
					$json['msg']			= 'Update Successfully Save';
					$json['ftype']  		= 'edit';
				}			
			}			
			
		}else{
			$json['status']		=  false;
			$json['msg'] 		= validation_errors();
		}
		
		echo json_encode($json);
	}	

	public function check_meeting_morethan_weekending($weekending,$ftype){
		
		//$dn = explode(':',$dept);
		$weekending = date('Y-m-d', strtotime($weekending));
		if( $ftype == 'new' ){
			$sql = "SELECT COUNT(*) AS num FROM meeting WHERE m_weekending = '".$weekending."' AND user_id = ".$this->user_id;
			$res = $this->db->query($sql)->row()->num;
			if( $res < 1 ){
				return TRUE;
			}else{
				$this->form_validation->set_message('check_meeting_morethan_weekending', 'Allowed only 1 meeting held with center group/individual per week' );
				return FALSE;
			}
		}else{
			return TRUE;
		}
		 
	}		
	
	public function ajax_meeting_listing(){
		
		$this->load->model('Meetings');
		
		$this->Meetings->getlist($this->user_id, $this->dept_id, $this->user_access);
	}	
	
	public function recommendations(){
		
		$data['members_to_be_forwarded'] = $this->dropdowns->members_to_be_forwarded();
		$data['department'] = $this->dropdowns->departments();
		$data['weekending'] = $this->dropdowns->weekending(); 
		$data['members'] = $this->dropdowns->members_department($this->dept_id); 
		
		$this->load->view('header');
		$this->load->view('recommendations', $data);
		$this->load->view('footer');
	}	
	
	public function recommendationsedit(){
		
		$result = $this->db->get_where( 'recommendation', array('rec_id'=>$this->uri->segment(2)) );
		$data['row'] 	= $result->row();		
		
		if( $this->config->item('meeting_extension') ){
			//$cur_week 		= date("Y-m-d", strtotime("last Sunday") );	
			$cur_week 		= $this->config->item('back_to_this_date');
		}else{
			$cur_week 		= date("Y-m-d", strtotime("next Sunday") );	
		}
		
		if( $this->config->item('recommend_extension') ){		
			if( $result->num_rows() > 0 AND ( $data['row']->rec_weekending >= $cur_week) ){ 
			
				$data['department'] = $this->dropdowns->departments();
				$data['weekending'] = $this->dropdowns->weekending(); 
				$data['members'] 	= $this->dropdowns->members_department($this->dept_id); 
				//$data['row']		= $result->row();
				
				$this->load->view('header');
				$this->load->view('recommendations_edit', $data);
				$this->load->view('footer');
			}else{
				redirect(base_url().'recommendations');
			}
		}else{
			if( ($result->num_rows() > 0) AND ($data['row']->rec_weekending == $cur_week) OR $this->user_access == 1 ){			 
				$data['department'] = $this->dropdowns->departments();
				$data['weekending'] = $this->dropdowns->weekending(); 
				$data['members'] 	= $this->dropdowns->members_department($this->dept_id); 
				//$data['row']		= $result->row();
				
				$this->load->view('header');
				$this->load->view('recommendations_edit', $data);
				$this->load->view('footer');
			}else{
				redirect(base_url().'recommendations');
			}
		
		}
	}
	
	public function recommend_submit(){
		
		$json = array('status'=>false, 'msg'=>"");
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('weekending', 'Weekending', 'required|callback_check_recommend_morethan_weekending['.$this->input->post('ftype').']');
		//$this->form_validation->set_rules('department', 'Department', 'required');
		//$this->form_validation->set_rules('members', 'Name', 'required');
		//$this->form_validation->set_rules('department', 'Department', 'required|callback_check_recommend_morethan_weekending['.$this->input->post('weekending').']');
		$this->form_validation->set_rules('recommend', 'Your Recommendation', 'required|xss_clean'); 
		
		if( $this->form_validation->run() ){
			
			//$dn = explode(':',$this->input->post('department'));
			

			$set['rec_weekending']  = date('Y-m-d', strtotime($this->input->post('weekending')));		
			$set['rec_text'] 		= $this->input->post('recommend');	 			 
			$set['rec_ipaddress'] 	= $_SERVER['REMOTE_ADDR'];
			 
			/* if( $this->db->insert('recommendation', $set) ){
				$json['status'] = true;
				$json['msg']	= 'Successfully Save';
			} */
			
			if( $this->input->post('ftype') == 'new')	{
				if( $this->config->item('recommend_extension') ){
					if( $this->dropdowns->getWeekendingondate1(date("Y-m-d")) != $set['rec_weekending'] ){
						$set['rec_dateadded'] 	= $set['rec_weekending'];	
					}
				}				
				$set['user_id'] 		= $this->user_id;	
				$set['dept_id'] 		= $this->dept_id;	
				
				$forward = '';
				
				if( $this->input->post('forwardedto') != '' ){
				
					$forward = $this->db->get_where('users', array('user_id'=>$this->input->post('forwardedto') ))->row();
					$set['isforwarded'] 	= 1;
					$set['forwardTo'] 		= $this->input->post('forwardedto');			
					$set['forwardName'] 	= $forward->user_fullname;				
					$set['forwardDate'] 	= date("Y-m-d H:i:s");

						 
				}				
				
				if( $this->db->insert('recommendation', $set) ){
				
				 
				
					$json['status'] = true;
					$json['msg']	= 'Successfully Save';
					$json['ftype']  = 'new';
					
					if( $this->input->post('forwardedto') != '' ){
						
						$set['user_id'] 		= $this->input->post('forwardedto');	
						$set['dept_id'] 		= $forward->dept_id;	
						$set['isforwarded'] 	= 1;
						$set['forwardTo'] 		= '';
						$set['forwardName'] 	= '';	
						$set['forwardBy'] 		= $this->user_id;			
						$set['forwardByName'] 	= $this->user_fullname;				
						$set['forwardDate'] 	= date("Y-m-d H:i:s");
						 
						$this->db->insert('recommendation', $set);
						 
						$this->load->library('email');
						 
						$config['protocol']		= 'smtp';
						$config['smtp_host'] 	= 'mail.qualfon.com';
						//$config['smtp_host'] 	= 'smtp.tracfone.com';
						//$config['smtp_host'] 	= 'miacas1.tracfone.wireless.ad'; 
						$config['smtp_user'] 	= 'croda';
						$config['smtp_pass'] 	= 'Heartbeat1!'; 
						$config['smtp_port'] 	= '25';
						$config['mailtype'] 	= 'text';
						$config['validate'] 	= true;
						$config['newline']    	= "\r\n";		 
						$config['charset'] 		= 'iso-8859-1';
						$config['wordwrap'] 	= TRUE;
						
						$this->email->initialize($config);	
						
						$this->email->from('no-reply-agentsupport-monitoring-log@tracfone.com', 'Agentsupport Monitoring Log');
						//$this->email->to($forward->user_email);
						$this->email->to('croda@qualfon.com');
						/* $this->email->cc('another@another-example.com'); */
						//$this->email->bcc('croda@qualfon.com');

						$this->email->subject('Recommendation Forwarded');
						
						
						$sender = $this->db->get_where('users', array('user_id'=>$this->user_id ))->row();
						
						
						$message = "From: {$sender->user_fullname}\n\n";
						$message .= "Recommendation: ".$this->input->post('recommend')."\n\n";
						$message .= "\n\nSent via Agent Support Monitoring Log";
						
						$this->email->message($message);

						$this->email->send();	

					}	
				}
				
			}else{	
				
				$set['rec_updatedby'] 	= $this->user_id;	
				$set['rec_updated'] 	= date('Y-m-d H:i:s');	

				if( $this->config->item('recommend_extension') ){
					$set['rec_dateadded'] 	= $this->input->post('rec_dateadded');	
				}
						
				$this->db->where("rec_id", $this->input->post('f_id'));
				
				if( $this->db->update('recommendation', $set) ){
					$json['status'] = true;
					$json['msg']	= 'Update Successfully Save';
					$json['ftype']  = 'edit';
				}			
			}			
			
		}else{
			$json['status']		=  false;
			$json['msg'] 		= validation_errors();
		}
		
		echo json_encode($json);
	}		
	
	public function check_recommend_morethan_weekending($weekending, $ftype){
		
		$weekending = date('Y-m-d', strtotime($weekending));	
		if( $ftype == 'new' ){
		
			$sql = "SELECT COUNT(*) AS num FROM recommendation WHERE forwardTo > 0 AND rec_weekending = '".$weekending."' AND user_id = ".$this->user_id;
			
			$res = $this->db->query($sql)->row()->num;
			if( $res < 1 ){
				return TRUE; 
					
			}else{
				$this->form_validation->set_message('check_recommend_morethan_weekending', 'Allowed only 1 recommendation logged per week' );
				RETURN FALSE;
			}
		}else{
			return TRUE;
		}
		
		 
	}	
	
	public function ajax_recommend_listing(){
		
		$this->load->model('Recommendations');
		
		$this->Recommendations->getlist($this->user_id, $this->dept_id, $this->user_access);
	}
	
	public function ajax_recommend_overview_search(){
		
		$this->load->model('Recommendations');
		
		$this->Recommendations->getlist2($this->user_id, $this->dept_id, $this->user_access);
	}
	
	public function recommendation_forward_form(){
		
		$this->db->where("rec_id", $this->uri->segment(3));	
		$data['row'] = $this->db->get('recommendation')->row();
		//echo $this->db->last_query();
		
		$this->load->view('recommendation_forward_form', $data);
	}
	
	public function reports(){
	
		$data['department'] = $this->dropdowns->departments();
		//$data['calltype'] = $this->dropdowns->calltypes();	
		
		$this->load->view('header');
		$this->load->view('reports', $data);
		$this->load->view('footer');
	}	
		
	public function ajax_dropdowns(){
	
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		
		/* if( $type == 'dept' ){
			echo json_encode($this->dropdowns->members_department($id));
		} */
		
		switch($type){
			case 'gdm':
				echo json_encode($this->dropdowns->members_department($id));
				break;
			case 'gsct':	
				echo json_encode($this->dropdowns->calltypes_sub($id));
			default:	
				break;
		}
		
	}
	
	public function logout(){
		$this->session->unset_userdata('islogin');
		$this->session->unset_userdata('access');
		$this->session->sess_destroy();
		
		redirect(base_url());
	}
	
	public function viewdetails(){
	
		$tab = $this->input->post('tab');
		$id = $this->input->post('id');
		
		$sql = '';
		switch($tab){
			case 'call':
				$sql = "SELECT DATE_FORMAT(call_dateadded,'%b %d, %Y %r') as 'Date',
							DATE_FORMAT(call_weekending, '%a %b %d, %Y') as 'Weekending',
							dept_desc as 'Department', 
							user_fullname as 'Name', 
							avaya as 'PBX ID', 
							center as 'Center', 
							contact as 'Contact ID', 
							call_min as 'MIN', 
							call_esn as 'ESN / IMEI / MEID', 
							call_type as 'Call Type', 
							call_subtype as 'Call Type Subcategory', 
							call_details as 'Call Details'
						FROM calllog
						LEFT OUTER JOIN department ON department.dept_id = calllog.dept_id
						LEFT OUTER JOIN users ON users.user_id =calllog.user_id
						WHERE call_id=".$id;
					break;
			case 'meeting':
			  	
				$sql = "SELECT DATE_FORMAT(m_dateadded,'%b %d, %Y %r') as 'Date Added', 
							DATE_FORMAT(m_weekending, '%a %b %d, %Y') as 'Weekending',
							dept_desc as 'Department', 
							user_fullname as 'Name', 
							m_title as 'Meeting Name',  
							m_type as 'Meeting Type', 
							DATE_FORMAT(m_date, '%a %b %d, %Y') as 'Meeting Date',
							m_attend as 'Attendees',
							m_notes as 'Notes' 
							 
						FROM meeting
						LEFT OUTER JOIN department ON department.dept_id = meeting.dept_id
						LEFT OUTER JOIN users ON users.user_id = meeting.user_id
						WHERE m_id=".$id;
					break;
			case 'recommend':
			  	
				$sql = "SELECT DATE_FORMAT(rec_dateadded, '%b %d, %Y %r') as 'Date Added', 
							DATE_FORMAT(rec_weekending, '%a %b %d, %Y') as 'Weekending',
							dept_desc as 'Department', 
							user_fullname as 'Name', 
							rec_text as 'Recommendation',
							if( forwardTo > 0, 'Forwarded To', 'Forwarded By' ) as 'Forward',
							if( forwardTo > 0, forwardName, forwardByName )	as 'Forward Name'
						FROM recommendation
						LEFT OUTER JOIN department ON department.dept_id = recommendation.dept_id
						LEFT OUTER JOIN users ON users.user_id = recommendation.user_id
						WHERE rec_id=".$id;
					break;						
		}
		
		$data['rows'] = $this->db->query($sql )->row();
		
		$this->load->view('popup_template', $data, false);
	}
	
	public function viewCalls(){
		$_where = '';
		if( @$this->input->post('department_search2') != '' ){
			$_where .= ' AND ov.dept_id = '.$this->input->post('department_search2');
		}		
		if( @$this->input->post('members_search2') != '' ){
			$_where .= ' AND ov.user_id = '.$this->input->post('members_search2');
		}			 
		
		$prev_weekending_mon =  $this->input->post('weekending_start');
		$prev_weekending_sun =  $this->input->post('weekending_end');	
		
		$y_call_sql = "SELECT user_fullname, COUNT(*) AS num  FROM calllog as ov 
						LEFT OUTER JOIN users ON users.user_id = ov.user_id
						WHERE (call_weekending  BETWEEN '$prev_weekending_mon' AND '$prev_weekending_sun') ".$_where."
						GROUP BY user_fullname
						ORDER BY user_fullname ASC
						";
		 
		$result = $this->db->query($y_call_sql)->result();		
		
		$msg = '';
		foreach( $result as $row){
			$msg .= '<p><span style="width:200px; float:left">'.$row->user_fullname.'</span>  '.$row->num.'</p>';		
		}
		
		$data['calls'] = $msg;
		
		echo json_encode($data);
	}

 	public function accounts(){
		if( $this->user_id == 34 OR $this->user_id == 14 ){
		
		$data['list'] = $this->db->get_where('users', array('user_active'=>1, 'user_access'=>3))->result();
		
		$this->load->view('header');
		$this->load->view('accounts', $data);
		$this->load->view('footer');
		
		}else{
			redirect(base_url().'overview');
		}
	}
	
	public function ajax_accounts_listing(){
	
		
		$this->load->model('Account');
		
		$this->Account->getlist();
		
	}
	
	public function ajax_accounts_editable(){
		
		//$set['user_pass']
		
	}
	
	public function ajax_y2dOverview(){
		
		$array = array();
	 
		$this->db->order_by('user_fullname','ASC' );
		$this->db->where('user_show', 1); 
		$this->db->where('user_active', 1); 
		if( isset($_POST['department_search']) AND $_POST['department_search'] > 0 ){ $this->db->where('dept_id', $this->input->post('department_search'));  }				
		if( isset($_POST['members_search']) AND $_POST['members_search'] > 0 ){ $this->db->where('user_id', $this->input->post('members_search'));  }		
		$names = $this->db->get('users')->result();
		
		foreach( $names as $row ){
			$array[$row->user_id]['name'] = $row->user_fullname;
		}
		
	 
		$this->db->select(" calllog.user_id, COUNT(*) AS num ");
		if( isset($_POST['department_search']) AND $_POST['department_search'] > 0 ){ $this->db->where('calllog.dept_id', $this->input->post('department_search'));  }				
		if( isset($_POST['members_search']) AND $_POST['members_search'] > 0 ){ $this->db->where('calllog.user_id', $this->input->post('members_search'));  }
		if( isset($_POST['weekending_start']) AND isset($_POST['weekending_end'])){ $this->db->where('call_weekending BETWEEN ', "'{$this->input->post('weekending_start')}' AND '{$this->input->post('weekending_end')}'", FALSE );  }
		$this->db->group_by('user_id');	
		$this->db->where('users.user_active', 1); 
		$this->db->join('users', 'users.user_id = calllog.user_id');	
		$call = $this->db->get("calllog")->result();
		
		foreach( $call as $row ){
				$array[$row->user_id]['calls'] = $row->num;
		}
		
		 
		$this->db->select(" meeting.user_id, COUNT(*) AS num, SUM(IF(m_type='Individual Meeting', 1, 0))  AS 'individual', SUM(IF(m_type='Group Meeting', 1, 0)) AS 'group' ", FALSE);
		if( isset($_POST['department_search']) AND $_POST['department_search'] > 0 ){ $this->db->where('meeting.dept_id', $this->input->post('department_search'));  }				
		if( isset($_POST['members_search']) AND $_POST['members_search'] > 0 ){ $this->db->where('meeting.user_id', $this->input->post('members_search'));  }		
		if( isset($_POST['weekending_start']) AND isset($_POST['weekending_end'])){ $this->db->where('m_weekending BETWEEN ', "'{$this->input->post('weekending_start')}' AND '{$this->input->post('weekending_end')}'", FALSE );  }		
		$this->db->group_by('user_id');
		$this->db->where('users.user_active', 1); 
		$this->db->join('users', 'users.user_id = meeting.user_id');		
		$meeting = $this->db->get('meeting')->result();	
		
		foreach( $meeting as $row ){
				$array[$row->user_id]['meeting']['num'] = $row->num;
				$array[$row->user_id]['meeting']['individual'] = $row->individual;
				$array[$row->user_id]['meeting']['group'] = $row->group;
		}		
		
		$this->db->select(" recommendation.user_id, COUNT(*) AS num, user_fullname ");
		if( isset($_POST['department_search']) AND $_POST['department_search'] > 0 ){ $this->db->where('recommendation.dept_id', $this->input->post('department_search'));  }				
		if( isset($_POST['members_search']) AND $_POST['members_search'] > 0 ){ $this->db->where('recommendation.user_id', $this->input->post('members_search'));  }
		if( isset($_POST['weekending_start']) AND isset($_POST['weekending_end'])){ $this->db->where('rec_weekending BETWEEN ', "'{$this->input->post('weekending_start')}' AND '{$this->input->post('weekending_end')}'", FALSE );  }	
		$this->db->group_by('recommendation.user_id');
		$this->db->where('users.user_active', 1); 
		$this->db->where('(forwardBy IS NULL OR forwardBy = recommendation.user_id)', NULL, false);
		$this->db->join('users', 'users.user_id = recommendation.user_id');
		$recommend = $this->db->get('recommendation')->result();		
		
		foreach( $recommend as $row ){
			$array[$row->user_id]['recommend']['num'] = $row->num;
			$array[$row->user_id]['recommend']['name'] = $row->user_fullname;
		}

		$tr = '';
		$i = 1;	
		$total = array('c'=>0, 'm'=>0, 'r'=>0, 'mi'=>0, 'mg'=>0);
		foreach( $array as $key=>$val ){
			
			$tr .= '<tr> 
					<td style="text-align:left; x"><h4 style="padding-left: 20p">'.$i.'. &nbsp;&nbsp;'.@$val['name'].'</h4></td>
					<td style="text-align:center">'.@$val['calls'].'</td>
					<td style="text-align:center">'.@$val['meeting']['num'].'</td>
					<td style="text-align:center">'.@(($val['meeting']['individual'] > 0)?$val['meeting']['individual']:'').'</td>
					<td style="text-align:center">'.@(($val['meeting']['group'] > 0)?$val['meeting']['group']:'').'</td> 
					<td style="text-align:center"><a href="recommendationslist/#'.@$val['recommend']['name'].'">'.@$val['recommend']['num'].'</a></td>
				</tr>';	
				
				$total['c'] += @$val['calls'];
				$total['m'] += @$val['meeting']['num'];
				$total['mi'] += @(($val['meeting']['individual'] > 0)?$val['meeting']['individual']:0);
				$total['mg'] += @(($val['meeting']['group'] > 0)?$val['meeting']['group']:0); 				
				$total['r'] += @$val['recommend']['num'];
				
			$i++;
		}
		
		$tr .= '<tr style="color:red; font-weight:bold; border-top:2px solid #375B91"> 
				<td style="text-align:left; text-align:center"> Total</td>
				<td style="text-align:center">'.@$total['c'].'</td>
				<td style="text-align:center">'.@$total['m'].'</td>
				<td style="text-align:center">'.@$total['mi'].'</td>
				<td style="text-align:center">'.@$total['mg'].'</td> 
				<td style="text-align:center">'.@$total['r'].'</td>
			</tr>';			
		
		$json['tr'] = $tr;
		
		echo  json_encode($json);
		
	}
	

	
	public function reclist(){
	
	
		$this->db->select('user_fullname');
		$this->db->order_by('user_fullname','ASC' );
		$this->db->where('user_show', 1);  	
		$this->db->where('user_active', 1);  	
		$data['names'] = $this->db->get('users')->result();

		
		$sql = "SELECT recommendation.user_id, rec_id, user_fullname, rec_weekending, rec_text, isforwarded, forwardTo, forwardName, forwardByName, forwardBy 
				FROM recommendation
				LEFT OUTER JOIN users ON users.user_id = recommendation.user_id
				WHERE user_active = 1
				ORDER BY user_fullname ASC, rec_weekending ASC ";
		
		$res = $this->db->query($sql)->result();
		
		$rec_array = array();
		$rec_count = array();
		
		foreach($res as $row){ 
		
			$x = '';
			if( $row->forwardBy =='' OR $row->forwardBy == $row->user_id ){
				if( isset($rec_count[$row->user_id]) ){
					$rec_count[$row->user_id] += 1;
				}else{
					$rec_count[$row->user_id] = 1;
				}
				$x = $rec_count[$row->user_id];
			}
			
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['count'] = $x;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['own'] = ($row->forwardBy =='' OR $row->forwardBy == $row->user_id)?true:false;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['txt'] = $row->rec_text;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['isforwarded'] = $row->isforwarded;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['forwardTo'] = $row->forwardTo;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['forwardName'] = $row->forwardName;
			$rec_array[$row->user_fullname][$row->rec_weekending.'#'.$row->rec_id]['forwardByName'] = $row->forwardByName;
		}
		
		$data['results']  = $rec_array;
		
		$this->load->view('header');
		$this->load->view('overview_rec', $data);
		$this->load->view('footer');	 
	}
	
	public function downloadrecommendation(){
	
		$this->db->select('user_fullname');
		$this->db->order_by('user_fullname','ASC' );
		$this->db->where('user_show', 1);  	
		$data['names'] = $this->db->get('users')->result();

		
		$sql = "SELECT user_fullname, rec_weekending, rec_text, forwardName, forwardByName 
				FROM recommendation
				LEFT OUTER JOIN users ON users.user_id = recommendation.user_id
				WHERE user_active = 1
				ORDER BY user_fullname ASC, rec_weekending ASC";
		
		$records = $this->db->query($sql)->result();

		$this->load->library('ExportDataExcel'); 
		
					 
		$excel = new ExportDataExcel('browser');
		$excel->filename = strtotime('now').".xls";

		$header = array('Name', 'Weekending', 'Recommendation', 'Forwarded To', 'Forwarded By'); 
		$excel->initialize();
		$excel->addRow($header);
		foreach($records as $row) {
			$excel->addRow($row);
		}
		$excel->finalize();		
	}

	public function searchrecommendation(){
		
		$data = '';
		$data['madeby'] = $this->dropdowns->members_all(); 
		$data['forwardeto'] = $this->dropdowns->members_to_be_forwarded(); 
		$this->load->view('header');
		$this->load->view('recommendations_search', $data);
		$this->load->view('footer');		
	}
	
	public function ajax_subcalltype(){
		
		$json = array('status'=>false, 'list'=>'');		
		
		$ct = $this->input->post('ct');
		$ssc = $this->input->post('ssc');
		
		$this->db->where('ct_desc', $ct );
		$this->db->join('calltype', 'calltype.ct_id = subcalltype.ct_id', 'LEFT OUTER');
		$result = $this->db->get('subcalltype');
		//echo $this->db->last_query();
		$options = '<option value=""> ---select---</option>';
		if( $result->num_rows() > 0 ){
			$json['status'] = true; 
			
			$result = $result->result();
			
			foreach($result as $row){
				$selected = '';
				if( $ssc != '' ) $selected = ($ssc == $row->sct_desc)?'selected="selected"' :'';
			
				$options .= '<option value="'.$row->sct_desc.'" '.$selected.'>'.$row->sct_desc.'</option>';
			}
			$json['list'] = $options;
		}
		
		echo json_encode($json);
		
	}	
	
}

/* End of file controller.php */
/* Location: ./application/controllers/controller.php */