
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autosize.js" type="text/javascript"></script>

<div class="jumbotron subhead">
    <div class="container">
        <h1>Pembuatan Sitasi Otomatis</h1>
        <p>Unggah <em>paper</em> dalam bentuk PDF, dan sistem akan mencoba membuat sitasinya.</p>
    </div>        
</div>

<div class="container">    
    <div class="row">
        <div class="col-md-12">
            <form class="well" action="<?php echo Yii::app()->request->baseUrl; ?>/site/upload" method="post" enctype="multipart/form-data" id="form">
                <div class="form-group">
                    <label class="control-label" for="q">Unggah berkas <em>paper</em> dalam bentuk PDF:</label>
                    <div>            
                        <?php
                            $model = new PDFUpload();
                            echo CHtml::activeFileField($model, 'pdf', array('class'=>'filestyle','data-buttonText'=>'&nbsp;&nbsp;Cari File'));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <button class="btn btn-success btn-lg" id="yw0" type="submit" name="yt0">Buat Daftar Pustaka</button>                    
                    </div>                
                </div>
            </form>        
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>Cara Penggunaan</h3>
            
            <ol>
                <li>Cari file PDF dari <em>paper</em> yang ingin dibuat sitasinya (maksimum 25 MB)</li>
                <li>Klik tombol "Buat Daftar Pustaka"</li>
                <li>Periksa kembali hasil yang diberikan oleh sistem</li>
            </ol>
        </div>

        <div class="col-md-6">
            <h3>Beberapa Keterbatasan</h3>

            <ul>
                <li>Hanya untuk <em>paper</em> jurnal, prosiding, atau bab dari buku</li>
                <li>Diutamakan <em>paper</em> berbahasa Inggris, terutama yang memiliki DOI</li>
                <li>Untuk prosiding, nomor halaman harus dimasukkan sendiri</li>
            </ul>        
        </div>
    </div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="loading" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Harap tunggu</h4>
            </div>
            <div class="modal-body">
                <p>Sedang memproses...</p>
                <div class="progress progress-striped active" style="height: 10px">
                  <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                  </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$('#form').submit(function(event){
    if($('#PDFUpload_pdf').val() === '') {
        event.preventDefault();
    } else {
        $('#loading').modal({
            backdrop : "static",
            keyboard : false
        });
    }    
});

</script>
