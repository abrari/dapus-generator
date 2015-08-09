<?php
/* @var $this SiteController */
/* @var $proceeding Proceeding */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'proceeding-form',
    'action' => $this->createUrl('') . '?tab=proceeding',
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well')
)); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="doi-input">Cari berdasarkan DOI</label>
    <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="form-control doi-input" placeholder="DOI" id="doi-input2">
          <span class="input-group-btn">
              <input type="button" class="btn btn-primary doi-input" value="Cari" onclick="searchProceedingDOI();">
          </span>
        </div><!-- /input-group -->        
    </div>
    <div class="col-sm-6"></div>
</div>    
    
<hr/>    
    
<?php echo $form->textFieldGroup($proceeding,'authors', array(
    'hint' => 'Pisahkan nama-nama pengarang dengan koma. Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($proceeding,'year'); ?>
<?php echo $form->textFieldGroup($proceeding,'title'); ?>
    
<?php echo $form->textFieldGroup($proceeding,'proc_name'); ?>    
<?php echo $form->textFieldGroup($proceeding,'editors', array(
    'hint' => 'Pisahkan nama-nama editor dengan koma (jika ada). Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($proceeding,'con_city', array(
    'hint' => 'Format: kota, negara. Contoh: Bogor, Indonesia'
)); ?>
<?php echo $form->textFieldGroup($proceeding,'con_date', array(
    'hint' => 'Format: tahun bulan tanggal. Contoh: 2014 Okt 19-22.'
)); ?>
    
<?php echo $form->textFieldGroup($proceeding,'pub_city'); ?>
<?php echo $form->textFieldGroup($proceeding,'pub_country', array(
    'hint' => 'Masukkan dua huruf kode negara. Lihat <a target="_blank" href="https://id.wikipedia.org/wiki/ISO_3166-1">daftar kode negara</a>.'
)); ?>
<?php echo $form->textFieldGroup($proceeding,'pub'); ?>

<?php echo $form->textFieldGroup($proceeding,'pages'); ?>    
    
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
function searchProceedingDOI() {
    var doi = $('#doi-input2').val();
    var url = '<?php echo $this->createUrl('site/doi') ?>?doi=' + doi + '&context=proceeding';
    
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
            $("[id^=Proceeding_]").each(function(){
                var id = $(this).attr('id');
                if(id.indexOf('_em_') < 0) {
                    $('#' + id).val(data[id.slice(11)]);
                }
            });

            $('.doi-input').prop('disabled', false);
        }
    });
}
</script>