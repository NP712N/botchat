<?php
#-----------------------------------------------------#

# BOT SIMSIMI REPLY COMMENT
# FB.COM/WHITE.HAT.11
# code năm 2015
#được phong fix lại năm 2017
# FIX By Phong best tristana 
#-----------------------------------------------------#
set_time_limit(0);
require ('funcEmo.php');
require ('cnf_data.php');
$iduser = "100012921348542"; // ID Người Sử Dụng Simsimi Cmt
$token = ""; // Token Của Nick simsimi
$limit = '3';  /* sô bài cần like & CMT*/
$getID = json_decode(auto('https://graph.facebook.com/me?access_token='.$token.'&fields=id'),true);
$getStt = json_decode(auto('https://graph.facebook.com/me/home?fields=id,message,created_time,from&limit=' . $limit . '&access_token=' . $token),true);
$log = json_encode(file('log.txt'));
for($i=1;$i<=count($getStt[data]);$i++)
{
	$getcmt = json_decode(auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&limit=' . $limit . '&fields=id,from,message'),true);
	if(count($getcmt[data]) > 0)
	{
		for($c=1;$c<=count($getcmt[data]);$c++)
		{
			$log_f = explode($getcmt[data][$c-1][id],$log);
			if(count($log_f) > 1)
			{
				echo'Done! ';
			}
			else
			{
				$log_x = $getcmt[data][$c-1][id].'_';
				$log_y = fopen('log.txt','a');
				fwrite($log_y,$log_x);
				fclose($log_y);
				$cmt = trim($getcmt[data][$c-1][message]);
				$a = 'add'; // từ khóa để sim gửi kết bạn
				if(strpos($cmt, $a)===false)
				{
					$str = $getcmt[data][$c-1][from][name];
					$traloi = '#'.str_replace( ' ', '_', $str).': '; // tag
					$result = @mysql_query("SELECT * FROM sim ");
					if ($result) 
					{
						while ($row = @mysql_fetch_array($result)) 
						{
							if ($row['ask'] == $cmt) 
							{
								$traloi .= $row['ans'];
								$ok=1;
							}
						}
						if($ok !=1)
						{
							$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
							$traloi .= file_get_contents('' .$link. '/?&text='.$cmt);
						}
					}
					if($getcmt[data][$c-1][from][id] !== $getID[id]) 
					{
						auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&message='.urlencode(Emo($traloi)).'&method=post');
					}
				}
				else
				{
					if($getcmt[data][$c-1][from][id] !== $getID[id]) 
					{
						auto('https://graph.facebook.com/me/friends?uid='.$getcmt[data][$c-1][from][id].'&access_token='.$token.'&method=post');
						$str = $getcmt[data][$c-1][from][name];
						$traloi = '#'.str_replace( ' ', '_', $str).': ';
						$traloi .= 'Gửi Lời Mời Kết Bạn Rồi Nha :D';
						auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&message='.urlencode(Emo($traloi)).'&method=post');
					}
				} 
			}

		}
	}
}
srand((float) microtime() * 10000000);
require('key.php');
$key1 = $keya;// bỏ key vào đây
$key2 = $keyb;// bỏ key vào đây
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

function auto($url){
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $url);
$ch = curl_exec($curl);
curl_close($curl);
return $ch;
}