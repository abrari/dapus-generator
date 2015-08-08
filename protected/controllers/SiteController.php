<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else {
                                if ($error['code'] == 500) {
                                    // save errors to database
                                    $submission = new Submission();
                                    $submission->timestamp = new CDbExpression('NOW()');
                                    $submission->object = 'File: ' . basename($error['file']) . ':' . $error['line'] . ' [' . $error['message'] . ']';
                                    $submission->oid = '';
                                    $submission->ref_type = 'ERROR';                                    
                                    $submission->save(false);
                                }
                                
				$this->render('error', $error);
                        }
		}
	}
                
        public function actionUpload()
        {         
            if($_FILES['PDFUpload']['error']['pdf'] === 0) {

                $tempFolder = tempnam("/tmp", "DAPUS_");
                unlink($tempFolder);

                mkdir($tempFolder);
                
                $model=new PDFUpload();
                $model->attributes = $_POST['PDFUpload'];
                $model->pdf = CUploadedFile::getInstance($model,'pdf');
                
                if($model->validate()) {
                    $uploaded = $model->pdf->saveAs($tempFolder.'/input.pdf');

                    if($uploaded) {
                        
                        $g = new Grobid();
                        $g->setGrobidJar(Yii::app()->params['grobidPath'] . 'grobid-core/target/grobid-core-0.3.3-SNAPSHOT.one-jar.jar');
                        $g->setGrobidHome(Yii::app()->params['grobidPath'] . 'grobid-home/');
                        $g->setIn($tempFolder);
                        $g->setOut($tempFolder);
                        $g->setProcess('processHeader');
                        
                        $grobidResult = $g->run();                            
                        list($g_doi, $g_title) = StringHelper::parseGrobid($grobidResult);

                        if($g_doi !== '') {
                            $reference = WebAPI::searchCrossRefDOI($g_doi);
                        } else if($g_title !== '') {
                            $reference = WebAPI::searchCrossRef($g_title);
                        } else {
                            throw new CHttpException(500, "Tidak ditemukan hasil");
                        }
                        
                        // save to database
                        $submission = new Submission();
                        $submission->timestamp = new CDbExpression('NOW()');
                        $submission->object = serialize($reference);
                        $submission->oid = sha1($submission->object);
                        $submission->ref_type = $reference->type;
                        
                        if($submission->save()) {
                            $this->redirect(array('site/result/' . $submission->oid));
                        } else {
                            throw new CHttpException(500, "Kesalahan: Gagal menyimpan data.");
                        }                                                
                    } else {
                        CFileHelper::removeDirectory($tempFolder);
                        throw new CHttpException(500, "Upload gagal dengan kode error: {$model->pdf->getError()}.");
                    }                    
                } else {
                    CFileHelper::removeDirectory($tempFolder);
                    throw new CHttpException(500, "Kesalahan dokumen (harus PDF).");
                }                
                
                // cleanup
                CFileHelper::removeDirectory($tempFolder);                
            } else {
                $this->redirect(array('site/index'));
            }            
        }
        
        public function actionResult($oid)
        {
            $submission = Submission::model()->getByOID($oid);
            
            if($submission) {
                $reference = unserialize($submission->object);

                $data['reference'] = $reference;
                
                switch($reference->type) {
                    case 'journal-article':
                        $type = 'artikel jurnal'; break;
                    case 'proceedings-article':
                        $type = 'artikel prosiding'; break;
                    case 'book-chapter':
                        $type = 'artikel dalam buku'; break;
                    case 'reference-entry':
                        $type = 'artikel'; break;
                }
                
                $data['type'] = $type;
                
                $this->render('result', $data);
                
            } else {
                throw new CHttpException(404, "Halaman tidak ditemukan");
            }
        }
        
        
        public function actionTest() {
            
            $book = new Book();
            $book->authors = array(array('given' => 'Muhammad Abrar', 'family' => 'Istiadi'));
            $book->year = "2014";
            $book->title = "Knowledge and data mining: theory and practices";
            $book->pub_city = "New Jersey";
            $book->pub_country = "US";
            $book->pub = "McGraw-Hill";
            
            echo $book->formatCitation() . '<br/>';
            
            $skripsi = new Thesis();
            $skripsi->authors = array(array('given' => 'Tri', 'family' => 'Ardini'));
            $skripsi->year = "2015";
            $skripsi->title = "Sistem Temu Kembali Dokumen Hukum Nasional dengan menggunakan SPHINX";
            $skripsi->thesis_type = "skripsi";
            $skripsi->univ_city = "Bogor";
            $skripsi->univ_country = "ID";
            $skripsi->univ_faculty = "Fakultas MIPA";
            $skripsi->univ = "Institut Pertanian Bogor";
            
            echo $skripsi->formatCitation();
        }
        
        public function actionManual() {
                        
            $book = new Book();
            
            if(isset($_POST['Book'])) {
                $book->attributes = $_POST['Book'];
                
                if($book->validate()) {
                    $data['citation'] = $book->formatCitation();
                    $data['inline']   = $book->formatInlineCitation();
                    //CVarDumper::dump($book);
                }
            }
            
            $data['book'] = $book;
            $this->render('form', $data);
            
        }
        
        public function actionIsbn($isbn) {

            $data = WebAPI::searchBookData($isbn); // id = ISBN
            $book = new Book();
            
            $book->authors = rtrim($data['author'], ".");
            $book->year = $data['year'];
            $book->title = str_replace(" : ", ": ", $data['title']);
            $book->edition = filter_var($data['ed'], FILTER_SANITIZE_NUMBER_INT);
            $city = explode(",", $data['city']);
            $book->pub_city = reset($city);
            $book->pub_country = WebAPI::searchCityData($book->pub_city);
            $book->pub = str_replace("/", ", ", $data['publisher']);
            
            $this->renderJSON((array) $book);
            
        }
        

}