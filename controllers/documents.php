<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class BillingControllerDocuments extends JControllerLegacy{
    function documents(){
        JLoader::discover('BillingHelpers', "components/com_billing/helpers");
        BillingHelpersUser::CheckAuthorization();

//        $search = JRequest::getVar('search');
//        $doctype_id = JRequest::getInt('doctype_id');
        $issue_id = JRequest::getInt('issue_id');
        $protocol_id = JRequest::getInt('protocol_id');

        $mainframe = JFactory::getApplication();
        $context = 'documentslist';
        $orderby = $mainframe->getUserStateFromRequest( $context.'orderby', 'orderby', 'id', 'string');
        $order = $mainframe->getUserStateFromRequest( $context.'order', 'order', 'desc', 'string');
        $limit = $mainframe->getUserStateFromRequest( $context.'limit', 'limit', '25', 'int');
//        $deleted = $mainframe->getUserStateFromRequest( $context.'deleted', 'deleted', '0', 'int');
        $client_id = $mainframe->getUserStateFromRequest( $context.'client_id', 'client_id', '0', 'int');
        $personnel_id = $mainframe->getUserStateFromRequest( $context.'personnel_id', 'personnel_id', '0', 'int');
        $dateFrom = $mainframe->getUserStateFromRequest( $context.'datefrom', 'datefrom', '', 'string');
        $dateTo = $mainframe->getUserStateFromRequest( $context.'dateto', 'dateto', '', 'string');
        $showOnly = $mainframe->getUserStateFromRequest( $context.'showOnly', 'showOnly', '', 'string');

        $limitstart = JRequest::getInt('limitstart');

        $_document = $this->getModel('document');
        $_protokol = $this->getModel('protokol');

        if($client_id > 0)          $filters['client_id'] = $client_id;
        if($personnel_id > 0)       $filters['personnel_id'] = $personnel_id;
        if($dateFrom != '')         $filters['datefrom'] = $dateFrom;
        if($dateTo != '')           $filters['dateto'] = $dateTo;
        if($issue_id > 0)           $filters['issue_id'] = $issue_id;
        if($showOnly == 'exist')    $filters['exist'] = 1;
        if($showOnly == 'absent')   $filters['exist'] = 0;
        if($showOnly == 'dateis')   $filters['date'] = 0;
        if($showOnly == 'dateisnt') $filters['date'] = 1;
        if($protocol_id)            $filters['protocol_id'] = $protocol_id;

        $total = $_document->getCountDocuments($filters, $search);

        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        $pagenav = $pagination->getPagesLinks();

        $rows = $_document->getAllDocuments($filters, $orderby, $order, $limitstart, $limit, $search);
   
        $list['orderingbyList'] = $_document->generateOrderingby($orderby);
        $list['orderingList'] = $_document->generateOrdering($order);

        $_clients = $this->getModel('client');
        $clients = $_clients->getAllClients(array(), 'name', 'asc', '0', '', '');
        $list['clientsList'] = $_document->generateSelect($clients, $client_id, 'client_id');

        if($client_id){
            $_personnel = $this->getModel('personnel');
            $personnels = $_personnel->getAllPersonnels(array('client_id'=>$client_id), 'name', 'asc', 0, '', '');
        }else{
            $personnels = array();
        }
        $list['personnelsList'] = $_document->generateSelect($personnels, $personnel_id, 'personnel_id');
        $list['showOnlyList'] = $_document->generateShowOnly($showOnly);
        
        $view = $this->getView('documentlist','html');
        $view->assign('pagination', $pagenav);
        $view->assign('pagination_obj', $pagination);
        $view->assign("rows", $rows);
        $view->assign('dateFrom', $dateFrom);
        $view->assign('dateTo', $dateTo);
        $view->assign('list', $list);
        $view->display();
    }

}