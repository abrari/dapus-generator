<div class="jumbotron subhead">
    <div class="container">
        <h1>Error <?php echo $code; ?></h1>
    </div>        
</div>

<div class="container">
    File: <?php echo CHtml::encode($file); ?><br/>
    Line: <?php echo CHtml::encode($line); ?><br/>
    <?php echo CHtml::encode($message); ?>
</div>