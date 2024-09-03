-- Insert data into the categories table
INSERT INTO categories (category_name)
VALUES ('Technology'),
       ('Health'),
       ('Finance'),
       ('Education'),
       ('Entertainment');

-- Insert data into the users table
INSERT INTO users (first_name, last_name, email)
VALUES ('John', 'Doe', 'john.doe@example.com'),
       ('Jane', 'Smith', 'jane.smith@example.com'),
       ('Alice', 'Johnson', 'alice.johnson@example.com'),
       ('Bob', 'Brown', 'bob.brown@example.com'),
       ('Charlie', 'Davis', 'charlie.davis@example.com');

-- Insert data into the user_categories table
-- Assuming you want to link some users with some categories
INSERT INTO user_categories (user_id, category_id)
VALUES (1, 1), -- John Doe with Technology
       (2, 2), -- Jane Smith with Health
       (3, 3), -- Alice Johnson with Finance
       (4, 4), -- Bob Brown with Education
       (5, 5), -- Charlie Davis with Entertainment
       (1, 3), -- John Doe also with Finance
       (2, 1), -- Jane Smith also with Technology
       (3, 2), -- Alice Johnson also with Health
       (4, 5), -- Bob Brown also with Entertainment
       (5, 4); -- Charlie Davis also with Education
