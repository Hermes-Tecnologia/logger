<?php

namespace HermesTecnologia\Logger;

/**
 * Fornece uma interface abstrata para definição de algoritmos de LOG
 * @author Pablo Dall'Oglio
 */
abstract class Log
{
    protected $message;  // local do arquivo de LOG
    protected $sql;  //instrução sql que queira armazenar
    protected $prefix;  // prefixo identificador do LOG

    public function __construct()
    {}

    static public function do( string $prefix, array|object $message, string|null $sql = null )
    {
        // verifica se o prefixo é válido
        if( !preg_match('/^[A-Z0-9_]+$/', $prefix) ){
            throw new \Exception('Prefixo inválido: '.$prefix);
        }

        // verifica se a mensagem é válida
        if( empty($message) ){
            throw new \Exception('Mensagem inválida: '.$message);
        }

        // cria uma instância da classe e define os valores
    
        $class = get_called_class();
        $instance = new $class();
        $instance->prefix = str_replace('_', '-', strtoupper( $prefix ));
        $instance->message = $message;
        $instance->sql = $sql;
        $instance->write();
    }

    // define o método write como obrigatório
    abstract function write();
}