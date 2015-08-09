<?php

$this->pageTitle=Yii::app()->name . ' - Tentang';

?>
<div class="jumbotron subhead">
    <div class="container">
        <h1>Tentang</h1>
    </div>        
</div>

<div class="container">
    <p>
        Pembuatan sitasi (<em>citation</em>) di daftar pustaka merupakan pekerjaan yang cukup sulit.
        Hal ini dapat dibuktikan dari pengalaman dalam memeriksa format tugas akhir mahasiswa,
        yaitu pada bagian daftar pustaka yang banyak terjadi kesalahan.
    </p>
    <p>
        Aplikasi web ini berusaha membantu permasalahan tersebut dengan menyediakan
        layanan untuk membuat sitasi di daftar pustaka dengan memasukkan data pustaka atau memberikan <em>file</em>
        PDF dari <em>paper</em> yang ingin dibuat sitasinya. 
    </p>
    <p>
        Namun demikian, aplikasi ini tidak selalu dapat memberikan hasil. 
        Hasil dari aplikasi juga tidak dapat dipastikan 100% benar. 
        Oleh karena itu, masih perlu dilakukan pemeriksaan secara manual terhadap 
        hasil yang diberikan oleh aplikasi.
    </p>
    <p>Aplikasi ini dapat terselenggara dengan bantuan komponen-komponen berikut:</p>
    <ul>
        <li>GROBID Scientific Literature Extractor (<a href="https://github.com/kermitt2/grobid">situs web</a> | <a href="https://lekythos.library.ucy.ac.cy/bitstream/handle/10797/14013/ECDL069.pdf?sequence=1">publikasi</a>)</li>
        <li>Stanford Named Entity Recognizer (<a href="http://nlp.stanford.edu/software/CRF-NER.shtml">situs web</a> | <a href="http://nlp.stanford.edu/~manning/papers/gibbscrf3.pdf">publikasi</a>)</li>
        <li>CrossRef Web Service (<a href="http://www.crossref.org/">situs web</a>)</li>
        <li>xISBN Web Service (<a href="http://www.worldcat.org/affiliate/webservices/xisbn/app.jsp">situs web</a>)</li>
        <li>Geobytes Web Service (<a href="http://www.geobytes.com/geobytes-apis/">situs web</a>)</li>
    </ul>
    
    <h3><em>Disclaimer</em></h3>
    <p>
        Aplikasi tidak menjamin 100% kebenaran hasil sitasi. <em>Use at your own risk.</em>
    </p>
    
    <h3><em>Privacy Policy</em></h3>
    <p>
        Aplikasi tidak menyimpan berkas PDF dari <em>paper</em> yang di-<em>upload</em> maupun isinya,
        tetapi hanya disimpan <em>metadata</em>-nya.
    </p>
    
    <h3>Ikut Berkontribusi</h3>
    <p>
        Jika Anda ingin berkontribusi terhadap pengembangan aplikasi ini, kode sumber aplikasi ada pada <em>repository</em> GitHub: <a href="https://github.com/abrari/dapus-generator">https://github.com/abrari/dapus-generator</a>.
    </p>

    <h3>Pelaporan <em>Bug</em></h3>
    <p>
        Jika terdapat pertanyaan atau <em>bug</em> yang hendak dilaporkan, silakan membuat <em>ticket</em> baru 
        di halaman GitHub: <a href="https://github.com/abrari/dapus-generator/issues">https://github.com/abrari/dapus-generator/issues</a>.
    </p>
    
    
</div>

<script type="text/javascript">
/** 
 * Open all external links in a new window
 */
jQuery(document).ready(function($) {
    $('a').not('[href*="mailto:"]').each(function () {
		var a = new RegExp('/' + window.location.host + '/');
		var href = this.href;
		if ( ! a.test(href) ) {
			$(this).attr('target', '_blank');
		}
	});
});
</script>