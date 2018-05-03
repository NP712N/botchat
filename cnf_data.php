<?php
$config['host'] = "localhost";

$config['username'] = "facez11t_simsimi";
$config['password'] = "simsimi123";
$config['dbname'] = "facez11t_simsimi";
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
if (!$connection){
die('ERORR DATA ');
}
mysql_select_db($config['dbname']) or die(mysql_error());
mysql_query("SET NAMES utf8");
