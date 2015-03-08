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
        
        private function searchCrossRef($query)
        {
            $url = "http://api.crossref.org/works?rows=1&query=" . urlencode($query);            
            $apiRequest = Yii::app()->curl->run($url);
            
            if($apiRequest->hasErrors()) {
                throw new CException('Gagal menghubungi server');
            } else {
                $apiResponse = CJSON::decode($apiRequest->getData());
                if($apiResponse === null) {
                    throw new CException("Gagal parsing data");
                }
                if($apiResponse['message']['total-results'] == 0) {
                    throw new CException("Tidak ditemukan hasil");
                }
                
                $foundTitle = $apiResponse['message']['items'][0]['title'][0];
                $foundScore = $apiResponse['message']['items'][0]['score'];
                if($foundScore < 2.0 || StringHelper::stringSimilarity($query, $foundTitle) < 80) {
                    throw new CException("Tidak ditemukan hasil");
                }
                
                $refType = $apiResponse['message']['items'][0]['type'];
                switch($refType) {
                    case 'journal-article': {
                        
                        }; break;
                    case 'proceedings-article': {
                        
                        }; break;
                    case 'book-chapter': {
                        
                        }; break;  
                    default: 
                        throw new CException("Tidak ditemukan hasil");
                }
                
                CVarDumper::dump($refType,10,true);
                echo "<br/><br/>";
                CVarDumper::dump($apiResponse,10,true);
            }
            
        }
        
        public function actionSearch()
        {
            $query = str_replace("\n", " ", $_POST['q']);
            
            $crossRef = $this->searchCrossRef($query);
        }

}