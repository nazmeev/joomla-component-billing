<?php
defined('_JEXEC') or die();

class BillingHelpersUser{
    public static function CheckAuthorization(){
        $user = JFactory::getUser();
        if($user->id == 0) {
            $app = JFactory::getApplication();
            $app->enqueueMessage('You have to be authorizated', 'success');
            $app->redirect('index.php');
        }
    }
    public static function CheckAccess(){
        $user = JFactory::getUser();
        if($user->id == 0) {
            JError::raiseError( 4711, JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND') );
            jexit();
        }
    }
    public static function CheckData($fopID){
        if(!$fopID){
            JError::raiseError( 4711, JText::_('CHANGE_FOP_ID') );
            jexit();
        }
    }
}