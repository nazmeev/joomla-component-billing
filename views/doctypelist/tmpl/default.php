<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_billing&view=doctypes');?>" method="POST" name="form-search">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <a class="btn btn-info" href="<?php echo JRoute::_('index.php?option=com_billing&controller=doctype&view=doctype');?>" ><?php echo JText::_('CREATE'); ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('SEARCH'); ?></label>
                    <div class="controls">
                        <input type="text" name="search" value="<?php echo $this->search; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERBY'); ?></label>
                    <div class="controls">
                        <?php echo $this->orderingbyList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERTO'); ?></label>
                    <div class="controls">
                        <?php echo $this->orderingList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('&nbsp'); ?></label>
                    <div class="controls">
                        <input class="btn btn-success" type="submit" value="<?php echo JText::_('SUBMIT'); ?>">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</form>

<div class="container-component">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <table class="table table-hover results">
                    <?php 
                    require ('row_head.php'); 
                    foreach($this->rows as $row) :
                        echo '<tr>';
                        require ('row_doc.php'); 
                        echo '</tr>';
                        //require ('row_doc0.php'); 
                    endforeach;
                    ?>
                </table>
                <div class="jshop_pagination">
                    <div class="pagination"><?php print $this->pagination; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>