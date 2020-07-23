<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_billing&view=protocol');?>" method="POST" name="form-search">
    <div class="container">
        
        <div class="row">
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('CLIENT'); ?></label>
                    <div class="controls">
                        <?php echo $this->clientsList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('PERSONNEL'); ?></label>
                    <div class="controls">
                        <?php echo $this->personnelsList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERBY'); ?></label>
                    <div class="controls">
                        <?php echo $this->orderingbyList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERTO'); ?></label>
                    <div class="controls">
                        <?php echo $this->orderingList; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2 text-right">
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
                <table class="table table-hover">
                    <?php 
                    require ('row_head.php'); 
                    foreach($this->rows as $row) :
                        echo '<tr>';
                        require ('row_doc.php'); 
                        echo '</tr>';
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

<script>
    const apiUrl = '<?php echo JRoute::_('index.php?option=com_billing&controller=process&view=getpersonnel', 0)?>';
    const clients = document.getElementById("client_id");
    const personnels = document.getElementById("personnel_id");
    
    function initListeners(){
        clients.addEventListener('change', getClientHandler);
    }
    
    function getClientHandler() {
       var client_id = clients.value;
       var url = apiUrl + '&client_id=' + client_id;
       fetch(url).then(function(response) {
            return response.json()
          }).then(function(json) {
            renderOptions(json, personnels)
          });
    }
    function renderOptions(optionsList, target) {
        let template = '';
        optionsList.forEach(option => {
            console.log(option);
            template += `<option value="${option.id}">${option.name}</option>`;
        });
        
        target.innerHTML = '<option value=""><?php echo JText::_('SELECT');?></option>'+template;
    }
    
    initListeners();
</script>