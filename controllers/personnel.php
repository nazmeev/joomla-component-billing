<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class BillingControllerPersonnel extends JControllerLegacy{
    function personnel(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__personnel= JTable::getInstance('personnel', 'billing');
        $__personnel->load($id);
        if($__personnel->client_id > 0)
            $__personnel->client_name($__personnel->client_id);
        
        $_clients = $this->getModel('client');
        $filters = array();
        $clients = $_clients->getAllClients($filters, 'name', 'asc', '0', '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $clients = array_merge($list_null, $clients);
        //JHtml::_('formbehavior.chosen', 'select');  
        $clientsList = JHTML::_('select.genericlist', $clients, 'client_id', $attribs = ' required = "required" ', $key = 'id', $text = 'name', $selected = $__personnel->client_id, $idtag = false, $translate = true);
        
        $view = $this->getView('personnel','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("personnel", $__personnel);
        $view->assign("clientsList", $clientsList);
        $view->assign("id", $id);
        $view->display();
    }
    
    function personnel_save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__personnel = JTable::getInstance('personnel', 'billing');
        $__personnel->load($id);

        $post = JRequest::get("post");
        if(!isset($post['publish'])) $post['publish'] = 0;

        $__personnel->bind($post);
        $__personnel->store($post);

        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=personnels', 0), $text);
    }
    function remove(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__personnel = JTable::getInstance('personnel', 'billing');
        $__personnel->load($id);

        $post = array('deleted'=>1);

        $__personnel->bind($post);
        $__personnel->store($post);
        $text = jText::_('DELETED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=personnels', 0), $text);
    }
}