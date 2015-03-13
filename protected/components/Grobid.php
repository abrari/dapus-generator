<?php

/**
 * Wrapper untuk GROBID: aplikasi pengekstrak metadata dari PDF
 *
 * @author abrari
 */
class Grobid {
    
    private $java_path = 'java';
    private $java_options = '';
    
    private $grobidJar;
    private $grobidHome;
    
    // input and output directory
    private $in;
    private $out;
    
    private $process;
    
    public function setJava_path($java_path) {
        $this->java_path = $java_path;
    }

    public function setJava_options($java_options) {
        $this->java_options = $java_options;
    }

    public function setGrobidJar($grobidJar) {        
        if (file_exists($grobidJar)) {
            $this->grobidJar = $grobidJar;
        } else {
            throw new Exception("Jar file path does not exist: " . $grobidJar);
        }        
    }

    public function setGrobidHome($grobidHome) {
        if (file_exists($grobidHome)) {
            $this->grobidHome = $grobidHome;
        } else {
            throw new Exception("Grobid Home directory path does not exist.");
        }          
    }

    public function setIn($in) {
        if (file_exists($in)) {
            $this->in = $in;
        } else {
            throw new Exception("Input directory path does not exist.");
        }          
    }

    public function setOut($out) {
        if (file_exists($out)) {
            $this->out = $out;
        } else {
            throw new Exception("Output directory path does not exist.");
        }            
    }

    public function setProcess($process) {
        $this->process = $process;
    }

    public function run() {
        
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin
           1 => array("pipe", "w"),  // stdout
           2 => array("pipe", "w")   // stderr
        );        
        
        $cmd = escapeshellcmd(
                $this->java_path . ' ' . $this->java_options 
                . ' -jar ' 
                . escapeshellarg($this->grobidJar)
                . ' -gH ' 
                . escapeshellarg($this->grobidHome)
                . ' -dIn ' 
                . escapeshellarg($this->in)
                . ' -dOut ' 
                . escapeshellarg($this->out)
                . ' -exe ' 
                . $this->process
        );  
        
        $process = proc_open($cmd, $descriptorspec, $pipes, $this->in);
            
        $output = null;
        $errors = null;
        if (is_resource($process)) {
            // We aren't working with stdin
            fclose($pipes[0]);

            // Get output
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Get any errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // close pipe before calling proc_close in order to avoid a deadlock
            $return_value = proc_close($process);
            if ($return_value == -1) {
                throw new Exception("Java process returned with an error (proc_close).");
            }
        }        
        
        if (file_exists($this->out . '/input.tei.xml')) {
            return simplexml_load_file($this->out . '/input.tei.xml');
        } else {
            throw new CHttpException(500, "Terjadi kesalahan pada proses GROBID");
        }
    }
    
}
