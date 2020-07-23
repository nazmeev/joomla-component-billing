<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=client&view=client_save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="control-group">
                    <label for="name" class="control-label"><?php echo jText::_('NAME');?></label>
                    <div class="controls">
                        <input type="text" name="name" value="<?php echo $this->client->name; ?>" required="">
                    </div>
                </div>
                <div class="control-group">
                    <label for="publish"><?php echo jText::_('PUBLISHED');?></label>
                    <div class="controls">
                        <?php
                            $checkox = '';
                            if(!$this->id) $this->client->publish =1; 
                            if($this->client->publish > 0){
                                $checkox = ' checked="checked"';
                            }
                        ?>                 
                        <input type="checkbox" id="publish" name="publish" value="1" <?php echo $checkox; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                        <a href="<?php echo JRoute::_('index.php?option=com_billing&view=clients'); ?>" class="btn btn-link"><?php echo JText::_('TO_BACK');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $this->id; ?>" name="id">
    <?php echo JHTML::_( 'form.token' ); ?>
</form>