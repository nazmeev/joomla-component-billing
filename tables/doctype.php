<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingDoctype extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_doctypes', 'id', $db);
    }
}