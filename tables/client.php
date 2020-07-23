<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingClient extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_clients', 'id', $db);
    }
}