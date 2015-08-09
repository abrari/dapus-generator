<?php
/* @var $this SiteController */
/* @var $thesis Thesis */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'thesis-form',
    'action' => $this->createUrl('') . '?tab=thesis',
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well')
)); ?>

<?php echo $form->textFieldGroup($thesis,'authors', array(
    'hint' => 'Tidak perlu membalik nama depan dan nama belakang.'
)); ?>
<?php echo $form->textFieldGroup($thesis,'year'); ?>
<?php echo $form->textFieldGroup($thesis,'title'); ?>
<?php echo $form->dropDownListGroup($thesis,'thesis_type', array('widgetOptions' => 
    array('data' => array('skripsi'=>"Skripsi", 'tesis'=>"Tesis", 'disertasi'=>"Disertasi"))
)); ?>

<?php echo $form->textFieldGroup($thesis,'univ_city'); ?>
<?php echo $form->textFieldGroup($thesis,'univ_country', array(
    'hint' => 'Masukkan dua huruf kode negara. Lihat <a target="_blank" href="https://id.wikipedia.org/wiki/ISO_3166-1">daftar kode negara</a>.'
)); ?>
<?php echo $form->textFieldGroup($thesis,'univ_faculty'); ?>
<?php echo $form->textFieldGroup($thesis,'univ'); ?>    
    
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