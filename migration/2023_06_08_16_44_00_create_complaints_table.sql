create table if not exists complaints (
     id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
     room_id BIGINT UNSIGNED NOT NULL,
     booking_id BIGINT UNSIGNED NOT NULL,
     status TINYINT UNSIGNED NOT NULL DEFAULT 0, -- 0 mean not finished, 1 mean finished
     is_read TINYINT UNSIGNED NOT NULL DEFAULT 0, -- 0 mean not read, 1 mean read
     created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

     FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE,
     FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE ON UPDATE CASCADE
)