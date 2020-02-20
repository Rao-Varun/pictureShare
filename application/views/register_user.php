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

</div>
<div id="container">
    <div id="group">
    <script></script>
    </div>
    <div id="content">
        <form id="loginForm" method="post" action="<?php echo base_url("/register/user");?>">
            <table id = "table">
                <tr>
                    <td>EmailId: </td>
                    <td><input type="text" class="login" name="email_id"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" class="login" name="password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" class="login" name="repassword"></td>
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