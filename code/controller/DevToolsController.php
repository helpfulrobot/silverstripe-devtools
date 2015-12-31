<?php

// TODO: somehow add the ability to trigger notice, warning, error, and fatal

class DevToolsController extends Controller
{
    
    private static $url_handlers = array(
        '' => 'index',
        '$Action' => '$Action',
    );
    
    private static $allowed_actions = array(
        'index',
        'triggerUserWarning',
        'triggerUserError',
        'triggerException',
    );
    
    public function init()
    {
        parent::init();
        $renderer = new DebugView();
        $renderer->writeHeader();
        $renderer->writeInfo("SilverStripe Development Tools: Logs", Director::absoluteBaseURL());
    }
    
    public function index()
    {
        echo SSViewer::execute_template('DevToolsIndex', null);
    }
    
    public function triggerUserWarning()
    {
        trigger_error('Test trigger_error E_USER_WARNING', E_USER_WARNING);
    }
    
    public function triggerUserError()
    {
        trigger_error('Test trigger_error E_USER_ERROR', E_USER_ERROR);
    }
    
    public function triggerException()
    {
        throw new Exception('Test trigger exception');
    }
}
