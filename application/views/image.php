<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url')
?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Picture Share</title>
    <link rel="stylesheet" href="<?php echo base_url("css/picshare.css")?>">
</head>


<body>
<div id="header">
    <h3>PicShare</h3>
    <div class = "headerContainers">
        <a href="<?php echo base_url("logout")?>" class = "headerlink">Logout</a>
        <a href="<?php echo base_url("/home")?>" class="headerlink">Home</a>
    </div>
</div>
<div class="container">
    <div class="group">
        <a href="<?php echo base_url("groups/all_groups")?>" class="anchorgroup"> all groups</a>
        <?php
        foreach ($group_list as $group)
        {
            $url = base_url("groups");
            echo "<a href=$url/display/$group class=\"anchorgroup\"> $group</a>";
        }
        ?>

    </div>

    <div class="content">
        <?php
        if($picture_details["email_id"] == $email_id)
        {                $picture_id = $picture_details["picture_id"];

        $url = base_url("groups/delete_pic/$picture_id");
            echo  "<a href='$url' class=\"join\"> Delete Pic</a>";
        }?>

        <img src="<?php
        $pic = $picture_details["picture_name"];
        echo base_url("$pic")?>">
        <div class = "comment_area">
            <form name="comment" method="post" action="<?php echo base_url("/groups/add_comment");?>">
                <input type="hidden" name="picture_id" value="<?php
                $picture_id = $picture_details["picture_id"];
                echo $picture_id;?>">
                <input type=text" name="comment" class="comment_input">
                <input type="submit" class="button" id="button" value="Add Comment">
                <br/>
            </form>

                <?php
                foreach ($comments as $comment) {
                    echo "<div  class=\"comment_box\">";
                    $commenter = $comment["email_id"];
                    $comment = $comment["comment"];
                    echo " <p class=\"user_name\">$commenter</p><br/>";
                    echo "<p class=\"user_comment\">$comment</p>";
                    echo "</div>";
                }
                ?>

        </div>
    </div>
</div>
</body>
