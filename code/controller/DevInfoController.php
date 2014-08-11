<?php 

class DevInfoController extends Controller {
	
	private static $url_handlers = array (
		'' => 'indexAction',
		'php' => 'phpInfoAction',
		'modules' => 'modulesAction',
		'manifest' => 'manifestAction',
		'cms' => 'cmsAction',
		'data-objects' => 'dataObjectsAction',
		'security' => 'securityAction',
	);
	
	private static $allowed_actions = array (
		'indexAction',
		'phpInfoAction',
		'manifestAction',
		'modulesAction',
		'cmsAction',
		'dataObjectsAction',
		'securityAction',
	);
	
	
	
	
	public function indexAction(){
		$this->header();
		$data = new ViewableData();
		echo SSViewer::execute_template('DevInfoIndex', $data);
	}
	
	
	
	public function phpInfoAction(){
		$this->header();
		phpinfo();
		die;
	}
	
	
	public function manifestAction(){
		$this->header();
		$data = new ViewableData();
		
		$classData = new ArrayList();
		foreach(self::getAllClasses() as $lowercaseClassName => $absFilePath){
			$filePath = null;
			if(strpos($absFilePath, BASE_PATH) === 0){
				$filePath = substr($absFilePath, strlen(BASE_PATH) + 1);
			}else{
				$filePath = $absFilePath; // somewhere else, for some reason
			}
				
			$classData[] = array(
					'ClassName' => self::getProperCasedClassName($lowercaseClassName),
					'lowercaseClassName' => $lowercaseClassName,
					'FilePath' => $filePath
			);
		}
		
		// 		usort($classData, function($a, $b){
		// 			return $a['ClassName'] < $b['ClassName'];
		// 		});
		
		$data->ClassManifestData = $classData;
		echo SSViewer::execute_template('DevInfoManifest', $data);
	}
	
	public function modulesAction(){
		$this->header();
		$data = new ViewableData();
		
		$composerLockPath = BASE_PATH . '/composer.lock';
		if(!file_exists($composerLockPath)){
			return;
		}
		
		$composerLockStr = file_get_contents($composerLockPath);
		$composerLockArr = json_decode($composerLockStr, true);
		
// 		die('<pre>'.print_r($composerLockArr,true));
		
		$r = new ArrayList();
		
		foreach($composerLockArr['packages'] as $package){
			$r[] = array(
				'Name' => $package['name'],
				'Version' => $package['version'],
			);
		}
		
// 		die('<pre>'.print_r($r,true));
		
		// todo: source
		
		$data->ModuleData = $r;
		echo SSViewer::execute_template('DevInfoModules', $data);
	}
	
	public function cmsAction(){
		$this->header();
		
		$data = array();
		$pageTypeData = array();
		
		// get page type classes 
		$allClasses = array();
		foreach(self::getAllClasses(true) as $lowercaseClassName => $absFilePath){
			$reflectionClass = new ReflectionClass($lowercaseClassName);
			if($lowercaseClassName == 'sitetree' || $reflectionClass->isSubclassOf('SiteTree')){
				$allClasses[] = $lowercaseClassName;
			}
		}
		
		// we build a list of subtypes
		$classExtensionMap = array(); // array of classname => classes it extends 
		foreach($allClasses as $c){
			$classExtensionMap[$c] = array();
			$reflectionClass = new ReflectionClass($c);
			$e = strtolower($reflectionClass->getParentClass()->getName());
			$classExtensionMap[$c][$e] = $e;
		}
		foreach($classExtensionMap as $c => $ds){
			$classExtensionMap[$c] = $this->_subtypes($classExtensionMap, $c);
		}
		
		// then we build db fields
		foreach($allClasses as $c){
			$reflectionClass = new ReflectionClass($c);
			$v = array();
			$v['ClassName'] = self::getProperCasedClassName($c);
			$v['Fields'] = array();
			$v['Extends'] = $reflectionClass->getParentClass()->getName();
			$pageTypeData[$c] = $v;
		}
		foreach($allClasses as $c){
			// go through the db fields in each class
			$reflectionClass = new ReflectionClass($c);
			$staticProps = $reflectionClass->getStaticProperties();
			foreach($staticProps['db'] as $fieldName => $fieldSpec){
				// add this field to this class and all subtypes
				$field = array();
				$field['Name'] = $fieldName;
				$field['Spec'] = $fieldSpec;
				$field['Native'] = true;
				$pageTypeData[$c]['Fields'][] = $field;
				
				$subTypeField = array();
				$subTypeField['Name'] = $fieldName;
				$subTypeField['Spec'] = $fieldSpec;
				$subTypeField['Native'] = false;
				$subTypeField['InheritedFrom'] = self::getProperCasedClassName($c);
				foreach($classExtensionMap as $d => $ds){
					// for each other PageType
					if(in_array($c, $ds)){ 
						// if the PageType we are doing now is a supertype, add fields
						$pageTypeData[$d]['Fields'][] = $subTypeField;
					}
				}
			}
		}
		
		unset($pageTypeData['sitetree']);
		
		
		$data['PageTypeData'] = $pageTypeData;
		
		
		
// 		die('<pre>'.print_r($data,true));

		
		include __DIR__ . '/../../templates/info/DevInfoCMS.php';
		
// 		echo SSViewer::execute_template('DevInfoCMS', $data);
	}
	
	public function dataObjectsAction(){
		$this->header();
		$data = new ViewableData();
		
		$dataObjectData = new ArrayList();
	
		$DATA_OBJECT_FIELDS = array('db', 'defaults', 'casting', 'has_one', 'many_many', 'extensions');
	
	
		foreach(self::getAllClasses(true) as $lowercaseClassName => $absFilePath){
			$reflectionClass = new ReflectionClass($lowercaseClassName);
	
			if($reflectionClass->isSubclassOf('DataObject')){
				$staticProps = $reflectionClass->getStaticProperties();
				$rowData = array(
					'ClassName' => self::getProperCasedClassName($lowercaseClassName),
				);
				foreach($DATA_OBJECT_FIELDS as $DATA_OBJECT_FIELD){
					$rowData['Field_'.$DATA_OBJECT_FIELD] = print_r($staticProps[$DATA_OBJECT_FIELD], true);
				}
				$dataObjectData[] = $rowData;
			}
	
		}
	
		$data->DataObjectData = $dataObjectData;
		
		echo SSViewer::execute_template('DevInfoDataObjects', $data);
	}
	
	public function securityAction(){
		$this->header();
		$data = new ViewableData();
		
		
		echo SSViewer::execute_template('DevInfoSecurity', $data);
	}
	
	
	
	// This is for all objects ----- goes in manifest + page types + 
// 	protected function addObjectExtensionData(ViewableData $data){
// 		$extData = new ArrayList();
// 		foreach(self::getAllClasses(true) as $lowercaseClassName => $absFilePath){
// 			foreach(Object::get_extensions($lowercaseClassName) as $x => $y){
// 				$extData[] = array(
// 						'ClassName' => self::getProperCasedClassName($lowercaseClassName),
// 						'ExtendedBy' => $y,
// 				);
// 			}
// 		}
		
// 		$data->ObjectExtensionData = $extData;
// 	}
	

	
	
	
	

	
	
	
	
	
	
	
	
	
	
	

	
	
	/*
	 * Helpers
	 */
	
	/**
	 * @return array of lower case class name => abs file path
	 */
	private static function getAllClasses($loadableOnly = false){
		$loader = SS_ClassLoader::instance();
		$manifest = $loader->getManifest();
		$r = $manifest->getClasses();
		if($loadableOnly){
			$r2 = array();
			foreach($r as $lowercaseClassName => $absFilePath){
				try{
					if(strpos($lowercaseClassName, '\\') !== false) throw new Exception('skip namespaced class name');
					// 				if(!class_exists($lowercaseClassName)) throw new Exception('nope');
					$reflectionClass = new ReflectionClass($lowercaseClassName);
					$r2[$lowercaseClassName] = $absFilePath;
				}catch(Exception $e){
					// trouble loading the class for whatever reason
				}
			}
			$r = $r2;
		}
		return $r;
	}
	
	private static function getProperCasedClassName($lowercaseClassName){
		$r = null;
		try{
			if(strpos($lowercaseClassName, '\\') !== false) throw new Exception('skip namespaced class name');
			// 				if(!class_exists($lowercaseClassName)) throw new Exception('nope');
			$reflectionClass = new ReflectionClass($lowercaseClassName);
			$r = $reflectionClass->getName();
		}catch(Exception $e){
			// trouble loading the class for whatever reason
			$r = $lowercaseClassName;
		}
		return $r;
	}
	
	protected function header(){
		$renderer = new DebugView();
		$renderer->writeHeader();
		$renderer->writeInfo("SilverStripe Development Tools: Info", Director::absoluteBaseURL());
	}
	
	
	
	protected function _subtypes($classExtensionMap, $class){
		foreach($classExtensionMap[$class] as $d){
			if(isset($classExtensionMap[$d])){
				$classExtensionMap[$class] = array_merge($classExtensionMap[$class], $this->_subtypes($classExtensionMap, $d));
			}
		}
		return $classExtensionMap[$class];
	}
	
}