<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/filestyle.min.js"> </script>
        
</head>

<body>

    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/beta_banner.png" alt="Beta" title="Versi Beta, selamanya" style="position: fixed; top: 0px; right: 0px; z-index: 2015"/>
    
        <?php 
        $this->widget(
            'booster.widgets.TbNavbar',
            array(
                'brand' => 'DA<b>PUS</b> Generator',
                'htmlOptions' => array('style' => "box-shadow: 0 1px 10px rgba(0,0,0,.1);"),
                'items' => array(
                    array(
                        'class' => 'booster.widgets.TbMenu',
                        'type' => 'navbar',
                        'items'=>array(
                            array('label'=>'Beranda', 'url'=>array('/site/index')),
                            array('label'=>'Pembuatan Sitasi', 'items'=>array(
                                array('label'=>'Manual', 'url'=>array('/site/manual')),
                                array('label'=>'Otomatis', 'url'=>array('/site/auto')),
                            )),
                            array('label'=>'Tentang', 'url'=>array('/site/page', 'view'=>'about')),
                            array('label'=>'FAQ', 'url'=>array('/site/page', 'view'=>'faq')),
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
