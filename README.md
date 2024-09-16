## Project on php 7.4 
Project on vanilla php7.4, docker composer and without any frameworks or extra dependencies except pdo
Alfa version of the project, started from small test task became even more fun.

*Not sure if it is a good idea, but it's a good experience for me.*

#### Comments
This repo is not the best of my code, but my curiosity and desire to experiment.
As the project started from a small test task, I noticed the absence of familiar patterns and tools that package managers, 
frameworks, and other elements typically provide in the modern ecosystem. So, I began implementing them myself.

I recognize some architectural mistakes, violations of SOLID principles, and failures in adhering to the KISS principle and 
will continue refactoring later.
For me, the main objective of this project was to attempt to build a simple framework from scratch as quickly as possible.
The entire project took around 12 hours, during which I created two separate versions using different approaches.
___
### Requirements
- Docker
- (partially) Linux
## SETUP
### 1. Clone the project
```bash
git clone git@github.com:Fessovsky/vanila7.4_basic.git
```

### 2. Copy env.example to .env and fill it with your data
```text
APP_ENV=<development | production>
DB_ROOT_PASSWORD=<root_pass>
DB_USERNAME=<user_name>
DB_PASSWORD=<password>
DB_NAME=<*>
DB_HOST=<docker-sql-container-name>
UPLOAD_DIR=/var/www/html/<PREFERRED_FOLDER>
```
```bash
cp .env.example .env
```

### 3. Run docker compose
```bash
docker compose up -d
```
### 4. Manually run SQLs in db (folder ./Initial_sql_statements) or execute this bash script in the container: 
```bash
docker exec -i <sqlserver_container_name> /bin/bash -c "if [ -f /Initial_sql_statements/' run-sql.sh' ]; then /bin/bash /Initial_sql_statements/' run-sql.sh'; elif [ -f /Initial_sql_statements/run-sql.sh ]; then /bin/bash /Initial_sql_statements/run-sql.sh; else echo 'No valid SQL script found'; fi"
```

## User flow
1. After starting the containers, the project will be available at http://localhost
2. You can upload example.csv file with data from folder ./ExampleData on the upload page
3. Then you can send to every user message from the list, 
   it's fake, so we just put it to the database in fake_microservice table
4. Check DB tables to check if it's working

## TODO;
- Refactor architecture
- Implement DI container
- Add notifications report rendering
- Refactor routing
- Add tests
- ...
- Think what kind of another bicycle I can invent