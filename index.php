<?php
require('config.php');
require('function.php');
$menus = getMenu(null);
renderMenu($menus);