<?php 

require_once 'Zend/Log/Writer/Abstract.php';


class DataObjectErrorWriter extends Zend_Log_Writer_Abstract {
	
	static public function factory($config){}
	
	protected function _write($event){
		// parse event
		$file = $event['message']['errfile'];
		$line = $event['message']['errline'];
		$message = $event['message']['errstr'];
		$data = print_r($event, true);
		$stack = '';
		foreach($event['message']['errorcontext'] as $stackPart){
			if(isset($stackPart['file']) && isset($stackPart['line'])){
				$stack .= $stackPart['file'] . '#' . $stackPart['line'] . PHP_EOL;
			}
		}
		
		// error unique-ness
		$hash = Error::generateHash($file, $line);
		
		// get/create error
		$error = Error::get()->filter('Hash', $hash)->limit(1);
		if($error->exists()){
			$error = $error->first();
			$error->NumOccurances++;
			$error->LatestOccurance = SS_Datetime::now();
			$error->write();
		}else{
			$error = new Error();
			$error->Hash = $hash;
			$error->Message = $message;
			$error->Stack = $stack;
			$error->File = $file;
			$error->Line = $line;
			$error->NumOccurances = 1;
			$error->LatestOccurance = SS_Datetime::now();
			$error->write();
		}
		
		// create occurance
		$errorOccurance = new ErrorOccurance();
		$errorOccurance->Hash = $hash;
		$errorOccurance->Message = $message;
		$errorOccurance->Stack = $stack;
		$errorOccurance->File = $file;
		$errorOccurance->Line = $line;
		$errorOccurance->Data = $data;
		$errorOccurance->write();
	}
	
}


