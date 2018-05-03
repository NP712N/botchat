<?php
header('Content-Type: text/html; charset=utf-8');
if ($_POST) 
{
	require('cnf_data.php');
	if ($_POST['type'] == "day") 
	{
		$ask = $_POST['ask'];
		$ans = $_POST['ans'];
		if (!$ask) 
		{
			die("Bạn Đang Để Trống Câu Hỏi");
		}
		if (!$ans) 
		{
			die("Bạn Đang Để Trống Câu Trả Lời");
		}
		$result = @mysql_query("SELECT * FROM sim ");
		if ($result) 
		{
			while ($row = @mysql_fetch_array($result)) 
			{
				if ($row['ask'] == $ask) 
				{
					die('Câu Hỏi Đã Có. Vui Lòng Hỏi Câu Khác');
				}
			}
			@mysql_query("INSERT INTO sim SET ask = '".addslashes($ask)."', ans = '".addslashes($ans)."'");
			die("Sim Đã Ghi Nhớ <br /> Hỏi: ".$ask." <br /> Đáp: ".$ans);
		}
	}
	else
	{
		$hoi = $_POST['hoi'];
		if (!$hoi) 
		{
			die("Bạn Chưa Nhập Câu Hỏi");
		}
		$result = @mysql_query("SELECT * FROM sim ");
		if ($result) 
		{
			while ($row = @mysql_fetch_array($result)) 
			{
				if ($row['ask'] == $hoi) 
				{
					die("<font color='#00FF00'>".$row['ans']."</font>");
					$ok =1;
				}
			}
		} 
		if ($ok !=1) 
		{
		    $link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$data = file_get_contents('' .$link. '/post_sim.php?text='.$hoi);
			die($data);
			$hoi = $_GET['hoi'];
		}
	}

}
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