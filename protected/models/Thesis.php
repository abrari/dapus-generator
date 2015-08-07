<?php

/**
 * Model yang merepresentasikan tugas akhir (skripsi/tesis/disertasi)
 *
 * @author abrari
 */

class Thesis extends Reference {
    
    public $authors;
    public $year;
    public $title;
    public $thesis_type;
    public $univ_city;
    public $univ_country;
    public $univ_faculty;    
    public $univ;    
    
    public function attributeNames() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul',
            'thesis_type' => 'Jenis tugas akhir',
            'univ_city' => 'Kota universitas',
            'univ_country' => 'Negara universitas',
            'univ_faculty' => 'Fakultas universitas',
            'univ' => 'Universitas' 
        );
    }
    
    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= StringHelper::sentenceCase($this->title) . ' ';
        $citation .= '[' . strtolower($this->thesis_type) . ']. ';
        $citation .= $this->univ_city . ' (' . $this->univ_country . '): ';
        
        if($this->univ_faculty) {
            $citation .= $this->univ_faculty . ', ';
        }
        $citation .= $this->univ . '.';
        
        return $citation;        
    }    
    
}