<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=personnel&view=personnel_save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="control-group">
                    <label for="name" class="control-label"><?php echo jText::_('NAME');?></label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $this->personnel->name; ?>" required="">
                    </div>
                </div>
                <div class="control-group">
                    <label for="client_id" class="control-label"><?php echo jText::_('CLIENT');?></label>
                    <div class="controls">
                        <?php echo $this->clientsList; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="publish"><?php echo jText::_('PUBLISHED');?></label>
                    <div class="controls">
                        <?php
                            $checkox = '';
                            if(!$this->id) $this->personnel->publish =1; 
                            if($this->personnel->publish > 0){
                                $checkox = ' checked="checked"';
                            }
                        ?>                 
                        <input type="checkbox" id="publish" name="publish" value="1" <?php echo $checkox; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                        <a href="<?php echo JRoute::_('index.php?option=com_billing&view=personnels'); ?>" class="btn btn-link"><?php echo JText::_('TO_BACK');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $this->id; ?>" name="id">
    <?php echo JHTML::_( 'form.token' ); ?>
</form>