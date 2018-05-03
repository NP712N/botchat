<?php
header('Content-Type: text/html; charset=utf-8');
srand((float) microtime() * 10000000);
$key1 = 'd1b03379-191d-41b9-b6fb-19dd7437b50e';// bỏ key vào đây
$key2 = 'e58c4bef-ce05-4520-8063-7cb3dd87a8bf';// bỏ key vào đây
$input = array($key1,$key2);
$key = array_rand($input, 1);
$text = $_GET['text'];
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$input[$key].'&lc=vi&ft=1.0&text='.urlencode($text);
$sim = json_decode(file_get_contents($url),true);
if($sim['result']==100){
}
else if($sim['result']==404){
$sim['response'] = '404';
}
else{
$sim['response'] = ':)';
}
echo $sim['response'];
?>
