<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelIssue extends JModelLegacy{
    function getCountIssues($filters, $search){
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

        $query = "SELECT COUNT(id) FROM `#__billing_issues` WHERE ".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
        //$this->_db->stderr();
    }
    function getAllIssues($filters, $orderby, $order, $limitstart, $limit, $search){
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
        $query = "SELECT * FROM `#__billing_issues` WHERE ".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;//tyt
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

//    function Erase($id){
//        $query = "DELETE FROM `#__billing_issues_documents` WHERE `issue_id` = ".$this->_db->Quote($id);
//        $this->_db->setQuery($query);
//        $this->_db->query();
//    }
    function removeDocument($id){
        $query = "DELETE FROM `#__billing_issues_doctypes` WHERE `id` = ".$this->_db->Quote($id);
        $this->_db->setQuery($query);
        $this->_db->query();
    }
    
    function setDoctype($id, $doctypes = array()){
        foreach($doctypes as $doctype){
            $query = 'INSERT INTO '.$this->_db->QuoteName('#__billing_issues_doctypes').' SET '.$this->_db->QuoteName('issue_id').' = '.$this->_db->quote($id).', '.$this->_db->QuoteName('doctype_id').' = '.$this->_db->quote($doctype); 
            $this->_db->setQuery($query);
            $this->_db->query();
        }
    }
    
    function getDoctypes($id){
        $queryInner.= " INNER JOIN `#__billing_doctypes` b ON a.doctype_id = b.id ";
        $query = "SELECT a.id, a.issue_id, a.doctype_id, b.name as doc_name FROM `#__billing_issues_doctypes` a ".$queryInner;        
        $query.= "WHERE ".$this->_db->QuoteName('issue_id')." = ".$this->_db->Quote($id);
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }
}