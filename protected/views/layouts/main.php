<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" rel="stylesheet" />
        
</head>

<body>

        <?php 
        $this->widget(
            'booster.widgets.TbNavbar',
            array(
                'brand' => 'DA<b>PUS</b>',
                'htmlOptions' => array('style' => "box-shadow: 0 1px 10px rgba(0,0,0,.1);"),
                'items' => array(
                    array(
                        'class' => 'booster.widgets.TbMenu',
                        'type' => 'navbar',
                        'items'=>array(
                                array('label'=>'Home', 'url'=>array('/site/index')),
                                array('label'=>'Tentang', 'url'=>array('/site/page', 'view'=>'about')),
                                array('label'=>'Unduh', 'url'=>array('/site/page', 'view'=>'download')),
                        ),
                    )
                )
            )
        );                            
        ?>

    
    <?php echo $content; ?>

    <footer class="footer">
        <div class="container">
            <p class="copy">Copyleft © 2015 <a href="http://cs.ipb.ac.id">Departemen Ilmu Komputer FMIPA IPB</a> </p>
        </div>
    </footer>

</body>
</html>
