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
<?php echo $form->textFieldGroup($book,'pub_country'); ?>
<?php echo $form->textFieldGroup($book,'pub'); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for=""></label>
    <div class="col-sm-9">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array('buttonType' => 'submit', 'label' => 'Submit')
        ); ?>
    </div>
</div>    

<?php $this->endWidget(); ?>

</div><!-- form -->