-- Task Pro — Task Management System schema
-- Database: task_management_db (existing XAMPP DB named "task management db" used at runtime)

CREATE DATABASE IF NOT EXISTS `task management db`;
USE `task management db`;

CREATE TABLE IF NOT EXISTS user (
    id int primary key auto_increment,
    full_name varchar(100) not null,
    username varchar(100) not null,
    password varchar(255) not null,
    role enum('admin', 'employee') not null,
    created_at timestamp default current_timestamp
);

CREATE TABLE IF NOT EXISTS tasks (
    id int primary key auto_increment,
    title varchar(255) not null,
    description text,
    due_date date null,
    status enum('pending', 'in_progress', 'completed') not null default 'pending',
    assigned_to int not null,
    assigned_by int not null,
    created_at timestamp default current_timestamp,
    constraint fk_tasks_assigned_to foreign key (assigned_to) references user(id) on delete cascade,
    constraint fk_tasks_assigned_by foreign key (assigned_by) references user(id) on delete cascade
);

CREATE TABLE IF NOT EXISTS notifications (
    id int primary key auto_increment,
    employee_id int not null,
    task_id int not null,
    message text not null,
    type varchar(100) not null default 'New Task Assigned',
    is_read tinyint(1) not null default 0,
    created_at timestamp default current_timestamp,
    constraint fk_notif_employee foreign key (employee_id) references user(id) on delete cascade,
    constraint fk_notif_task foreign key (task_id) references tasks(id) on delete cascade
);

-- Seed data (only if users table is empty)
INSERT INTO user (full_name, username, password, role) VALUES
('System Admin', 'admin', '$2y$10$nqjQ.z/E5IeaHtKojnvec.s0ESZ50fz3uezEayOfULPI.Ex6dtaZS', 'admin'),
('Abebe Kebede', 'abebe', '$2y$10$Z.2dqjI6VAoHu.L4uUIzU.mrpXIWYdpjDxJ1QKuAt2mJT7rwNGxzO', 'employee'),
('Sara Alemu', 'sara', '$2y$10$Z.2dqjI6VAoHu.L4uUIzU.mrpXIWYdpjDxJ1QKuAt2mJT7rwNGxzO', 'employee'),
('David Tesfaye', 'david', '$2y$10$Z.2dqjI6VAoHu.L4uUIzU.mrpXIWYdpjDxJ1QKuAt2mJT7rwNGxzO', 'employee');

-- Sample tasks (assigned_by = admin id)
INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Fix login bug', 'Investigate and fix the login redirect issue on the dashboard.', '2026-09-10', 'in_progress', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'abebe';

INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Design landing page', 'Create a responsive landing page mockup for Task Pro.', '2026-09-18', 'pending', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'sara';

INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Prepare monthly report', 'Compile the monthly progress report for the team.', NULL, 'pending', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'david';

INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Update documentation', 'Update the project README with setup instructions.', '2026-10-01', 'completed', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'abebe';

INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Review API endpoints', 'Review and test all API endpoint responses.', '2026-09-25', 'in_progress', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'sara';

INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
SELECT 'Setup email server', 'Configure SMTP settings for notification emails.', '2026-09-05', 'pending', id, (SELECT id FROM user WHERE username = 'admin') FROM user WHERE username = 'david';

-- Sample notifications (two read, four unread)
INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Fix login bug'), CONCAT("'Fix login bug' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 1 FROM user WHERE username = 'abebe';

INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Design landing page'), CONCAT("'Design landing page' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 0 FROM user WHERE username = 'sara';

INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Prepare monthly report'), CONCAT("'Prepare monthly report' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 0 FROM user WHERE username = 'david';

INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Update documentation'), CONCAT("'Update documentation' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 1 FROM user WHERE username = 'abebe';

INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Review API endpoints'), CONCAT("'Review API endpoints' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 0 FROM user WHERE username = 'sara';

INSERT INTO notifications (employee_id, task_id, message, type, is_read)
SELECT id, (SELECT id FROM tasks WHERE title = 'Setup email server'), CONCAT("'Setup email server' has been assigned to you. Please review and start working on it."), 'New Task Assigned', 0 FROM user WHERE username = 'david';