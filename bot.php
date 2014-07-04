#!/usr/bin/php
<?php
$config    = array();
$config['nickname'] 	= 	'MoDeBoT';
$config['realname'] 	= 	'MoDeBoT 1.1-Stable';
$config['ident']   		= 	'MoDeBoT';
$config['hostname'] 	= 	0;
$config['server']  	 	= 	'irc.rizon.net';
$config['poort']   		= 	6667;
$config['channel']		= 	'#hun_bot';
$config['channel2']		= 	'#tomaa3757';
$config['pass']			=	'toma3757';

	require('functions.php');															//functions.php meghívása
	
	if(!$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) 							//socket_create ellenõrzés
	{
		die('Végzetes hiba: nem sikerült kapcsolodni a kiszolgálohoz');
	}
	echo 'Socket OK'."\n";

	if(!socket_bind($socket,$config['hostname'])) 
	{
		die('Nem zsír a hostname '.$config['hostname'].'.');
	}
	echo 'Hostname OK'."\n";

	if(!socket_connect($socket,$config['server'],$config['poort']))
	{
		die('Nem lehet csatlakozni a szerverhez!');
	}
	echo 'Csatlakozás...'."\n";
	
	send_data('USER '.$config['ident'].' '.$config['hostname'].' '.$config['server'].' :'.$config['realname']);
	send_data('NICK '.$config['nickname']);
	$start_time=date("Y.m.d H.i.s",time());
	$inDefaultChannel=false;
	if(file_exists("log/".$start_time.".txt"))
	{
		$log=fopen("log/".$start_time.".txt","w");
	}
	else
	{
		touch("log/".$start_time.".txt");
		$log=fopen("log/".$start_time.".txt","w");
	}
	
	while($data = socket_read($socket,65000,PHP_NORMAL_READ)) 
	{
		if($data == "\n") continue;
		
		$eData    = explode(" ",$data);				
		for($i = 0; isset($eData[$i]); $i++) 
		{
			$eData[$i]=trim($eData[$i]);
		}
		
		if($inDefaultChannel == false && strstr($data,"NOTICE MoDeBoT :Your vhost of "))
		{
			send_data('JOIN '.$config['channel']);
			privmsg($config['channel'],'Csáó all!');
			send_data('JOIN '.$config['channel2']);
			privmsg($config['channel2'],'Hali all!');
			$inDefaultChannel=true;
		}
		
		$format="[RECIEVE] ".$data."\n";	
		echo $format;														//logging to screen
		fwrite($log,$format);													//logging to file
		
		if($eData[7] == 'IDENTIFY' && $eData[1] == 'NOTICE' ) 				//Identifying
		{
			send_data('NICKSERV identify '.$config['pass'].'');
		}		
		
		if($eData[0] == 'PING')												//ping pong game :D                
		{	
			send_data('PONG '.$eData[1]);
		}
		
		if($eData[1] == 'JOIN')												//köszönés, majd jog adása
		{		
			$nick = preg_split("/\\!/", substr($eData[0], 1, -1));
			$channel=substr($eData[2], 1);
		
			if($nick[0] != $config['nickname'])
			{
					welcome($channel,$nick[0]);
				
				$access=fopen($channel.".txt", "r") or die("ERROR a MEGNYITÁSNÁL");			
					while(!feof($access))
					{
						$line=fgets($access,4096);
						$dataa=explode(" ",$line);

						if($nick[0] == $dataa[0])			//&& $channel == $dataa[2]
						{
							send_data("MODE ".$channel." ".$dataa[1]." ".$nick[0]." ");
						}
					}				
				fclose($access);
			}
		}
		
		if($eData[3] == ":!modebot")										//command értelmezés
		{	
			require("commands.php");
		}
	}
fclose($log);