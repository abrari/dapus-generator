<?php
/* @var $this SiteController */
/* @var $book Book */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'book-form',
    'enableAjaxValidation' => true,
    'action' => $this->createUrl('') . '?tab=book',
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well')
)); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="isbn-input">Cari berdasarkan ISBN</label>
    <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="form-control isbn-input" placeholder="ISBN" id="isbn-input">
          <span class="input-group-btn">
              <input type="button" class="btn btn-primary isbn-input" value="Cari" onclick="searchISBN();">
          </span>
        </div><!-- /input-group -->        
    </div>
    <div class="col-sm-6"></div>
</div>    
    
<hr/>
    
<?php echo $form->textFieldGroup($book,'authors', array(
    'hint' => 'Pisahkan nama-nama pengarang dengan koma. Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($book,'year'); ?>
<?php echo $form->textFieldGroup($book,'title'); ?>
<?php echo $form->textFieldGroup($book,'edition'); ?>
<?php echo $form->textFieldGroup($book,'editors', array(
    'hint' => 'Pisahkan nama-nama editor dengan koma (jika ada). Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($book,'pub_city'); ?>
<?php echo $form->textFieldGroup($book,'pub_country', array(
    'hint' => 'Masukkan dua huruf kode negara. Lihat <a target="_blank" href="https://id.wikipedia.org/wiki/ISO_3166-1">daftar kode negara</a>.'
)); ?>
<?php echo $form->textFieldGroup($book,'pub'); ?>

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
function searchISBN() {
    var isbn = $('#isbn-input').val();
    var url = '<?php echo $this->createUrl('site/isbn') ?>/' + isbn;
    
    if(isbn == '') return false;
    
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function (xhr) {
            $('.isbn-input').prop('disabled', true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error: " + jqXHR.responseText);
            
            $('.isbn-input').prop('disabled', false);
        },
        success: function (data, textStatus, jqXHR) {
            $("[id^=Book_]").each(function(){
                var id = $(this).attr('id');
                if(id.indexOf('_em_') < 0) {
                    $('#' + id).val(data[id.slice(5)]);
                }
            });

            $('.isbn-input').prop('disabled', false);
        }
    });
}
</script>