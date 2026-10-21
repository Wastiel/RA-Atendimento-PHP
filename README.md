# 📘 Guia do Projeto: Sistema de Atendimento (RAtendimento2)

> Material de apoio para quem está tendo o **primeiro contato com desenvolvimento WEB**.
> Não precisa entender tudo de uma vez. Leia na ordem, abra os arquivos do projeto ao lado e vá conferindo.

---

## 📑 Índice

1. [O que é este projeto?](#1-o-que-é-este-projeto)
2. [Como uma aplicação WEB funciona (a base de tudo)](#2-como-uma-aplicação-web-funciona-a-base-de-tudo)
3. [As tecnologias usadas](#3-as-tecnologias-usadas)
4. [O Banco de Dados](#4-o-banco-de-dados)
5. [Estrutura de pastas](#5-estrutura-de-pastas)
6. [A pasta `includes/`: peças reaproveitadas](#6-a-pasta-includes-peças-reaproveitadas)
7. [Login e Sessão: como o sistema sabe quem é você](#7-login-e-sessão-como-o-sistema-sabe-quem-é-você)
8. [O padrão CRUD: o coração do sistema](#8-o-padrão-crud-o-coração-do-sistema)
9. [Estudo de caso: o módulo Cliente, arquivo por arquivo](#9-estudo-de-caso-o-módulo-cliente-arquivo-por-arquivo)
10. [O módulo Atendimento (o mais completo)](#10-o-módulo-atendimento-o-mais-completo)
11. [Dashboard](#11-dashboard)
12. [O visual: Bootstrap e CSS](#12-o-visual-bootstrap-e-css)
13. [Como rodar o projeto](#13-como-rodar-o-projeto)
14. [⚠️ Pontos de atenção (o que melhorar)](#14-️-pontos-de-atenção-o-que-melhorar)
15. [Exercícios para praticar](#15-exercícios-para-praticar)
16. [Glossário](#16-glossário)

---

## 1. O que é este projeto?

O **RAtendimento2** é um sistema para **registrar atendimentos** feitos a clientes, por exemplo numa secretaria escolar. (O nome "EEEPE" aparece no menu e no login.)

Ele responde perguntas como:

- **Quem** foi atendido? → *Cliente*
- **Quem** atendeu? → *Atendente*
- **Qual** foi o assunto? → *Tipo de Atendimento*
- **Quando** começou e terminou? → *Atendimento*

### O que o sistema faz

| Funcionalidade | Descrição |
|---|---|
| 🔐 Login | Só entra quem tem usuário e senha |
| 👥 Clientes | Cadastrar, editar, ativar/desativar |
| 🧑‍💼 Atendentes | Cadastrar, editar, ativar/desativar (com perfil Usuário ou Administrador) |
| 🏷️ Tipos de Atendimento | Ex.: "Matrícula", "Segunda via de documento" |
| 📋 Atendimentos | Registrar, editar, concluir e cancelar |
| 📊 Dashboard | Painel com totais gerais |

---

## 2. Como uma aplicação WEB funciona (a base de tudo)

Antes do código, vamos entender a **conversa** entre o navegador e o servidor.

```
┌──────────────┐      1. Pedido (Request)       ┌──────────────────┐
│  NAVEGADOR   │  ───────────────────────────▶  │     SERVIDOR     │
│  (Chrome)    │                                │  (Apache + PHP)  │
│  o "cliente" │  ◀───────────────────────────  │                  │
└──────────────┘      4. Resposta (HTML)        └────────┬─────────┘
                                                         │ 2. PHP executa
                                                         │    e consulta
                                                         ▼
                                                ┌──────────────────┐
                                                │  BANCO DE DADOS  │
                                                │    (MariaDB)     │
                                                └──────────────────┘
                                                  3. devolve os dados
```

### Passo a passo

1. Você digita um endereço ou clica num link. O navegador faz um **pedido** (*request*) ao servidor.
2. O servidor encontra o arquivo `.php` e **executa o código PHP**.
3. Se precisar de dados, o PHP **pergunta ao banco de dados**.
4. O PHP monta uma página **HTML** e a devolve. O navegador só recebe HTML pronto. **Ele nunca vê o seu código PHP.**

> 💡 **Ideia-chave:** PHP roda no **servidor**. HTML/CSS aparecem no **navegador**.

### GET e POST: duas formas de enviar informação

| | GET | POST |
|---|---|---|
| Onde vão os dados? | Na **URL** (`form.php?id=5`) | **Escondidos** no corpo do pedido |
| Quando usar? | Para **buscar/abrir** algo | Para **enviar formulários** |
| Neste projeto | Links "Editar", "Desativar" | Formulários de login e cadastro |
| Em PHP | `$_GET['id']` | `$_POST['nome']` |

Exemplo real do projeto, o botão Editar:

```html
<a href="form.php?id=5">Editar</a>
```

O `?id=5` vai na URL. Lá no `form.php`, o PHP lê com `$_GET['id']` e descobre que é para editar o registro 5.

---

## 3. As tecnologias usadas

| Tecnologia | Papel | Analogia |
|---|---|---|
| **HTML** | Estrutura da página | O **esqueleto** do prédio |
| **CSS** | Aparência (cores, espaços) | A **pintura e decoração** |
| **Bootstrap 5** | Biblioteca de CSS pronta | **Móveis prontos**, em vez de fabricar cada um |
| **Bootstrap Icons** | Ícones (lápis, check, usuário) | Adesivos prontos |
| **PHP** | Lógica no servidor | O **cérebro** |
| **PDO** | Forma de o PHP falar com o banco | O **telefone** entre PHP e banco |
| **MariaDB (MySQL)** | Guarda os dados | O **arquivo/armário** de dados |
| **SQL** | Linguagem para consultar o banco | O **idioma** que o banco entende |
| **Git/GitHub** | Controle de versões | O "histórico" do projeto |

> O projeto usa **PHP puro**, sem framework (como Laravel). Isso é ótimo para aprender, pois dá para ver tudo o que está acontecendo.

---

## 4. O Banco de Dados

> ℹ️ O arquivo `.sql` **não veio no projeto**. As tabelas abaixo foram **deduzidas lendo o código PHP** (os `SELECT`, `INSERT` e `UPDATE`). Os tipos de dados (`VARCHAR`, `INT`...) são uma **sugestão**.

### 4.1 As 4 tabelas

```
┌────────────────┐        ┌───────────────────┐
│    cliente     │        │ tipo_atendimento  │
├────────────────┤        ├───────────────────┤
│ id_cliente  PK │        │ id_tipo_atend. PK │
│ nome           │        │ tipo_atendimento  │
│ cpf            │        │ ativo             │
│ telefone       │        └─────────┬─────────┘
│ ativo          │                  │
└───────┬────────┘                  │
        │ 1                         │ 1
        │                           │
        │ N                         │ N
        ▼                           ▼
     ┌──────────────────────────────────┐
     │           atendimento            │
     ├──────────────────────────────────┤
     │ id_atendimento              PK   │
     │ id_cliente                  FK   │
     │ id_atendente                FK   │
     │ id_tipo_atendimento         FK   │
     │ dt_inicio                        │
     │ dt_fim  (vazio = em aberto)      │
     │ descricao                        │
     │ ativo   (N = cancelado)          │
     └──────────────────────────────────┘
                    ▲ N
                    │
                    │ 1
        ┌───────────┴───────────┐
        │       atendente       │
        ├───────────────────────┤
        │ id_atendente       PK │
        │ login                 │
        │ senha                 │
        │ nome                  │
        │ cpf                   │
        │ tipo_acesso (U ou A)  │
        │ ativo                 │
        └───────────────────────┘
```

### 4.2 Conceitos importantes

- **PK (Primary Key / Chave Primária):** identificador **único** de cada linha (o `id_...`).
- **FK (Foreign Key / Chave Estrangeira):** campo que **aponta** para a PK de outra tabela. É assim que o `atendimento` "sabe" quem é o cliente.
- **Relacionamento 1:N:** *um* cliente pode ter *vários* atendimentos.

### 4.3 O campo `ativo` ('S' ou 'N')

Quase toda tabela tem `ativo`. Quando você "desativa" um cliente, **ele não é apagado**, só passa de `'S'` para `'N'`.

> 🧠 Isso se chama **exclusão lógica** (*soft delete*). Por quê? Se apagássemos o cliente, os atendimentos antigos dele ficariam "sem dono" e o histórico se perderia.

### 4.4 Script SQL sugerido para criar tudo

```sql
CREATE DATABASE IF NOT EXISTS RAtendimento CHARACTER SET utf8;
USE RAtendimento;

CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    cpf        VARCHAR(14)  NOT NULL,
    telefone   VARCHAR(20),
    ativo      CHAR(1) NOT NULL DEFAULT 'S'
);

CREATE TABLE atendente (
    id_atendente INT AUTO_INCREMENT PRIMARY KEY,
    login        VARCHAR(50)  NOT NULL UNIQUE,
    senha        VARCHAR(255) NOT NULL,
    nome         VARCHAR(100) NOT NULL,
    cpf          VARCHAR(14)  NOT NULL,
    tipo_acesso  CHAR(1) NOT NULL DEFAULT 'U',   -- U = Usuário, A = Admin
    ativo        CHAR(1) NOT NULL DEFAULT 'S'
);

CREATE TABLE tipo_atendimento (
    id_tipo_atendimento INT AUTO_INCREMENT PRIMARY KEY,
    tipo_atendimento    VARCHAR(100) NOT NULL,
    ativo               CHAR(1) NOT NULL DEFAULT 'S'
);

CREATE TABLE atendimento (
    id_atendimento      INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_atendimento INT NOT NULL,
    id_atendente        INT NOT NULL,
    id_cliente          INT NOT NULL,
    dt_inicio           DATETIME NOT NULL,
    dt_fim              DATETIME NULL,
    descricao           TEXT,
    ativo               CHAR(1) NOT NULL DEFAULT 'S',
    FOREIGN KEY (id_tipo_atendimento) REFERENCES tipo_atendimento(id_tipo_atendimento),
    FOREIGN KEY (id_atendente)        REFERENCES atendente(id_atendente),
    FOREIGN KEY (id_cliente)          REFERENCES cliente(id_cliente)
);

-- Primeiro usuário para conseguir entrar no sistema:
INSERT INTO atendente (login, senha, nome, cpf, tipo_acesso, ativo)
VALUES ('admin', '123', 'Administrador', '000.000.000-00', 'A', 'S');
```

> ⚠️ Sem esse `INSERT` você não consegue fazer login, pois não existe nenhum usuário ainda.

---

## 5. Estrutura de pastas

```
RAtendimento2/
│
├── 📁 login/                 ← Entrar e sair do sistema
│   ├── index.php             (tela de login)
│   ├── autenticar.php        (confere usuário e senha)
│   └── logout.php            (sai do sistema)
│
├── 📁 index/                 ← Páginas iniciais
│   ├── index.php             (boas-vindas)
│   └── dashboard.php         (painel com totais)
│
├── 📁 cliente/               ← CRUD de clientes
├── 📁 atendente/             ← CRUD de atendentes
├── 📁 tipoAtendimento/       ← CRUD de tipos de atendimento
├── 📁 atendimento/           ← CRUD de atendimentos (+ concluir)
│
├── 📁 includes/              ← Peças reaproveitadas
│   ├── conexao.php           (liga com o banco)
│   ├── validarLogin.php      (barra quem não logou)
│   ├── header.php            (topo do HTML)
│   ├── menu.php              (barra de navegação)
│   └── footer.php            (rodapé do HTML)
│
├── 📁 css/
│   └── estilo.css            ← Nossas cores e estilos
│
└── .gitignore                ← O que o Git deve ignorar
```

### 💡 A organização segue um padrão

Cada módulo (`cliente`, `atendente`, `tipoAtendimento`, `atendimento`) tem **os mesmos arquivos**:

| Arquivo | Função |
|---|---|
| `listar.php` | Mostra a **tabela** com todos os registros |
| `form.php` | Mostra o **formulário** (novo ou editar) |
| `salvar.php` | **Recebe** o formulário e grava no banco |
| `toggleAtivo.php` | **Ativa/desativa** um registro |

Aprendeu um módulo, entendeu todos. 🎉

---

## 6. A pasta `includes/`: peças reaproveitadas

Imagine montar uma página como montar um lanche: o **pão de cima e o de baixo** são sempre iguais; só o **recheio** muda. Em vez de copiar o pão em todo arquivo, guardamos em `includes/` e **chamamos** quando precisar.

Isso é feito com o comando `require`:

```php
require '../includes/header.php';
```

> Significa: *"pegue o conteúdo desse arquivo e cole aqui"*. O `../` quer dizer "suba uma pasta".

### 6.1 `conexao.php`: a ligação com o banco

```php
$host = "mariadb";
$banco = "RAtendimento";
$usuario = "root";
$senha = "mypass";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
```

| Trecho | O que faz |
|---|---|
| `$host`, `$banco`... | Guardam os dados de acesso (onde está o banco, nome, usuário, senha) |
| `new PDO(...)` | Cria a conexão e guarda em `$pdo` |
| `setAttribute(... EXCEPTION)` | Se der erro no SQL, o PHP **avisa** em vez de ficar calado |
| `try { } catch { }` | "**Tente** conectar; se der erro, **capture** e mostre a mensagem" |

> Toda página que usa o banco faz `require '../includes/conexao.php';` e passa a ter a variável `$pdo` disponível.

> 📝 `host = "mariadb"` é o nome do **container Docker** do banco. Se você rodar sem Docker, troque por `localhost`.

### 6.2 `validarLogin.php`: o "segurança da porta"

```php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login/index.php');
    exit;
}
```

Em português: *"Se **não existe** usuário logado, **mande** para a tela de login e **pare**."*

Todas as páginas internas começam com esse `require`. Por isso, se você tentar abrir `cliente/listar.php` sem logar, é jogado de volta ao login.

### 6.3 `header.php`, `menu.php`, `footer.php`: o "pão do lanche"

- **`header.php`**: abre o HTML (`<html>`, `<head>`, `<body>`) e carrega Bootstrap e nosso CSS.
- **`menu.php`**: a barra azul de navegação, com o nome do usuário logado: `$_SESSION['usuario']['nome']`.
- **`footer.php`**: rodapé, carrega o JavaScript do Bootstrap e **fecha** `</body></html>`.

Uma página típica fica assim:

```php
<?php
require '../includes/validarLogin.php';   // 1. Está logado?
require '../includes/conexao.php';        // 2. Conecta no banco

// ... busca dados no banco ...

require '../includes/header.php';         // 3. Abre o HTML
require '../includes/menu.php';           // 4. Menu azul
?>

<!-- 5. Aqui vai o conteúdo específico da página -->

<?php require '../includes/footer.php'; ?>   <!-- 6. Fecha o HTML -->
```

> 📌 **Regra de ouro:** a lógica PHP (buscar dados, redirecionar) vem **antes** do HTML. Por quê? Porque o `header()` de redirecionamento só funciona **antes** de qualquer HTML ser enviado ao navegador.

---

## 7. Login e Sessão: como o sistema sabe quem é você

### 7.1 O problema

O HTTP "esquece" tudo entre um pedido e outro. Cada clique é como falar com alguém que **perdeu a memória**. Então, como o sistema lembra que você já fez login?

### 7.2 A solução: **Sessão** (`$_SESSION`)

A sessão é uma "**pulseira de festa**": você prova quem é **uma vez** na entrada e recebe a pulseira. Depois é só mostrá-la.

```
1. Você envia login + senha
2. O servidor confere no banco
3. Se estiver certo → guarda seus dados em $_SESSION (a pulseira)
4. Nas próximas páginas → validarLogin.php confere se a pulseira existe
5. Ao clicar em Sair → session_destroy() rasga a pulseira
```

### 7.3 O fluxo completo

```
login/index.php          login/autenticar.php            index/dashboard.php
┌──────────────┐  POST   ┌─────────────────────┐ certo  ┌───────────────┐
│ Formulário   │ ──────▶ │ Procura no banco    │ ─────▶ │ Painel        │
│ usuário/senha│         │ login + senha       │        └───────────────┘
└──────────────┘         │                     │ errado ┌───────────────┐
        ▲                │                     │ ─────▶ │ volta p/ login│
        │                └─────────────────────┘        │ com ?erro=1   │
        └───────────────────────────────────────────────┴───────────────┘
```

### 7.4 `autenticar.php` explicado

```php
session_start();                         // liga o sistema de sessões
require '../includes/conexao.php';

$login = $_POST['login'] ?? '';          // pega o que veio do formulário
$senha = $_POST['senha'] ?? '';
```

> `??` significa *"se não existir, use esse valor padrão"*. Evita erro quando o campo não foi enviado.

```php
$stmt = $pdo->prepare("
    SELECT * FROM atendente
    WHERE login = :login AND senha = :senha AND ativo = 'S'
");
$stmt->bindValue(':login', $login);
$stmt->bindValue(':senha', $senha);
$stmt->execute();

$usuario = $stmt->fetch();   // devolve a linha encontrada, ou false se não achou
```

Se achou, guarda na sessão e vai para o painel:

```php
if ($usuario) {
    $_SESSION['usuario'] = [
        'id' => $usuario['id_atendente'],
        'nome' => $usuario['nome'],
        'tipo_acesso' => $usuario['tipo_acesso']
    ];
    header('Location: ../index/dashboard.php');
    exit;
}

header('Location: index.php?erro=1');   // não achou: volta pro login
exit;
```

### 7.5 Um detalhe: o `AND ativo = 'S'`

Atendente **desativado não consegue entrar**. É por isso que desativar (e não apagar) é útil.

### 7.6 `logout.php`

```php
session_start();
session_destroy();           // destrói a sessão (rasga a pulseira)
header('Location: index.php');
exit;
```

---

## 8. O padrão CRUD: o coração do sistema

**CRUD** são as 4 operações básicas de quase todo sistema:

| Letra | Operação | Em português | Comando SQL | Neste projeto |
|---|---|---|---|---|
| **C** | Create | Criar | `INSERT` | `salvar.php` (sem id) |
| **R** | Read | Ler | `SELECT` | `listar.php` e `form.php` |
| **U** | Update | Atualizar | `UPDATE` | `salvar.php` (com id) |
| **D** | Delete | Apagar | `DELETE` | *(não usamos: fazemos desativação via `toggleAtivo.php`)* |

### O ciclo de vida de um cadastro

```
   ┌───────────┐  clica em       ┌───────────┐  envia       ┌────────────┐
   │ listar.php│ ─"Novo/Editar"─▶│  form.php │ ─formulário─▶│ salvar.php │
   │  (tabela) │                 │(formulário)│    POST     │ (grava BD) │
   └───────────┘                 └───────────┘              └─────┬──────┘
         ▲                                                        │
         └────────────── redireciona de volta ────────────────────┘
```

---

## 9. Estudo de caso: o módulo Cliente, arquivo por arquivo

### 9.1 `cliente/listar.php`: mostrando os dados

**Parte 1: buscar no banco (PHP, no topo)**

```php
$sql = "
    SELECT id_cliente, nome, cpf, telefone, ativo
    FROM cliente
    ORDER BY nome
";

$clientes = $pdo->query($sql)->fetchAll();
```

| Trecho | Significado |
|---|---|
| `SELECT ... FROM cliente` | "Traga essas colunas da tabela cliente" |
| `ORDER BY nome` | Em ordem alfabética |
| `$pdo->query($sql)` | Executa a consulta |
| `->fetchAll()` | Traz **todas** as linhas como uma lista (array) |

`$clientes` agora é uma lista assim:

```php
[
  ['id_cliente' => 1, 'nome' => 'Ana',  'cpf' => '111...', 'ativo' => 'S'],
  ['id_cliente' => 2, 'nome' => 'Beto', 'cpf' => '222...', 'ativo' => 'N'],
]
```

**Parte 2: mostrar na tela (HTML misturado com PHP)**

```php
<?php foreach($clientes as $cliente): ?>
    <tr>
        <td><?= $cliente['id_cliente'] ?></td>
        <td><?= $cliente['nome'] ?></td>
        ...
    </tr>
<?php endforeach; ?>
```

| Sintaxe | O que é |
|---|---|
| `foreach ($lista as $item)` | "**Para cada** item da lista, repita o bloco" (gera uma linha `<tr>` por cliente) |
| `<?= $variavel ?>` | Atalho para **imprimir** um valor na página |
| `$cliente['nome']` | Pega o campo `nome` daquele cliente |

**Parte 3: o "se/senão" dentro do HTML**

```php
<?php if($cliente['ativo'] == 'S'): ?>
    <span class="badge badge-ativo">Ativo</span>
<?php else: ?>
    <span class="badge badge-inativo">Inativo</span>
<?php endif; ?>
```

Mostra um selo **verde** (Ativo) ou **vermelho** (Inativo) conforme o valor do campo.

**Parte 4: os links de ação**

```html
<a href="form.php?id=<?= $cliente['id_cliente'] ?>">Editar</a>
<a href="toggleAtivo.php?id=<?= $cliente['id_cliente'] ?>">Desativar</a>
```

Para o cliente de id 3, o PHP gera: `form.php?id=3` e `toggleAtivo.php?id=3`.

---

### 9.2 `cliente/form.php`: o formulário (serve para criar **e** editar)

O mesmo arquivo faz dois trabalhos. Quem decide é o `id` na URL:

| Como chegou aqui | URL | Resultado |
|---|---|---|
| Botão "Novo Cliente" | `form.php` | Formulário **vazio** |
| Botão "Editar" | `form.php?id=3` | Formulário **preenchido** com o cliente 3 |

```php
$id = $_GET['id'] ?? null;      // lê o id da URL (ou null se não tiver)

$cliente = [                    // valores "vazios" para o caso de cadastro novo
    'id_cliente' => '',
    'nome' => '',
    'cpf' => '',
    'telefone' => ''
];

if ($id) {                      // se veio id → é edição: busca no banco
    $stmt = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $cliente = $stmt->fetch();  // substitui os "vazios" pelos dados reais
}
```

No HTML, o campo já vem preenchido (ou vazio) graças ao `value`:

```html
<input type="text" name="nome" value="<?= $cliente['nome'] ?>" required>
```

E o título também muda sozinho:

```php
<?= $id ? 'Editar Cliente' : 'Novo Cliente' ?>
```

> `condição ? A : B` é o **operador ternário**: *"se a condição for verdadeira, use A; senão, use B"*.

**O campo escondido (`hidden`):**

```html
<input type="hidden" name="id" value="<?= $cliente['id_cliente'] ?>">
```

Não aparece na tela, mas é **enviado junto** com o formulário. Assim o `salvar.php` sabe se é cadastro novo (id vazio) ou edição (id preenchido).

**O formulário em si:**

```html
<form action="salvar.php" method="POST">
```

- `action="salvar.php"`: *para onde* os dados vão.
- `method="POST"`: *como* vão (escondidos).
- O atributo **`name`** de cada `<input>` vira a chave em `$_POST['nome']`.
- `required` faz o navegador **impedir** o envio se o campo estiver vazio.

---

### 9.3 `cliente/salvar.php`: gravando no banco

É a página que **não tem tela**. Ela trabalha e redireciona.

```php
$id = $_POST['id'];

if(empty($id)){
    // ID vazio → é cadastro novo → INSERT
    $sql = "INSERT INTO cliente (nome, cpf, telefone, ativo)
            VALUES (:nome, :cpf, :telefone, 'S')";
} else {
    // ID preenchido → é edição → UPDATE
    $sql = "UPDATE cliente
            SET nome = :nome, cpf = :cpf, telefone = :telefone
            WHERE id_cliente = :id";
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':nome', $_POST['nome']);
$stmt->bindValue(':cpf', $_POST['cpf']);
$stmt->bindValue(':telefone', $_POST['telefone']);

if(!empty($id)){
    $stmt->bindValue(':id', $id);
}

$stmt->execute();

header('Location: listar.php');   // volta para a lista
exit;
```

> 🧠 Repare que um novo cliente já nasce com `ativo = 'S'`, fixado no próprio SQL.

> ⚠️ **Cuidado:** o `UPDATE` sempre precisa do `WHERE`. Sem ele, **todos** os registros da tabela seriam alterados!

#### 🔒 O que são os `:nome`, `:cpf` e o `bindValue`? (Prepared Statements)

Esta é **a técnica de segurança mais importante** do projeto.

**Jeito PERIGOSO** (que **não** usamos):

```php
$sql = "SELECT * FROM cliente WHERE nome = '" . $_POST['nome'] . "'";
```

Se alguém digitar no campo: `' OR '1'='1`, o SQL vira uma consulta que devolve **tudo**. Isso é o ataque **SQL Injection**.

**Jeito SEGURO** (que usamos):

```php
$stmt = $pdo->prepare("SELECT * FROM cliente WHERE nome = :nome");
$stmt->bindValue(':nome', $_POST['nome']);
```

Aqui o SQL e os dados viajam **separados**. O banco trata o que o usuário digitou **sempre como simples texto**, nunca como comando.

> 🧠 Analogia: é como entregar uma **carta lacrada** (o SQL) e, num envelope à parte, os **dados**. Ninguém consegue "colar um comando" dentro da carta.

---

### 9.4 `cliente/toggleAtivo.php`: o interruptor Ativo/Inativo

```php
$id = $_GET['id'];                       // 1. qual cliente?

// 2. busca o status atual
$stmt = $pdo->prepare("SELECT ativo FROM cliente WHERE id_cliente = :id");
$stmt->bindValue(':id', $id);
$stmt->execute();
$cliente = $stmt->fetch();

// 3. inverte: se era 'S' vira 'N'; se era 'N' vira 'S'
$novoStatus = $cliente['ativo'] == 'S' ? 'N' : 'S';

// 4. grava o novo status
$stmt = $pdo->prepare("UPDATE cliente SET ativo = :ativo WHERE id_cliente = :id");
$stmt->bindValue(':ativo', $novoStatus);
$stmt->bindValue(':id', $id);
$stmt->execute();

header('Location: listar.php');          // 5. volta para a lista
exit;
```

Funciona como um **interruptor de luz**: cada clique inverte o estado.

---

### 9.5 Os outros módulos

`atendente/`, `tipoAtendimento/` e `atendimento/` seguem **exatamente a mesma lógica**. As diferenças são só os campos:

| Módulo | Campos no formulário |
|---|---|
| **cliente** | nome, cpf, telefone |
| **tipoAtendimento** | tipo_atendimento (só 1 campo!). É o mais simples, ótimo para começar |
| **atendente** | nome, login, senha, cpf, perfil (Usuário/Admin) |
| **atendimento** | tipo, cliente, atendente, data início, data fim, descrição |

---

## 10. O módulo Atendimento (o mais completo)

É o módulo "principal" do sistema e tem alguns recursos extras.

### 10.1 JOIN: juntando tabelas (`atendimento/listar.php`)

O `atendimento` guarda só **números** (`id_cliente = 7`). Mas na tela queremos o **nome**! Para isso, usamos o **JOIN**:

```sql
SELECT
    a.id_atendimento,
    ta.tipo_atendimento,
    atd.nome AS atendente,
    c.nome   AS cliente,
    a.dt_inicio,
    a.dt_fim,
    a.descricao,
    a.ativo
FROM atendimento a
INNER JOIN tipo_atendimento ta ON ta.id_tipo_atendimento = a.id_tipo_atendimento
INNER JOIN atendente atd       ON atd.id_atendente       = a.id_atendente
INNER JOIN cliente c           ON c.id_cliente           = a.id_cliente
ORDER BY a.dt_inicio DESC
```

| Trecho | Explicação |
|---|---|
| `FROM atendimento a` | `a` é um **apelido** (alias) para não escrever o nome inteiro toda vez |
| `INNER JOIN cliente c ON c.id_cliente = a.id_cliente` | "Junte com a tabela cliente, **ligando** pelo id_cliente" |
| `atd.nome AS atendente` | Renomeia a coluna na saída (assim `nome` do cliente e do atendente não se confundem) |
| `ORDER BY a.dt_inicio DESC` | Mais **recentes primeiro** (DESC = decrescente) |

**Visualizando o JOIN:**

```
atendimento                 cliente
┌────┬────────────┐        ┌────────────┬───────┐
│ id │ id_cliente │        │ id_cliente │ nome  │
├────┼────────────┤        ├────────────┼───────┤
│ 10 │     7      │ ─────▶ │     7      │ Maria │
└────┴────────────┘        └────────────┴───────┘
                  resultado: Atendimento 10 → Maria
```

### 10.2 Os 3 estados de um atendimento

Não existe uma coluna "status". O estado é **deduzido** de duas colunas (`ativo` e `dt_fim`):

```php
<?php if ($atendimento['ativo'] == 'N'): ?>
    Cancelado
<?php elseif (empty($atendimento['dt_fim'])): ?>
    Em Aberto
<?php else: ?>
    Concluído
<?php endif; ?>
```

| `ativo` | `dt_fim` | Situação mostrada |
|---|---|---|
| `N` | qualquer | 🔴 **Cancelado** |
| `S` | vazio (NULL) | 🟡 **Em Aberto** |
| `S` | preenchido | 🟢 **Concluído** |

### 10.3 Botão "Concluir" (`concluir.php`)

```php
UPDATE atendimento
   SET dt_fim = NOW()
 WHERE id_atendimento = :id
```

`NOW()` é uma função do SQL que devolve **a data e hora de agora**. Basta preencher `dt_fim` para o atendimento passar a ser "Concluído".

O botão só aparece quando faz sentido:

```php
<?php if ($atendimento['ativo'] == 'S' && empty($atendimento['dt_fim'])): ?>
    <a href="concluir.php?id=...">Concluir</a>
<?php endif; ?>
```

`&&` quer dizer **E**: só mostra se estiver ativo **E** ainda sem data de fim.

### 10.4 Listas suspensas (`<select>`) alimentadas pelo banco (`atendimento/form.php`)

Veja como o formulário monta as opções de **Cliente**:

```php
// No topo, busca só os clientes ativos
$clientes = $pdo->query("
    SELECT * FROM cliente WHERE ativo = 'S' ORDER BY nome
")->fetchAll();
```

```php
<select name="id_cliente" required>
    <option value="">Selecione</option>

    <?php foreach ($clientes as $cliente): ?>
        <option
            value="<?= $cliente['id_cliente'] ?>"
            <?= $cliente['id_cliente'] == $atendimento['id_cliente'] ? 'selected' : '' ?>
        >
            <?= $cliente['nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
```

| Detalhe | Explicação |
|---|---|
| `value="<?= $cliente['id_cliente'] ?>"` | O que é **enviado** ao servidor (o número) |
| `<?= $cliente['nome'] ?>` | O que o **usuário vê** (o nome) |
| `selected` | Na **edição**, já deixa marcada a opção que estava salva |
| `WHERE ativo = 'S'` | Clientes desativados **não aparecem** para novos atendimentos |

### 10.5 Campo de data e hora

```html
<input type="datetime-local" name="dt_inicio" ...>
```

Mostra o seletor de data e hora do navegador. Para preencher na edição, convertemos o formato do banco:

```php
date('Y-m-d\TH:i', strtotime($atendimento['dt_inicio']))
```

E para **exibir** ao usuário no formato brasileiro:

```php
date('d/m/Y H:i', strtotime($atendimento['dt_inicio']))   // 20/10/2026 14:30
```

### 10.6 Detalhes que expandem (Bootstrap *collapse*)

Cada linha tem uma setinha ⌄ que **abre/fecha** os detalhes (atendente, datas, descrição), sem JavaScript escrito por nós:

```html
<button data-bs-toggle="collapse" data-bs-target="#detalhes5">⌄</button>
...
<div class="collapse" id="detalhes5"> ...detalhes... </div>
```

O botão aponta (`data-bs-target`) para o `id` da `<div>` escondida. Como o `id` precisa ser **único**, usamos o id do atendimento: `detalhes5`, `detalhes6`...

### 10.7 `htmlspecialchars` e `nl2br` na descrição

```php
<?= nl2br(htmlspecialchars($atendimento['descricao'])) ?>
```

- `htmlspecialchars()` → **protege** contra código malicioso digitado no texto (veja a seção 14).
- `nl2br()` → transforma "Enter" em quebra de linha (`<br>`), para o texto aparecer em parágrafos.

### 10.8 Data fim vazia → `NULL`

No `salvar.php`:

```php
$stmt->bindValue(':dt_fim', empty($_POST['dt_fim']) ? null : $_POST['dt_fim']);
```

Se o usuário deixou a data de fim em branco, gravamos **`NULL`** (ausência de valor) em vez de texto vazio. O banco rejeitaria `''` num campo de data.

---

## 11. Dashboard

`index/dashboard.php` conta quantos registros existem em cada tabela:

```php
$totalClientes = $pdo
    ->query("SELECT COUNT(*) FROM cliente")
    ->fetchColumn();
```

| Trecho | Significado |
|---|---|
| `COUNT(*)` | Função SQL que **conta linhas** |
| `fetchColumn()` | Traz **um único valor** (ideal para contagens) |

Depois, cada número aparece dentro de um **card** do Bootstrap:

```php
<h2><?= $totalClientes ?></h2>
```

O layout em 4 colunas vem do Bootstrap: `col-md-3` (3 de 12 colunas = 4 cards lado a lado).

---

## 12. O visual: Bootstrap e CSS

### 12.1 Bootstrap: CSS pronto via CDN

No `header.php`:

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
```

**CDN** = o arquivo é carregado da internet (não precisa baixar nada). Por isso o projeto **precisa de internet** para ficar bonito.

### 12.2 Classes do Bootstrap que aparecem em todo lugar

| Classe | O que faz |
|---|---|
| `container` | Centraliza e limita a largura do conteúdo |
| `row` + `col-md-6` | Grade: divide a linha em colunas (total 12) |
| `card`, `card-body` | Caixinha com borda e sombra |
| `table table-striped table-hover` | Tabela zebrada que destaca a linha ao passar o mouse |
| `btn btn-sm` | Botão (e botão pequeno) |
| `form-control`, `form-label`, `form-select` | Campos e rótulos de formulário estilizados |
| `badge` | Selinho colorido (Ativo/Inativo) |
| `mb-3`, `mt-4`, `ms-auto` | **Margens** (m = margin; b = bottom; t = top; s = start) |
| `d-flex`, `gap-2` | Organiza itens lado a lado com espaçamento |
| `text-center` | Centraliza o texto |
| `shadow-sm` | Sombra leve |

### 12.3 O nosso `css/estilo.css`

Aqui definimos a **identidade visual** (azul e amarelo da escola) sobrescrevendo o Bootstrap.

**Variáveis CSS**, definidas uma vez e usadas em vários lugares:

```css
:root {
    --eeepe-azul: #0D47A1;
    --eeepe-amarelo: #FFC107;
}

.navbar-eeepe {
    background-color: var(--eeepe-azul);
}
```

> 💡 Quer mudar a cor do sistema inteiro? Troque **uma linha** no `:root`.

**Classes personalizadas** criadas para o projeto:

| Classe | Uso |
|---|---|
| `.btn-eeepe` | Botão principal azul |
| `.btn-eeepe-warning` | Botão "Editar" amarelo |
| `.badge-ativo` / `.badge-inativo` | Selos verde/vermelho |
| `.badge-aberto` / `.badge-concluido` | Selos de situação do atendimento |
| `.badge-admin` / `.badge-usuario` | Selos de perfil |
| `.dashboard-card` | Efeito nos cards do painel |
| `.login-container`, `.login-card` | Tela de login |

### 12.4 Ícones

```html
<i class="bi bi-pencil-square"></i>
```

Vêm do **Bootstrap Icons**. Para achar outros: <https://icons.getbootstrap.com>

### 12.5 JavaScript

O projeto **não tem JavaScript próprio**. Só carrega o do Bootstrap (no `footer.php`) para fazer funcionar o menu suspenso (*dropdown*) e os detalhes expansíveis (*collapse*).

---

## 13. Como rodar o projeto

### 13.1 O que você precisa

1. Um servidor web com **PHP** (Apache/Nginx)
2. Um banco **MariaDB/MySQL**
3. O banco `RAtendimento` criado (use o script da [seção 4.4](#44-script-sql-sugerido-para-criar-tudo))

### 13.2 Opção A: com Docker (como o projeto foi feito)

O `conexao.php` aponta para `host = "mariadb"`, que é o **nome de um serviço Docker**. Um `docker-compose.yml` típico seria:

```yaml
services:
  web:
    image: php:8-apache
    ports:
      - "8080:80"
    volumes:
      - ./RAtendimento2:/var/www/html
    depends_on:
      - mariadb
    # Atenção: a imagem php:apache precisa da extensão pdo_mysql
    # (instale com: docker-php-ext-install pdo_mysql)

  mariadb:
    image: mariadb:11
    environment:
      MARIADB_ROOT_PASSWORD: mypass
      MARIADB_DATABASE: RAtendimento
```

Depois, acesse: `http://localhost:8080/login/index.php`

### 13.3 Opção B: XAMPP / WAMP / Laragon

1. Copie a pasta `RAtendimento2` para `htdocs` (XAMPP).
2. Crie o banco pelo phpMyAdmin e rode o script SQL.
3. Em `includes/conexao.php`, troque:
   ```php
   $host = "localhost";
   $usuario = "root";
   $senha = "";          // no XAMPP a senha costuma ser vazia
   ```
4. Acesse `http://localhost/RAtendimento2/login/index.php`

### 13.4 Primeiro acesso

Entre com o usuário que você inseriu no script (ex.: `admin` / `123`).

---

## 14. ⚠️ Pontos de atenção (o que melhorar)

> Este é um projeto **de aprendizado**, e está muito bom para isso! Mas um bom desenvolvedor sabe reconhecer o que **não** faria em produção. Veja os pontos abaixo como **oportunidades de melhoria**.

### 🔴 Segurança

#### 1. Senhas guardadas em texto puro
```php
WHERE login = :login AND senha = :senha     // compara senha direto
```
Se alguém ler o banco, vê todas as senhas. O correto é guardar um **hash**:

```php
// Ao salvar:
$hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Ao fazer login: busca só pelo login e confere assim:
if ($usuario && password_verify($senha, $usuario['senha'])) { ... }
```

#### 2. Senha aparece preenchida no formulário de edição
Em `atendente/form.php` o campo recebe `value="<?= $atendente['senha'] ?>"`. A senha viaja de volta para o navegador. O ideal é deixar o campo **vazio** e só trocar a senha se o usuário digitar uma nova.

#### 3. XSS: falta `htmlspecialchars` na maioria das telas
Só o campo *descrição* é protegido. Os demais fazem `<?= $cliente['nome'] ?>` direto. Se alguém cadastrar um nome como `<script>alert('hackeado')</script>`, esse script **executa** no navegador de quem abrir a lista.

```php
<?= htmlspecialchars($cliente['nome']) ?>    // ✅ jeito correto
```

#### 4. Ações perigosas via link (GET)
`toggleAtivo.php?id=3` altera dados só de ser acessado. Navegadores e extensões às vezes "pré-carregam" links, e outra pessoa pode te enganar com um link. Ações que **alteram dados** deveriam usar **POST**.

#### 5. Perfil de acesso não é verificado
O sistema guarda `tipo_acesso` (Usuário/Admin) na sessão, mas **nenhuma página o usa**. Um "Usuário" comum consegue cadastrar atendentes e mexer em tudo.

#### 6. Credenciais do banco dentro do código
`root` / `mypass` estão escritas no `conexao.php`. Em produção, usa-se **variáveis de ambiente** (o `.gitignore` já ignora `.env`, preparado para isso!) e um usuário do banco com **permissões limitadas**, nunca o `root`.

### 🟡 Bugs e inconsistências

#### 7. Perfil do atendente não vem selecionado na edição
Em `atendente/form.php`, os valores das opções são `U` e `A`, mas a comparação é feita com `'USUARIO'` e `'ADMIN'`:

```php
<option value="A" <?= $atendente['tipo_acesso'] == 'ADMIN' ? 'selected' : '' ?>>
```

Como o banco guarda `'A'`, nunca será igual a `'ADMIN'`. O select sempre abre em "Usuário". **Correção:** comparar com `'A'` e `'U'`.

#### 8. Arquivo `atendente/atendente.php` é código antigo
Ele usa `require '../header.php'` (caminho que não existe) e links para arquivos inexistentes (`editarAtendente.php`). Foi substituído por `listar.php` e pode ser **apagado**.

#### 9. `atendimento/reabrir.php` existe, mas nenhum botão o chama
O arquivo funciona (volta `dt_fim` para `NULL`), mas não há link para ele na tela. Faltou criar o botão "Reabrir".

#### 10. `require` duplicado no `dashboard.php`
`require '../includes/conexao.php';` aparece **duas vezes** seguidas. Funciona, mas é desnecessário.

#### 11. `index/index.php` é pouco usado
O login manda direto para `dashboard.php`. A página de boas-vindas só é acessada pelo link da marca no menu.

### 🟢 Boas práticas que faltam

- **Validar no servidor:** o `required` do HTML pode ser burlado. Valide também em PHP (ex.: CPF válido, campos vazios).
- **Tratar ID inexistente:** se alguém acessar `form.php?id=9999`, o `fetch()` devolve `false` e o PHP gera erro.
- **Evitar duplicados:** nada impede dois clientes com o mesmo CPF.
- **Mensagens ao usuário:** o login devolve `?erro=1`, mas a tela **não mostra** nenhuma mensagem de erro.
- **Máscara de CPF/telefone** com JavaScript.
- **Tabelas sem `<thead>`/`<tbody>`:** a listagem de clientes não usa; as demais usam.
- **Paginação e busca:** com milhares de registros, a lista ficará enorme.

---

## 15. Exercícios para praticar

### 🟢 Nível 1: Iniciante

1. Mude a cor azul do sistema para verde alterando **apenas** o `:root` do CSS.
2. Troque o texto do rodapé em `footer.php`.
3. Altere o título da aba do navegador em `header.php`.
4. Faça a tela de login **mostrar uma mensagem de erro** quando a URL tiver `?erro=1` (dica: `if (isset($_GET['erro']))`).

### 🟡 Nível 2: Intermediário

5. Adicione o campo **e-mail** ao cliente (banco → `form.php` → `salvar.php` → `listar.php`).
6. Corrija o **bug do perfil** descrito no item 7 da seção 14.
7. Crie o botão **"Reabrir"** para atendimentos concluídos, usando o `reabrir.php`.
8. Aplique `htmlspecialchars()` em todas as listagens.
9. Adicione ao dashboard um card com o total de atendimentos **em aberto** (dica: `WHERE dt_fim IS NULL AND ativo = 'S'`).

### 🔴 Nível 3: Desafio

10. Troque as senhas para **hash** com `password_hash` / `password_verify`.
11. Faça só **administradores** acessarem o cadastro de atendentes (use `$_SESSION['usuario']['tipo_acesso']`).
12. Adicione um **campo de busca por nome** na lista de clientes (dica: `WHERE nome LIKE :busca`).
13. Impeça cadastrar dois clientes com o **mesmo CPF**.
14. Transforme `toggleAtivo.php` para funcionar via **POST**.

---

## 16. Glossário

| Termo | Significado simples |
|---|---|
| **Aplicação WEB** | Programa que roda em um servidor e é acessado pelo navegador |
| **Servidor** | Computador que recebe pedidos e devolve páginas |
| **Cliente (no sentido técnico)** | O navegador. *(No projeto, "Cliente" também é a pessoa atendida. Cuidado com a confusão!)* |
| **Request / Response** | Pedido do navegador / resposta do servidor |
| **HTML** | Linguagem que define a **estrutura** da página |
| **CSS** | Linguagem que define a **aparência** |
| **PHP** | Linguagem que roda no **servidor** e gera o HTML |
| **Framework** | Conjunto de ferramentas prontas que organiza o projeto |
| **Bootstrap** | Biblioteca de CSS pronta |
| **CDN** | Servidor na internet que hospeda arquivos como Bootstrap |
| **SQL** | Linguagem para conversar com o banco de dados |
| **PDO** | Ferramenta do PHP para conectar e consultar bancos |
| **Prepared Statement** | Consulta SQL com "buracos" (`:nome`) preenchidos com segurança |
| **SQL Injection** | Ataque que injeta comandos SQL por meio de campos de formulário |
| **XSS** | Ataque que injeta JavaScript malicioso em uma página |
| **CRUD** | Create, Read, Update, Delete (criar, ler, atualizar, apagar) |
| **PK / FK** | Chave primária / chave estrangeira |
| **JOIN** | Junção de tabelas em uma consulta |
| **NULL** | Ausência de valor (diferente de texto vazio ou zero) |
| **Sessão** | Memória temporária do servidor sobre o usuário logado |
| **GET / POST** | Formas de enviar dados: pela URL / pelo corpo do pedido |
| **Redirecionamento** | Mandar o navegador para outra página (`header('Location: ...')`) |
| **Hash** | "Embaralhamento" irreversível de uma senha |
| **Soft delete** | Marcar como inativo em vez de apagar de verdade |
| **Container (Docker)** | "Caixa" isolada que roda um serviço (PHP, banco...) |
| **Git / GitHub** | Controle de versão / site que hospeda repositórios |

---

## 🧭 Roteiro de estudo sugerido

1. Leia as seções **2 e 3** (conceitos).
2. Monte o ambiente e **rode o projeto** (seção 13).
3. Abra `login/` e `includes/` e acompanhe a [seção 6](#6-a-pasta-includes-peças-reaproveitadas) e a [seção 7](#7-login-e-sessão-como-o-sistema-sabe-quem-é-você).
4. Estude `tipoAtendimento/`, que é o CRUD mais simples.
5. Compare com `cliente/` e `atendente/`.
6. Chegue ao `atendimento/` (JOIN, selects, estados).
7. Faça os **exercícios** e depois releia a [seção 14](#14-️-pontos-de-atenção-o-que-melhorar).

> 💬 **Dica final:** não decore código. Entenda o **fluxo** (listar → formulário → salvar → listar) e o resto vira variação do mesmo tema. Bons estudos! 🚀
