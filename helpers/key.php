<?php
defined('_JEXEC') or die();

class FopHelpersKey{
    public static function RemoveExpiredKey(){
//        $db = JFactory::getDBO();
//        $query = "SELECT * FROM `#__fop_keys` WHERE date_stop < ".$db->Quote(date('Y-m-d'))." AND deleted = ".$db->Quote('0');
//        $db->setQuery($query);
//        $res = $db->loadObjectList();
//        print_r($res);
        $db = JFactory::getDBO();
        $query = "UPDATE ".$db->QuoteName('#__fops_keys')." SET ".$db->QuoteName('deleted')." = ".$db->quote(1)." WHERE date_stop < ".$db->Quote(date('Y-m-d'))." AND deleted = ".$db->Quote('0');
        $db->setQuery($query);
        $db->query();
    }
}