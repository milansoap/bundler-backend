-- Users Table
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  name VARCHAR(50),
  surname VARCHAR(50),
  failed_attempts INT,
  is_locked TINYINT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pages Table
CREATE TABLE pages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  users_id INT,
  content TEXT,
  FOREIGN KEY (users_id) REFERENCES users(id)
);

-- Elements Table
CREATE TABLE elements (
  id INT PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(50),
  name VARCHAR(50),
  is_custom TINYINT,
  configuration_id INT
);

-- Page_has_Elements Table
CREATE TABLE page_has_elements (
  page_id INT,
  element_id INT,
  PRIMARY KEY (page_id, element_id),
  FOREIGN KEY (page_id) REFERENCES pages(id),
  FOREIGN KEY (element_id) REFERENCES elements(id)
);

-- Configuration Table
CREATE TABLE configuration (
  id INT PRIMARY KEY AUTO_INCREMENT,
  text_color VARCHAR(10),
  background_color VARCHAR(10),
  border_color VARCHAR(10),
  font_size VARCHAR(10),
  font_family VARCHAR(50),
  content TEXT
);

-- Add foreign key in elements for configuration_id
ALTER TABLE elements
ADD FOREIGN KEY (configuration_id) REFERENCES configuration(id);
