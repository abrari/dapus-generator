
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/autosize.js" type="text/javascript"></script>

<div class="jumbotron">
    <div class="container">

        <h1>Pembuat Daftar Pustaka</h1>
        <p>
            Aplikasi web ini dapat membantu pembuatan sitasi untuk daftar pustaka secara semi-otomatis <br/>
            dengan berpedoman pada Pedoman Penulisan Karya Ilmiah (PPKI) IPB.
        </p>

        <form class="col-md-8 col-md-offset-2" action="search" method="post">
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
    <h3>... atau masukkan data sumber pustaka secara manual:</h3>
    
    <div class="alert alert-info">(Sedang dalam tahap pembangunan)</div>    
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