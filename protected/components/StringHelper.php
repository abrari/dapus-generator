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
    
}
