<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
        <p class="group_name"><?php echo $group_name ?></p>
        <form id="add_pic_form" method="post" action="<?php echo base_url("groups/submit_pics");?>">
<!--            <input type="hidden" name="group_name" value="--><?php //echo $group_name ?><!--">-->
            <table id = "table">
                <tr>
                    <td>Choose Picture:</td>
                    <td><input type="file"  accept="image/png, image/jpeg, image/jpg" class="login" id="file" name="file"></td>
                </tr>
                <tr>
                    <td>Caption:</td>
                    <td><input type="text" class="comment_input" name="caption"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="button"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>