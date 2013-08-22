<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public $user_id = '';
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function index(){	
		$data['group_departments_member'] = $this->dropdowns->group_departments_member();
		
		$this->load->view('header');
		$this->load->view('login', $data);
		$this->load->view('footer');		 
	}
	
	public function isLogin(){
		
		$json = array('status'=>false, 'msg'=>'');
		
		/* $gp		= explode(':', $this->input->post('department'));
		$dept 	= $gp[0];
		$user 	= $gp[1]; */		
		$login 	= $this->input->post('login');
		
		//$res = $this->db->query("SELECT user_id, user_pass, dept_id, user_access, user_fullname FROM users WHERE dept_id = $dept AND user_id = $user");
		//$res = $this->db->query("SELECT user_id, user_pass, dept_id, user_access, user_fullname FROM users WHERE dept_id = $dept AND user_id = $user");
		
		$this->db->where('user_pass', $login);
		$res = $this->db->get_where('users');
		
		$row = $res->row();
		
		if( ($res->num_rows > 0) AND strtolower($row->user_pass) == strtolower($login) ){
		 
			$json['status'] = true; 
			$this->session->set_userdata('islogin', TRUE);			
			$this->session->set_userdata('u_m_id', $row->user_id);			
			$this->session->set_userdata('u_access', $row->user_access);			
			$this->session->set_userdata('u_d_id', $row->dept_id);	
			$this->session->set_userdata('u_m_full', $row->user_fullname);	
			
		}else{
			$json['status'] = false;			
			$json['msg'] = 'Login Failed';	
		
		}
		
		/* if( $login == 'miamimonitor'){
			$json['status'] = true; 
			$this->session->set_userdata('islogin', TRUE);			
			$this->session->set_userdata('access', 1);			
		}elseif($login == 't0ba'){
			$json['status'] = true; 
			$this->session->set_userdata('islogin', TRUE);			
			$this->session->set_userdata('access', 1);			
		}else{
			$json['status'] = false;			
			$json['msg'] = 'Login Failed';			
		} */
		
		
		echo json_encode($json);
	
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */