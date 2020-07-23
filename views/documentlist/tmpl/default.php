<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_billing&view=documents');?>" method="POST" name="form-search">
    <div class="container">
<!--        <div class="row">
            <div class="col-md-12 text-right">
                <a class="btn btn-info" href="<?php echo JRoute::_('index.php?option=com_billing&controller=document&view=document');?>" ><?php echo JText::_('CREATE'); ?></a>
            </div>
        </div>-->
<!--        <div class="row">
            <div class="col-md-12">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('SEARCH'); ?></label>
                    <div class="controls">
                        <input type="text" name="search" value="<?php echo $this->search; ?>">
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-md-3">
                <div class="control-group">
                    <label for="dateFrom" class="control-label"><?php echo jText::_('DATEFROM');?></label>
                    <div class="controls">
                        <?php echo JHtml::_('calendar', $this->dateFrom, 'datefrom', 'datefrom', '%Y-%m-%d', null); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label for="dateTo" class="control-label"><?php echo jText::_('DATETO');?></label>
                    <div class="controls">
                        <?php echo JHtml::_('calendar', $this->dateTo, 'dateto', 'dateto', '%Y-%m-%d', null); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('CLIENT'); ?></label>
                    <div class="controls">
                        <?php echo $this->list['clientsList']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('PERSONNEL'); ?></label>
                    <div class="controls">
                        <?php echo $this->list['personnelsList']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-2">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERBY'); ?></label>
                    <div class="controls">
                        <?php echo $this->list['orderingbyList']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('ORDERTO'); ?></label>
                    <div class="controls">
                        <?php echo $this->list['orderingList']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="control-group">
                    <label class="control-label"><?php echo JText::_('SHOWONLY'); ?></label>
                    <div class="controls">
                        <?php echo $this->list['showOnlyList']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
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
                        if($row->exist > 0){
                            $classExist = 'btn-success';
                            $textExist = JText::_('EXIST');
                        }else{
                            $classExist = 'btn-danger';
                            $textExist = JText::_('ABSENT');
                        }
                        echo '';
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