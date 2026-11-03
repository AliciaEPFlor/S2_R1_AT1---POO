<?php
// CLASSE: FoneDeOuvido
// Modelagem de um objeto pessoal com encapsulamento,
// construtor, getters/setters e métodos funcionais.

class FoneDeOuvido {
    // 1. ATRIBUTOS PRIVADOS (Encapsulamento)

    private int   $nivelBateria;   // int   → 0 a 100 (%)
    private int   $volume;         // int   → 0 a 100
    private bool  $ligado;         // bool  → true ou false
    private bool  $conectado;      // bool  → true ou false

    // 2. CONSTRUTOR
    public function __construct(int $nivelBateria = 100, int $volume = 50) {
        // Usa os setters para aproveitar as validações
        $this->setNivelBateria($nivelBateria);
        $this->setVolume($volume);
        $this->ligado = false;      // bool → Por padrão desligado
        $this->conectado = false;   // bool -> Por padrão desconectado
    }

    // 3. GETTERS
    public function getNivelBateria(): int {
        return $this->nivelBateria;
    }

    public function getVolume(): int {
        return $this->volume;
    }

    public function isLigado(): bool {
        return $this->ligado;
    }

    public function isConectado(): bool {
        return $this->conectado;
    }

    // 4. SETTERS
    public function setNivelBateria(int $nivel): void {
        if ($nivel < 0 || $nivel > 100) {
            echo "Erro: Bateria deve estar entre 0% e 100%.\n";
            return;
        }
        $this->nivelBateria = $nivel;
    }

    public function setVolume(int $volume): void {
        if ($volume < 0 || $volume > 100) {
            echo "Erro: Volume deve estar entre 0 e 100.\n";
            return;
        }
        $this->volume = $volume;
    }
    // 5. MÉTODOS FUNCIONAIS (Comportamentos)

    // Ligar o fone (verifica bateria)
    public function ligar(): void {
        if ($this->ligado) {
            echo "O fone já está ligado.\n";
            return;
        }
        if ($this->nivelBateria <= 0) {
            echo "Não é possível ligar: bateria descarregada!\n";
            return;
        }
        $this->ligado = true;
        echo "Fone ligado com sucesso!\n";
    }

    // Desligar o fone (também desconecta)
    public function desligar(): void {
        if (!$this->ligado) {
            echo "O fone já está desligado.\n";
            return;
        }
        $this->ligado = false;
        $this->conectado = false;
        echo "Fone desligado.\n";
    }

    // Conectar ao dispositivo (verifica se está ligado)
    public function conectar(): void {
        if (!$this->ligado) {
            echo "Não é possível conectar: o fone está desligado!\n";
            return;
        }
        if ($this->conectado) {
            echo "O fone já está conectado.\n";
            return;
        }
        $this->conectado = true;
        echo "Fone conectado ao dispositivo.\n";
    }

    // Tocar música (regra de negócio composta)
    public function tocarMusica(): void {
        if (!$this->ligado) {
            echo "Não é possível tocar música: fone desligado.\n";
            return;
        }
        if (!$this->conectado) {
            echo "Não é possível tocar música: fone não conectado.\n";
            return;
        }
        if ($this->nivelBateria <= 0) {
            echo "Não é possível tocar música: bateria descarregada.\n";
            return;
        }
        // Consome 5% de bateria por execução
        $this->nivelBateria -= 5;
        echo "Tocando música no volume {$this->volume}... (Bateria: {$this->nivelBateria}%)\n";
    }

    // Carregar o fone (aumenta bateria com limite de 100%)
    public function carregar(int $percentual): void {
        if ($percentual <= 0) {
            echo "Valor de carga inválido.\n";
            return;
        }
        $this->nivelBateria += $percentual;
        if ($this->nivelBateria > 100) {
            $this->nivelBateria = 100;
        }
        echo "Carregando... Bateria atual: {$this->nivelBateria}%\n";
    }

    // Exibir status completo
    public function status(): void {
        $estadoLigado  = $this->ligado ? "Ligado" : "Desligado";          
        $estadoConexao = $this->conectado ? "Conectado" : "Desconectado"; 
        echo "Status: {$estadoLigado} | {$estadoConexao} | " .
             "Bateria: {$this->nivelBateria}% | Volume: {$this->volume}\n";
    }
}

// PROGRAMA DE TESTE (Main) — execução no terminal
// 6. INSTANCIANDO O OBJETO (via construtor)
$meuFone = new FoneDeOuvido(80, 60);   // objeto FoneDeOuvido
$meuFone->status();

// 7. CONSULTANDO E ALTERANDO VIA GETTERS/SETTERS
echo "Bateria atual: " . $meuFone->getNivelBateria() . "%\n";  // int
echo "Volume atual: "  . $meuFone->getVolume() . "\n";          // int

echo "\nAlterando volume para 75...\n";
$meuFone->setVolume(75);

// 8. TESTANDO VALIDAÇÕES DOS SETTERS
echo "\nTentando definir volume = 150 (inválido):\n";
$meuFone->setVolume(150);

echo "Tentando definir bateria = -20 (inválido):\n";
$meuFone->setNivelBateria(-20);

// 9. TESTANDO MÉTODOS FUNCIONAIS

echo "\nTentando tocar música com fone desligado:\n";
$meuFone->tocarMusica();

echo "\nLigando o fone:\n";
$meuFone->ligar();

echo "\nTentando tocar música sem conexão:\n";
$meuFone->tocarMusica();

echo "\nConectando o fone:\n";
$meuFone->conectar();

echo "\nTocando música:\n";
$meuFone->tocarMusica();

echo "\nCarregando 50%:\n";
$meuFone->carregar(50);

echo "\nStatus final:\n";
$meuFone->status();

echo "\nDesligando o fone:\n";
$meuFone->desligar();
$meuFone->status();

// 10. TESTE CRÍTICO: BATERIA ZERADA
echo "\nCriando fone com 0% de bateria...\n";
$foneDescarregado = new FoneDeOuvido(0, 50);   // objeto FoneDeOuvido
$foneDescarregado->ligar();