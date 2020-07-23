<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerDocument extends JControllerLegacy{
    function document(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__document= JTable::getInstance('document', 'billing');
        $__document->load($id);
        if($__document->doctype_id > 0)
            $__document->doctypeName = $__document->doctype_name($__document->doctype_id);
        
        $_doctypes = $this->getModel('doctype');
        $filters = array();
        $doctypes = $_doctypes->getAllDoctypes($filters, 'name', 'asc', '0', '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $doctypes = array_merge($list_null, $doctypes);
        //JHtml::_('formbehavior.chosen', 'select');  
        $doctypesList = JHTML::_('select.genericlist', $doctypes, 'doctype_id', $attribs = ' required = "required" ', $key = 'id', $text = 'name', $selected = $__document->doctype_id, $idtag = false, $translate = true);
        
        $view = $this->getView('document','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("document", $__document);
        $view->assign("doctypesList", $doctypesList);
        $view->assign("id", $id);
        $view->display();
    }
    
    function document_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__document = JTable::getInstance('document', 'billing');
        $__document->load($id);

        $post = JRequest::get("post");
        if(!isset($post['exist'])) $post['exist'] = 0;

        $__document->bind($post);
        $__document->store($post);
        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=documents', 0), $text);
    }
    function remove(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__document = JTable::getInstance('document', 'billing');
        $__document->load($id);

        $post = array('deleted'=>1);

        $__document->bind($post);
        $__document->store($post);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=documents', 0), $text);
    }
}