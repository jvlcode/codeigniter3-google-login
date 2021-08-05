<?php 
	use Google\Client as GoogleClient;
	use Google\Service\Oauth2;
	class Home extends CI_Controller{
		
		public function __construct()
		{	
			parent::__construct();
			$this->load->database();
			$this->load->model('user_model');
			$this->load->helper('url');
			$this->load->library('session');
		}

		public function index(){
			$this->load->view('login_form');
		}

		public function login(){
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if($user = $this->user_model->getUser($email)){
				if($password == $user->password){
					$this->session->set_userdata('user',$user);
					redirect('home/dashboard');
				}else{
					$this->load->view('login_form',array('message'=>'Invalid Login Credentials!'));
				}
				
			}else{
				$this->load->view('login_form',array('message'=>'No account exists!'));
			}
		}

		public function dashboard(){
			if($this->session->has_userdata('user')){
				$user = $this->session->userdata('user');
				$this->load->view('home',array('user'=>$user));
			}else{
				redirect('home');
			}
			
		}
		public function logout(){
			$this->session->sess_destroy();
			redirect('home');
		}

		public function google_login(){
			$client = new GoogleClient();
			$client->setApplicationName('JVLcode Google Login');
			$client->setClientId('416748681329-e2t800u2qshvgvo0c6bteo69mtvat1rp.apps.googleusercontent.com');
			$client->setClientSecret('zAHNyYKFq-cjTkXEkYzsHby9');
			$client->setRedirectUri('http://localhost/codeigniter3/home/google_login');
			$client->addScope(['https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile']);
			if($code = $this->input->get('code')){
				$token = $client->fetchAccessTokenWithAuthCode($code);
				$client->setAccessToken($token);
				$oauth = new Oauth2($client);
				
				$user_info = $oauth->userinfo->get();
				$data['name'] = $user_info->name;
				$data['email'] = $user_info->email;
				$data['image'] = $user_info->picture;
				
				if($user = $this->user_model->getUser($user_info->email)){
					$this->session->set_userdata('user',$user);
				}else{
					$this->user_model->createUser($data);
				}
				
				redirect('home/dashboard');;


			}else{
			
				

				$url = $client->createAuthUrl();
				header('Location:'.filter_var($url,FILTER_SANITIZE_URL));
			}
			

			
		}

		
	}
