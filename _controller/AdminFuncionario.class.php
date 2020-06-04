<?php
class AdminFuncionario
{
    private $table = 'Funcionario';
    private $tableFilho = 'FuncionarioFilho';
    private $execute = null;

    public function getExecuteResult()
    {
        return $this->execute->getResult();
    }

    public function getExecuteMsg()
    {
        return $this->execute->getMsg();
    }

    public function Pesquisa($texto)
    {
        $query = "SELECT f.CodFuncionario, f.Nome, f.DataNascimento, 
                        (SELECT COUNT(CodFuncionario) FROM {$this->tableFilho} ff 
                            WHERE f.CodFuncionario = ff.CodFuncionario) AS qtfilho 
                  FROM {$this->table} f 
                  WHERE f.nome LIKE CONCAT('%',:pesquisa,'%');";

        $this->execute = new Read();
        $this->execute->fullRead($query, "pesquisa={$texto}");
    }

    public function exeReadFilhos($cod)
    {
        $this->execute = new Read();
        $this->execute->exeRead($this->tableFilho, "WHERE CodFuncionario = :CodFuncionario", "CodFuncionario={$cod}");
    }

    public function exeCreateFilho($dados)
    {
        $this->execute = new Create();
        $this->execute->exeCreate($this->tableFilho, $dados);
    }

    public function exeReadFilho($cod)
    {
        $this->execute = new Read();
        $this->execute->exeRead($this->tableFilho, "WHERE CodFuncionarioFilho = :CodFuncionarioFilho", "CodFuncionarioFilho={$cod}");
    }

    public function exeUpdateFilho($dados, $cod)
    {
        $this->execute = new Update();
        $this->execute->exeUpdate($this->tableFilho, $dados, "WHERE CodFuncionarioFilho = :CodFuncionarioFilho", "CodFuncionarioFilho={$cod}");
    }

    public function exeDeleteFilho($cod)
    {
        $condicao = "WHERE CodFuncionarioFilho = :CodFuncionarioFilho";
        $this->execute = new Delete();
        $this->execute->exeDelete($this->tableFilho, $condicao, "CodFuncionarioFilho={$cod}");
    }

    public function exeCreate($dados)
    {
        $this->execute = new Create();
        $this->execute->exeCreate($this->table, $dados);
    }

    public function exeDelete($cod)
    {
        $condicao = "WHERE CodFuncionario = :CodFuncionario";
        $this->execute = new Delete();
        $this->execute->exeDelete($this->tableFilho, $condicao, "CodFuncionario={$cod}");
        $this->execute->exeDelete($this->table, $condicao, "CodFuncionario={$cod}");
    }

    public function exeReadFunc($cod)
    {
        $this->execute = new Read();
        $this->execute->exeRead($this->table, "WHERE CodFuncionario = :CodFuncionario", "CodFuncionario={$cod}");
    }

    public function exeReadFuncFilho($cod)
    {
        $this->execute = new Read();
        $this->execute->exeRead($this->tableFilho, "WHERE CodFuncionario = :CodFuncionario", "CodFuncionario={$cod}");
    }

    public function exeUpdate($dados, $cod)
    {
        $this->execute = new Update();
        $this->execute->exeUpdate($this->table, $dados, "WHERE CodFuncionario = :CodFuncionario", "CodFuncionario={$cod}");
    }
    
    
    
    //validação
    
    <?php

function validaCPF($cpf)
{
    $soma = 0;
    $novoCpf = substr($cpf, 0, 9);					    //Pega somente os valores para o cálculo sem os dígitos.

    for($d = 2; $d >= 1; $d--):						    //Controla a quantidade de digitos.
        $j = ($d == 2) ? 10 : 11;					    //Recebe o multiplicador inicial.
        for($i = 0; $i < strlen($novoCpf); $i++)	    //Varre o vetor do $novocpf.
        {
            $valor = substr($novoCpf, $i, 1);		    //Pega um valor.
            $soma += $valor * $j--;					    //Soma todas as multiplicações do vetor.
        }
        
        $resto = $soma % 11;						    //Resto da divisão.
        $novoCpf .= ($resto < 2) ? 0 : 11 - $resto;	    //Recebe o digito e concatena.
        $soma=0;									    //Zera a soma.
    endfor;
    
    if($novoCpf == $cpf)							    //Verifica se o CPF é válido.
        return '';								        //Retorna TRUE se for verdadeiro.
    else
        return 'Este CPF é inválido.';
}

function validaCNPJ($cnpj)
{
    $soma = 0;
    $novoCnpj = substr($cnpj, 0, 12);				    //Pega somente os valores para o cálculo.

    for($d = 2; $d >= 1; $d--):						    //Controla a quantidade de digitos.
        $j = ($d == 2) ? 5 : 6;						    //Recebe o multiplicador inicial.
        for($i = 0; $i < strlen($novoCnpj); $i++)	    //Varre o vetor do $novocnpj.
        {
            $valor = substr($novoCnpj, $i, 1);		    //Pega um valor.
            $soma += $valor * $j--;					    //Soma todas as multiplicações do vetor.
            if ($j < 2) $j = 9;						    //Verifica o valor do multiplicador.
        }
        
        $resto = $soma % 11;						    //Resto da divisão.
        $novoCnpj .= ($resto < 2) ? 0 : 11 - $resto;	//Recebe o primeiro digito.
        $soma=0;									    //Zera a soma.
    endfor;
    
    if($novoCnpj == $cnpj)							    //Verifica se o CNPJ é válido.
        return '';								        //Retorna TRUE se for verdadeiro.
    else
        return 'Este CNPJ é inválido!';
}
}
