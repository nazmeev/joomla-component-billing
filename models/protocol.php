<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelProtocol extends JModelLegacy{
    function getCountProtocol($filters){
        $adv = '';
        if(is_array($filters) and count($filters) > 0)
        foreach($filters as $key=>$data){
            switch ($key) {
                default:
                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
                break;
            }
        }

        $query = "SELECT COUNT(*) FROM `#__billing_protocol` a WHERE 1=1 ".$adv;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
        //$this->_db->stderr();
    }
    function getAllProtocol($filters, $orderby, $order, $limitstart, $limit){
        $adv = '';
        if(is_array($filters) and count($filters) > 0)
        foreach($filters as $key=>$data){
            switch ($key) {
                default:
                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
                break;
            }
        }

        $query = "SELECT a.*, c.name as clientName, i.name as issueName, p.name as personelName, DATE_FORMAT(a.date, '%d.%m.%Y') as date FROM `#__billing_protocol` a "
                    . " LEFT JOIN `#__billing_clients` c ON a.client_id = c.id "
                    . " LEFT JOIN `#__billing_issues` i ON a.issue_id = i.id "
                    . " LEFT JOIN `#__billing_personnels` p ON a.personnel_id = p.id "
                    . "WHERE 1=1 ".$adv;
        $query .= ' ORDER BY '.$orderby.' '.$order;
        if ($limit){
            $this->_db->setQuery($query, $limitstart, $limit);
        }else{
            $this->_db->setQuery($query);
        }
        $rows = $this->_db->loadObjectList();

        return $rows;
    }
}