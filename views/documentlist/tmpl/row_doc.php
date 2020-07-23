<?php defined('_JEXEC') or die('Restricted access');?>
<tr>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_billing&controller=document&view=document&id='.$row->id);?>"><?php echo $row->doctypeName; ?></a>
    </td>
    <td>
        <?php echo $row->clientName; ?>
    </td>
    <td>
        <?php echo $row->personelName; ?>
    </td>
    <td class="text-center">
        <?php if($row->date != '00.00.0000') echo $row->date; ?>
    </td>
    <td class="text-center <?php echo $classExist; ?>">
        <?php echo $textExist; ?>
    </td>
</tr>