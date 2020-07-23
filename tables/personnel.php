<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingPersonnel extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_personnels', 'id', $db);
    }
    
    function client_name($client_id){
        $query = "SELECT COUNT(id) FROM `#__billing_clients` WHERE ".$this->_db->QuoteName('id')." = ".$this->_db->Quote($client_id);
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }
}