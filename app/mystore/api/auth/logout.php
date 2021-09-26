<?php

session_start();
unset($_SESSION['ADMIN_USERNAME']);
unset($_SESSION['ADMIN_FIRSTNAME']);
unset($_SESSION['ADMIN_LASTNAME']);
unset($_SESSION['ADMIN_LEVEL']);

exit;