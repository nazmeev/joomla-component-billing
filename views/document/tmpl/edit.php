<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=document&view=document_save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="control-group">
                    <label for="name" class="control-label"><?php echo jText::_('NAME');?></label>
                    <div class="controls">
                        <p class="form-control-static"><?php echo $this->document->doctypeName; ?></p>
                    </div>
                </div>
                <div class="control-group">
                    <label for="date" class="control-label"><?php echo jText::_('DATE');?></label>
                    <div class="controls">
                        <?php echo JHtml::_('calendar', $this->document->date, 'date', 'date', '%Y-%m-%d', null); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="checkbox-inline">
                        <?php
                            $checkox = '';
                            if(!$this->id) $this->document->exist =1; 
                            if($this->document->exist > 0){
                                $checkox = ' checked="checked"';
                            }
                        ?>
                        <input type="checkbox" id="exist" name="exist" value="1" <?php echo $checkox; ?>> <?php echo jText::_('EXIST');?>
                    </label>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                        <a href="<?php echo JRoute::_('index.php?option=com_billing&view=documents'); ?>" class="btn btn-link"><?php echo JText::_('TO_BACK');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $this->id; ?>" name="id">
    <?php echo JHTML::_( 'form.token' ); ?>
</form>