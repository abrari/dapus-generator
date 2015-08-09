<?php

/**
 * Model yang merepresentasikan buku
 *
 * @author abrari
 */

class Book extends Reference {
    
    public $authors;
    public $year;
    public $title;
    public $edition;
    public $editors;
    public $pub_city;
    public $pub_country;
    public $pub;    
    
    public function attributeLabels() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul buku',
            'edition' => 'Edisi',
            'editors' => 'Editor',
            'pub_city' => 'Kota penerbit',
            'pub_country' => 'Kode negara penerbit',
            'pub' => 'Penerbit',
        );
    }    
    
    public function rules() {
        return array(
            array('authors, year, title, pub_city, pub_country, pub', 'required'),
            array('authors, year, title, edition, editors, pub_city, pub_country, pub', 'safe'),
            array('pub_country', 'length', 'is' => 2),
        );
    }
    
    public function formatEditors()
    {
        // format names in editors
        $editors = $this->makeEditors();
        $editorsFormatted = array();
        
        if(!$editors) {
            return '';
        }
        
        foreach($editors as $editor) {
            $name = explode(' ', $editor);
            $lastName = array_pop($name);
            
            $editorsFormatted[] = trim($lastName . ' ' . StringHelper::initials(implode(' ', $name)));
        }
        
        $editorsString = implode(', ', $editorsFormatted);
        
        return $editorsString;
    }
    
    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= '<em>' . StringHelper::titleCase($this->title) . '</em>. ';
        if($this->edition) {
            $citation .= 'Ed ke-' . filter_var($this->edition, FILTER_SANITIZE_NUMBER_INT) . '. ';
        }
        if($this->editors) {
            $citation .= $this->formatEditors() . ', editor. ';
        }
        if($this->pub) {
            $citation .= $this->pub_city . ' (' . strtoupper($this->pub_country) . '): ' . $this->pub . '. ';
        } else {
            $citation .= '[Penerbit tidak diketahui]. ';
        }
        
        return $citation;        
    }
    
    private function makeEditors() {
        // convert comma-separated list of editor to array
        if(!is_string($this->editors) || is_array($this->editors)) return $this->editors;
        
        $editors = explode(",", $this->editors);
        for($i = 0; $i < count($editors); $i++) {
            $editors[$i] = trim($editors[$i]);
        }
        
        return $editors;
    }
    
}