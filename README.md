# news_parser

Install Symfony CLI

`docker-compose up -d`

`symfony server:start`

`https://127.0.0.1:8000`

## Description

Create a news parsing service from a news resource, for example https://highload.today/. The service must have a page displaying the list of downloaded news and a CLI command to start parsing.

### Parsing features:

from each article, the download should and be saved:

- title
- short description
- picture
- date added

When parsing, it is necessary to check the presence of the title in the database, and if the news is already in the database, make a note about the date and time of the last update

Database queries should be optimized for heavy load

Parsing should be in several parallel processes (via rabbitMQ)

Parsing must be run via cron

Features of the page for viewing news from the database:

The page for viewing news from the database should be available only after authorization in the system (registration is not required)
Authorized users can be with one of two roles: admin or moderator (the administrator can delete articles)
there must be pagination at the end of the list of articles (10 per page)


### Stack:

- Symfony 5.4
- Php 7.4
- Mysql
- Bootstrap 5.1
- Docker (docker-compose)
- RabbitMQ
