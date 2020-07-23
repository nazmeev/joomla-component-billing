<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action = "<?php echo JRoute::_('index.php?option=com_billing&controller=process&view=process_save'); ?>" class="" role="form" method="POST" data-toggle="validator">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="control-group">
                    <label for="client_id" class="control-label"><?php echo jText::_('SELECT_CLIENT');?></label>
                    <div class="controls">
                        <?php echo $this->clientsList;?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="personnel_id" class="control-label"><?php echo jText::_('SELECT_PERSONNEL');?></label>
                    <div class="controls">
                        <?php echo $this->personnelsList;?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="issue_id" class="control-label"><?php echo jText::_('SELECT_ISSUE');?></label>
                    <div class="controls">
                        <?php echo $this->issuesList; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="date" class="control-label"><?php echo jText::_('DATE');?></label>
                    <div class="controls">
                        <?php echo JHtml::_('calendar', $this->document->date, 'date', 'date', '%Y-%m-%d', null); ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success" type="submit"><?php echo JText::_('SAVE');?></button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php echo JHTML::_( 'form.token' ); ?>
</form>

<script>
    const apiUrl = '<?php echo JRoute::_('index.php?option=com_billing&controller=process&view=getpersonnel', 0)?>';
    const clients = document.getElementById("client_id");
    const personnels = document.getElementById("personnel_id");
    
    
    function initListeners(){
        clients.addEventListener('change', getClientHandler);
        //removeButton.addEventListener('click', removeButtonHandler);
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