<?php


class GroupModel extends CI_Model
{

    public function get_group_membership_for_users($email_id)
    {
        $where_cond = array("email_id" => $email_id);
        return $this->db->select("*")->from("group_member")->where($where_cond)->join("groups", "group_member.group_id = groups.group_id")->
        get()->result_array();
    }

    public function insert_new_group_to_db($group_details)
    {
        if(!$this->_is_group_valid($group_details["group_name"])) {
            return false;
        }
        else
        {
            $this->db->insert("group", $group_details);
            return true;
        }
    }

    public function insert_user_to_group_member_db($member_details)
    {
        if($this->is_user_member_of_group($member_details["email_id"], $member_details["group_id"])) {
            return false;
        }
        $this->db->insert("group_member", $member_details);
        return true;
    }

    public function is_user_member_of_group($email_id, $group_id){
        $where_condition = array("email_id" => $email_id, "group_id"=>$group_id);
        $result = $this->db->select("*")->from("group_member")->where($where_condition)->get()->num_rows();
        if($result==1)
        {
            return true;
        }
        else
            return false;

    }

    public function get_new_groups_for_user($email_id){
        $group_membership_details = $this->get_group_membership_for_users($email_id);
        $group = $this->get_group_detail_from_membership_details($group_membership_details, "group_id");
        if(sizeof($group)!=0)
            $new_group_details = $this->db->select("*")->from("groups")->where_not_in("group_id", $group)->get()->result_array();
        else
            $new_group_details = $this->db->select("*")->from("groups")->get()->result_array();
        return $new_group_details;
    }

    public function get_group_detail_from_membership_details($group_membership_details, $attribute)
    {
        $detail = array();
         foreach ($group_membership_details as $membership_detail)
         {
             $detail[] = $membership_detail[$attribute];
         }
         return $detail;
    }

    public function get_group_id_by_group_name($group_name)
    {
        $result = $this->db->select("group_id")->from("groups")->where(array("group_name"=>$group_name))->get()->result_array();
        return $result[0]["group_id"];

    }

    public function get_group_name_by_group_id($group_id)
    {
        $result = $this->db->select("group_name")->from("groups")->where(array("group_id"=>$group_id))->get()->result_array();
        return $result[0]["group_name"];

    }

    public function _is_group_valid($group_name)
    {
        $result = $this->db->select("group_id")->from("groups")->where(array("group_name"=>$group_name))->get()->row();
        if($result)
            return true;
        else
            false;

    }



}
