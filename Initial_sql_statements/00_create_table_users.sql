CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    number BIGINT UNIQUE,
    name VARCHAR(30) NOT NULL # Возможно нужно больше в csv максимальная длина строки - 26
);