<?php


class LoginModel extends CI_Model
{


    public function _is_user_login_data_valid($user_data)
    {
        if ($user_data["email_id"] == null or $user_data["password"] == null){
            return false;
    }
        else {
            $user_data["password"] = md5($user_data["password"]);
            $result_array = $this->db->select("*")->from("users")->where($user_data)->get()->result_array();
            if (sizeof($result_array) == 1)
                return true;
            else
                return false;
        }
    }

    public function get_user_data_from_db(array $user_data)
    {
        $result_array = $this->db->select("*")->from("users")->where("email_id",$user_data["email_id"])->get()->result_array();
        return $result_array[0];
    }



    public function _is_registering_user_data_valid($user_data)
    {
//        print_r($user_data);
        if(!filter_var($user_data["email_id"], FILTER_VALIDATE_EMAIL))
            return false;
        if($user_data["password"] != $user_data["re_password"])
            return false;
        $password = $user_data["password"];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
//        $spec_char = preg_match('@[!@$%^&*()_+)]@\.', $password);
        if (!$uppercase || !$lowercase || !($number) || strlen($password) < 8)
        {
            return false;}
        return true;


    }

    public function insert_new_userdata_to_db($user_data)
    {
        $reg_data = array();
        $reg_data["email_id"] = $user_data["email_id"];
        $reg_data["password"] = md5($user_data["password"]);
        $reg_data["status"] = 1;
        $reg_data["user_type"] = "general";
        $this->db->insert("users", $reg_data);
        return;
    }
}