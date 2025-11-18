🅿️ Simple PHP Parking Lot Reporting System

Este projeto é um sistema minimalista e funcional para gerenciar e reportar o faturamento de um estacionamento. Desenvolvido em PHP puro com SQLite, ele é projetado para ser executado via linha de comando (CLI) para tarefas administrativas e via navegador para visualização de relatórios.

🌟 Resumo do Projeto

O sistema armazena informações de veículos e seus registros de estacionamento no banco de dados SQLite. Ele possui scripts dedicados para gerenciar o ciclo de vida do banco (migração e seed) e dois pontos de entrada para geração de relatórios:

Um relatório formatado em HTML (index.php) para visualização rápida no navegador.

Um relatório em texto puro (report.php) para execução e consumo via terminal.

O cálculo da tarifa é feito por hora, com o tempo de permanência arredondado para cima (ceil), garantindo que qualquer fração de hora seja cobrada como uma hora completa.

🏗️ Estrutura e Arquivos

O projeto adota uma estrutura plana para os scripts e uma organização básica para as configurações e o banco de dados.

Arquivo/Pasta

Propósito

index.php

Relatório Web: Ponto de entrada via navegador. Conecta ao DB, calcula o faturamento com tarifas hardcoded e renderiza o resultado em uma tabela HTML.

migrate.php

Migração DB: Script CLI para criar as tabelas vehicles e parking_records no arquivo SQLite. Essencial para configurar o ambiente.

report.php

Relatório CLI: Script CLI para gerar o mesmo relatório de faturamento, mas com saída formatada para o terminal (texto puro).

seed.php

População de Dados (Seed): Script CLI para inserir dados de exemplo (veículos e registros de estacionamento) no banco de dados para testes.

composer.json

Configuração do Composer. Define a dependência mínima do PHP (>=8.0) e configura o autoload para uma futura pasta src/.

database/

Contém o arquivo do banco de dados database.sqlite.

vendor/

Contém o autoloader e dependências do Composer.

⚙️ Decisões Técnicas

Simplicidade Monolítica: A lógica de conexão com o banco de dados (PDO), o cálculo de negócios (tarifas e tempo) e a apresentação (HTML ou CLI echo) estão contidas em arquivos de script únicos. Essa abordagem favorece a rapidez no desenvolvimento e a fácil compreensão.

SQLite como Backend: Escolha ideal para prototipagem e aplicações de baixo tráfego que não exigem um servidor de banco de dados dedicado. O arquivo database/database.sqlite é o único ponto de dados.

Tarifas Fixas: As tarifas de estacionamento (carro=5, moto=3, caminhao=10) são definidas como um array ($rates) no topo dos scripts de relatório. Isso permite fácil visualização e edição, mas deve ser movido para um arquivo de configuração se o projeto crescer.

Preparação para PSR-4: O composer.json já inclui a configuração de psr-4 para a pasta src/, indicando que há uma intenção futura de refatorar e organizar a lógica principal em Classes e Namespaces (Orientação a Objetos).

🚀 Como Executar o Projeto

Siga estes passos para preparar e rodar o sistema localmente.

1. Pré-requisitos

PHP (Versão 8.0 ou superior) com a extensão PDO SQLite habilitada.

Composer instalado globalmente.

2. Instalação e Configuração

Clone o Repositório:

git clone [URL_DO_SEU_REPOSITÓRIO]
cd [NOME_DO_PROJETO]


Instale o Autoloader do Composer:

composer install


Crie a Pasta do Banco de Dados:

mkdir database


3. Setup do Banco de Dados

Você precisará executar os scripts de migração e seed via terminal para configurar o banco.

A. Aplicar Migrações (Criação das Tabelas)

Execute o script migrate.php para criar as tabelas necessárias:

php migrate.php
# Saída esperada: Migrações aplicadas com sucesso


B. População de Dados (Opcional)

Execute o script seed.php para inserir dados de exemplo para que os relatórios tenham o que exibir:

php seed.php
# Saída esperada: Seed aplicado


4. Geração de Relatórios

A. Relatório em Linha de Comando (CLI)

Use o report.php para visualizar o resumo do faturamento diretamente no seu terminal:

php report.php


B. Relatório Web (HTML)

Use o servidor embutido do PHP para visualizar o relatório no navegador:

php -S localhost:8000
