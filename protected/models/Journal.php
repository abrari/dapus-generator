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
    
    public function attributeLabels() {
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
    
    public function rules() {
        return array(
            array('authors, year, title, journal, volume, pages', 'required'),
            array('authors, year, title, journal, volume, issue, pages, doi', 'safe'),
        );
    }    
    
    public function formatCitation() {
        $citation  = "";
        $citation .= $this->formatAuthors() . '. ';
        $citation .= $this->year . '. ';
        $citation .= StringHelper::sentenceCase($this->title) . '. ';
        $citation .= '<em>' . StringHelper::titleCase($this->journal) . '</em>. ';
        $citation .= $this->volume;
        if($this->issue != '')
            $citation .= '(' . $this->issue . ')';
        $citation .= ':' . $this->pages . '.';
        if($this->doi != '')
            $citation .= ' doi:' . $this->doi . '.';
        
        return $citation;
    }

}
