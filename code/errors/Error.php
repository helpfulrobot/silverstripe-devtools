<?php 
// TODO add request info



class Error extends DataObject {

	private static $db = array(
		'Hash' 				=> 'Text',
		'Message' 			=> 'Text', 	//
		'Stack' 			=> 'Text', 	// These four are copies of the first ErrorOccurance
		'File' 				=> 'Text', 	// recorded for this error, for performance.
		'Line' 				=> 'Text', 	// 
		'LatestOccurance' 	=> 'SS_DateTime',
		'NumOccurances' 	=> 'Int'
	);

	public static function generateHash($file, $line){
		return md5($file . '-' . $line);
	}

}