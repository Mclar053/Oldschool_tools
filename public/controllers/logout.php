<?php

session_unset();
session_destroy();

header("Location:" . $HOME_PAGE, true, 301);
exit();