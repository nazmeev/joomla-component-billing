<?php defined( '_JEXEC' ) or die( 'Restricted access' );
    $document = JFactory::getDocument();
    $document->addStyleSheet('components/com_billing/lib/css/billing.css');
    $document->addScript('components/com_billing/lib/js/billing.js');
    $document->addScriptDeclaration('jQuery(function(){jQuery(".btn-remove").click(function(){if(!confirm("Realy?")) return false;})})');

    $controller = JRequest::getCmd('controller');
    $view = JRequest::getVar('view');

    if($view == 'clients'){
        $controller = 'clients';
    }
    if($view == 'issues'){
        $controller = 'issues';
    }
    if($view == 'personnels'){
        $controller = 'personnels';
    }
    if($view == 'documents'){
        $controller = 'documents';
    }
    if($view == 'doctypes'){
        $controller = 'doctypes';
    }
    if($view == 'action'){
        $controller = 'actions';
    }
    if($view == 'process'){
        $controller = 'process';
    }
    if($view == 'protocol'){
        $controller = 'protocol';
    }

    $path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
    if (file_exists($path)) {require_once $path;} else {$controller = '';}

    $classname    = 'BillingController'.$controller;
    $controller   = new $classname();

    $controller->execute($view);
    $controller->redirect();
