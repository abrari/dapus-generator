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
    
    public function attributeNames() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul artikel',
            'title' => 'Edisi',
            'editors' => 'Editor',
            'pub_city' => 'Kota penerbit',
            'pub_country' => 'Negara penerbit',
            'pub' => 'Penerbit',
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
        $citation .= '<em>' . StringHelper::titleCase($this->title) . '</em>. ';
        if($this->edition) {
            $citation .= 'Ed ke-' . intval($this->edition) . '. ';
        }
        if($this->editors) {
            $citation .= $this->formatEditors() . ', editor. ';
        }
        if($this->pub) {
            $citation .= $this->pub_city . ' (' . $this->pub_country . '): ' . $this->pub . '. ';
        } else {
            $citation .= '[Penerbit tidak diketahui]. ';
        }
        
        return $citation;        
    }
    
}