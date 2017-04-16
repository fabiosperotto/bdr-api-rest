## API Rest com PHP
Este projeto foi desenvolvido como solução do exercício 4 para a prova fornecida pela BDR Talentos. O objetivo foi resolver o sistema em menos de 24 horas. Os demais exercícios estão em [https://github.com/fabiosperotto/prova-analista-bdr](https://github.com/fabiosperotto/prova-analista-bdr)

### Requisitos
1. PHP versão 5.3.0
2. banco de dados MySQL.
3. Desenvolver com PHP puro ou com framework CakePHP

### Diferenciais
1. Criação de interface para visualização da lista de tarefas;
2. Interface com drag and drop;
3. Interface responsiva (desktop e mobile);

### O que foi desenvolvido
1. Implementado com PHP puro, sem frameworks, criado toda a infraestrutura necessária para a api Rest com autenticação por token
2. Criado painel simples responsivo, para manipulação das tarefas (com drag and drop para reposicionar a ordem das tarefas). Sem login de acesso.

### Componentes de Terceiros
- Apenas uma parte de um painel administrativo (gratuito e licensiado) foi utilizado de terceiros, para fornecer um ambiente rápido de front-end responsivo com bootstrap.

### Organização do projeto
- index.php e api.php: são os roteadores do acesso via painel e via API respectivamente.
- /app: contém as classes entidades do projeto.
- /database: repositório de classes de conexão com banco de dados utilizando design pattern Singleton
- /pages: arquivos HTML do projeto.
- /public: assets do projeto (js, css, imgs).


### Instalação
```bash
$ git clone https://github.com/fabiosperotto/bdr-api-rest.git
$ cd bdr-api-rest
$ composer install
$ cp .env.ini.example .env.ini
```
- Criar a base de dados e configurar no arquivo .env.ini as respectivas informações de acesso.


### Utilização pelo Painel
- Acesso ocorre pela URL [http://localhost/tasks-api/tarefas](http://localhost/tasks-api/tarefas)
- Pelo painel responsivo, são disponibilizadas a inserção, exclusão e ordenação das tarefas. Mensagens de sucesso/erro indicam resultado das operações.
- As ordenações das tarefas são salvas automaticamente, sem mensagem de retorno.


### Utilização pela API
A URL de acesso: [http://localhost/tasks-api/api/v1/tarefas/](http://localhost/tasks-api/api/v1/tarefas/). Para cada requisição, deve ser enviado um token (hash em sha1) pelo cabeçalho do HTTP no atributo "Authorization". Este token será confrontado com a base de dados para validar sua autorização. Um exemplo do formato pode ser visto abaixo para o verbo GET:
```bash
GET /tasks-api/api/v1/tarefas HTTP/1.1
Host: localhost
Authorization: 4ac4278b4580b6b8db50c8db9d774548140ff5e9
```

Os verbos REST disponíveis nesta aplicação são o GET, DELETE e POST, sendo que para o PUT, é utilizado a rota para POST com adição de um id que atualiza ao invés de criar um novo registro. Os testes foram realizados com [Postman](https://www.getpostman.com/)


#### Exemplos
- GET (todos os registros): http://localhost/tasks-api/api/v1/tarefas
- POST (informe via post titulo e descrição): http://localhost/tasks-api/api/v1/tarefas
- DELETE: http://localhost/tasks-api/api/v1/tarefas/50
- POST (substitui PUT, para update): http://localhost/tasks-api/api/v1/tarefas/50
- Exemplo de requisição via cURL pode ser verificado em /public/exemplo-requisicao.php

### Melhorias necessárias
- Refatorar a arquitetura de rotas e respostas da API.
- Disponibilizar seleção de um registro específico, via GET.
- Testes formais. Tanto testes unitários nos componentes quanto testes de usabilidade do painel via celular.

### Minha avaliação
Os restritos requisitos impactaram na qualidade do projeto. Fora complicado o desenvolvimento com PHP puro pois houve a necessidade de realizar pesado desenvolvimento de infraestrutura. Sendo que este tipo de trabalho já desenvolvo mais rapidamente em frameworks como Laravel, Silex, etc. Uma versão deste projeto com frameworks pode ser concebido, só não o fiz em CakePHP por não ter fluência.

