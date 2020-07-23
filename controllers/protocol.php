<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class BillingControllerProtocol extends JControllerLegacy{
    function protocol(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $mainframe = JFactory::getApplication();
        $context = 'protocollist';
        $orderby = $mainframe->getUserStateFromRequest( $context.'orderby', 'orderby', 'id', 'string');
        $order = $mainframe->getUserStateFromRequest( $context.'order', 'order', 'desc', 'string');
        $limit = $mainframe->getUserStateFromRequest( $context.'limit', 'limit', '35', 'int');
        $client_id = $mainframe->getUserStateFromRequest( $context.'client_id', 'client_id', '0', 'int');
        $personnel_id = $mainframe->getUserStateFromRequest( $context.'personnel_id', 'personnel_id', '0', 'int');
        
        $limitstart = JRequest::getInt('limitstart');

        $_document = $this->getModel('document');
        $_protocol = $this->getModel('protocol');

        if($client_id > 0)
            $filters['client_id'] = $client_id;
        if($personnel_id > 0){
            $filters['personnel_id'] = $personnel_id;
        }
        

        $total = $_protocol->getCountProtocol($filters);
        
//        $total = $_document->getCountDocuments($filters, $search);

        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        $pagenav = $pagination->getPagesLinks();

        $rows = $_protocol->getAllProtocol($filters, $orderby, $order, $limitstart, $limit);

        $orderingby[] = JHTML::_('select.option', $value = 'id', $text= JText::_( 'ID' ), 'value', 'text');
        $orderingby[] = JHTML::_('select.option','clientName', JText::_( 'CLIENT' ) );
        $orderingby[] = JHTML::_('select.option','issueName', JText::_( 'PROCESS' ) );
        $orderingbyList = JHTML::_('select.genericlist', $orderingby, $name = 'orderby', $attribs = null, $key = 'value', $text = 'text', $selected = $orderby, $idtag = false, $translate = false );
        
        $ordering[] = JHTML::_('select.option', $value = 'asc', $text= JText::_( 'ASC' ), 'value', 'text');
        $ordering[] = JHTML::_('select.option','desc', JText::_( 'DESC' ) );
        $orderingList = JHTML::_('select.genericlist', $ordering, $name = 'order', $attribs = null, $key = 'value', $text = 'text', $selected = $order, $idtag = false, $translate = false );

        $_clients = $this->getModel('client');

        $filters = array();
        $clients = $_clients->getAllClients($filters, 'name', 'asc', '0', '', '');
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        $clients = array_merge($list_null, $clients);
        //JHtml::_('formbehavior.chosen', 'select');  
        $clientsList = JHTML::_('select.genericlist', $clients, 'client_id', $attribs = ' ', $key = 'id', $text = 'name', $selected = $client_id, $idtag = false, $translate = true);
        
        if($client_id){
            $_personnel = $this->getModel('personnel');
            $filter = array('client_id'=>$client_id);
            $personnels = $_personnel->getAllPersonnels($filter, 'name', 'asc', 0, '', '');
            $personnels = array_merge($list_null, $personnels);
        }else{
            $personnels = $list_null;
        }
        $personnelsList = JHTML::_('select.genericlist', $personnels, 'personnel_id', $attribs = ' ', $key = 'id', $text = 'name', $selected = $personnel_id, $idtag = false, $translate = false);
        
        $view = $this->getView('protocol','html');
        $view->assign('pagination', $pagenav);
        $view->assign('pagination_obj', $pagination);
        $view->assign("rows", $rows);
        $view->assign('orderingbyList', $orderingbyList);
        $view->assign('orderingList', $orderingList);
        $view->assign('clientsList', $clientsList);
        $view->assign('personnelsList', $personnelsList);
        $view->display();
    }
    function edit(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');
        
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__protocol= JTable::getInstance('protocol', 'billing');
        $__protocol->load($id);
        
        $view = $this->getView('protocol','html');
        //$view->setModel($_fop, true);
        $view->setLayout("edit");
        $view->assign("protocol", $__protocol);
        $view->assign("id", $id);
        $view->display();
    }
    
    function save(){
        JRequest::checkToken() or die('Token Error');
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();
        
        $id = JRequest::getInt('id');

        JTable::addIncludePath(JPATH_COMPONENT.'/tables');
        $__protocol = JTable::getInstance('protocol', 'billing');
        $__protocol->load($id);

        $post = JRequest::get("post");
        
        $__protocol->bind($post);
        $__protocol->store($post);

        $text = jText::_('SAVED');
        $this->setRedirect(JRoute::_('index.php?option=com_billing&view=protocol', 0), $text);
    }
}