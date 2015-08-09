<?php

/**
 * Model yang merepresentasikan artikel prosiding
 *
 * @author abrari
 */
class Proceeding extends Book {
    
    public $proc_name;
    public $con_date;
    public $con_city;
    public $pages;
    
    public function attributeLabels() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul artikel prosiding',
            'editors' => 'Editor',
            'pub_city' => 'Kota penerbit',
            'pub_country' => 'Kode negara penerbit',
            'pub' => 'Penerbit',            
            'proc_name' => 'Nama prosiding atau konferensi',
            'con_date' => 'Tanggal konferensi',
            'con_city' => 'Kota dan negara konferensi',
            'pages' => 'Halaman',
        );
    }
    
    public function rules() {
        return array(
            array('authors, year, title, pub_city, pub_country, pub, proc_name, pages', 'required'),
            array('authors, year, title, edition, editors, pub_city, pub_country, pub, proc_name, con_date, con_city, pages', 'safe'),
            array('pub_country', 'length', 'is' => 2),
        );
    }    

    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= StringHelper::sentenceCase($this->title) . '. ';
        $citation .= "Di dalam: ";
        if($this->editors) {
            $citation .= $this->formatEditors() . ', editor. ';
        }
        if($this->proc_name) {
            $citation .= '<em>' . StringHelper::titleCase($this->proc_name) . '</em>; ';
        } else {
            $citation .= '[Prosiding tidak diketahui]; ';
        }
        if($this->con_date != '') {
            $citation .= $this->con_date . '; ';
            $citation .= $this->con_city . '. ';
        } else {
            $citation .= '[Waktu dan tempat pertemuan tidak diketahui]. ';
        }
        if($this->pub) {
            $citation .= $this->pub_city . ' (' . strtoupper($this->pub_country) . '): ' . $this->pub . '. ';
        } else {
            $citation .= '[Penerbit tidak diketahui]. ';
        }
        if($this->pages) {
            $citation .= 'hlm ' . $this->pages . '. ';
        } else {
            $citation .= '[No halaman tidak diketahui]. ';
        }
        
        return $citation;
    }    
}
