<form id='login' action='?page=login' method='post' accept-charset='UTF-8'>
    <fieldset>
        <legend>Login</legend>

        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <div>
            <label for='username' >UserName*:</label>
            <input type='text' name='username' id='username'  maxlength="50" />
        </div>
        <div>
            <label for='password' >Password*:</label>
            <input type='password' name='password' id='password' maxlength="50" />
        </div>

        <input type='submit' name='Submit' value='Submit' />
</fieldset>
</form>
