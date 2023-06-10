-- Create the messages table
CREATE TABLE messages (
  id SERIAL PRIMARY KEY,
  content VARCHAR(255),
  status VARCHAR(20),
  scheduled_date TIMESTAMP,
  delivered_date TIMESTAMP
);

-- Create the recipients table
CREATE TABLE recipients (
  id SERIAL PRIMARY KEY,
  message_id INT,
  email_address VARCHAR(255),
  status VARCHAR(20),
  delivered_date TIMESTAMP,
  FOREIGN KEY (message_id) REFERENCES messages (id)
);