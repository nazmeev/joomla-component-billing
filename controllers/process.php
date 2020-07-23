<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerProcess extends JControllerLegacy{
    function process(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
//        $client_id = JRequest::getInt('client_id');
        
        $_client = $this->getModel('client');
        $rows = $_client->getAllClients(array(), 'name', 'asc', 0, '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $clients = array_merge($list_null, $rows);
        $clientsList = JHTML::_('select.genericlist', $clients, 'client_id', $attribs = ' required ', $key = 'id', $text = 'name', $selected = '', $idtag = false, $translate = false);
      
//        $_personnel = $this->getModel('personnel');
//        if($client_id) $filter = array('client_id'=>$client_id); else $filter = array();
//        $rows = $_personnel->getAllPersonnels($filter, 'name', 'asc', 0, '', '');
        
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
//        $personnels = array_merge($list_null, $rows);
        $personnels = $list_null;
        $personnelsList = JHTML::_('select.genericlist', $personnels, 'personnel_id', $attribs = ' required ', $key = 'id', $text = 'name', $selected = '', $idtag = false, $translate = false);
        
        
        $_issue = $this->getModel('issue');
        $rows = $_issue->getAllIssues(array(), 'name', 'asc', 0, '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $issues = array_merge($list_null, $rows);
        $issuesList = JHTML::_('select.genericlist', $issues, 'issue_id', $attribs = ' required ', $key = 'id', $text = 'name', $selected = '', $idtag = false, $translate = false);
        
        $_client = $this->getModel('client');
        $rows = $_client->getAllClients(array(), 'name', 'asc', 0, '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $clients = array_merge($list_null, $rows);
        $clientsList = JHTML::_('select.genericlist', $clients, 'client_id', $attribs = ' required ', $key = 'id', $text = 'name', $selected = '', $idtag = false, $translate = false);
        
        $view = $this->getView('process','html');
        //$view->setModel($_fop, true);
        $view->assign("issuesList", $issuesList);
        $view->assign("personnelsList", $personnelsList);
        $view->assign("clientsList", $clientsList);
        $view->display();
    }
    
    function process_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $issue_id = JRequest::getInt('issue_id');
        $client_id = JRequest::getInt('client_id');
        $personnel_id = JRequest::getInt('personnel_id');
        $date = JRequest::getVar('date');

        $_process = $this->getModel('process');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $id = 0;
        $__protocol = JTable::getInstance('protocol', 'billing');
        $post = array('date'=>$date, 'issue_id'=>$issue_id, 'client_id'=>$client_id, 'personnel_id'=>$personnel_id);
        $__protocol->bind($post);
        $__protocol->store($post);
        $protocol_id = $__protocol->id;            
            
        $doctypes = $_process->getDoctypesOfIssue($issue_id);
        foreach($doctypes as $doctype){
            $__document = JTable::getInstance('document', 'billing');
            $__document->load($id);
            $post['doctype_id'] = $doctype->doctype_id;            
            $post['protocol_id'] = $protocol_id;
            $__document->bind($post);
            $__document->store($post);
        }
        $text = jText::_('CREATED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=documents&protocol_id='.$protocol_id, 0), $text);
    }
    
    function getPersonnel(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $client_id = JRequest::getInt('client_id');
        
        $_personnel = $this->getModel('personnel');
        
        $filter = array('client_id'=>$client_id);
        $rows = $_personnel->getAllPersonnels($filter, 'name', 'asc', 0, '', '');
        
        echo json_encode($rows);
        jexit();
    }
}