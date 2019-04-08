<form id='login' action='?page=createAccount' method='post' accept-charset='UTF-8'>
    <fieldset>
        <legend>Login</legend>

        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <div>
            <label for='username' >Email:</label>
            <input type='text' name='username' id='username'  maxlength="50" />
        </div>
        <div>
            <label for='username' >Reenter Email:</label>
            <input type='text' name='username2' id='username2'  maxlength="50" />
        </div>

        <div>
            <label for='password' >Password:</label>
            <input type='password' name='password' id='password' maxlength="50" />
        </div>
        <div>
            <label for='password' >Reenter Password:</label>
            <input type='password' name='password2' id='password2' maxlength="50" />
        </div>

        <input type='submit' name='Submit' value='Submit' />
</fieldset>
</form>
