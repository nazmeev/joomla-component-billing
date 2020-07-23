<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelDoctype extends JModelLegacy{
    function getCountDoctypes($filters, $search){
        $adv = '';
        foreach($filters as $key=>$data){
            switch ($key) {
                case 'date_stop':
                    if($data != '')
                        $adv.= ' AND a.'.$db->QuoteName('date_stop').' <= '.$db->Quote($data);
                break;
                default:
                    $adv.= ' AND a.'.$db->QuoteName($key).' = '.$db->Quote($data);
                break;
            }
        }
        if($search != ''){
            $adv.= ' AND ('.$this->_db->QuoteName('name').' LIKE "%'.$this->_db->escape($search).'%")';
        }

        $query = "SELECT COUNT(id) FROM `#__billing_doctypes` WHERE ".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
        //$this->_db->stderr();
    }
    function getAllDoctypes($filters, $orderby, $order, $limitstart, $limit, $search){
        $adv = '';
        foreach($filters as $key=>$data){
            switch ($key) {
                case 'date_stop':
                    if($data != '')
                        $adv.= ' AND a.'.$db->QuoteName('date_stop').' <= '.$db->Quote($data);
                break;
                case 'date_start':
                    if($data != '')
                        $adv.= ' AND a.'.$db->QuoteName('date_start').' > '.$db->Quote($data);
                break;
                default:
                    $adv.= ' AND a.'.$db->QuoteName($key).' = '.$db->Quote($data);
                break;
            }
        }
        if($search != ''){
            $adv.= ' AND ('.$this->_db->QuoteName('name').' LIKE "%'.$this->_db->escape($search).'%")';
        }

        //$query = "SELECT * FROM `#__fops_keys` WHERE ".$db->QuoteName('deleted')." = ".$db->Quote(0)." ".$adv;//tyt
        //echo $query = "SELECT a.*, b.shortname, c.name as servicename FROM `#__fop_keys` a INNER JOIN `#__fops` b ON a.fop_id = b.id INNER JOIN `#__fop_key_services` c ON a.keyservice_id = c.id WHERE a.".$db->QuoteName('deleted')." = ".$db->Quote(0)." AND b.".$db->QuoteName('deleted')." = ".$db->Quote(0)." ".$adv;//tyt
        $query = "SELECT * FROM `#__billing_doctypes` WHERE ".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;//tyt
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