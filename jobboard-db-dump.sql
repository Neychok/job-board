-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2023 at 06:49 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  `custom_message` text NOT NULL,
  `cv` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `custom_message`, `cv`) VALUES
(9, 4, 2, 'test', 'sample8.pdf'),
(10, 4, 1, 'Test', 'sample9.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Front End'),
(2, 'Back End'),
(3, 'Full Stack'),
(4, 'Web'),
(5, 'DevOps'),
(6, 'Security'),
(7, 'Cloud'),
(8, 'Gaming'),
(9, 'Quality Assurance'),
(10, 'Project Manager');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salary` decimal(10,0) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_posted` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `title`, `status`, `description`, `salary`, `location`, `date_posted`) VALUES
(1, 3, 'Senior Front End Dev', '1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 10000, 'Sofia, NBU', '2023-02-22 22:35:52'),
(2, 3, 'Junior Front End Dev', '1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 10000, 'Sofia, NBU', '2023-02-22 22:41:54'),
(3, 4, 'Senior Java Developer', '1', 'Bulmag AD is providing to its clients IT System integration elements in various combinations: Hardware &amp; Software Delivery, Professional Services, Consultations Rendering, Training, Authorized Warranty (Lenovo Think, NetApp, Datecs, Pax) and Post-Warranty Service Provider, Servicing and Maintenance, Specific Solutions Development, Design, and Implementation.\r\n\r\nProject Description:\r\n\r\nWe are on the lookout for a Senior JAVA Developer for the Human Resource &amp; Payroll application serving several of the most significant financial institutions in Bulgaria.\r\n\r\nThe Senior JAVA Developer works under minimal supervision to design, test, and implement code, using industry-standard software development practices, techniques, tools, and frameworks.\r\n\r\nResponsibilities:\r\nDesigning, creating, and implementing Java-based applications.\r\nInterpreting briefs to create high-quality coding that functions according to specifications.\r\nDetermining application functions and building objectives with the team.\r\nEnsuring that written code falls in line with the project objectives.\r\nProblem-solving with other team members in the project.\r\nIdentifying and resolving immediate and potential issues with applications.\r\nDrafting detailed reports on the work performed and projects completed.\r\nParticipating in group meetings to discuss projects and objectives.\r\nAssisting other developers with troubleshooting, debugging, and coding.\r\nMeeting deadlines on fast-paced deliverables.\r\nSkills:\r\nEducation: Bachelor&#039;s degree in Computer Science/Information Systems (or relevant education or experience);\r\nRole Specific Experience: 3+ years of relevant experience in Java-based programming;\r\nSignificant coding skills in Java, with other languages such as SQL, PLSQL, HTML, CSS JavaScript will be considered an advantage;\r\nExperience with TOMCAT, Apache and Oracle Application server 12c;\r\nExperience with innovative use of analytical models;\r\nExperience in designing and implementing RestAPI/GraphQL;\r\nFunctional proficiency in performing business process analysis, gathering and analyzing requirements, creating design specifications, unit test plans and system test plans, testing, development, and production support;\r\nTechnical proficiency in module development and upgrades based on organizational needs;\r\nProven ability to support major technology initiatives and tasks of the unit, including coordination of working teams and maintenance of close and constructive working relationships with management and staff in defining and resolving technology issues;\r\nUnderstanding of complex enterprise data;\r\nGood Knowledge of Java 11+, Spring Boot, and JUnit testing framework;\r\nExcellent oral and written communication skills;\r\nProven conceptual, analytical, and judgmental skills;\r\nAbility to multitask.\r\n \r\nWhy should you start working at Bulmag?\r\n\r\nWe offer you the opportunity to work in a team of professionals, in a comfortable and modern environment.\r\nYour individuality and a good work-life balance are important to us.\r\nWe will provide  comfort in a relaxed environment for you to work and succeed.\r\nEach  member of the team is a good specialist and a good person.\r\nYou will receive attractive  and motivating remuneration.\r\n\r\nIf you are interested in the advertised position, we will be waiting for your CV, as well as information about the projects you have worked on.', 4000, 'Sofia', '2023-02-22 22:44:03'),
(4, 4, 'INTERMEDIATE GAME DEVELOPER', '1', 'Job Description\r\nGameloft Sofia is hiring an INTERMEDIATE GAME DEVELOPER,\r\n\r\nAs Game Developer you will work with some of the best talents in the world from hit games and franchises including War Planet Online, which was created in this studio.\r\n\r\n\r\nYour role:\r\nYou will link up with imaginative design teams to create hot new titles, fulfilling a wide range of genres from hardcore action to casual simulation.\r\nYou will track, monitor, optimize, review and manage the full lifecycle of the code using agile methods.\r\nYou will follow development standards, guidelines and best practices for quality assurance\r\nYou will work in an agile environment.', 2300, 'Sofia', '2023-02-22 22:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_categories`
--

CREATE TABLE `jobs_categories` (
  `id` int NOT NULL,
  `job_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs_categories`
--

INSERT INTO `jobs_categories` (`id`, `job_id`, `category_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 4, 8),
(4, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cookie_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone_number` varchar(30) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_site` varchar(255) NOT NULL,
  `company_description` text NOT NULL,
  `company_image` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `cookie_hash`, `phone_number`, `company_name`, `company_site`, `company_description`, `company_image`, `is_admin`) VALUES
(3, 'n.kalaidjiev@gmail.com', 'Neycho', 'Kalaydzhiev', '$2y$10$XM6u9w.UVuFbm2d1XeAtie5KMdX1n1x6BQCW7AIdvDYWxWCDkJtWm', '$2y$10$1TXHES6AO.M/pP2iESxeYO.Kdls3pQqERePEeeNH3RIozrc.ImOAW', '0895000166', 'NBU', 'https://nbu.bg', 'testtest', 'download1.jpeg', 0),
(4, 'admin@nbu.bg', 'Admin', 'Admin', '$2y$10$ppnjGrqPPxLJfMkBA3qazu43wGZqR/gXN1jFQaXJzeblko6qlWgZW', '$2y$10$XHIP6530D.kmi/aMk5xCXevSUDjDRYze.v3Wd72HKSZFUXL0wZ0RG', '0895000166', 'NBU', 'https://nbu.bg', 'NBU ADMIN', 'download2.jpeg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_fk0` (`user_id`),
  ADD KEY `applications_fk1` (`job_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_fk0` (`user_id`);

--
-- Indexes for table `jobs_categories`
--
ALTER TABLE `jobs_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_categories_fk0` (`job_id`),
  ADD KEY `jobs_categories_fk1` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs_categories`
--
ALTER TABLE `jobs_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_fk0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_fk1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_fk0` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobs_categories`
--
ALTER TABLE `jobs_categories`
  ADD CONSTRAINT `jobs_categories_fk0` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `jobs_categories_fk1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
