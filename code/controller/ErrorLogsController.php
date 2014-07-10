<?php 

class ErrorLogsController extends Controller {
	
	private static $url_handlers = array (
			'' => 'index'
	);
	
	private static $allowed_actions = array (
			'index'
	);
	
	public function index() {
		$hash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : null;
		$occuranceId = isset($_REQUEST['occuranceId']) ? $_REQUEST['occuranceId'] : null;
	
		if($hash && $occuranceId){
			// dump the data from this occurance
			die('<pre>'.ErrorOccurance::get()->byID($occuranceId)->Data);
	
		}else if($hash){
			// one error (all occurances)
			$data = new ViewableData();
			$data->Error = Error::get()->filter('Hash', $hash)->limit(1)->first();
			$data->ErrorOccurances = ErrorOccurance::get()->filter('Hash', $hash)->sort('Created DESC');
			echo SSViewer::execute_template('ErrorDetail', $data);
				
		}else{
			// all errors (latest occurance for each error)
			$data = new ViewableData();
			$data->Errors = Error::get()->sort('Created DESC')->leftJoin('ErrorOccurance', 'Error.Hash = ErrorOccurance.Hash');
			echo SSViewer::execute_template('Errors', $data);
		}
	}
	
	
}