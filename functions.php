<?php
function send_data($data) 
	{
		global $socket;
		global $log;
		socket_write($socket,$data."\r\n");
		
		$form="[SEND] ".$data."  \n";
		echo $form;
		fwrite($log, $form);
	}
	
function privmsg($channel, $msg)
	{
		send_data("PRIVMSG ".$channel." :".$msg." ");
	}
	
function welcome($channel,$nick)
	{
		$input=rand(0,10);
		
		switch($input)
			{
				case 0:
					$output='Haley';
				break;				
				case 1:
					$output='Szia';
				break;
				case 2:
					$output='Ahoy';
				break;
				case 3:
					$output='Üdv';
				break;
				case 4:
					$output='Csáó';
				break;
				case 5:
					$output='Szervusz';
				break;
				case 6:
					$output='Szevasz';
				break;
				case 7:
					$output='Aloha';
				break;
				case 8:
					$output='Hy';
				break;
				case 9:
					$output='Háj';
				break;	
				case 10:
					$output='Üdvözöllek';
				break;	
			}
		$msg=$output.' '.$nick.'!';
		privmsg($channel,$msg);
	}
	
function mode($who,$access,$channel)
	{
		send_data('MODE '.$channel.' '.$access.' '.$who.'');
	}
?>

	