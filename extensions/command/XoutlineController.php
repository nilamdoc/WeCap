<?php
namespace app\extensions\command;
use app\models\Outlines;
class XoutlineController extends \lithium\console\Command {

// hourly cron job for getting exchange rates

public function run() {
	$outline = Outlines::find('all');
	
	
	foreach($outline as $o){
		$hash = sha1($o['_id']);
		
		$directory = substr($hash,0,1)."\\".substr($hash,1,1)."\\".substr($hash,2,1)."\\".substr($hash,3,1);
		$directory_os = substr($hash,0,1)."/".substr($hash,1,1)."/".substr($hash,2,1)."/".substr($hash,3,1);
		$outfile = "https://englishtolead.com/documents/".$directory_os."/".$hash.".mp3";
		
		$data = array(
				"outline_audio"=>$outfile
		);
		$conditions = array('_id'=>(string)$o['_id']);

		Outlines::update($data,$conditions);
		
		if($o['outline_description']!=""){
			echo exec("mkdir ".LITHIUM_APP_PATH.'\\webroot\\documents\\'.$directory);
			echo exec('"c:\program files (x86)\balabolka\cli\balcon.exe"  -n "Microsoft Heera Mobile" -k -p 2 -v 100 -t "'.$o['outline_description'].'" -e 2 -a 2 -w "'.LITHIUM_APP_PATH.'\\webroot\\documents\\'.$directory.'\\'.$hash.'.mp3"');
		}
		
	}
	
	
}

}
