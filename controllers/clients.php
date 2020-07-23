<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class BillingControllerClients extends JControllerLegacy{
    function clients(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

        $search = JRequest::getVar('search');

        $mainframe = JFactory::getApplication();
        $context = 'clientslist';
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

        $_clients = $this->getModel('client');

        $filters = array();

        $total = $_clients->getCountClients($filters, $search);

        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        $pagenav = $pagination->getPagesLinks();

        $rows = $_clients->getAllClients($filters, $orderby, $order, $limitstart, $limit, $search);

        $orderingby[] = JHTML::_('select.option', $value = 'id', $text= JText::_( 'ID' ), 'value', 'text');
        $orderingby[] = JHTML::_('select.option','name', JText::_( 'NAME' ) );
        $orderingby[] = JHTML::_('select.option','publish', JText::_( 'PUBLISH' ) );
        $orderingbyList = JHTML::_('select.genericlist', $orderingby, $name = 'orderby', $attribs = null, $key = 'value', $text = 'text', $selected = $orderby, $idtag = false, $translate = false );
        
        $ordering[] = JHTML::_('select.option', $value = 'asc', $text= JText::_( 'ASC' ), 'value', 'text');
        $ordering[] = JHTML::_('select.option','desc', JText::_( 'DESC' ) );
        $orderingList = JHTML::_('select.genericlist', $ordering, $name = 'order', $attribs = null, $key = 'value', $text = 'text', $selected = $order, $idtag = false, $translate = false );

        $view = $this->getView('clientlist','html');
        $view->assign('pagination', $pagenav);
        $view->assign('pagination_obj', $pagination);
        $view->assign("rows", $rows);
        $view->assign('order', $order);
        $view->assign('orderby', $orderby);
        $view->assign('ordering', $ordering);
        $view->assign('deleted', $deleted);
        $view->assign('search', $search);
        $view->assign('orderingbyList', $orderingbyList);
        $view->assign('orderingList', $orderingList);
//        $view->assign('date_stop', $date_stop);
//        $view->assign('keyservuces_list', $keyservuces_list);
        $view->display();
    }

}