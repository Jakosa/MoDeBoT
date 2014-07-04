<?php
switch($eData[4])
	{
		case 'info':
			$version=explode(' ',$config['realname']);
			privmsg($eData[2],'Tulajdonosom, üzemeltetõm, íróm, szerkesztõm: ToMa3757 ');
			privmsg($eData[2],'Verzióm: '. $version[1]);
			privmsg($eData[2],'Programozási nyelv: PHP');			
			privmsg($eData[2],'Fõ parancsom: !modebot [command] [value] -> További információ: !modebot commands');
			//privmsg($eData[2],'!tombot alparancsok: join [#channel], leave [#channel], pw_change [old_password] [new_password] [new_password], usage, calc. [value] [operator] [value] [operator] [value]');
			privmsg($eData[2],'Start time: '.$start_time);
		break;
		case 'usage':
			$mem=memory_get_usage() / 1024 / 1024 ;
			$memory=substr($mem, 0, 6);
			privmsg($eData[2],'Memória kihasználtság: '.$memory.' MB');
		break;
		case 'commands':
			privmsg($eData[2],'Parancsaim(al parancsok):');
			privmsg($eData[2],"'usage' -> kiírja hogy éppen mennyit fogyasztok.");
			privmsg($eData[2],"'info'  -> fontos információkat tudhatsz meg rólam.");	
			privmsg($eData[2],"'join'  -> csatlakozok a channelhez.");	
		break;
		case 'join':
			send_data('JOIN '.$eData[5]);
		break;
		
	
	}









?>