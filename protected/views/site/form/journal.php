<?php
/* @var $this SiteController */
/* @var $journal Journal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'journal-form',
    'action' => $this->createUrl('') . '?tab=journal',
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well')
)); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="doi-input">Cari berdasarkan DOI</label>
    <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="form-control doi-input" placeholder="DOI" id="doi-input">
          <span class="input-group-btn">
              <input type="button" class="btn btn-primary doi-input" value="Cari" onclick="searchDOI();">
          </span>
        </div><!-- /input-group -->        
    </div>
    <div class="col-sm-6"></div>
</div>    
    
<hr/>
    
    
<?php echo $form->textFieldGroup($journal,'authors', array(
    'hint' => 'Pisahkan nama-nama pengarang dengan koma. Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($journal,'year'); ?>
<?php echo $form->textFieldGroup($journal,'title'); ?>
<?php echo $form->textFieldGroup($journal,'journal'); ?>
<?php echo $form->textFieldGroup($journal,'volume'); ?>
<?php echo $form->textFieldGroup($journal,'issue'); ?>
<?php echo $form->textFieldGroup($journal,'pages'); ?>
<?php echo $form->textFieldGroup($journal,'doi'); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for=""></label>
    <div class="col-sm-9">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array('buttonType' => 'submit', 'label' => 'Submit', 'context' => 'success', 'size' => 'large')
        ); ?>
    </div>
</div>    

<?php $this->endWidget(); ?> 

</div><!-- form -->

<script type="text/javascript">
function searchDOI() {
    var doi = $('#doi-input').val();
    var url = '<?php echo $this->createUrl('site/doi') ?>?doi=' + doi;
    
    if(doi == '') return false;
    
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function (xhr) {
            $('.doi-input').prop('disabled', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error: " + jqXHR.responseText);
            
            $('.doi-input').prop('disabled', false);
        },
        success: function (data, textStatus, jqXHR) {
            $("[id^=Journal_]").each(function(){
                var id = $(this).attr('id');
                if(id.indexOf('_em_') < 0) {
                    $('#' + id).val(data[id.slice(8)]);
                }
            });

            $('.doi-input').prop('disabled', false);
        }
    });
}
</script>