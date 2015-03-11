<?php

/**
 * Beberapa fungsi untuk string
 *
 * @author abrari
 */
class StringHelper {
    
    public static function stringSimilarity($s1, $s2)
    {
        $s1 = preg_replace("/[^A-Za-z0-9]/", '', strtolower($s1));
        $s2 = preg_replace("/[^A-Za-z0-9]/", '', strtolower($s2));

        similar_text($s1, $s2, $percent);
        
        return floatval($percent);
    }
    
    public static function getISBN($url)
    {
        $url = explode("/", $url);  // bugfix
        $isbn = end($url);
        return str_replace("-", "", $isbn);
    }
    
    // http://camendesign.com/code/title-case
    
    public static function titleCase ($title) {
	//remove HTML, storing it for later
	//       HTML elements to ignore    | tags  | entities
	$regx = '/<(code|var)[^>]*>.*?<\/\1>|<[^>]+>|&\S+;/';
	preg_match_all ($regx, $title, $html, PREG_OFFSET_CAPTURE);
	$title = preg_replace ($regx, '', $title);
	
	//find each word (including punctuation attached)
	preg_match_all ('/[\w\p{L}&`\'‘’"“\.@:\/\{\(\[<>_]+-? */u', $title, $m1, PREG_OFFSET_CAPTURE);
	foreach ($m1[0] as &$m2) {
		//shorthand these- "match" and "index"
		list ($m, $i) = $m2;
		
		//correct offsets for multi-byte characters (`PREG_OFFSET_CAPTURE` returns *byte*-offset)
		//we fix this by recounting the text before the offset using multi-byte aware `strlen`
		$i = mb_strlen (substr ($title, 0, $i), 'UTF-8');
		
		//find words that should always be lowercase…
		//(never on the first word, and never if preceded by a colon)
		$m = $i>0 && mb_substr ($title, max (0, $i-2), 1, 'UTF-8') !== ':' && 
			!preg_match ('/[\x{2014}\x{2013}] ?/u', mb_substr ($title, max (0, $i-2), 2, 'UTF-8')) && 
			 preg_match ('/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|t(he|o)|vs?\.?|via)[ \-]/i', $m)
		?	//…and convert them to lowercase
			mb_strtolower ($m, 'UTF-8')
			
		//else:	brackets and other wrappers
		: (	preg_match ('/[\'"_{(\[‘“]/u', mb_substr ($title, max (0, $i-1), 3, 'UTF-8'))
		?	//convert first letter within wrapper to uppercase
			mb_substr ($m, 0, 1, 'UTF-8').
			mb_strtoupper (mb_substr ($m, 1, 1, 'UTF-8'), 'UTF-8').
			mb_substr ($m, 2, mb_strlen ($m, 'UTF-8')-2, 'UTF-8')
			
		//else:	do not uppercase these cases
		: (	preg_match ('/[\])}]/', mb_substr ($title, max (0, $i-1), 3, 'UTF-8')) ||
			preg_match ('/[A-Z]+|&|\w+[._]\w+/u', mb_substr ($m, 1, mb_strlen ($m, 'UTF-8')-1, 'UTF-8'))
		?	$m
			//if all else fails, then no more fringe-cases; uppercase the word
		:	mb_strtoupper (mb_substr ($m, 0, 1, 'UTF-8'), 'UTF-8').
			mb_substr ($m, 1, mb_strlen ($m, 'UTF-8'), 'UTF-8')
		));
		
		//resplice the title with the change (`substr_replace` is not multi-byte aware)
		$title = mb_substr ($title, 0, $i, 'UTF-8').$m.
			 mb_substr ($title, $i+mb_strlen ($m, 'UTF-8'), mb_strlen ($title, 'UTF-8'), 'UTF-8')
		;
	}
	
	//restore the HTML
	foreach ($html[0] as &$tag) $title = substr_replace ($title, $tag[0], $tag[1], 0);
        
        // fix colon
        $title = str_replace(" : ", ": ", $title);
	return $title;
    }
    
    // parse book editors names to array
    public static function parseEditors($str)
    {
        $editors = array();
        foreach(explode(",", $str) as $_name) {
            $_name = trim($_name);
            $name = array();
            foreach(explode(" ", $_name) as $c) {
                $c = trim($c, " .");
                if($c !== '' && ctype_upper($c[0])) {
                    $name[] = $c;
                }
            }
            $name = implode(" ", $name);
            $editors[] = $name;
        }
        return $editors;
    }
    
    // pilih kota yang sebisa mungkin di luar US (kalau ada)
    public static function cityNonUS($cities)
    {
        $i = 0;
        $idx = 0;
        foreach($cities as $city) {
            $city = strtolower($city);
            if(strpos($city, "united states") === false) {
                $idx = $i;
                break;
            }
            $i++;
        }
        return $cities[$idx];
    }
    
    // do named entity recognition
    public static function NER($sentences)
    {
        Yii::setPathOfAlias('StanfordNLP', Yii::app()->basePath . '/components/StanfordNLP');

        $ner = new StanfordNLP\NERTagger(
            Yii::app()->params['stanfordNerPath'] . 'classifiers/english.muc.7class.distsim.crf.ser.gz',
            Yii::app()->params['stanfordNerPath'] . 'stanford-ner.jar'    
        );

        $result = $ner->tag(explode('.', $sentences));
        return $result;
    }    
    
    // parse persons dari hasil Stanford NER
    public static function parseNerPerson($result)
    {
        $persons = array();

        // merge adjacent entities
        $j = 0;
        $length = count($result);
        for($i = 0; $i < $length; $i++) {
            if($result[$i][1] == 'PERSON') {
                $name = $result[$i][0];
                $j = $i + 1;
                while($j < $length && $result[$j][1] == 'PERSON') {
                    $name .= ' ' . $result[$j][0];
                    $j++;
                }
                $i = $j;
                $persons[] = $name;
            }
        }        
        
        if(count($persons) > 0)
            return $persons;
        else
            return null;
    }
    
    // parse lokasi dari hasil Stanford NER
    public static function parseNerLocation($result)
    {
        $locations = array();

        $j = 0;
        $length = count($result);
        for($i = 0; $i < $length; $i++) {
            if($result[$i][1] == 'LOCATION') {
                $v = $result[$i][0];
                $j = $i + 1;
                while($j < $length && $result[$j][1] == 'LOCATION') {
                    $v .= ' ' . $result[$j][0];
                    $j++;
                }
                $i = $j;
                $locations[] = str_replace(",", "", $v);
            }
        }           
        
        if(count($locations) > 0)
            return implode(', ', $locations);
        else
            return '';
    }

    // parse tanggal dari hasil Stanford NER
    public static function parseNerDate($result)
    {
        $date = array();

        $j = 0;
        $length = count($result);
        for($i = 0; $i < $length; $i++) {
            if($result[$i][1] == 'DATE') {
                $v = $result[$i][0];
                $j = $i + 1;
                while($j < $length && $result[$j][1] == 'DATE') {
                    $v .= ' ' . $result[$j][0];
                    $j++;
                }
                $i = $j;
                $date[] = str_replace(",", "", $v);
            }
        }              
        
        $udate = array_unique($date);
        
        if(count($udate) > 0)
            return implode(' ', $udate);
        else
            return '';
    }
    
    // parse XML hasil Grobid
    public static function parseGrobid(SimpleXMLElement $xml)
    {
        $ret = array('', ''); // DOI, title
        
        // check if DOI exist
        if (isset($xml->teiHeader->fileDesc->sourceDesc->biblStruct->idno) &&
            $xml->teiHeader->fileDesc->sourceDesc->biblStruct->idno['type'] == 'DOI') 
        {
            $ret[0] = $xml->teiHeader->fileDesc->sourceDesc->biblStruct->idno;
        }
        
        // check title
        if (isset($xml->teiHeader->fileDesc->titleStmt->title))
        {
            $ret[1] = $xml->teiHeader->fileDesc->titleStmt->title;
        }        
        
        return $ret;
    }
    
}
