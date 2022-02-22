<?php

// Start session
session_start();
// unset session
session_unset();
// destroy session
session_destroy();

// Tag bruger til index.php
header("location: index.php");
exit();