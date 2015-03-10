
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autosize.js" type="text/javascript"></script>

<div class="jumbotron">
    <div class="container">

        <h1>Pembuat Daftar Pustaka</h1>
        <p>
            Aplikasi web ini dapat membantu pembuatan sitasi untuk daftar pustaka secara semi-otomatis <br/>
            dengan berpedoman pada Pedoman Penulisan Karya Ilmiah (PPKI) IPB.
        </p>

        <form class="col-md-8 col-md-offset-2" action="<?php echo Yii::app()->request->baseUrl; ?>/site/search" method="post">
            <div class="form-group">
                <label class="control-label" for="q">Masukkan judul paper jurnal atau prosiding</label>
                <div>
                    <textarea rows="1" class="form-control" placeholder="Masukkan judul paper lengkap" name="q" id="q"></textarea>
                </div>
            </div>
            <button class="btn btn-success btn-lg" id="yw0" type="submit" name="yt0">Buat Daftar Pustaka</button>
        </form>
        
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

<!--
<div class="container">
    <h2>Pilih sesuai jenis pustaka:</h2>
    
    <div id="yw0">
        <ul id="yw1" class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#yw0_tab_1">Jurnal/Prosiding</a></li>
            <li>
                <a data-toggle="tab" href="#yw0_tab_2">Buku</a></li>
            <li>
                <a data-toggle="tab" href="#yw0_tab_3">Skripsi/Tesis/Disertasi</a></li>
            <li>
                <a data-toggle="tab" href="#yw0_tab_4">Internet</a></li>
        </ul>
        <div class="tab-content">
            <div id="yw0_tab_1" class="tab-pane fade active in">1</div>
            <div id="yw0_tab_2" class="tab-pane fade">2</div>
            <div id="yw0_tab_3" class="tab-pane fade">3</div>
            <div id="yw0_tab_4" class="tab-pane fade">4</div>
        </div>            
    </div>            
</div>
-->

<script type="text/javascript">
$(document).ready(function(){
    autosize($('#q'));
});
</script>