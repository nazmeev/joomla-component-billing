<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelPersonnel extends JModelLegacy{
    function getCountPersonnels($filters, $search){
        $adv = '';
        if(is_array($filters) and count($filters) > 0)
        foreach($filters as $key=>$data){
            switch ($key) {
                default:
                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
                break;
            }
        }
        if($search != ''){
            $adv.= ' AND (a.'.$this->_db->QuoteName('name').' LIKE "%'.$this->_db->escape($search).'%")';
        }

        $query = "SELECT COUNT(*) FROM `#__billing_personnels` a "
                . " INNER JOIN `#__billing_clients` b ON a.client_id = b.id "
                . "WHERE a.".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
        //$this->_db->stderr();
    }
    function getAllPersonnels($filters, $orderby, $order, $limitstart, $limit, $search){
        $adv = '';
        if(is_array($filters) and count($filters) > 0)
        foreach($filters as $key=>$data){
            switch ($key) {
                default:
                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
                break;
            }
        }
        if($search != ''){
            $adv.= ' AND (a.'.$this->_db->QuoteName('name').' LIKE "%'.$this->_db->escape($search).'%")';
        }

        $query = "SELECT a.*, b.name as client_name FROM `#__billing_personnels` a "
                . " INNER JOIN `#__billing_clients` b ON a.client_id = b.id "
                . "WHERE a.".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;
        $query .= ' ORDER BY '.$orderby.' '.$order;
        if ($limit){
            $this->_db->setQuery($query, $limitstart, $limit);
        }else{
            $this->_db->setQuery($query);
        }
        $rows = $this->_db->loadObjectList();
        $this->_db->setQuery($query);
        return $rows;
    }
}