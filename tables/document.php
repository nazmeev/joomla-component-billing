<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingDocument extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_documents', 'id', $db);
    }
    
    function doctype_name($id){
        $query = "SELECT name FROM `#__billing_doctypes` WHERE ".$this->_db->QuoteName('id')." = ".$this->_db->Quote($id);
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }
}