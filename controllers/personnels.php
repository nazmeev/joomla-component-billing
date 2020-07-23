<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class BillingControllerPersonnels extends JControllerLegacy{
    function personnels(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $search = JRequest::getVar('search');
        $client_id = JRequest::getInt('client_id');

        $mainframe = JFactory::getApplication();
        $context = 'personnelslist';
        $orderby = $mainframe->getUserStateFromRequest( $context.'orderby', 'orderby', 'id', 'string');
        $order = $mainframe->getUserStateFromRequest( $context.'order', 'order', 'desc', 'string');
        $limit = $mainframe->getUserStateFromRequest( $context.'limit', 'limit', '20', 'int');
        $deleted = $mainframe->getUserStateFromRequest( $context.'deleted', 'deleted', '0', 'int');
//
//        $keyservice_id = $mainframe->getUserStateFromRequest( $context.'keyservice_id', 'keyservice_id', '0', 'int');
//        $date_start = $mainframe->getUserStateFromRequest( $context.'date_start', 'date_start', '', 'string');
//        $date_stop = $mainframe->getUserStateFromRequest( $context.'date_stop', 'date_stop', '', 'string');
//        if($date_stop != '') $date_stop = date('Y-m-d', strtotime($date_stop));
//        if($date_start != '') $date_start = date('Y-m-d', strtotime($date_start));

        $limitstart = JRequest::getInt('limitstart');

        $_personnels = $this->getModel('personnel');

        if($client_id > 0)
            $filters['client_id'] = $client_id;

        $total = $_personnels->getCountPersonnels($filters, $search);

        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        $pagenav = $pagination->getPagesLinks();

        $rows = $_personnels->getAllPersonnels($filters, $orderby, $order, $limitstart, $limit, $search);

        $orderingby[] = JHTML::_('select.option', $value = 'id', $text= JText::_( 'ID' ), 'value', 'text');
        $orderingby[] = JHTML::_('select.option','name', JText::_( 'NAME' ) );
        $orderingby[] = JHTML::_('select.option','publish', JText::_( 'PUBLISH' ) );
        $orderingby[] = JHTML::_('select.option','client_name', JText::_( 'CLIENT' ) );
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
        
        $view = $this->getView('personnellist','html');
        $view->assign('pagination', $pagenav);
        $view->assign('pagination_obj', $pagination);
        $view->assign("rows", $rows);
        $view->assign('order', $order);
        $view->assign('orderby', $orderby);
        $view->assign('ordering', $ordering);
        $view->assign('deleted', $deleted);
        $view->assign('search', $search);
        $view->assign('orderingbyList', $orderingbyList);
        $view->assign('clientsList', $clientsList);
        $view->assign('orderingList', $orderingList);
//        $view->assign('date_stop', $date_stop);
//        $view->assign('keyservuces_list', $keyservuces_list);
        $view->display();
    }

}