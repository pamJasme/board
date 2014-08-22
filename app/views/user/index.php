<!--
    User Login Page
-->

<?php $title="Login" ?>

<div class='register' style='margin-top:100px'>
<center>
<form class="well" action='<?php eh(url(''));?>' method='POST'>
    <table border='0'>
        <tr>
            <td><label>Username </label></td><td><input type='text' name='login_name' value='<?php eh(Param::get('login_name'));?>'></td></tr>
            <tr><td><label>Password </label></td><td><input type='password' name='login_pword' value='<?php eh(Param::get('login_pword'));?>'></td></tr>
            <tr><td><button type="submit" style='width:100%'>Login</td>
            <td><center>Register <a href='<?php eh(url('user/registration'))?>'>Here</a></td></tr>
        </tr>       
    </table>
</form>
</center>
</div>
