<?php

namespace App\Core\Database;

use PDO;
use Exception;

class QueryBuilder
{

    protected $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function selectAll($table)
    {

        $sql = "select * from {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchALL(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function insereCategoria($tables, $parametros)
    {

        $sql = "INSERT INTO `{$tables}`(`nome`) VALUES ('{$parametros['nome']}')";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table, $id)
    {
        $sql = "delete from {$table} where id = {$id}";

        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
       
    public function numLinhas($table, $filtro, $busca)
    {
        //Vendo se há alguma busca
        if( $filtro != '' )
            $sql = "SELECT COUNT(*) FROM {$table} WHERE `categoria` LIKE '%{$filtro}%'";
        else if( $busca != '' )
            $sql = "SELECT COUNT(*) FROM {$table} WHERE `nome` LIKE '%{$busca}%'";
        else
            $sql = "SELECT COUNT(*) FROM {$table}";
        
        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function login($table, $email, $senha)
    {

        $sql = "select 'email' from {$table} where email='{$email}'and senha='{$senha}'";
        
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchALL(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function paginacao($table, $pagina, $itensPorPagina, $filtro, $busca)
    {
        if( $filtro != '' )
        {
            //Filtro
            $sql = "SELECT * FROM `{$table}` WHERE `categoria` LIKE '{$filtro}' LIMIT {$pagina}, {$itensPorPagina}";
        }
        else if( $busca != '')
        {
            //Busca
            $sql = "SELECT * FROM {$table} WHERE `nome` LIKE '%{$busca}%' LIMIT {$pagina}, {$itensPorPagina}";
        }
        else{
            //Sem filtro ou busca
            $sql = "select * from {$table} LIMIT {$pagina},{$itensPorPagina}";
        }
        // die(var_dump($sql));


        try {
            
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function insereProdutos ($table, $parametros)
    {
        $sql = sprintf(
            'insert into %s (%s) values(%s)',
            $table,
            implode(', ', array_keys($parametros)),
            ':'. implode(', :', array_keys($parametros))
        );
        
        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($parametros);
            
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    

    public function edit($tabela , $parametros)
    {
        $sql = "UPDATE `{$tabela}` SET ";
        
        //Adicionando os parametros
        foreach($parametros as $chave => $parametro)
        {
            $sql = $sql . "`{$chave}` = '{$parametro}', ";
        }
        
        //Tirando a ultima virgula
        $sql = rtrim($sql, " " . ",");
        
        //Adicionando o id
        $sql = $sql . " WHERE `id` = {$parametros['id']}";
        

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }

    public function selectProduto($tabela, $id)
    {
        $sql = "SELECT * FROM $tabela WHERE id = {$id}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();


            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function insereUsuario($table, $parametros)
    {
        $sql= "INSERT INTO `usuarios`(`nome`, `email`, `senha`, `foto`) VALUES ('{$parametros['nome']}','{$parametros['email']}','{$parametros['senha']}','{$parametros['foto']}')";
        
        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute();
            
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }
    
    
}
