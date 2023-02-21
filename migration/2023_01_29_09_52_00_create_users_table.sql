create table if not exists users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(40) NOT NULL UNIQUE,
    password VARCHAR(70) NOT NULL,
    role VARCHAR(20) NOT NULL
)