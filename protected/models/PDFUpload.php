<?php

class PDFUpload extends CFormModel {

    public $pdf;

    public function rules() {
        return array(
            array('pdf', 'file', 'types' => 'pdf'),
        );
    }

}