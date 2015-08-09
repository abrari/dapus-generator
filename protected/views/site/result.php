<?php /* @var $reference Reference */ ?>

<div class="jumbotron subhead">
    <div class="container">
        <h1>Hasil Pembuatan Sitasi</h1>
    </div>        
</div>

<div class="container">
    
    <h3>Informasi Referensi</h3>
    
    <table class="table">
        <tbody>
            <tr>
                <td style="width: 15%">Jenis Pustaka</td>
                <td>
                    <?php echo ucfirst(CHtml::encode($type)); ?>
                </td>
            </tr>
            <tr>
                <td>Pengarang</td>
                <td>
                    <ul style="padding-left: 16px">
                    <?php
                    foreach($reference->makeAuthors() as $name) {
                        echo '<li>';
                        echo CHtml::encode($name['given']) . ' ' . CHtml::encode($name['family']);
                        echo '</li>';
                    }                    
                    ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>
                    <?php echo CHtml::encode($reference->year); ?>
                </td>
            </tr>
            <tr>
                <td>Judul</td>
                <td>
                    <?php echo CHtml::encode($reference->title); ?>
                </td>
            </tr>
        </tbody>        
    </table>
    
    <br/>
    
    <h3>Entri Daftar Pustaka</h3>

    <div class="well">
        <p class="ipb-text" contenteditable="true"><?php echo $reference->formatCitation(); ?></p>
    </div>
    
    <br/>
    
    <h3>Sitasi dalam Teks</h3>

    <div class="well">
        <p class="ipb-text" contenteditable="true"><?php echo "(" . $reference->formatAuthorsInline() . ' ' . CHtml::encode($reference->year) . ')'; ?></p>
    </div>    
    
</div>
