<style type="text/css">
    .tab-content .form {
        margin-top: 20px;
    }
</style>

<?php
/* @var $this SiteController */
/* @var $book Book */
/* @var $form CActiveForm */
?>

<div class="jumbotron subhead">
    <div class="container">
        <h1>Pembuatan Entri Daftar Pustaka</h1>
        <p>Tentukan jenis pustaka, dan masukkan data-datanya pada <em>form</em> berikut.</p>
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
    
    <div class="modal fade" id="result-popup" tabindex="-1" role="dialog" aria-labelledby="loading" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Entri Daftar Pustaka</h4>

                    <div class="well">
                        <p class="ipb-text"><?php echo $citation; ?></p>
                    </div>

                    <h4>Sitasi dalam Teks</h4>

                    <div class="well ipb-text">
                        <p class="ipb-text"><?php echo $inline; ?></p>
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