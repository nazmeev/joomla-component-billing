<?php defined('_JEXEC') or die('Restricted access'); ?>
<td class="row-id" data-id="<?php echo $row->id; ?>">
    <?php echo $row->id; ?>
</td>
<td>
    <?php echo $row->name; ?>
</td>
<td>
    <?php echo $row->client_name; ?>
</td>
<td>
    <?php if($row->publish) echo JText::_('PUBLISHED'); else echo JText::_('UNPUBLISHED'); ?>
</td>
<td class="clicker text-right">
    <div class="btn-group" role="group" aria-label="...">
        <a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_billing&controller=personnel&view=personnel&id='.$row->id);?>"><?php echo JText::_('EDIT'); ?></a>
        <a class="btn btn-danger btn-remove" alt="<?php echo JText::_('REMOVE'); ?>" href="<?php echo JRoute::_('index.php?option=com_billing&controller=personnel&view=remove&id='.$row->id);?>"><i class="fa fa-remove"></i></a>
    </div>
</td>
