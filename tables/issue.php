<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class BillingIssue extends JTable
{

    function __construct( &$db )
    {
        parent::__construct('#__billing_issues', 'id', $db);
    }
}