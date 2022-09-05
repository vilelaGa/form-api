<?php

namespace App\DbConnect;

use PDOException;
use PDO;


class DbConnect
{
    //Constantes de conexão com Db
    const SERVER = "localhost";
    const DATABASE_NAME = "usuarios";
    const USER = "root";
    const PASSWORD = "";

    //Variavel tabela
    public $tabela;


    /**
     * Conexão db
     * @var PDO
     */
    public $conexao;


    /**
     * Função define a tabela e instancia de conexão
     * 1 Parametro
     * @var string tabela
     */
    public function __construct($tabela = null)
    {
        $this->tabela = $tabela;
        $this->setConnection();
    }


    /**
     * Função que efetua a conexão com Db
     */
    private function setConnection()
    {
        try {
            $this->conexao = new PDO('mysql:host=' . self::SERVER . ';dbname=' . self::DATABASE_NAME,  self::USER, self::PASSWORD);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERRO DE CONEXÃO {$e->getMessage()}");
            // die("ERRO: 405");
        }
    }


    /**
     * Função para execultar a query no Db
     * 2 Parametro 
     * @var string query
     * @var array parametros
     */
    public function exculte($values, $parametros = [])
    {
        try {
            $excQuery = $this->conexao->prepare($values);
            $excQuery->execute($parametros);
            return $excQuery;
        } catch (PDOException $e) {
            die("ERRO NA QUERY {$e->getMessage()}");
            // die("ERRO: 405");
        }
    }


    /**
     * Função Insert no Db
     * 1 Parametro 
     * @var array values insert
     */
    public function insert($values)
    {
        $fields = array_keys($values);
        $binds =  array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->tabela . '(' . implode(',', $fields) . ') VALUES(' . implode(',', $binds) . ')';

        // var_dump($query);
        // echo '<pre>';
        // print_r($values);
        // echo '<pre>';
        // die();

        $this->exculte($query, array_values($values));

        // return $this->connection->lastInsertId();
    }


    /**
     * Função Select no Db
     * 1 Parametro 
     * @var string where
     */
    public function select($where = null)
    {
        $query = 'SELECT * FROM ' . $this->tabela . ' WHERE ' . $where;
        // var_dump($query);
        // die();
        return $this->exculte($query);
    }


    /**
     * Função SelectALL no Db 
     * @var string where
     */
    public function selectAll()
    {
        $query = 'SELECT * FROM ' . $this->tabela;
        // var_dump($query);
        // die();
        return $this->exculte($query);
    }


    /**
     * Função delete no Db
     * 1 Parametro 
     * @var string where
     */
    public function delete($where)
    {
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE ' . $where;
        // var_dump($query);
        // die();
        return $this->exculte($query);
    }


    /**
     * Função Select no Db
     * 2 Parametro 
     * @var array values @var string where
     */
    public function update($where = null, $values)
    {
        $binds = array_keys($values);

        $query = 'UPDATE ' . $this->tabela . ' SET ' . implode('=?,', $binds) . '=? WHERE ' . $where;
        $this->exculte($query, array_values($values));
        // var_dump($query);
        // die();
        return true;
        // echo $query;
    }
}
