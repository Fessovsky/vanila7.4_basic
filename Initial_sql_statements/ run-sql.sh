#!/bin/bash

for sql_file in ./Initial_sql_statements/*.sql
do
    echo "Executing file: $sql_file"

    mariadb -h localhost -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < "$sql_file"

    if [ $? -eq 0 ]; then
        echo "File $sql_file executed successfully"
    else
        echo "Error executing file $sql_file" >&2
        exit 1
    fi
    sleep 1
done

echo "All files executed successfully"
