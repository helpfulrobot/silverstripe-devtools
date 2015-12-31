<?php 

class DevErrorLogsController extends Controller
{
    
    private static $url_handlers = array(
            '' => 'all',
            'data' => 'errorData',
            'delete' => 'delete',
            '$hash' => 'one',
    );
    
    private static $allowed_actions = array(
            'all',
            'one',
            'errorData',
            'delete',
    );
    
    
    public function all()
    {
        $errs = Error::get()->toArray();
        usort($errs, function ($a, $b) {
            return $a->LatestOccurance()->Created < $b->LatestOccurance()->Created;
        });
        $r = new ArrayList($errs);
        
        $this->header();
        $data = new ViewableData();
        $data->Errors = $r;
        echo SSViewer::execute_template('Errors', $data);
    }
    
    public function one(SS_HTTPRequest $request)
    {
        $this->header();
        $hash = $request->param('hash');
        $data = new ViewableData();
        $data->Error = Error::get()->filter('Hash', $hash)->limit(1)->first();
        $data->ErrorOccurances = ErrorOccurance::get()->filter('Hash', $hash)->sort('Created DESC');
        echo SSViewer::execute_template('ErrorDetail', $data);
    }
    
    public function errorData(SS_HTTPRequest $request)
    {
        $occuranceId = $_REQUEST['id'];
        echo '<pre>'.ErrorOccurance::get()->byID($occuranceId)->Data;
    }
    
    public function delete(SS_HTTPRequest $request)
    {
        $hash = $_REQUEST['hash'];
        
        $error = Error::get()->filter('Hash', $hash)->first();
        if ($error) {
            $error->delete();
        }
        
        foreach (ErrorOccurance::get()->filter('Hash', $hash) as $errorOccurance) {
            /* @var $errorOccurance ErrorOccurance */
            $errorOccurance->delete();
        }
        
        return $this->redirect('dev/logs');
    }
    
    
    
    protected function header()
    {
        $renderer = new DebugView();
        $renderer->writeHeader();
        $renderer->writeInfo("SilverStripe Development Tools: Logs", Director::absoluteBaseURL());
    }
}
