create table if not exists promos (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    price DECIMAL(19, 5) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL
)