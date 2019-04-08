<ul>
    <li><a href='index.php'>Home</a></li>
    <li><a href='?page=quests'>Quests</a></li>
    <?php if(isset($_SESSION['userID'])): ?>
        <li><a href="?page=logout">Log out</a></li>
        <li><?= $_SESSION['username'] ?></li>
    <?php else: ?>
        <li><a href='?page=login'>Login</a></li>
        <li><a href='?page=createAccount'>Create Account</a></li>
    <?php endif; ?>
</ul>