<?php

/**
 * Model yang merepresentasikan jurnal ilmiah
 *
 * @author abrari
 */
class Journal extends CModel {
    
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

}
