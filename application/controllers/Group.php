<?php


class Group extends CI_Controller
{

    public function display_group($group_name)
    {
        if(!($this->_is_sesion_active() and $this->GroupModel->_is_group_valid($group_name)) )
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata());
        $group_id = $this->GroupModel->get_group_id_by_group_name($group_name);
        if($this->GroupModel->is_user_member_of_group($user_data["email_id"], $group_id))
        {
            $pictures = $this->PictureModel->get_all_pictures_in_a_group($group_id);
            $data["pictures"] = $pictures;
            $group_list = $this->get_all_groups_for_user($user_data);
            $data["group_list"] = $group_list;
            $data["group_name"] = $group_name;
            $this->load->view("display_group", $data);
            return;

        }
        $this->view_error_page();
        return;



    }

    public function add_pic($group_name)
    {
        if(!($this->_is_sesion_active() and $this->GroupModel->_is_group_valid($group_name)) )
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata());
        $group_id = $this->GroupModel->get_group_id_by_group_name($group_name);
        if($this->GroupModel->is_user_member_of_group($user_data["email_id"], $group_id))
        {
            $group_list = $this->get_all_groups_for_user($user_data);
            $data["group_list"] = $group_list;
            $data["group_name"] = $group_name;
            $this->load->view("add_pic", $data);
            return;
        }
        $this->view_error_page();
        return;
    }

    public function submit_pic()
    {
        print_r($_FILES);
        $picture_details = $this->get_picture_details();
        if (!($this->_is_sesion_active() and $this->GroupModel->_is_group_valid($picture_details["group_name"]))) {
            $this->view_error_page();
        }
            $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata);
            $group_id = $this->GroupModel->get_group_id_by_group_name($picture_details["group_name"]);
            if ($this->GroupModel->is_user_member_of_group($user_data["email_id"], $group_id)) {
                $picture_details = $this->upload_pic_to_server($picture_details);
                 $this->PictureModel->add_pic_details_to_db($user_data["email_id"], $group_id, $picture_details);
                 $this->display_group($group_id);
            return;
        }
            $this->view_error_page();



    }

    public function get_picture_details()
    {

        $pic_details["group_name"] = $this->input->post("group_name");
        $pic_details["caption"] = $this->input->post("caption");

        return $pic_details;

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


    private function _is_picture_extension_valid($pic_details)
    {
        $allowedfileExtensions = array('jpg', 'jpeg', 'png');
        if(in_array($pic_details["extensions"], $allowedfileExtensions))
            return true;
        else
            return false;

    }

    private function upload_pic_to_server($picture_details)
    {
        $config['upload_path']   = './public/images';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);        }

        else
            {
            $data = array('upload_data' => $this->upload->data());
        print_r($data);
            $pic_details["picture_name"] = $data["file_name"];
            $pic_details["location"] = "./public/images/".$pic_details["picture_name"];
            return $picture_details;

        }
    }

    public function display_image($picture_id)
    {
        $picture_details = $this->PictureModel->get_picture_details_by_id($picture_id);
        if (!($this->_is_sesion_active() and $picture_details != null and $picture_details["status"] == 1 and
            $this->GroupModel->is_user_member_of_group($this->session->userdata("email_id"), $picture_details["group_id"])))
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata());
        $group_list = $this->get_all_groups_for_user($user_data);
        $data["group_list"] = $group_list;
        $comments = $this->PictureModel->get_all_commentes_for_picture_id($picture_id);
        $data["comments"] = $comments;
        $data["picture_details"] = $picture_details;
        $data["email_id"] = $user_data["email_id"];
        $this->load->view("image", $data);
        return;

    }

    public function add_comments()
    {
        $picture_details = $this->PictureModel->get_picture_details_by_id($this->input->post("picture_id"));
        $comment = $this->input->post("comment");
        if (!($this->_is_sesion_active() and $picture_details != null and $picture_details["status"] == 1 and
            $this->GroupModel->is_user_member_of_group($this->session->userdata("email_id"), $picture_details["group_id"])))
        {
            $this->view_error_page();
            return;
        }
        $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata());
        $this->PictureModel->add_comment_to_picture($picture_details["picture_id"], $user_data["email_id"], $comment);
        $this->display_image($picture_details["picture_id"]);
        return;


    }

    public function delete_pic($picture_id){
        $picture_details = $this->PictureModel->get_picture_details_by_id($picture_id);
        if (!($this->_is_sesion_active() and $picture_details != null and $picture_details["status"] == 1 and
            $this->GroupModel->is_user_member_of_group($this->session->userdata("email_id"), $picture_details["group_id"]))
        and $picture_details["email_id"] == $this->session->userdata("email_id") )
        {
            print_r($picture_details);
            print_r($this->session->userdata());
            $this->view_error_page();
            return;
        }
        $user_data = $this->LoginModel->get_user_data_from_db($this->session->userdata());
        $group_list = $this->get_all_groups_for_user($user_data);
        $this->PictureModel->delete_picture($picture_id);
        $group_name = $this->GroupModel->get_group_name_by_group_id($picture_details["group_id"]);
        $this->display_group($group_name);
        return;
    }

}