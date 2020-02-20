<?php


class PictureModel extends CI_Model
{

    public function get_all_pictures_in_a_group($group_id)
    {
        $result = $this->db->select("*")->from("picture")->where(array("group_id"=> $group_id, "status"=>1))->get()->result_array();
        return $result;
    }

    public function add_pic_details_to_db($email_id, $group_id, $pic_details)
    {
        $pic_details["picture_name"] =
        $insert_details = array("picture_name"=>$pic_details["picture_name"], "email_id"=>$email_id, "group_id"=>$group_id,
            "location"=>$pic_details["location"], 'status'=>1);
        $this->db->insert("picture", $insert_details);
        return true;
    }

    public function get_picture_details_by_id($picture_id)
    {
        $result = $this->db->select("*")->from("picture")->where("picture_id", $picture_id)->get();
        if($result->num_rows()>0) {
            $result = $result->result_array();
            return $result[0];
        }
        else
            return null;
    }

    public function get_all_commentes_for_picture_id($picture_id)
    {
        $result = $this->db->select("*")->from("comment")->where("picture_id", $picture_id)->join("users", "comment.email_id = users.email_id")->get()->result_array();
//        print_r($result);
        return $result;
    }

    public function add_comment_to_picture($picture_id, $email_id, $comment){
        $details = array(
                "picture_id" => $picture_id,
                "email_id" => $email_id,
                "comment" => $comment
        );
        $this->db->insert("comment", $details);
    }


    public function delete_picture($pic_id)
    {
        $this->db->set("status", 0);
        $this->db->where("picture_id", $pic_id);
        $this->db->update("picture");
        return;
    }


}