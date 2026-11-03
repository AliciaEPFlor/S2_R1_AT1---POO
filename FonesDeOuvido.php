<?php

// CLASSE: FoneDeOuvido (Modelagem de Objeto Pessoal)

class FoneDeOuvido {
    // 1. ATRIBUTOS PRIVADOS (Encapsulamento)

    private $nivelBateria;   // 0 a 100 (%)
    private $volume;         // 0 a 100
    private $ligado;         // true ou false
    private $conectado;      // true ou false

    // 2. CONSTRUTOR (Inicialização obrigatória)

    public function __construct($nivelBateria = 100, $volume = 50) {
        // Usa os setters para aproveitar as validações
        $this->setNivelBateria($nivelBateria);
        $this->setVolume($volume);
        $this->ligado = false;      // Por padrão desligado
        $this->conectado = false;   // Por padrão desconectado
    }
    // 3. GETTERS E SETTERS (com validações)

    public function getNivelBateria() {
        return $this->nivelBateria;
    }

    // Setter com VALIDAÇÃO: bateria entre 0 e 100
    public function setNivelBateria($nivel) {
        if ($nivel < 0 || $nivel > 100) {
            echo "Erro: Bateria deve estar entre 0% e 100%.<br>";
            return;
        }
        $this->nivelBateria = $nivel;
    }

    public function getVolume() {
        return $this->volume;
    }

    // Setter com VALIDAÇÃO: volume entre 0 e 100
    public function setVolume($volume) {
        if ($volume < 0 || $volume > 100) {
            echo "Erro: Volume deve estar entre 0 e 100.<br>";
            return;
        }
        $this->volume = $volume;
    }

    public function isLigado() {
        return $this->ligado;
    }

    public function isConectado() {
        return $this->conectado;
    }

    // 4. MÉTODOS FUNCIONAIS (Comportamentos)
    // Ligar o fone (verifica bateria)
    public function ligar() {
        if ($this->ligado) {
            echo "O fone já está ligado.<br>";
            return;
        }
        if ($this->nivelBateria <= 0) {
            echo "Não é possível ligar: bateria descarregada <br>";
            return;
        }
        $this->ligado = true;
        echo "Fone ligado com sucesso!<br>";
    }

    // Desligar o fone
    public function desligar() {
        if (!$this->ligado) {
            echo "O fone já está desligado.<br>";
            return;
        }
        $this->ligado = false;
        $this->conectado = false; // Desconecta ao desligar
        echo "Fone desligado.<br>";
    }

    // Conectar ao dispositivo (verifica se está ligado)
    public function conectar() {
        if (!$this->ligado) {
            echo "Não é possível conectar: o fone está desligado!<br>";
            return;
        }
        if ($this->conectado) {
            echo "O fone já está conectado.<br>";
            return;
        }
        $this->conectado = true;
        echo "Fone conectado ao dispositivo.<br>";
    }

    // Tocar música (regra de negócio composta)
    public function tocarMusica() {
        if (!$this->ligado) {
            echo "Não é possível tocar música: fone desligado.<br>";
            return;
        }
        if (!$this->conectado) {
            echo "Não é possível tocar música: fone não conectado.<br>";
            return;
        }
        if ($this->nivelBateria <= 0) {
            echo "Não é possível tocar música: bateria descarregada.<br>";
            return;
        }
        // Consome 5% de bateria por execução
        $this->nivelBateria -= 5;
        echo "Tocando música no volume {$this->volume}... (Bateria: {$this->nivelBateria}%)<br>";
    }

    // Carregar o fone (aumenta bateria com limite de 100%)
    public function carregar($percentual) {
        if ($percentual <= 0) {
            echo "Valor de carga inválido.<br>";
            return;
        }
        $this->nivelBateria += $percentual;
        if ($this->nivelBateria > 100) {
            $this->nivelBateria = 100;
        }
        echo "Carregando... Bateria atual: {$this->nivelBateria}%<br>";
    }

    // Exibir status completo
    public function status() {
        $estadoLigado = $this->ligado ? "Ligado" : "Desligado";
        $estadoConexao = $this->conectado ? "Conectado" : "Desconectado";
        echo "Status: {$estadoLigado} | {$estadoConexao} | " .
             "Bateria: {$this->nivelBateria}% | Volume: {$this->volume}<br>";
    }
}


// PROGRAMA DE TESTE (Main)

echo "<h2>Teste da Classe FoneDeOuvido</h2>";

// 1. INSTANCIANDO O OBJETO (via construtor)

echo "<h3>Criando o objeto com construtor</h3>";
$meuFone = new FoneDeOuvido(80, 60);
$meuFone->status();


// 2. USANDO GETTERS E SETTERS

echo "<h3>Consultando e alterando via getters/setters</h3>";
echo "Bateria atual: " . $meuFone->getNivelBateria() . "%<br>";
echo "Volume atual: " . $meuFone->getVolume() . "<br>";

echo "<br>Alterando volume para 75...<br>";
$meuFone->setVolume(75);


// 3. TESTANDO VALIDAÇÕES DOS SETTERS

echo "<h3>Testando validações (regras de negócio)</h3>";
echo "Tentando definir volume = 150 (inválido):<br>";
$meuFone->setVolume(150); // Deve falhar

echo "Tentando definir bateria = -20 (inválido):<br>";
$meuFone->setNivelBateria(-20); // Deve falhar


// 4. TESTANDO MÉTODOS FUNCIONAIS

echo "<h3>Testando métodos funcionais</h3>";

echo "<strong>Tentando tocar música com fone desligado:</strong><br>";
$meuFone->tocarMusica(); // Deve falhar (desligado)

echo "<br><strong>Ligando o fone:</strong><br>";
$meuFone->ligar();

echo "<br><strong>Tentando tocar música sem conexão:</strong><br>";
$meuFone->tocarMusica(); // Deve falhar (não conectado)

echo "<br><strong>Conectando o fone:</strong><br>";
$meuFone->conectar();

echo "<br><strong>Tocando música:</strong><br>";
$meuFone->tocarMusica();

echo "<br><strong>Carregando 50%:</strong><br>";
$meuFone->carregar(50);

echo "<br><strong>Status final:</strong><br>";
$meuFone->status();

echo "<br><strong>Desligando o fone:</strong><br>";
$meuFone->desligar();
$meuFone->status();


// 5. TESTE CRÍTICO: BATERIA ZERADA

echo "<h3>Teste de regra: bateria descarregada</h3>";
$foneDescarregado = new FoneDeOuvido(0, 50);
echo "Criando fone com 0% de bateria...<br>";
$foneDescarregado->ligar(); // Deve falhar
?>