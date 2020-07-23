<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
foreach($this->doctypes as $doctype){
?>
    <div class="input-group">
        <p class="col-md-6"><?php echo $doctype->doc_name; ?></p>
        <span class="input-group-btn">
          <a class="btn btn-danger btn-remove" href="<?php echo JRoute::_('index.php?option=com_billing&controller=issue&view=removedoctype&id='.$doctype->id."&issue_id=".$doctype->issue_id); ?>"><?php echo JText::_( 'DELETE' ); ?></a>
        </span>
    </div><!-- /input-group -->
    <div>
        
    </div>        
<?php 
}

