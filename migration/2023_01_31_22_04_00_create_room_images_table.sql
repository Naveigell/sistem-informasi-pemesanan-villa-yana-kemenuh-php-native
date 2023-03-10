create table if not exists room_images (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    room_id BIGINT UNSIGNED NOT NULL,
    is_main TINYINT UNSIGNED NOT NULL DEFAULT 1,
    name VARCHAR(50),

    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE
)