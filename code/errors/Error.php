<?php 
// TODO add request info



class Error extends DataObject {

	private static $db = array(
		'Hash' 	=> 'Text',
	);

	public static function generateHash($file, $line){
		return md5($file . '-' . $line);
	}
	
	/**
	 * @return ErrorOccurance
	 */
	public function LatestOccurance(){
		return ErrorOccurance::get()->filter('Hash', $this->Hash)->sort('Created', 'DESC')->limit(1)->first();
	}
	
	/**
	 * @return int
	 */
	public function NumOccurances(){
		return ErrorOccurance::get()->filter('Hash', $this->Hash)->count();
	}

}