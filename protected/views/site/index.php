
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autosize.js" type="text/javascript"></script>

<div class="jumbotron">
    <div class="container">

        <h1>Pembuat Daftar Pustaka</h1>
        <p>
            Aplikasi web ini dapat membantu pembuatan sitasi untuk daftar pustaka secara semi-otomatis <br/>
            dengan berpedoman pada Pedoman Penulisan Karya Ilmiah (PPKI) IPB.
        </p>

        <form class="col-md-8 col-md-offset-2" action="<?php echo Yii::app()->request->baseUrl; ?>/site/upload" method="post" enctype="multipart/form-data" id="form">
            <div class="form-group">
                <label class="control-label" for="q">Unggah berkas paper dalam bentuk PDF:</label>
                <div>            
                    <?php
                        $model = new PDFUpload();
                        echo CHtml::activeFileField($model, 'pdf', array('class'=>'filestyle','data-size'=>'lg','data-buttonText'=>'&nbsp;&nbsp;Cari File'));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <button class="btn btn-success btn-lg" id="yw0" type="submit" name="yt0">Buat Daftar Pustaka</button>                    
                </div>                
            </div>
        </form>        
        
        <?php /*
        <form class="col-md-8 col-md-offset-2" action="<?php echo Yii::app()->request->baseUrl; ?>/site/search" method="post">
            <div class="form-group">
                <label class="control-label" for="q">Masukkan judul paper jurnal atau prosiding</label>
                <div>
                    <textarea rows="1" class="form-control" placeholder="Masukkan judul paper lengkap" name="q" id="q"></textarea>
                </div>
            </div>
            <button class="btn btn-success btn-lg" id="yw0" type="submit" name="yt0">Buat Daftar Pustaka</button>
        </form> */ ?>
        
    </div>        
</div>

<div class="container">    
    <h3>Beberapa keterbatasan</h3>
    
    <p>Aplikasi web ini memiliki beberapa keterbatasan, antara lain</p>
    <ul>
        <li>Hanya mampu mencari paper jurnal, prosiding, atau bab dari buku</li>
        <li>Hanya mampu mencari paper berbahasa Inggris, terutama yang terindeks SCOPUS</li>
        <li>Kapitalisasi judul harus disesuaikan secara manual</li>
        <li>Untuk prosiding, nomor halaman harus dimasukkan sendiri</li>
    </ul>        
</div>

<script type="text/javascript">
$(document).ready(function(){
    autosize($('#q'));
});
</script>