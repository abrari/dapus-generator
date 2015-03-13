<?php

/**
 * Model yang merepresentasikan artikel prosiding
 *
 * @author abrari
 */
class Proceeding extends Reference {
    
    public $authors;
    public $year;
    public $title;
    public $editors;
    public $proc_name;
    public $con_date;
    public $con_city;
    public $pub_city;
    public $pub_country;
    public $pub;    
    public $pages;
    
    public function attributeNames() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul artikel',
            'editors' => 'Editor',
            'proc_name' => 'Nama konferensi',
            'con_date' => 'Tanggal konferensi',
            'con_city' => 'Kota konferensi',
            'pub_city' => 'Kota penerbit',
            'pub_country' => 'Negara penerbit',
            'pub' => 'Penerbit',
            'pages' => 'Halaman',
        );
    }

    public function formatEditors()
    {
        // format names in editors
        $editorsFormatted = array();
        
        if(!$this->editors) {
            return '';
        }
        
        foreach($this->editors as $editor) {
            $name = explode(' ', $editor);
            $lastName = array_pop($name);
            
            $editorsFormatted[] = $lastName . ' ' . StringHelper::initials(implode(' ', $name));
        }
        
        $editorsString = implode(', ', $editorsFormatted);
        
        return $editorsString;
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
