create table if not exists testimonials (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    description TEXT NOT NULL,
    star INTEGER UNSIGNED NOT NULL
)