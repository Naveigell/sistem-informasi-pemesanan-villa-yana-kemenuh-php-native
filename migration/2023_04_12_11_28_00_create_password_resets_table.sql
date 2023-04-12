create table if not exists password_resets (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED,
    email VARCHAR(60) NOT NULL,
    token VARCHAR(120) NOT NULL
)