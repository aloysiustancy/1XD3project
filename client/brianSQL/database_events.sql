-- McMaster Mindfulness Club - Events Table
-- Run this in phpMyAdmin when ready (no foreign keys to avoid dependency issues)

CREATE TABLE IF NOT EXISTS events (
    eventID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    eventDate DATE NOT NULL,
    eventTime TIME,
    description TEXT,
    location VARCHAR(200),
    createdBy INT DEFAULT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Test data for April 5th meeting
INSERT INTO events (title, eventDate, eventTime, description, location) 
VALUES 
('Weekly Meditation Session', '2026-04-05', '18:00:00', 'Guided group meditation open to all students', 'Student Center Room 202'),
('Stress Relief Workshop', '2026-04-12', '17:30:00', 'Learn techniques for exam stress management', 'Mills Library Room L107');