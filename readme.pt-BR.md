# G Suite Admin

Esta aplicação de exemplo foi construída usando Laravel, de maneira que deverá ser fácil, em especial para os que estão familiarizados com este framework, entender o funcionamento desta app e como executá-la.

De qualquer maneira, a seção chamada Primeiros poderá guiá-lo para rapidamente ter esta app rodando no seu ambiente.

*Read this in other languages: [English](README.md)*

## Primeiros Passos

### Instalação
Depois que você clonou (ou fez o download) deste repositório, você precisará:

Instalar as dependências (que são libraries utilizadas por este projeto)  
```
composer update
```

Conceder acesso de escrita à pasta storage
```
sudo chmod -R gu+w storage
```

Criar um arquivo chamado .env utilizando como modelo um arquivo chamado .env.example. Você precisará atualizar os parâmetros deste arquivo de forma que os valores correspondam ao seu ambiente, em especial os seguintes:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=GSuiteAdmin
DB_USERNAME=GSuiteAdmin
DB_PASSWORD=A-SENHA-VEM-AQUI
```

Gerar uma chave para ser usada pela instância local do seu projeto.
```
php artisan key:generate
```

Por último, mas não menos importante, atualize o cache das configurações do projeto:
```
php artisan config:cache
```

### Conectando ao seu Domínio/Conta G Suite

Para permitir que esta aplicação acesse o seu Google G Suite (anteriormente conhecido como Google Apps), você precisará:
- Criar um Projeto no Console do Desenvolvedor Google
- Criar uma Credencial (do tipo Conta de Serviço)
- Habilitar/Autorizar APIs

*Estes passos estão detalhados no link
[G Suite APIs: Configuração de Projeto, Credencial e APIs](https://docs.google.com/presentation/d/1rsJlZ48BYw6HiK0OqP6-7o0tKY8KVNXyTKwzS5OjR_c/edit#slide=id.g1a1712ec78_1_122)*

# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel é um framework de aplicação web com uma sintaxe expressiva e elegante. Acreditamos que o desenvolvimento deve ser uma experiência criativa e prazerosa para ser realmente satisfatória. Laravel tenta eliminar as dores comuns do desenvolvimento facilitando tarefas comuns na maior partes dos projetos web, tais como authenticação, roteamento, sessões, queueing e caching.

Laravel é acessível mas poderoso, fornecendo as ferramentas necessárias para aplicações grandes e robustas. Um container de inversion of control, sistema de migração expressiva altamente integrado com um suporte à teste unitário oferece o que você necessita para construir qualquer aplicação que você precisar.

## Documentação Oficial

Documentação do framework pode ser encontrado no [Laravel website](http://laravel.com/docs).

## Vulnerabilidades de Segurança

Se você descobrir uma vulnerabilidade de segurança dentro do Laravel, por favor envie um e-mail para Taylor Otwell via taylor@laravel.com. Todas vulnerabilidades serão rapidamente verificadas.

## Licença

O framework Laravel é um software open-sourced licenciado usando [MIT license](http://opensource.org/licenses/MIT).
