# Meu Mundo Express!

## Sobre o projeto

Sistema web para cadastro e consulta de informações geográficas e políticas: continentes, países, cidades e governantes. O acesso é protegido por autenticação de usuário, com bloqueio após tentativas erradas de senha, troca de senha obrigatória no primeiro acesso e registro de eventos de acesso.

## Funcionalidades

- Login de usuário com controle de acesso às telas do sistema
- Bloqueio do usuário após 3 senhas incorretas consecutivas
- Troca de senha obrigatória no primeiro acesso
- Alteração de senha (senha atual, nova senha e confirmação)
- Registro de eventos de acesso na tabela de logs
- Cadastro, listagem e exclusão de continentes, países, cidades e governantes
- Contagem de países por continente
- Navegação entre as telas por meio de menu
- Senhas armazenadas com hash e dados dos formulários tratados contra SQL Injection

## Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS
- Git
- GitHub

## Requisitos

- XAMPP (Apache, PHP e MySQL) ou ambiente equivalente
- Git

## Estrutura do projeto

```
CRUD_MUNDO/
├── banco.sql          Script de criação do banco de dados (banco.sql)
├── imgs/              Imagens do sistema
├── crud.php           Ações de cadastro, exclusão e autenticação
├── index.php          Telas do sistema (continentes, países, cidades, governantes e alterar senha)
├── login.php          Telas de login e troca de senha do primeiro acesso
└── style.css          Estilos das páginas
```

## Como executar

1. Clone o repositório:
   `git clone https://github.com/M0C-Dev/PW3-Samuel-Marques`
2. Copie a pasta `CRUD_MUNDO` para a pasta `htdocs` do XAMPP.
3. Inicie o Apache e o MySQL no painel do XAMPP.
4. No phpMyAdmin, importe o arquivo `database/banco.sql`.
6. Acesse `http://localhost/CRUD_MUNDO/login.php`.

### Primeiro acesso

O banco já cria o usuário `admin` com a senha `password`. No primeiro login o sistema exige a troca da senha.

Se o usuário for bloqueado após 3 senhas erradas, desbloqueie pelo MySQL:

```sql
UPDATE usuarios SET bloqueado = 0, tentativas_erro = 0 WHERE login = 'admin';
```

## Autor

Samuel Marques de Oliveira Cabral 3DS