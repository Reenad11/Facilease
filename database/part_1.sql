


CREATE TABLE `administrator` (
  `admin_id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `administrator` (`admin_id`, `fullname`, `phone`, `email`, `password`) VALUES
(1, 'admin test', '050343434', 'admin@admin.com', '$2y$12$jpeJLPrr804.v7QN/NMQzOxFAu6lF/OGI0oIGgGPtoGxG4PWhc.O6');



CREATE TABLE `faculty` (
  `faculty_id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `faculty_name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `faculty` (`faculty_id`, `fullname`, `phone_number`, `email`, `password`, `faculty_name`, `department`, `position`) VALUES
(1, 'Reem', '0534334447', 'reem@f.com', '$2y$12$jpeJLPrr804.v7QN/NMQzOxFAu6lF/OGI0oIGgGPtoGxG4PWhc.O6', 'JIC', 'MIS', NULL),
(2, 'Amani', '0565555555', 'amani@f.com', '$2y$12$jpeJLPrr804.v7QN/NMQzOxFAu6lF/OGI0oIGgGPtoGxG4PWhc.O6', 'JIC', 'MIS', 'Researcher');


CREATE TABLE `feedback` (
  `feedback_id` int NOT NULL,
  `faculty_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `room_id` int NOT NULL,
  `feedback_text` text NOT NULL,
  `rating` int NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `feedback` (`feedback_id`, `faculty_id`, `room_id`, `feedback_text`, `rating`, `date_time`) VALUES
(2, 2, 1, 'this room is very goood', 3, '2024-09-10 08:04:55'),
(4, 2, 1, 'nice room', 4, '2024-09-10 08:14:56'),
(5, 1, 1, 'nice room', 4, '2024-09-10 08:14:56'),
(6, 2, 1, 'd', 2, '2024-09-10 10:28:00');


CREATE TABLE `notification` (
  `notification_id` int NOT NULL,
  `faculty_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL,
  `status` enum('Unread','Read') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_id` (`room_id`);


ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `faculty_id` (`faculty_id`);


ALTER TABLE `administrator`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `faculty`
  MODIFY `faculty_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `feedback`
  MODIFY `feedback_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `notification`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `feedback_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;
