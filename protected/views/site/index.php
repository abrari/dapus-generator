
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autosize.js" type="text/javascript"></script>

<style type="text/css">
    #mode-select-text {
        font-size: 15px;
        font-style: italic;
        margin-bottom: 10px;
    }
    
    .mode-select {
        text-align: center;
        padding: 30px;
        padding: 20px 40px;
        color: #FFF !important;
    }
    
    .mode-select .glyphicon {
        font-size: 40px;
        display: block;
        margin-bottom: 15px;
    }
</style>

<div class="jumbotron">
    <div class="container">

        <h1>Pembuat Daftar Pustaka</h1>
        <p>
            Aplikasi web ini dapat membantu pembuatan sitasi untuk daftar pustaka <br/>
            dengan berpedoman pada Pedoman Penulisan Karya Ilmiah (PPKI) IPB.
        </p>

        <p id="mode-select-text">Pilih mode:</p>
        <div class="btn-group" role="group" aria-label="...">
            <a href="<?php echo $this->createUrl('site/manual') ?>" class="btn btn-lg btn-success mode-select"><span class="glyphicon glyphicon-list"></span>Manual</a>
            <a href="<?php echo $this->createUrl('site/auto') ?>" class="btn btn-lg btn-warning mode-select"><span class="glyphicon glyphicon-flash"></span>Otomatis</a>
        </div>     
        <p></p>        
        
    </div>        
</div>

<div class="container">    
    <div class="row">
        <div class="col-md-6">
            <h3>Manual</h3>
            
            <p>
                Pada mode ini, Anda harus menentukan jenis pustaka dan 
                memasukkan sendiri data-data terkait sumber pustaka
                yang akan dibuat sitasinya. 
            </p>
        </div>

        <div class="col-md-6">
            <h3>Otomatis</h3>
            
            <p>
                Pada mode ini, Anda cukup mengunggah <em>paper</em> dalam bentuk PDF dan sistem 
                akan mencoba membuat sitasinya. Lebih mudah namun tidak selalu berhasil.
            </p>      
        </div>
    </div>
</div>
