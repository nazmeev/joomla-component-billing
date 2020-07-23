<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=protocol&view=save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="control-group">
                    <label for="name" class="control-label"><?php echo jText::_('COMMENT');?></label>
                    <div class="controls">
                        <textarea name="comment"><?php echo $this->protocol->comment; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label for="date" class="control-label"><?php echo jText::_('DATE');?></label>
                    <div class="controls">
                        <?php echo JHtml::_('calendar', $this->protocol->date, 'date', 'date', '%Y-%m-%d', null); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                        <a href="<?php echo JRoute::_('index.php?option=com_billing&view=protocol'); ?>" class="btn btn-link"><?php echo JText::_('TO_BACK');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $this->id; ?>" name="id">
    <?php echo JHTML::_( 'form.token' ); ?>
</form>