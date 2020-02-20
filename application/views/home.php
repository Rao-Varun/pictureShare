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

    </div>
</div>
</body>