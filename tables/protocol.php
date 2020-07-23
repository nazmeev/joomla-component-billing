<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingProtocol extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_protocol', 'id', $db);
    }
}