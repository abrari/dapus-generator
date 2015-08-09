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
    
    public function attributeLabels() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul',
            'thesis_type' => 'Jenis tugas akhir',
            'univ_city' => 'Kota',
            'univ_country' => 'Kode negara',
            'univ_faculty' => 'Fakultas',
            'univ' => 'Universitas' 
        );
    }
    
    public function rules() {
        return array(
            array('authors, year, title, thesis_type, univ_city, univ_country, univ', 'required'),
            array('authors, year, title, thesis_type, univ_city, univ_country, univ_faculty, univ', 'safe'),
            array('univ_country', 'length', 'is' => 2),
        );
    }    
    
    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= StringHelper::sentenceCase($this->title) . ' ';
        $citation .= '[' . strtolower($this->thesis_type) . ']. ';
        $citation .= $this->univ_city . ' (' . strtoupper($this->univ_country) . '): ';
        
        if($this->univ_faculty) {
            $citation .= $this->univ_faculty . ', ';
        }
        $citation .= $this->univ . '.';
        
        return $citation;        
    }    
    
}