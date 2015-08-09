<?php

/**
 * Model yang merepresentasikan artikel dalam satu buku (book chapter)
 *
 * @author abrari
 */
class BookChapter extends Reference {
    
    public $authors;
    public $year;
    public $title;
    public $editors;
    public $book_title;
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
            'book_title' => 'Judul buku',
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
        $citation .= StringHelper::sentenceCase($this->title) . '. ';
        $citation .= "Di dalam: ";
        if($this->editors) {
            $citation .= $this->formatEditors() . ', editor. ';
        }
        if($this->book_title) {
            $citation .= '<em>' . StringHelper::titleCase($this->book_title) . '</em>; ';
        } else {
            $citation .= '[Judul buku tidak diketahui]; ';
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
