CREATE TABLE user_categories
(
    user_id     INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id),
    PRIMARY KEY (user_id, category_id)
);
