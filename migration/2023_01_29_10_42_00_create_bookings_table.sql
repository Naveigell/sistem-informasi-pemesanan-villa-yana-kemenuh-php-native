create table if not exists bookings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    room_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    promo_id BIGINT UNSIGNED NULL,
    identity_card VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status TINYINT UNSIGNED NOT NULL DEFAULT 0, -- 0 means not acc, 1 means acc, 2 means canceled
    note TEXT NULL,
    down_payment VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,

    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (promo_id) REFERENCES promos(id) ON DELETE CASCADE ON UPDATE CASCADE
)