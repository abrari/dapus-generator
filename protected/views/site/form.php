<style type="text/css">
    .tab-content .form {
        margin-top: 10px;
    }
</style>

<?php
/* @var $this SiteController */
/* @var $book Book */
/* @var $form CActiveForm */
?>

<div class="jumbotron">
    <div class="container">

        <h1>Format Daftar Pustaka</h1>
        <p>
            Aplikasi web ini dapat membantu pembuatan sitasi untuk daftar pustaka <br/>
            dengan berpedoman pada Pedoman Penulisan Karya Ilmiah (PPKI) IPB.
        </p>      
        
    </div>        
</div>

<div class="container">    
    <div class="row">

        <?php $this->widget(
            'booster.widgets.TbTabs',
            array(
                'type' => 'pills',
                'id' => 'tabs',
                'tabs' => array(
                    array(
                        'id' => 'book',
                        'label' => 'Buku',
                        'content' => $this->renderPartial('form/book', array('book' => $book), true),
                        'active' => true
                    ),
                    array(
                        'id' => 'journal',
                        'label' => 'Jurnal',
                        'content' => "Isi form jurnal"
                    )
                )
            )
        );?>
        
    </div>
    
    <?php if(isset($citation) && isset($inline)) : ?>
    <div class="row" id="result">
        <h3>Entri Daftar Pustaka</h3>

        <div class="well">
            <p class="ipb-text"><?php echo $citation; ?></p>
        </div>

        <h3>Sitasi dalam Teks</h3>

        <div class="well ipb-text">
            <p class="ipb-text"><?php echo $inline; ?></p>
        </div>           
    </div>
    <?php endif; ?>
    
</div>

<?php if((new CHttpRequest)->getParam("tab") != null): ?>
        <script>
            $(document).ready(function() { 
                $('#tabs a[href*="<?php echo (new CHttpRequest)->getParam("tab"); ?>"]').tab('show');
            });
        </script> 
<?php endif; ?>