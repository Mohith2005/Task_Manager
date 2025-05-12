-- Sample dataset for Task Manager
-- Passwords: 'password123' (bcrypt hashed)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    status ENUM('pending','in_progress','completed') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample users (password: 'password123')
INSERT INTO users (username, password, email, role) VALUES
('john_doe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'john@example.com', 'user'),
('admin_jane', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jane@admin.com', 'admin');

-- Sample tasks
INSERT INTO tasks (user_id, title, description, due_date, status) VALUES
(1, 'Complete project proposal', 'Draft and finalize Q2 project proposal document', '2025-03-20', 'pending'),
(1, 'Team meeting preparation', 'Prepare agenda and materials for sprint planning', '2025-03-18', 'in_progress'),
(2, 'System maintenance', 'Perform monthly server updates and backups', '2025-03-19', 'completed');