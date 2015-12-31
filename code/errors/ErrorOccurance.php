<?php 

class ErrorOccurance extends DataObject
{

    private static $db = array(
        'Hash' => 'Text',
        'Message' => 'Text',
        'Stack' => 'Text',
        'File' => 'Text',
        'Line' => 'Text',
        'Data' => 'Text',
        'IP' => 'Text',
        'RequestMethod' => 'Text',
        'RequestURI' => 'Text',
    );
    
    /**
     * Needed because Data is apparently a reserved keyword in templates
     */
    public function ErrorData()
    {
        return $this->Data;
    }
}
