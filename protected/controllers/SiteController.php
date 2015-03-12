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
			else
				$this->render('error', $error);
		}
	}
                
        public function actionUpload()
        {
            $tempFolder = tempnam("/tmp", "DAPUS_");
            unlink($tempFolder);
            
            mkdir($tempFolder);
            
            if($_FILES['PDFUpload']['error']['pdf'] === 0) {
                
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
                            throw new CException("Tidak ditemukan hasil");
                        }
                        
                        echo $reference->formatAuthors();
                        CVarDumper::dump($reference);
                        
                    } else {
                        CFileHelper::removeDirectory($tempFolder);
                        throw new CException("Upload gagal dengan kode error: {$model->pdf->getError()}.");
                    }                    
                } else {
                    CFileHelper::removeDirectory($tempFolder);
                    throw new CException("Kesalahan dokumen (harus PDF).");
                }                
            }
            
            // cleanup
            CFileHelper::removeDirectory($tempFolder);
            
        }

}