create table if not exists rooms (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    room_number VARCHAR(200) NOT NULL UNIQUE,
    name VARCHAR(200) NOT NULL,
    price INT UNSIGNED NOT NULL
)