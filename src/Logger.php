<?php

namespace HermesTecnologia\Logger;

class Logger extends Log
{
    /**
     * Escreve uma mensagem no arquivo de LOG
     * @param $message = mensagem a ser escrita
     */

     public function write()
     {
         $debug = debug_backtrace();
         $trace = '## Backtrace: ';
         if(is_array($debug)){
             foreach($debug as $d){
                 if(isset($d['file'])){
                     $file = substr($d['file'],strrpos($d['file'], DIRECTORY_SEPARATOR)) ;
                     $trace .= $file .'['. $d['line'] . '] ';
                 }
             }
         }
 
         if(is_array($this->message)){
             $this->message = json_encode($this->message,JSON_PRETTY_PRINT);
         }
         if(is_object($this->message)){
             $this->message = json_encode((array) $this->message,JSON_PRETTY_PRINT);
         }
 
         // $filelog = config('logging.localpath').$this->prefix.'_'.date("Y-m-d").'.log';
 
         $path = config('logger.localpath');
         
         $filelog = $path.$this->prefix.'_'. strtoupper( get_current_user() ) .'_'.date("Y-m-d").'.log';
 
         $log  = '# **'.$this->prefix.'** - '.date(DATE_ATOM, time()).''.PHP_EOL.
                 $trace.PHP_EOL;
 
         if(!is_null($this->sql)){
         $log  .= '## STATEMENT: '.PHP_EOL.
                 ' '.$this->sql.PHP_EOL;
         }
         
         $log  .= '## ERROR: '.PHP_EOL
                 .'```javascript'.PHP_EOL
                 .$this->message.PHP_EOL
                 .'```'.PHP_EOL;
 
         $log  .= "-------------------------".PHP_EOL;
 
 
         if( $this->prefix == 'LOG' ){
             $filelog = $path . $this->prefix . '_' . time() .'_'.date("Y-m-d").'.log';
             file_put_contents($filelog, $log, FILE_APPEND | LOCK_EX);
         }else{
             file_put_contents($filelog, $log, FILE_APPEND | LOCK_EX);
         }
         
 
         $log = str_replace('"','',$log);
 
         return true;
     }
}