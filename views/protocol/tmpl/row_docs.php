<?php defined('_JEXEC') or die('Restricted access'); ?>
<td colspan="99">
    <table class="table">
        
    <?php foreach($row->docs as $doc){?>
        <tr>
            <td><a href="<?php echo JRoute::_('index.php?option=com_billing&controller=document&view=document&id='.$doc->id); ?>"><?php echo $doc->doctypeName; ?></a></td>
            <td><?php if($doc->date == '00.00.0000') echo 'x'; else echo $doc->date; ?></td>
            <td><?php if($doc->exist > 0) echo JText::_('EXIST'); else echo JText::_('ABSENT'); ?></td>
        </tr>
    <?php } ?>
        
    </table>
</td>
