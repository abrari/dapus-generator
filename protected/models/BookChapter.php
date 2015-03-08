<?php

/**
 * Model yang merepresentasikan artikel dalam satu buku (book chapter)
 *
 * @author abrari
 */
class BookChapter extends CModel {
    
    public $authors;
    public $year;
    public $title;
    public $editors;
    public $book_title;
    public $pub_city;
    public $pub;    
    public $pages;
    public $isbn;
    
    public function attributeNames() {
        return array(
            'authors' => 'Pengarang',
            'year' => 'Tahun',
            'title' => 'Judul artikel',
            'editors' => 'Editor',
            'book_title' => 'Judul buku',
            'pub_city' => 'Kota penerbit',
            'pub' => 'Penerbit',
            'pages' => 'Halaman',
            'isbn' => 'ISBN'
        );
    }

}
