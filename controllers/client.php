<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerClient extends JControllerLegacy{
    function client(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__client= JTable::getInstance('client', 'billing');
        $__client->load($id);
        
        $view = $this->getView('client','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("client", $__client);
        $view->assign("id", $id);
        $view->display();
    }
    
    function client_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__client = JTable::getInstance('client', 'billing');
        $__client->load($id);

        $post = JRequest::get("post");
        
        if(!isset($post['publish'])) $post['publish'] = 0;

        $__client->bind($post);
        $__client->store($post);

        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=clients', 0), $text);
    }
    function remove(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__client = JTable::getInstance('client', 'billing');
        $__client->load($id);

        $post = array('deleted'=>1);

        $__client->bind($post);
        $__client->store($post);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=clients', 0), $text);
    }
}