<?php

Class Home extends CI_Controller{

    function index(){
        if(!$this->_is_sesion_active())
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->session->userdata();
        $user_data = $this->LoginModel->get_user_data_from_db($user_data);
        $group_list = $this->get_all_groups_for_user($user_data);
        $data["group_list"] = $group_list;
        $this->load->view('home', $data);
        return;

    }


    public function all_groups()
    {
        if(!$this->_is_sesion_active())
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->session->userdata();
        $user_data = $this->LoginModel->get_user_data_from_db($user_data);
        $group_names = $this->GroupModel->get_new_groups_for_user($user_data["email_id"]);
        $new_group_list = $this->GroupModel->get_group_detail_from_membership_details($group_names, "group_name");
        $data["new_group_list"]= $new_group_list;
        $group_list = $this->get_all_groups_for_user($user_data);
        $data["group_list"] = $group_list;
        $this->load->view("all_groups", $data);
        return;

    }

    public function join_group($group_name)
    {
        if(!($this->_is_sesion_active() or $this->GroupModel->_is_group_valid($group_name)))
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->session->userdata();
        $user_data = $this->LoginModel->get_user_data_from_db($user_data);
        $group_id = $this->GroupModel->get_group_id_by_group_name($group_name);
        if($this->GroupModel->insert_user_to_group_member_db(array("email_id" => $user_data["email_id"], "group_id"=>$group_id)))
            return $this->all_groups();
        return $this->view_error_page();

    }

    private function _is_sesion_active()
    {
        if($this->session->has_userdata("email_id") and $this->session->has_userdata("logged_in") and $this->session->
        userdata("logged_in"))
            return true;
        else
            return false;
    }

    private function get_all_groups_for_user($user_data)
    {
        $group_membership_details = $this->GroupModel->get_group_membership_for_users($user_data["email_id"]);
        $group_list = $this->GroupModel->get_group_detail_from_membership_details($group_membership_details, "group_name");
        return $group_list;
    }

    private function view_error_page()
    {
        $message = "Page not found/ Invalid operation";
        $heading = "404 Page not found";
        $data = array("message" => $message, "heading"=>$heading);
        $this->load->view("/errors/html/error_404", $data);
        return;
    }
}
