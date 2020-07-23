<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerDoctype extends JControllerLegacy{
    function doctype(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__doctype= JTable::getInstance('doctype', 'billing');
        $__doctype->load($id);
        
        $view = $this->getView('doctype','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("doctype", $__doctype);
        $view->assign("id", $id);
        $view->display();
    }
    
    function doctype_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__doctype = JTable::getInstance('doctype', 'billing');
        $__doctype->load($id);

        $post = JRequest::get("post");
        
        if(!isset($post['publish'])) $post['publish'] = 0;

        $__doctype->bind($post);
        $__doctype->store($post);

        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=doctypes', 0), $text);
    }
    function remove(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__doctype = JTable::getInstance('doctype', 'billing');
        $__doctype->load($id);

        $post = array('deleted'=>1);

        $__doctype->bind($post);
        $__doctype->store($post);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=doctypes', 0), $text);
    }
}