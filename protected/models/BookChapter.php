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

}
