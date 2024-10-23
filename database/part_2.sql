

CREATE TABLE `reservation` (
  `reservation_id` int NOT NULL,
  `faculty_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `room_id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date` date NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `reservation` (`reservation_id`, `faculty_id`, `room_id`, `admin_id`, `start_time`, `end_time`, `date`, `status`) VALUES
(2, 2, 1, 1, '11:28:30', '17:28:30', '2024-10-05', 'Confirmed'),
(3, 2, 1, NULL, '01:25:00', '03:27:00', '2024-10-04', 'Cancelled'),
(4, 2, 1, NULL, '01:00:00', '14:00:00', '2024-09-10', 'Cancelled');


CREATE TABLE `room` (
  `room_id` int NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int NOT NULL,
  `equipment` text,
  `availability_status` enum('Available','Reserved','Blocked') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `room_type_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `room` (`room_id`, `room_number`, `location`, `capacity`, `equipment`, `availability_status`, `image`, `admin_id`, `room_type_id`) VALUES
(1, '34444', 'Sed qui voluptates a', 44, '<p>test test&nbsp;</p>\r\n<p>test test&nbsp;</p>\r\n<p>test test</p>', 'Available', 'uploads/dummy-slug-2024-09-08-66ddb031051db.jpeg', NULL, 3),
(3, '941', 'Aliquam nihil facere', 91, '<p>Do dolores est eum v</p>', 'Reserved', NULL, 1, 2),
(4, 'xscfsdg', 'sdfgdfg', 453, '<p>sdfg</p>', 'Blocked', NULL, NULL, 2),
(5, '917', 'Ut perspiciatis inc', 87, NULL, 'Blocked', NULL, 1, 2);


CREATE TABLE `room_type` (
  `room_type_id` bigint UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `admin_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `room_type` (`room_type_id`, `type_name`, `admin_id`) VALUES
(2, 'conference', 1),
(3, 'Classroom', 1);

ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `admin_id` (`admin_id`);


ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `room_type_id` (`room_type_id`);

ALTER TABLE `room_type`
  ADD PRIMARY KEY (`room_type_id`),
  ADD KEY `admin_id` (`admin_id`);

ALTER TABLE `reservation`
  MODIFY `reservation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `room`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `room_type`
  MODIFY `room_type_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`);

ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`),
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`) ON DELETE SET NULL;

ALTER TABLE `room_type`
  ADD CONSTRAINT `room_type_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE CASCADE;
COMMIT;
