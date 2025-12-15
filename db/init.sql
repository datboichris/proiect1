CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    grade DECIMAL(4, 2) NOT NULL
);

INSERT INTO students (name, year, grade) VALUES
('Cojoaca Cristian', 2, 8.45),
('Samata George', 3, 7.00),
('Tarbuzan Robert', 1, 5.65);