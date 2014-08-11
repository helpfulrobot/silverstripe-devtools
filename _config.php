<?php 

// DevelopmentAdmin::addLink('ErrorLogsController', 'logs', 'logs', 'Error logs');
// DevelopmentAdmin::addLink('DevToolsController', 'tools', 'tools', 'Tools');

// log errors and warnings
SS_Log::add_writer(new DataObjectErrorWriter(), SS_Log::WARN, '<=');



// Config::inst()->update('DevelopmentAdmin', 'my_property', array('wat'));






