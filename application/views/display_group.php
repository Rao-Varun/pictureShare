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
        <a href='<?php echo base_url("groups/add_pic/$group_name")?>' class="join">Add Pic</a>
        <?php
        foreach ($pictures as $picture)
        {   $img_location = $picture["location"];
            $img = base_url($img_location);
            $name = $picture["picture_id"];
            $href = base_url("groups/display_pic/$name");
            echo "<a href=\"$href\"><img alt=\"$name\"  src=$img?>\"></a>";
        }
        ?>
    </div>
</div>
</body>