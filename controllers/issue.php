<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerIssue extends JControllerLegacy{
    function issue(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__issue= JTable::getInstance('issue', 'billing');
        $__issue->load($id);
        
        $_issue = $this->getModel('issue');
        $doctypes = $_issue->getDoctypes($id);
        
        $view = $this->getView('issue','html');
        $view->setLayout("doc");
        $view->assign("doctypes", $doctypes);
        $documentsList = $view->loadTemplate();
        
        $view = $this->getView('issue','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("issue", $__issue);
        $view->assign("id" ,$id);
        $view->assign("documents" ,$documentsList);
        $view->display();
    }
    
    function issue_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__issue = JTable::getInstance('issue', 'billing');
        $__issue->load($id);

        $post = JRequest::get("post");
        
        if(!isset($post['publish'])) $post['publish'] = 0;

        $__issue->bind($post);
        $__issue->store($post);

        $doctypes = $post['doctype_id'];
        $_issue = $this->getModel('issue');
        //$_issue->Erase($id);
        $_issue->setDoctype($id, $doctypes);
        
        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&controller=issue&view=issue&id='.$id, 0), $text);
        //$this->setRedirect(JRoute::_('index.php?option=com_billing&view=issues', 0), $text);
    }
    function remove(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__issue = JTable::getInstance('issue', 'billing');
        $__issue->load($id);

        $post = array('deleted'=>1);

        $__issue->bind($post);
        $__issue->store($post);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=issues', 0), $text);
    }
    
    function adddoctype(){
        $_doctype = $this->getModel('doctype');
        $rows = $_doctype->getAllDoctypes(array(), 'name', 'asc', 0, '', '');

        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $doctypes = array_merge($list_null, $rows);
        //JHtml::_('formbehavior.chosen', 'select');  
        $doctypeList = JHTML::_('select.genericlist', $doctypes, 'doctype_id[]', $attribs = ' required ', $key = 'id', $text = 'name', $selected = '', $idtag = false, $translate = false);
        
        
        $view = $this->getView('issue','html');
        $view->setLayout("adddoc");
        $view->assign("doctypeList", $doctypeList);
//        $view->display();
        
        $result = array('html' => $view->loadTemplate());
        echo json_encode($result);
        
        jexit();
    }
    
    function removedoctype(){
        $id = JRequest::getInt('id');
        $issue_id = JRequest::getInt('issue_id');
        $_issue = $this->getModel('issue');
        $_issue->removeDocument($id);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&controller=issue&view=issue&id='.$issue_id, 0), $text);
    }
}