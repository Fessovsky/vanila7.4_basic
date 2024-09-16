## Project on php 7.4 
Project on vanilla php with docker composer without any frameworks or extra dependencies except pdo
___
### Requirements
- Docker
- (partially) Linux
## SETUP
### 1. Clone the project
```bash
git clone git@github.com:Fessovsky/wahelp_basic.git
```

### 2. Copy env.example to .env
```text
APP_ENV=<development | production>
DB_ROOT_PASSWORD=<root_pass>
DB_USERNAME=<user_name>
DB_PASSWORD=<password>
DB_NAME=<*>
DB_HOST=wahelp_mariadb_<docker-sql-container-name>
UPLOAD_DIR=/var/www/html/<PREFERRED_FOLDER>
```
```bash
cp .env.example .env
```

### 3. Run docker compose
```bash
docker compose up -d
```
### 4. Manually run sqls in db cli or use bash script: 
```bash
docker exec -i <sqlserver_container_name> /bin/bash /Initial_sql_statements/run-sql.sh
```

## Use
1. After starting the containers, the project will be available at http://localhost
2. You can upload example.csv file with data from folder /exampleData to the project