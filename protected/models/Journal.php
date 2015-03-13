<?php

/**
 * Model yang merepresentasikan jurnal ilmiah
 *
 * @author abrari
 */
class Journal extends Reference {
    
    public $authors;
    public $year;
    public $title;
    public $journal;
    public $volume;
    public $issue;
    public $pages;
    public $doi;
    
    public function attributeNames() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul artikel',
            'journal' => 'Nama jurnal',
            'volume' => 'Volume',
            'issue' => 'Edisi',
            'pages' => 'Halaman',
            'doi' => 'DOI'
        );
    }
    
    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= $this->title . '. ';
        $citation .= '<em>' . $this->journal . '</em>. ';
        $citation .= $this->volume;
        if($this->issue != '')
            $citation .= '(' . $this->issue . ')';
        $citation .= ':' . $this->pages . '.';
        if($this->doi != '')
            $citation .= 'doi:' . $this->doi . '.';
        
        return $citation;
    }

}
