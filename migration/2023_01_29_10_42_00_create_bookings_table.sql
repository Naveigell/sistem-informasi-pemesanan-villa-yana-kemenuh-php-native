create table if not exists bookings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    room_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status TINYINT UNSIGNED NOT NULL DEFAULT 0, -- 0 means not acc, 1 means acc, 2 means canceled

    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE
)