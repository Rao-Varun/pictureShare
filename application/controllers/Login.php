<?php
class Login extends CI_Controller{

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        if($this->session->has_userdata("email_id") and $this->session->has_userdata("logged_in") and $this->session->
            userdata("logged_in")) {
            $user_data = $this->session->userdata();
            $user_data = $this->LoginModel->get_user_data_from_db($user_data);
            $group_membership_details = $this->GroupModel->get_group_membership_for_users($user_data["email_id"]);
            $group_list = $this->GroupModel->get_group_detail_from_membership_details($group_membership_details, "group_name");
            $data["group_list"] = $group_list;
            $this->load->view('home', $data);
            return;
        }
        else
            $this->load->view('login');

    }

    public function login()
    {
        $user_data = $this->get_user_data_from_input();
        if($this->LoginModel->_is_user_login_data_valid($user_data))
        {
            $user_data = $this->LoginModel->get_user_data_from_db($user_data);
            $this->set_session_data($user_data);
            $this->index();        }
        else{
            $this->load->view("failed_login");
        }
        return;
    }



    private function get_user_data_from_input()
    {
        $user_data = array();
        $user_data["email_id"] = $this->input->post("email_id");
        $user_data["password"] = $this->input->post("password");
        return $user_data;
    }

    private function set_session_data(array $user_data)
    {
        $user_data["logged_in"] = true;
        $this->session->set_userdata($user_data);
        return;

    }



    public function logout()
    {
        if($this->session->has_userdata("email_id") and $this->session->has_userdata("logged_in") and $this->session->
        userdata("logged_in"))
        {
            $this->session->set_userdata("logged_in", false);
            $this->session->sess_destroy();
            $this->load->view("login");

        }
        else{
            $this->load->view("login");
        }
    }

    public function register()
    {
        $this->load->view("register_user");
    }

    public function register_user(){
        $user_data = $this->get_regestering_user_data();
        if($this->LoginModel->_is_registering_user_data_valid($user_data))
        {
             $this->LoginModel->insert_new_userdata_to_db($user_data);

            $this->load->view("login");
        }
        else{
          echo("User Data Not Valid");
        }
    }

    private function get_regestering_user_data()
    {
        $user_data["email_id"] = $this->input->post("email_id");
        $user_data["password"] = $this->input->post("password");
        $user_data["re_password"] = $this->input->post("repassword");
        return $user_data;
    }



}