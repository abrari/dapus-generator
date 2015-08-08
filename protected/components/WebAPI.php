<?php

/**
 * Fungsi-fungsi yang memanggil web API
 *
 * @author abrari
 */
class WebAPI {
    
    public static function searchCrossRef($query)
    {
        $query = str_replace("\n", " ", $query);
        $query = str_replace(":", "", $query);
        $query = preg_replace('!\s+!', ' ', $query);            

        $url = "http://api.crossref.org/works?rows=1&query=" . urlencode($query);            
        $apiRequest = Yii::app()->curl->run($url);

        if($apiRequest->hasErrors()) {
            throw new CHttpException(500, 'Gagal menghubungi server CrossRef');
        } else {
            $apiResponse = CJSON::decode($apiRequest->getData());
            // CVarDumper::dump($apiResponse, 10, TRUE);
            if($apiResponse === null) {
                throw new CHttpException(500, "Gagal parsing data CrossRef");
            }
            if($apiResponse['message']['total-results'] == 0) {
                throw new CHttpException(404, "Tidak ditemukan hasil dari CrossRef");
            }

            // use subtitle if exist
            if(count($apiResponse['message']['items'][0]['subtitle']) > 0) {
                $subTitle = $apiResponse['message']['items'][0]['subtitle'][0];
                $apiResponse['message']['items'][0]['title'][0] .= ': ' . $subTitle;
            }

            $foundTitle = $apiResponse['message']['items'][0]['title'][0];
            $foundScore = $apiResponse['message']['items'][0]['score'];
            if($foundScore < 2.0 || StringHelper::stringSimilarity($query, $foundTitle) < 80) {
                throw new CHttpException(500, "Tidak ditemukan hasil dari CrossRef");
            }

            $refType = $apiResponse['message']['items'][0]['type'];
            $ref = new Reference();
            switch($refType) {
                case 'journal-article':
                    return $ref->createJournal($apiResponse['message']['items'][0]);
                case 'proceedings-article':
                    return $ref->createProceeding($apiResponse['message']['items'][0]);
                case 'book-chapter':
                    return $ref->createBookChapter($apiResponse['message']['items'][0]);
                case 'reference-entry':
                    return $ref->createBookChapter($apiResponse['message']['items'][0]);                        
                default: 
                    throw new CHttpException(404, "Tidak ditemukan hasil dari CrossRef");
            }
        }
    }

    public static function searchCrossRefDOI($doi)
    {
        $doi = preg_replace('!\s+!', ' ', $doi);

        $url = "http://api.crossref.org/works/" . $doi;            
        $apiRequest = Yii::app()->curl->run($url);

        if($apiRequest->hasErrors()) {
            throw new CHttpException(500, 'Gagal menghubungi server CrossRef');
        } else {
            $apiResponse = CJSON::decode($apiRequest->getData());

            if($apiResponse === null) {
                throw new CHttpException(404, "Tidak ditemukan hasil dari CrossRef");
            }

            $refType = $apiResponse['message']['type'];
            $ref = new Reference();
            switch($refType) {
                case 'journal-article':
                    return $ref->createJournal($apiResponse['message']);
                case 'proceedings-article':
                    return $ref->createProceeding($apiResponse['message']);
                case 'book-chapter':
                    return $ref->createBookChapter($apiResponse['message']);
                case 'reference-entry':
                    return $ref->createBookChapter($apiResponse['message']);
                default: 
                    throw new CHttpException(404, "Tidak ditemukan hasil dari CrossRef");
            }
        }
    }        

    public static function searchBookData($isbn)
    {
        $isbn = StringHelper::getISBN($isbn);            
        $url = "http://xisbn.worldcat.org/webservices/xid/isbn/" . urlencode($isbn) . "?method=getMetadata&format=json&fl=*";

        $apiRequest = Yii::app()->curl->run($url);

        if($apiRequest->hasErrors()) {
            throw new CHttpException(500, 'Gagal menghubungi server ISBN'); // ignored, actually
        } else {
            $apiResponse = CJSON::decode($apiRequest->getData());
            if($apiResponse === null) {
                throw new CHttpException(500, "Gagal parsing data ISBN");
            }            
            if($apiResponse['stat'] !== 'ok') {
                throw new CHttpException(404, "Tidak ditemukan hasil ISBN");
            }                

            return $apiResponse['list'][0];
        }
    }

    public static function searchCityData($city)
    {
        $city = preg_replace("/[^A-Za-z0-9 \-']/", "", $city);
        $cities = Yii::app()->curl->run("http://gd.geobytes.com/AutoCompleteCity?q=" . urlencode($city));
        if(!$cities->hasErrors()) {
            $city = StringHelper::cityNonUS(CJSON::decode($cities->getData()));
            $cityData = Yii::app()->curl->run("http://gd.geobytes.com/GetCityDetails?fqcn=" . urlencode($city));
            if(!$cityData->hasErrors()) {
                $country = CJSON::decode($cityData->getData());
                return $country['geobytesinternet'];
            }                
            return "";
        }
        return "";
    }    
    
}
