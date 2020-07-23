<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=issue&view=issue_save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="control-group">
                    <p for="name" class="control-label"><?php echo jText::_('NAME');?></p>
                    <div class="controls">
                        <input class="col-md-7" type="text" name="name" value="<?php echo $this->issue->name; ?>" required="">
                    </div>
                </div>
                <div class="control-group">
                    <label for="publish"><?php echo jText::_('PUBLISHED');?></label>
                    <div class="controls">
                        <?php
                            $checkox = '';
                            if(!$this->id) $this->issue->publish =1; 
                            if($this->issue->publish > 0){
                                $checkox = ' checked="checked"';
                            }
                        ?>                 
                        <input type="checkbox" id="publish" name="publish" value="1" <?php echo $checkox; ?>>
                    </div>
                </div>
                <?php 
                if($this->issue->id){
                ?>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary" type="button" id="adddocument"><?php echo jText::_('ADDDOCUMENT');?></button>
                    </div>
                </div>
                <div class="documents">
                    <?php echo ($this->documents); ?>
                </div>
                <div id="result">
                    
                </div>
                <?php } ?>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                        <a href="<?php echo JRoute::_('index.php?option=com_billing&view=issues'); ?>" class="btn btn-link"><?php echo JText::_('TO_BACK');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $this->id; ?>" name="id">
    <?php echo JHTML::_( 'form.token' ); ?>
</form>


<script>
document.addEventListener("DOMContentLoaded", () => {
    
    const apiUrl = '<?php echo JRoute::_('index.php?option=com_billing&controller=issue&view=adddoctype', 0)?>';
    //const apiremoveUrl = '<?php echo JRoute::_('index.php?option=com_billing&controller=issue&view=removedocument', 0)?>';
    
    const addButton = document.getElementById("adddocument");
    //const removeButton = document.getElementByClassName("removedocument");
    
    const result = document.getElementById('result');
    
    function initListeners() {
        addButton.addEventListener('click', addButtonHandler);
        //removeButton.addEventListener('click', removeButtonHandler);
    }
    
    function addButtonHandler() {
       fetch(apiUrl).then(function(response) {
            return response.json()
          }).then(function(json) {
            renderResult(json, result)
          });
    }
    function removeButtonHandler() {
        alert('')
//       var id = removeButton.attr('data-id');
//       fetch(`${apiremoveUrl}${id}`).then(function(response) {
//            return response.json()
//          }).then(function(json) {
//            removeResult(json, result)
//          });
    }
    function getListDocument() {
        return fetch(`${apiUrl}`).then(result => result.json());
    }
    function renderResult(html, target) {
        target.innerHTML = `${html.html}`;
    }
    function removeDocument(){
        alert('')
    }
    initListeners();
})    
</script>