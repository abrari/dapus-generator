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
    
    public function attributeNames() {
        return array_merge(parent::attributeNames(), array(
            'proc_name' => 'Nama konferensi',
            'con_date' => 'Tanggal konferensi',
            'con_city' => 'Kota konferensi',
            'pages' => 'Halaman',
        ));
    }

    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= $this->title . '. ';
        $citation .= "Di dalam: ";
        if($this->editors) {
            $citation .= $this->formatEditors() . ', editor. ';
        }
        if($this->proc_name) {
            $citation .= '<em>' . $this->proc_name . '</em>; ';
        } else {
            $citation .= '[Prosiding tidak diketahui]; ';
        }
        if($this->con_date != '') {
            $citation .= $this->con_date . ', ';
            $citation .= $this->con_city . '. ';
        } else {
            $citation .= '[Waktu dan tempat pertemuan tidak diketahui]. ';
        }
        if($this->pub) {
            $citation .= $this->pub_city . ' (' . $this->pub_country . '): ' . $this->pub . '. ';
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
