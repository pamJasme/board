<!--
    User Registration Page
-->
<form class="well" action="<?php encode_quotes(url(''));?>" method="POST">
    <table border='0'>
        <tr>
            <td><label>Username</label></td>
            <td><input type="text" name='username' style="height:25px" 
                placeholder="5-12 characters">
            </td>
        </tr>
        <tr>
            <td><label>Password</label></td>
            <td><input type='password' name='pword' style="height:25px"
                placeholder="5-12 characters"></td>
        </tr>
        <tr>
            <td><label>Confirm Password&nbsp;</label></td>
            <td><input type='password' name='pword_match' style="height:25px"></td>
        </tr>
        <tr>
            <td><label>First Name</label></td>
            <td><input type='text' name='fname' style="height:25px"></td>
        </tr>
        <tr>
            <td><label>Last Name</label></td>
            <td><input type='text' name='lname' style="height:25px"></td>
        </tr>
        <tr>
            <td><label>Email Address&nbsp;</label></td>
            <td><input type='text' name='email' style="height:25px"
                placeholder="abc@abc.com"></td>
        </tr>
        <tr>
            <td><button class="btn btn-medium btn-primary" type="submit">Register</button></td>
            <td>Go to
                <a href="index" style="height:25px"> Login </a>
                Page
            </td>
        </tr>
    </table>
</form>
<?php echo $status; ?>
