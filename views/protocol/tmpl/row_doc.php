<?php defined('_JEXEC') or die('Restricted access'); ?>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_billing&controller=documents&view=documents&protocol_id='.$row->id);?>" ><?php echo $row->issueName; ?></a>
    </td>
    <td class="text-center">
        <?php if($row->date != '00.00.0000') echo $row->date; ?>
    </td>
    <td>
        <p><?php echo $row->clientName; ?></p>
        <p><?php echo $row->personelName; ?></p>
    </td>
    <td>
        <?php echo $row->comment; ?>
    </td>
    <td>
        <a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_billing&controller=protocol&view=edit&id='.$row->id);?>"><?php echo JText::_('EDIT'); ?></a>
    </td>