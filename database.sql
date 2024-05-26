-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Maj 2024, 23:05
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `jobportal`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(80) COLLATE utf8mb4_polish_ci NOT NULL,
  `logo_src` text COLLATE utf8mb4_polish_ci NOT NULL,
  `information` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offer`
--

CREATE TABLE `offer` (
  `offer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `position_name` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `position_level` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `contract_type` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `job_type` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `salary` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `working_time` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `working_hours` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `working_days` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `gmaps_url` text COLLATE utf8mb4_polish_ci NOT NULL,
  `adress` varchar(80) COLLATE utf8mb4_polish_ci NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offer_benefits`
--

CREATE TABLE `offer_benefits` (
  `benetif_id` int(11) NOT NULL,
  `benefit` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `offer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offer_duties`
--

CREATE TABLE `offer_duties` (
  `duty_id` int(11) NOT NULL,
  `duty` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `offer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offer_filters`
--

CREATE TABLE `offer_filters` (
  `filters_id` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `items` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `offer_filters`
--

INSERT INTO `offer_filters` (`filters_id`, `items`) VALUES
('contract_type', 'Umowa o pracę;Umowa o dzieło;Umowa zlecenie;Umowa B2B;Umowa na zastępstwo;Umowa o staż / praktyki'),
('job_type', 'Praca stacjonarna;Praca hybrydowa;Praca Zdalna'),
('position_level', 'Praktykant / stażysta;Asystent;Młodszy specjalista (junior);Specjalista (mid);Starszy specjalista (senior);Ekspert;Kierownik / koordynator;Menedżer;Dyrektor;Prezes'),
('working_time', 'Część etatu;Cały etat;Dodatkowa / tymczasowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offer_requirements`
--

CREATE TABLE `offer_requirements` (
  `requirement_id` int(11) NOT NULL,
  `requirement` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `offer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `surname` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `birth_date` date NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `avatar_src` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `user_adress` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `job_position` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `job_position_description` text COLLATE utf8mb4_polish_ci NOT NULL,
  `career_summary` text COLLATE utf8mb4_polish_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `profile`
--

INSERT INTO `profile` (`profile_id`, `name`, `surname`, `birth_date`, `phone_number`, `avatar_src`, `user_adress`, `job_position`, `job_position_description`, `career_summary`, `user_id`) VALUES
(2, 'administrator', '', '2005-05-04', '123', '../imgs/userImg/admin.png', 'Brak', 'Administrator', 'Administrator serwisu JobPortal', 'test', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_certificates`
--

CREATE TABLE `profile_certificates` (
  `certificate_id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `organizer` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `course_date` date NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_education`
--

CREATE TABLE `profile_education` (
  `education_id` int(11) NOT NULL,
  `school_name` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `location` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `education_level` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `major` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `peroid_from` date NOT NULL,
  `peroid_to` date NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_experience`
--

CREATE TABLE `profile_experience` (
  `experience_id` int(11) NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `company_name` varchar(150) COLLATE utf8mb4_polish_ci NOT NULL,
  `location` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `peroid_from` date NOT NULL,
  `peroid_to` date NOT NULL,
  `duties` varchar(80) COLLATE utf8mb4_polish_ci NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_languages`
--

CREATE TABLE `profile_languages` (
  `language_id` int(11) NOT NULL,
  `language` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `level` varchar(2) COLLATE utf8mb4_polish_ci NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `profile_languages`
--

INSERT INTO `profile_languages` (`language_id`, `language`, `level`, `profile_id`) VALUES
(1, 'Angielski', 'B2', 2),
(2, 'Francuski', 'A2', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_skills`
--

CREATE TABLE `profile_skills` (
  `skill_id` int(11) NOT NULL,
  `skill` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_urls`
--

CREATE TABLE `profile_urls` (
  `url_id` int(11) NOT NULL,
  `url` text COLLATE utf8mb4_polish_ci NOT NULL,
  `profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_polish_ci NOT NULL,
  `isadmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `isadmin`) VALUES
(1, 'admin', '$2y$10$iwkJEmPK943HUKnH4DDrsOp/KgrUH9vfcrcZYTnsS70wjzI5VLnaG', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_applications`
--

CREATE TABLE `user_applications` (
  `application_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_favourites`
--

CREATE TABLE `user_favourites` (
  `favourite_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indeksy dla tabeli `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indeksy dla tabeli `offer_benefits`
--
ALTER TABLE `offer_benefits`
  ADD PRIMARY KEY (`benetif_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indeksy dla tabeli `offer_duties`
--
ALTER TABLE `offer_duties`
  ADD PRIMARY KEY (`duty_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indeksy dla tabeli `offer_filters`
--
ALTER TABLE `offer_filters`
  ADD PRIMARY KEY (`filters_id`);

--
-- Indeksy dla tabeli `offer_requirements`
--
ALTER TABLE `offer_requirements`
  ADD PRIMARY KEY (`requirement_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indeksy dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `profile_certificates`
--
ALTER TABLE `profile_certificates`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `profile_education`
--
ALTER TABLE `profile_education`
  ADD PRIMARY KEY (`education_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `profile_experience`
--
ALTER TABLE `profile_experience`
  ADD PRIMARY KEY (`experience_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `profile_languages`
--
ALTER TABLE `profile_languages`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `profile_skills`
--
ALTER TABLE `profile_skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `profile_urls`
--
ALTER TABLE `profile_urls`
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `user_applications`
--
ALTER TABLE `user_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `offer_id` (`offer_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indeksy dla tabeli `user_favourites`
--
ALTER TABLE `user_favourites`
  ADD PRIMARY KEY (`favourite_id`),
  ADD KEY `offer_id` (`offer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `offer_benefits`
--
ALTER TABLE `offer_benefits`
  MODIFY `benetif_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `offer_duties`
--
ALTER TABLE `offer_duties`
  MODIFY `duty_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `offer_requirements`
--
ALTER TABLE `offer_requirements`
  MODIFY `requirement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `profile_certificates`
--
ALTER TABLE `profile_certificates`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `profile_education`
--
ALTER TABLE `profile_education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `profile_experience`
--
ALTER TABLE `profile_experience`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `profile_languages`
--
ALTER TABLE `profile_languages`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `profile_skills`
--
ALTER TABLE `profile_skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `user_favourites`
--
ALTER TABLE `user_favourites`
  MODIFY `favourite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `offer_benefits`
--
ALTER TABLE `offer_benefits`
  ADD CONSTRAINT `offer_benefits_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `offer_duties`
--
ALTER TABLE `offer_duties`
  ADD CONSTRAINT `offer_duties_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `offer_requirements`
--
ALTER TABLE `offer_requirements`
  ADD CONSTRAINT `offer_requirements_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_certificates`
--
ALTER TABLE `profile_certificates`
  ADD CONSTRAINT `profile_certificates_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_education`
--
ALTER TABLE `profile_education`
  ADD CONSTRAINT `profile_education_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_experience`
--
ALTER TABLE `profile_experience`
  ADD CONSTRAINT `profile_experience_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_languages`
--
ALTER TABLE `profile_languages`
  ADD CONSTRAINT `profile_languages_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_skills`
--
ALTER TABLE `profile_skills`
  ADD CONSTRAINT `profile_skills_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `profile_urls`
--
ALTER TABLE `profile_urls`
  ADD CONSTRAINT `profile_urls_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `user_applications`
--
ALTER TABLE `user_applications`
  ADD CONSTRAINT `user_applications_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_applications_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `user_favourites`
--
ALTER TABLE `user_favourites`
  ADD CONSTRAINT `user_favourites_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_favourites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
