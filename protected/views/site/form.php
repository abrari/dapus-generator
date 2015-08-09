<style type="text/css">
    .tab-content .form {
        margin-top: 20px;
    }
</style>

<?php
/* @var $this SiteController */
/* @var $form CActiveForm */
?>

<div class="jumbotron subhead">
    <div class="container">
        <h1>Pembuatan Sitasi Manual</h1>
        <p>Tentukan jenis pustaka, dan masukkan data-datanya pada <em>form</em> berikut.</p>
    </div>        
</div>

<div class="container">    
    <div class="row">

        <?php $this->widget(
            'booster.widgets.TbTabs',
            array(
                'type' => 'tabs',
                'id' => 'tabs',
                'tabs' => array(
                    array(
                        'id' => 'hint',
                        'label' => 'Jenis Pustaka:',
                        'itemOptions' => array('id' => 'tab-hint')
                    ),
                    array(
                        'id' => 'book',
                        'label' => 'Buku',
                        'content' => $this->renderPartial('form/book', array('book' => $book), true),
                        'active' => true
                    ),
                    array(
                        'id' => 'thesis',
                        'label' => 'Tugas Akhir',
                        'content' => $this->renderPartial('form/thesis', array('thesis' => $thesis), true),
                    ),
                    array(
                        'id' => 'journal',
                        'label' => 'Jurnal',
                        'content' => $this->renderPartial('form/journal', array('journal' => $journal), true),
                    ),
                    array(
                        'id' => 'proceeding',
                        'label' => 'Prosiding',
                        'content' => $this->renderPartial('form/proceeding', array('proceeding' => $proceeding), true),
                    )
                )
            )
        );?>
        
    </div>
    
    <?php if(isset($citation) && isset($inline)) : ?>
    
    <div class="modal fade" id="result-popup" tabindex="-1" role="dialog" aria-labelledby="loading" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Entri Daftar Pustaka</h4>

                    <div class="well">
                        <p class="ipb-text" contenteditable="true"><?php echo $citation; ?></p>
                    </div>

                    <h4>Sitasi dalam Teks</h4>

                    <div class="well">
                        <p class="ipb-text" contenteditable="true"><?php echo $inline; ?></p>
                    </div>           
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>                
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
    $(document).ready(function() {
        $('#result-popup').modal({
            backdrop : "static",
            keyboard : false
        });
    });
    </script>
    
    <?php endif; ?>
    
</div>

<?php if((new CHttpRequest)->getParam("tab") != null): ?>
    <script>
        $(document).ready(function() { 
            $('#tabs a[href*="<?php echo (new CHttpRequest)->getParam("tab"); ?>"]').tab('show');
        });
    </script> 
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#tab-hint').css({padding:'10px 15px'}).html("Jenis Pustaka:");
});
</script>