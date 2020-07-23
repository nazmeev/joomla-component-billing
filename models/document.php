<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
class BillingModelDocument extends JModelLegacy{
    function getCountDocuments($filters, $search){
        $adv = $this->queryFilter($filters);
        $query = "SELECT COUNT(*) FROM `#__billing_documents` a "
                . " LEFT JOIN `#__billing_protocol` p ON a.protocol_id = p.id "
                . "WHERE a.".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)." ".$adv;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
        //$this->_db->stderr();
    }
    function getAllDocuments($filters, $orderby, $order, $limitstart, $limit, $search){
        $adv = $this->queryFilter($filters);
        $query = "SELECT a.id, DATE_FORMAT(a.date, '%d.%m.%Y') as date, a.exist, d.name as doctypeName, c.name as clientName, pp.name as personelName FROM `#__billing_documents` a "
                . " LEFT JOIN `#__billing_protocol` p ON a.protocol_id = p.id "
                . " LEFT JOIN `#__billing_doctypes` d ON a.doctype_id = d.id "
                . " LEFT JOIN `#__billing_clients` c ON p.client_id = c.id "
                . " LEFT JOIN `#__billing_personnels` pp ON p.personnel_id = pp.id "
                . " WHERE a.".$this->_db->QuoteName('deleted')." = ".$this->_db->Quote(0)
                . " ".$adv;
        $query .= ' ORDER BY '.$orderby.' '.$order;

        if ($limit){
            $this->_db->setQuery($query, $limitstart, $limit);
        }else{
            $this->_db->setQuery($query);
        }
        $rows = $this->_db->loadObjectList();
//        $this->_db->setQuery($query);
        return $rows;
    }
    private function queryFilter($filters){
        $adv = '';
        if(is_array($filters) and count($filters) > 0)
        foreach($filters as $key=>$data){
            switch ($key) {
                case 'datefrom':
                    $adv.= ' AND a.'.$this->_db->QuoteName('date').' > '.$this->_db->Quote($data);
                break;
                case 'dateto':
                    $adv.= ' AND a.'.$this->_db->QuoteName('date').' <= '.$this->_db->Quote($data);
                break;
//                case 'issue_id':
//                    $adv.= ' AND p.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
//                break;
//                case 'exist':
//                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
//                break;
                case 'date':
                    if($data)
                        $adv.= ' AND a.'.$this->_db->QuoteName('date').' = '.$this->_db->Quote('0000-00-00');
                    else
                        $adv.= ' AND a.'.$this->_db->QuoteName('date').' != '.$this->_db->Quote('0000-00-00');
                break;
                default:
                    $adv.= ' AND a.'.$this->_db->QuoteName($key).' = '.$this->_db->Quote($data);
                break;
            }
        }
        return $adv;
    }

    function generateOrderingby($selected){
        $option[] = JHTML::_('select.option', 'id', 'ID', 'value', 'text');
        $option[] = JHTML::_('select.option','exist', 'EXISTENCE' );
        $option[] = JHTML::_('select.option','clientName', 'CLIENT' );
        $option[] = JHTML::_('select.option','date', 'DATE' );
        return JHTML::_('select.genericlist', $option, $name = 'orderby', $attribs = null, $key = 'value', $text = 'text', $selected, $idtag = false, $translate = true );
    }
    function generateOrdering($selected){
        $option[] = JHTML::_('select.option', 'asc', 'ASC', 'value', 'text');
        $option[] = JHTML::_('select.option', 'desc', 'DESC');
        return JHTML::_('select.genericlist', $option, $name = 'order', $attribs = null, $key = 'value', $text = 'text', $selected, $idtag = false, $translate = true );
    }
    
    function generateShowOnly($selected){
        $option[] = JHTML::_('select.option', $value = '0', 'SELECT', 'value', 'text');
        $option[] = JHTML::_('select.option','exist', 'DOCEXIST' );
        $option[] = JHTML::_('select.option','absent', 'DOCABSENT' );
        $option[] = JHTML::_('select.option','dateis', 'DATEEXIST' );
        $option[] = JHTML::_('select.option','dateisnt', 'DATEABSENT' );
        return JHTML::_('select.genericlist', $option, $name = 'showOnly', $attribs = null, $key = 'value', $text = 'text', $selected, $idtag = false, $translate = true );
    }
    function generateSelect($array, $selected, $name){
        $list_null = array('0'=>JHTML::_('select.option', $value = '', $text= JText::_( 'SELECT' ), 'id', 'name' ));
        return JHTML::_('select.genericlist', array_merge($list_null, $array), $name, $attribs = ' ', $key = 'id', $text = 'name', $selected, $idtag = false, $translate = false);
    }
}