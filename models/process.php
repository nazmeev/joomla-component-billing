<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelProcess extends JModelLegacy{
    function getDoctypesOfIssue($issue_id){
        $queryInner.= " INNER JOIN `#__billing_doctypes` b ON a.doctype_id = b.id ";
        $query = "SELECT a.id, a.doctype_id, b.name as doctype_name FROM `#__billing_issues_doctypes` a ".$queryInner;        
        $query.= "WHERE a.".$this->_db->QuoteName('issue_id')." = ".$this->_db->Quote($issue_id);
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }
}