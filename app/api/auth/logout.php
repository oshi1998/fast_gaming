<?php

session_start();
unset($_SESSION['CUSTOMER_USERNAME']);
unset($_SESSION['CUSTOMER_FIRSTNAME']);
unset($_SESSION['CUSTOMER_LASTNAME']);

exit;