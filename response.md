# 🧠 Exercícios de Aplicação — Encapsulamento e Construtores em PHP

---

## 📌 1. Explicação Teórica

### 🔹 Diferença entre `public` e `private`

| Modificador | Quem pode acessar | Uso típico |
|-------------|-------------------|------------|
| `public` | **Qualquer lugar** (dentro ou fora da classe) | Métodos que precisam ser chamados de fora |
| `private` | **Somente a própria classe** | Atributos sensíveis, controle interno |

**Exemplo prático:**

```php
class Cliente {
    public $nome;      // acessível de fora
    private $cpf;      // só acessível dentro da classe
}

$cliente = new Cliente();
$cliente->nome = "Ana";   // ✅ funciona
$cliente->cpf  = "123";   // ❌ ERRO fatal
```

> 💡 **Boa prática:** atributos **sempre `private`**, e o acesso controlado por **getters e setters**.

---

### 🔹 O que acontece ao acessar um atributo `private` fora da classe?

O PHP gera um **erro fatal** e interrompe a execução:

```
Fatal error: Uncaught Error: Cannot access private property Cliente::$cpf
```

**Ou seja:** o encapsulamento está funcionando — é justamente esse erro que **protege os dados** de alterações indevidas.

```php
$cliente = new Cliente();
$cliente->cpf = "000"; 
// ❌ Fatal error: Cannot access private property
```

---

### 🔹 Qual a função do construtor?

O construtor (`__construct`) é um método **especial** que:

1. **Executa automaticamente** quando o objeto é criado (`new Cliente(...)`).
2. **Inicializa os atributos** obrigatórios.
3. **Garante que o objeto já nasça válido** — evita criar objetos "vazios" ou inconsistentes.

```php
class Cliente {
    private $nome;
    private $cpf;

    public function __construct($nome, $cpf) {
        $this->nome = $nome;
        $this->cpf  = $cpf;
    }
}

$cliente = new Cliente("Ana", "123.456.789-00"); // ✅ obrigatório passar dados
```

> 🏭 **No mercado:** *"Não existe cliente sem nome e CPF."*

---

## 🛠️ 2. Exercício de Aplicação — Classe `Produto`

### 📄 Código completo

```php
<?php

class Produto {
    // Atributos privados
    private $nome;
    private $preco;

    // Construtor com nome e preço
    public function __construct($nome, $preco) {
        $this->nome  = $nome;
        $this->preco = $preco;
    }

    // Getters
    public function getNome() {
        return $this->nome;
    }

    public function getPreco() {
        return $this->preco;
    }
}

// Criando dois objetos Produto
$produto1 = new Produto("Notebook", 3500.00);
$produto2 = new Produto("Mouse Gamer", 150.00);

// Exibindo os dados
echo "Produto 1: {$produto1->getNome()} — R$ {$produto1->getPreco()}<br>";
echo "Produto 2: {$produto2->getNome()} — R$ {$produto2->getPreco()}<br>";

// Teste: tentar acessar atributo private diretamente
// $produto1->nome = "Outro"; 
// ❌ Fatal error: Cannot access private property Produto::$nome
?>
```

### ✅ Saída esperada

```
Produto 1: Notebook — R$ 3500
Produto 2: Mouse Gamer — R$ 150
```

### 📋 Checklist

- [x] Atributos `private` (`$nome`, `$preco`)
- [x] Construtor recebendo `nome` e `preço`
- [x] Getters para consulta
- [x] Dois objetos criados

---

## 🏆 3. Desafio Profissional — Validação de CPF

### ❓ Onde deve ficar a validação?

| Local | É o ideal? | Por quê? |
|-------|-----------|----------|
| **No formulário (frontend)** | ❌ Não | Pode ser burlado (desabilitar JS, enviar via Postman) |
| **No setter (classe)** | ✅ **Sim** | Centraliza a regra, protege o objeto em **qualquer** ponto de entrada |
| **Direto no atributo** | ❌ Impossível | Atributos `private` não têm lógica — só armazenam valores |

### 🎯 Resposta correta: **no `setter`**

### 💡 Justificativa

1. **Encapsulamento** = o objeto se protege sozinho.
2. **Regra única** = vale para qualquer tela, API, importação em massa.
3. **O frontend é conveniência; o backend é a lei.**

### 📄 Exemplo prático

```php
class Cliente {
    private $nome;
    private $cpf;

    public function setCpf($cpf) {
        // Validação da regra de negócio
        if (!$this->validarCpf($cpf)) {
            throw new Exception("❌ CPF inválido: $cpf");
        }
        $this->cpf = $cpf;
    }

    public function getCpf() {
        return $this->cpf;
    }

    private function validarCpf($cpf) {
        // Remove máscara e verifica tamanho
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        return strlen($cpf) === 11;
    }
}

$cliente = new Cliente();

try {
    $cliente->setCpf("123.456.789-00"); // ✅ válido
    echo "CPF salvo: " . $cliente->getCpf();

    $cliente->setCpf("000");            // ❌ inválido
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### ✅ Boa prática profissional

```
[ Formulário ]  →  validação "amigável" (UX, feedback rápido)
        ↓
[ Setter ]      →  validação "oficial" (segurança, regra de negócio)
        ↓
[ Banco ]       →  dado confiável, sistema íntegro
```

> 💬 **Regra de ouro:** *valide no frontend para o usuário; valide no backend para o sistema.*

