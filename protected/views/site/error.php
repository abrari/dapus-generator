<div class="jumbotron subhead">
    <div class="container">
        <h1>Error <?php echo $code; ?></h1>
    </div>        
</div>

<div class="container">
    <!--File: <?php echo CHtml::encode($file); ?><br/>
    Line: <?php echo CHtml::encode($line); ?><br/>-->
    <p>
        Terjadi kesalahan saat memproses permintaan Anda.
    </p>
    
    <div class="alert alert-danger" role="alert">
        <strong>Pesan kesalahan</strong>: <?php echo CHtml::encode($message); ?>
    </div>
    
</div>