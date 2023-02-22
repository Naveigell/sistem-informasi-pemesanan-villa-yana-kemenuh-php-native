create table if not exists complaints(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    room_id BIGINT UNSIGNED NOT NULL,
    booking_id BIGINT UNSIGNED NOT NULL,
    complaint_type VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    status TINYINT UNSIGNED NOT NULL DEFAULT 0, -- 0 mean not finished, 1 mean finished

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE
)