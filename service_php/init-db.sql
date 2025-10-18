
-- Create the 'accounts' table if it doesn't exist
CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(64) NOT NULL,
    address VARCHAR(256) NOT NULL,
    phone_number VARCHAR(32),
    date_joined DATE NOT NULL DEFAULT CURRENT_DATE
);

-- Insert sample data (optional)
INSERT INTO accounts (name, email, address, phone_number, date_joined)
VALUES
    ('John Doe', 'john@example.com', '123 Main St, City', '555-1234', CURRENT_DATE),
    ('Jane Smith', 'jane@example.com', '456 Oak Ave, Town', '555-5678', CURRENT_DATE);
