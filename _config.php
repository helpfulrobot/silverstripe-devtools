<?php 

DevelopmentAdmin::registerAction('ErrorLogsController', 'logs', 'Error logs');
DevelopmentAdmin::registerAction('DevToolsController', 'tools', 'Tools');

// log errors and warnings
SS_Log::add_writer(new DataObjectErrorWriter(), SS_Log::WARN, '<=');
