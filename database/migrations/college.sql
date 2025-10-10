-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 07:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `language_id`   int(10) UNSIGNED NOT NULL,
    `label`         varchar(191) DEFAULT NULL,
    `title`         varchar(191) DEFAULT NULL,
    `short_desc`    text         DEFAULT NULL,
    `description`   longtext     DEFAULT NULL,
    `features`      longtext     DEFAULT NULL,
    `attach`        text         DEFAULT NULL,
    `video_id`      varchar(191) DEFAULT NULL,
    `button_text`   varchar(191) DEFAULT NULL,
    `mission_title` varchar(191) DEFAULT NULL,
    `mission_desc`  text         DEFAULT NULL,
    `mission_icon`  varchar(191) DEFAULT NULL,
    `mission_image` text         DEFAULT NULL,
    `vision_title`  varchar(191) DEFAULT NULL,
    `vision_desc`   text         DEFAULT NULL,
    `vision_icon`   varchar(191) DEFAULT NULL,
    `vision_image`  text         DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications`
(
    `id`                       bigint(20) UNSIGNED NOT NULL,
    `registration_no`          varchar(191) DEFAULT NULL,
    `batch_id`                 int(10) UNSIGNED DEFAULT NULL,
    `program_id`               int(10) UNSIGNED DEFAULT NULL,
    `apply_date`               date         DEFAULT NULL,
    `first_name`               varchar(191) NOT NULL,
    `last_name`                varchar(191) NOT NULL,
    `father_name`              varchar(191) DEFAULT NULL,
    `mother_name`              varchar(191) DEFAULT NULL,
    `father_occupation`        varchar(191) DEFAULT NULL,
    `mother_occupation`        varchar(191) DEFAULT NULL,
    `father_photo`             text         DEFAULT NULL,
    `mother_photo`             text         DEFAULT NULL,
    `country`                  varchar(191) DEFAULT NULL,
    `present_province`         int(10) UNSIGNED DEFAULT NULL,
    `present_district`         int(10) UNSIGNED DEFAULT NULL,
    `present_village`          text         DEFAULT NULL,
    `present_address`          text         DEFAULT NULL,
    `permanent_province`       int(10) UNSIGNED DEFAULT NULL,
    `permanent_district`       int(10) UNSIGNED DEFAULT NULL,
    `permanent_village`        text         DEFAULT NULL,
    `permanent_address`        text         DEFAULT NULL,
    `gender`                   tinyint(4) NOT NULL COMMENT '1 Male, 2 Female & 3 Other',
    `dob`                      date         NOT NULL,
    `email`                    varchar(191) NOT NULL,
    `phone`                    varchar(191) DEFAULT NULL,
    `emergency_phone`          varchar(191) DEFAULT NULL,
    `religion`                 varchar(191) DEFAULT NULL,
    `caste`                    varchar(191) DEFAULT NULL,
    `mother_tongue`            varchar(191) DEFAULT NULL,
    `marital_status`           tinyint(4) DEFAULT NULL,
    `blood_group`              tinyint(4) DEFAULT NULL,
    `nationality`              varchar(191) DEFAULT NULL,
    `national_id`              varchar(191) DEFAULT NULL,
    `passport_no`              varchar(191) DEFAULT NULL,
    `school_name`              text         DEFAULT NULL,
    `school_exam_id`           varchar(191) DEFAULT NULL,
    `school_graduation_field`  varchar(191) DEFAULT NULL,
    `school_graduation_year`   varchar(191) DEFAULT NULL,
    `school_graduation_point`  varchar(191) DEFAULT NULL,
    `school_transcript`        varchar(191) DEFAULT NULL,
    `school_certificate`       varchar(191) DEFAULT NULL,
    `collage_name`             text         DEFAULT NULL,
    `collage_exam_id`          varchar(191) DEFAULT NULL,
    `collage_graduation_field` varchar(191) DEFAULT NULL,
    `collage_graduation_year`  varchar(191) DEFAULT NULL,
    `collage_graduation_point` varchar(191) DEFAULT NULL,
    `collage_transcript`       varchar(191) DEFAULT NULL,
    `collage_certificate`      varchar(191) DEFAULT NULL,
    `photo`                    text         DEFAULT NULL,
    `signature`                text         DEFAULT NULL,
    `fee_amount` double(10,2) DEFAULT NULL,
    `pay_status`               tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 Unpaid, 1 Paid, 2 Cancel',
    `payment_method`           int(11) DEFAULT NULL,
    `status`                   tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Rejected, 1 Pending, 2 Approve',
    `created_by`               bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`               bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`               timestamp NULL DEFAULT NULL,
    `updated_at`               timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_settings`
--

CREATE TABLE `application_settings`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `slug`          varchar(191) NOT NULL,
    `title`         text     DEFAULT NULL,
    `header_left`   text     DEFAULT NULL,
    `header_center` text     DEFAULT NULL,
    `header_right`  text     DEFAULT NULL,
    `body`          longtext DEFAULT NULL,
    `footer_left`   text     DEFAULT NULL,
    `footer_center` text     DEFAULT NULL,
    `footer_right`  text     DEFAULT NULL,
    `logo_left`     text     DEFAULT NULL,
    `logo_right`    text     DEFAULT NULL,
    `background`    text     DEFAULT NULL,
    `fee_amount` double(10,2) DEFAULT NULL,
    `pay_online`    tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 No, 1 Yes',
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `faculty_id`  int(10) UNSIGNED DEFAULT NULL,
    `program_id`  int(10) UNSIGNED DEFAULT NULL,
    `session_id`  int(10) UNSIGNED DEFAULT NULL,
    `semester_id` int(10) UNSIGNED DEFAULT NULL,
    `section_id`  int(10) UNSIGNED DEFAULT NULL,
    `subject_id`  bigint(20) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` longtext      DEFAULT NULL,
    `total_marks` decimal(5, 2) DEFAULT NULL,
    `start_date`  date          DEFAULT NULL,
    `end_date`    date          DEFAULT NULL,
    `attach`      text          DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `assign_by`   bigint(20) UNSIGNED NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `start_date` date DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batch_program`
--

CREATE TABLE `batch_program`
(
    `batch_id`   int(10) UNSIGNED NOT NULL,
    `program_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `category_id`  int(10) UNSIGNED NOT NULL,
    `title`        varchar(191) NOT NULL,
    `isbn`         varchar(191)   DEFAULT NULL,
    `code`         varchar(191)   DEFAULT NULL,
    `author`       varchar(191)   DEFAULT NULL,
    `publisher`    varchar(191)   DEFAULT NULL,
    `edition`      varchar(191)   DEFAULT NULL,
    `publish_year` varchar(191)   DEFAULT NULL,
    `language`     varchar(191)   DEFAULT NULL,
    `price`        decimal(10, 2) DEFAULT NULL,
    `quantity`     int(11) DEFAULT NULL,
    `section`      varchar(191)   DEFAULT NULL,
    `column`       varchar(191)   DEFAULT NULL,
    `row`          varchar(191)   DEFAULT NULL,
    `description`  longtext       DEFAULT NULL,
    `note`         text           DEFAULT NULL,
    `attach`       text           DEFAULT NULL,
    `status`       tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Lost, 1 Available, 2 Damage',
    `created_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE `book_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

CREATE TABLE `book_requests`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `category_id`  int(10) UNSIGNED NOT NULL,
    `title`        varchar(191) NOT NULL,
    `isbn`         varchar(191)   DEFAULT NULL,
    `code`         varchar(191)   DEFAULT NULL,
    `author`       varchar(191)   DEFAULT NULL,
    `publisher`    varchar(191)   DEFAULT NULL,
    `edition`      varchar(191)   DEFAULT NULL,
    `publish_year` varchar(191)   DEFAULT NULL,
    `language`     varchar(191)   DEFAULT NULL,
    `price`        decimal(10, 2) DEFAULT NULL,
    `quantity`     int(11) DEFAULT NULL,
    `request_by`   varchar(191)   DEFAULT NULL,
    `phone`        varchar(191)   DEFAULT NULL,
    `email`        varchar(191)   DEFAULT NULL,
    `description`  longtext       DEFAULT NULL,
    `note`         text           DEFAULT NULL,
    `attach`       text           DEFAULT NULL,
    `status`       tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Rejected, 1 Pending, 2 Progress, 3 Approved',
    `created_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `call_to_actions`
--

CREATE TABLE `call_to_actions`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) DEFAULT NULL,
    `sub_title`   text         DEFAULT NULL,
    `image`       text         DEFAULT NULL,
    `bg_image`    text         DEFAULT NULL,
    `button_text` varchar(191) DEFAULT NULL,
    `button_link` varchar(191) DEFAULT NULL,
    `video_id`    varchar(191) DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `template_id`   int(10) UNSIGNED NOT NULL,
    `student_id`    bigint(20) UNSIGNED NOT NULL,
    `serial_no`     varchar(191) DEFAULT NULL,
    `date`          date          NOT NULL,
    `starting_year` varchar(191) DEFAULT NULL,
    `ending_year`   varchar(191) DEFAULT NULL,
    `credits`       decimal(5, 2) NOT NULL,
    `point`         decimal(5, 2) NOT NULL,
    `barcode`       varchar(191) DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_templates`
--

CREATE TABLE `certificate_templates`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `title`         varchar(191) NOT NULL,
    `header_left`   text                  DEFAULT NULL,
    `header_center` text                  DEFAULT NULL,
    `header_right`  text                  DEFAULT NULL,
    `body`          longtext              DEFAULT NULL,
    `footer_left`   text                  DEFAULT NULL,
    `footer_center` text                  DEFAULT NULL,
    `footer_right`  text                  DEFAULT NULL,
    `logo_left`     text                  DEFAULT NULL,
    `logo_right`    text                  DEFAULT NULL,
    `background`    text                  DEFAULT NULL,
    `width`         varchar(191) NOT NULL DEFAULT 'auto',
    `height`        varchar(191) NOT NULL DEFAULT 'auto',
    `student_photo` tinyint(1) NOT NULL DEFAULT 0,
    `barcode`       tinyint(1) NOT NULL DEFAULT 0,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_rooms`
--

CREATE TABLE `class_rooms`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `floor`       varchar(191) DEFAULT NULL,
    `capacity`    varchar(191) DEFAULT NULL,
    `type`        varchar(191) DEFAULT NULL,
    `description` text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_routines`
--

CREATE TABLE `class_routines`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `teacher_id`  bigint(20) UNSIGNED NOT NULL,
    `subject_id`  bigint(20) UNSIGNED NOT NULL,
    `room_id`     int(10) UNSIGNED NOT NULL,
    `session_id`  int(10) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `section_id`  int(10) UNSIGNED NOT NULL,
    `start_time`  time NOT NULL,
    `end_time`    time NOT NULL,
    `day`         tinyint(4) NOT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `type_id`      int(10) UNSIGNED NOT NULL,
    `source_id`    int(10) UNSIGNED DEFAULT NULL,
    `name`         varchar(191) NOT NULL,
    `father_name`  varchar(191) DEFAULT NULL,
    `phone`        varchar(191) DEFAULT NULL,
    `email`        varchar(191) DEFAULT NULL,
    `date`         date         NOT NULL,
    `action_taken` text         DEFAULT NULL,
    `assigned`     varchar(191) DEFAULT NULL,
    `issue`        longtext     DEFAULT NULL,
    `note`         text         DEFAULT NULL,
    `attach`       text         DEFAULT NULL,
    `status`       tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Rejected, 1 Pending, 2 Progress, 3 Resolved',
    `created_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complain_sources`
--

CREATE TABLE `complain_sources`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complain_types`
--

CREATE TABLE `complain_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contentables`
--

CREATE TABLE `contentables`
(
    `content_id`       bigint(20) NOT NULL,
    `contentable_id`   bigint(20) NOT NULL,
    `contentable_type` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `faculty_id`  int(10) UNSIGNED DEFAULT NULL,
    `program_id`  int(10) UNSIGNED DEFAULT NULL,
    `session_id`  int(10) UNSIGNED DEFAULT NULL,
    `semester_id` int(10) UNSIGNED DEFAULT NULL,
    `section_id`  int(10) UNSIGNED DEFAULT NULL,
    `type_id`     int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` longtext DEFAULT NULL,
    `date`        date         NOT NULL,
    `url`         text     DEFAULT NULL,
    `attach`      text     DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE `content_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `faculty`     varchar(191) DEFAULT NULL,
    `semesters`   varchar(191) DEFAULT NULL,
    `credits`     varchar(191) DEFAULT NULL,
    `courses`     varchar(191) DEFAULT NULL,
    `duration`    varchar(191) DEFAULT NULL,
    `fee` double(10,2) DEFAULT NULL,
    `description` longtext     DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `province_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docables`
--

CREATE TABLE `docables`
(
    `document_id`  bigint(20) UNSIGNED NOT NULL,
    `docable_type` varchar(191) NOT NULL,
    `docable_id`   bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `title`      varchar(191) DEFAULT NULL,
    `attach`     text         DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_notifies`
--

CREATE TABLE `email_notifies`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `faculty_id`    int(10) UNSIGNED DEFAULT NULL,
    `program_id`    int(10) UNSIGNED DEFAULT NULL,
    `session_id`    int(10) UNSIGNED DEFAULT NULL,
    `semester_id`   int(10) UNSIGNED DEFAULT NULL,
    `section_id`    int(10) UNSIGNED DEFAULT NULL,
    `subject`       text     NOT NULL,
    `message`       longtext NOT NULL,
    `receive_count` int(11) DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries`
(
    `id`                 bigint(20) UNSIGNED NOT NULL,
    `reference_id`       int(10) UNSIGNED DEFAULT NULL,
    `source_id`          int(10) UNSIGNED DEFAULT NULL,
    `program_id`         int(10) UNSIGNED DEFAULT NULL,
    `name`               varchar(191) NOT NULL,
    `father_name`        varchar(191) DEFAULT NULL,
    `phone`              varchar(191) DEFAULT NULL,
    `email`              varchar(191) DEFAULT NULL,
    `address`            text         DEFAULT NULL,
    `purpose`            longtext     DEFAULT NULL,
    `note`               text         DEFAULT NULL,
    `date`               date         NOT NULL,
    `follow_up_date`     date         DEFAULT NULL,
    `assigned`           varchar(191) DEFAULT NULL,
    `number_of_students` int(11) NOT NULL DEFAULT 1,
    `status`             tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Closed, 1 Pending, 2 Progress, 3 Resolved',
    `created_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`         timestamp NULL DEFAULT NULL,
    `updated_at`         timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_references`
--

CREATE TABLE `enquiry_references`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_sources`
--

CREATE TABLE `enquiry_sources`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enroll_subjects`
--

CREATE TABLE `enroll_subjects`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `section_id`  int(10) UNSIGNED NOT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enroll_subject_subject`
--

CREATE TABLE `enroll_subject_subject`
(
    `enroll_subject_id` bigint(20) UNSIGNED NOT NULL,
    `subject_id`        bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `start_date` date         NOT NULL,
    `end_date`   date         NOT NULL,
    `color`      varchar(191) DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams`
(
    `id`                bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `subject_id`        bigint(20) UNSIGNED NOT NULL,
    `exam_type_id`      int(10) UNSIGNED DEFAULT NULL,
    `date`              date                   DEFAULT NULL,
    `time`              time                   DEFAULT NULL,
    `attendance`        tinyint(4) NOT NULL DEFAULT 2 COMMENT '1-Present, 2-Absent',
    `marks`             decimal(5, 2)          DEFAULT NULL,
    `achieve_marks`     decimal(5, 2)          DEFAULT NULL,
    `contribution`      decimal(5, 2) NOT NULL DEFAULT 0.00,
    `note`              text                   DEFAULT NULL,
    `status`            tinyint(1) NOT NULL DEFAULT 1,
    `created_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_routines`
--

CREATE TABLE `exam_routines`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `exam_type_id` int(10) UNSIGNED NOT NULL,
    `session_id`   int(10) UNSIGNED NOT NULL,
    `program_id`   int(10) UNSIGNED NOT NULL,
    `semester_id`  int(10) UNSIGNED NOT NULL,
    `section_id`   int(10) UNSIGNED NOT NULL,
    `subject_id`   bigint(20) UNSIGNED NOT NULL,
    `date`         date NOT NULL,
    `start_time`   time NOT NULL,
    `end_time`     time NOT NULL,
    `status`       tinyint(1) NOT NULL DEFAULT 1,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_routine_room`
--

CREATE TABLE `exam_routine_room`
(
    `exam_routine_id` bigint(20) UNSIGNED NOT NULL,
    `room_id`         int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_routine_user`
--

CREATE TABLE `exam_routine_user`
(
    `exam_routine_id` bigint(20) UNSIGNED NOT NULL,
    `user_id`         bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types`
(
    `id`           int(10) UNSIGNED NOT NULL,
    `title`        varchar(191)  NOT NULL,
    `marks`        decimal(5, 2) NOT NULL,
    `contribution` decimal(5, 2) NOT NULL DEFAULT 0.00,
    `description`  text                   DEFAULT NULL,
    `status`       tinyint(1) NOT NULL DEFAULT 1,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `title`, `marks`, `contribution`, `description`, `status`, `created_at`, `updated_at`)
VALUES (1, 'Final Exam', '100.00', '50.00', NULL, 1, NULL, NULL),
       (2, 'Midterm Exam', '50.00', '20.00', NULL, 1, NULL, NULL),
       (3, 'Test Exam', '20.00', '0.00', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `category_id`    int(10) UNSIGNED NOT NULL,
    `title`          varchar(191)   NOT NULL,
    `invoice_id`     varchar(191) DEFAULT NULL,
    `amount`         decimal(10, 2) NOT NULL,
    `date`           date           NOT NULL,
    `reference`      varchar(191) DEFAULT NULL,
    `payment_method` int(11) DEFAULT NULL,
    `note`           text         DEFAULT NULL,
    `attach`         text         DEFAULT NULL,
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `slug`       varchar(191) NOT NULL,
    `shortcode`  varchar(191) DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `uuid`       varchar(191) NOT NULL,
    `connection` text         NOT NULL,
    `queue`      text         NOT NULL,
    `payload`    longtext     NOT NULL,
    `exception`  longtext     NOT NULL,
    `failed_at`  timestamp    NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` longtext     NOT NULL,
    `icon`        varchar(191) DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` longtext     NOT NULL,
    `icon`        varchar(191) DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees`
(
    `id`                bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `category_id`       int(10) UNSIGNED NOT NULL,
    `fee_amount` double(10,2) NOT NULL,
    `fine_amount` double(10,2) NOT NULL DEFAULT 0.00,
    `discount_amount` double(10,2) NOT NULL DEFAULT 0.00,
    `paid_amount` double(10,2) NOT NULL,
    `assign_date`       date NOT NULL,
    `due_date`          date NOT NULL,
    `pay_date`          date DEFAULT NULL,
    `payment_method`    int(11) DEFAULT NULL,
    `note`              text DEFAULT NULL,
    `status`            tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 Unpaid, 1 Paid, 2 Cancel',
    `created_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_categories`
--

CREATE TABLE `fees_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fees_categories`
--

INSERT INTO `fees_categories` (`id`, `title`, `slug`, `description`, `status`, `created_at`, `updated_at`)
VALUES (1, 'Admission Fees', 'admission-fees', NULL, 1, NULL, NULL),
       (2, 'Semester Fees', 'semester-fees', NULL, 1, NULL, NULL),
       (3, 'Exam Fees', 'exam-fees', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fees_category_fees_discount`
--

CREATE TABLE `fees_category_fees_discount`
(
    `fees_category_id` int(10) UNSIGNED NOT NULL,
    `fees_discount_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_category_fees_fine`
--

CREATE TABLE `fees_category_fees_fine`
(
    `fees_category_id` int(10) UNSIGNED NOT NULL,
    `fees_fine_id`     int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_discounts`
--

CREATE TABLE `fees_discounts`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191)   NOT NULL,
    `start_date` date           NOT NULL,
    `end_date`   date           NOT NULL,
    `amount`     decimal(10, 2) NOT NULL,
    `type`       tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Fixed & 2 Percentange',
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_discount_status_type`
--

CREATE TABLE `fees_discount_status_type`
(
    `fees_discount_id` int(10) UNSIGNED NOT NULL,
    `status_type_id`   int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_fines`
--

CREATE TABLE `fees_fines`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `start_day`  int(11) NOT NULL,
    `end_day`    int(11) NOT NULL,
    `amount`     decimal(10, 2) NOT NULL,
    `type`       tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Fixed, 2 Percentage',
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_masters`
--

CREATE TABLE `fees_masters`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `category_id` int(10) UNSIGNED NOT NULL,
    `faculty_id`  int(10) UNSIGNED DEFAULT NULL,
    `program_id`  int(10) UNSIGNED DEFAULT NULL,
    `session_id`  int(10) UNSIGNED DEFAULT NULL,
    `semester_id` int(10) UNSIGNED DEFAULT NULL,
    `section_id`  int(10) UNSIGNED DEFAULT NULL,
    `amount`      decimal(10, 2) NOT NULL,
    `type`        tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Fixed, 2 Per Credit',
    `assign_date` date           NOT NULL,
    `due_date`    date           NOT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_student_enroll`
--

CREATE TABLE `fees_master_student_enroll`
(
    `fees_master_id`    bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `slug`       varchar(191) NOT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `slug`, `status`, `created_at`, `updated_at`)
VALUES (1, 'user_father_name', 1, NULL, NULL),
       (2, 'user_mother_name', 1, NULL, NULL),
       (3, 'user_joining_date', 1, NULL, NULL),
       (4, 'user_ending_date', 1, NULL, NULL),
       (5, 'user_emergency_phone', 1, NULL, NULL),
       (6, 'user_religion', 0, NULL, NULL),
       (7, 'user_caste', 0, NULL, NULL),
       (8, 'user_mother_tongue', 0, NULL, NULL),
       (9, 'user_nationality', 0, NULL, NULL),
       (10, 'user_marital_status', 1, NULL, NULL),
       (11, 'user_blood_group', 1, NULL, NULL),
       (12, 'user_national_id', 1, NULL, NULL),
       (13, 'user_passport_no', 1, NULL, NULL),
       (14, 'user_address', 1, NULL, NULL),
       (15, 'user_education', 1, NULL, NULL),
       (16, 'user_epf_no', 1, NULL, NULL),
       (17, 'user_bank_account', 1, NULL, NULL),
       (18, 'user_signature', 1, NULL, NULL),
       (19, 'user_resume', 1, NULL, NULL),
       (20, 'user_joining_letter', 1, NULL, NULL),
       (21, 'user_documents', 1, NULL, NULL),
       (22, 'student_father_name', 1, NULL, NULL),
       (23, 'student_mother_name', 1, NULL, NULL),
       (24, 'student_father_occupation', 1, NULL, NULL),
       (25, 'student_mother_occupation', 1, NULL, NULL),
       (26, 'student_emergency_phone', 1, NULL, NULL),
       (27, 'student_religion', 1, NULL, NULL),
       (28, 'student_caste', 0, NULL, NULL),
       (29, 'student_mother_tongue', 0, NULL, NULL),
       (30, 'student_nationality', 0, NULL, NULL),
       (31, 'student_marital_status', 1, NULL, NULL),
       (32, 'student_blood_group', 1, NULL, NULL),
       (33, 'student_national_id', 1, NULL, NULL),
       (34, 'student_passport_no', 1, NULL, NULL),
       (35, 'student_address', 1, NULL, NULL),
       (36, 'student_school_info', 1, NULL, NULL),
       (37, 'student_collage_info', 1, NULL, NULL),
       (38, 'student_relatives', 1, NULL, NULL),
       (39, 'student_school_transcript', 1, NULL, NULL),
       (40, 'student_school_certificate', 1, NULL, NULL),
       (41, 'student_collage_transcript', 1, NULL, NULL),
       (42, 'student_collage_certificate', 1, NULL, NULL),
       (43, 'student_photo', 1, NULL, NULL),
       (44, 'student_signature', 1, NULL, NULL),
       (45, 'student_documents', 1, NULL, NULL),
       (46, 'application_father_name', 1, NULL, NULL),
       (47, 'application_mother_name', 1, NULL, NULL),
       (48, 'application_father_occupation', 1, NULL, NULL),
       (49, 'application_mother_occupation', 1, NULL, NULL),
       (50, 'application_emergency_phone', 0, NULL, NULL),
       (51, 'application_religion', 0, NULL, NULL),
       (52, 'application_caste', 0, NULL, NULL),
       (53, 'application_mother_tongue', 0, NULL, NULL),
       (54, 'application_nationality', 0, NULL, NULL),
       (55, 'application_marital_status', 1, NULL, NULL),
       (56, 'application_blood_group', 1, NULL, NULL),
       (57, 'application_national_id', 1, NULL, NULL),
       (58, 'application_passport_no', 1, NULL, NULL),
       (59, 'application_address', 1, NULL, NULL),
       (60, 'application_school_info', 1, NULL, NULL),
       (61, 'application_collage_info', 1, NULL, NULL),
       (62, 'application_school_transcript', 1, NULL, NULL),
       (63, 'application_school_certificate', 1, NULL, NULL),
       (64, 'application_collage_transcript', 1, NULL, NULL),
       (65, 'application_collage_certificate', 1, NULL, NULL),
       (66, 'application_photo', 1, NULL, NULL),
       (67, 'application_signature', 1, NULL, NULL),
       (68, 'panel_class_routine', 1, NULL, NULL),
       (69, 'panel_exam_routine', 1, NULL, NULL),
       (70, 'panel_attendance', 1, NULL, NULL),
       (71, 'panel_leave', 1, NULL, NULL),
       (72, 'panel_fees_report', 1, NULL, NULL),
       (73, 'panel_online_exam', 1, NULL, NULL),
       (74, 'panel_library', 1, NULL, NULL),
       (75, 'panel_notice', 1, NULL, NULL),
       (76, 'panel_assignment', 1, NULL, NULL),
       (77, 'panel_syllabus', 1, NULL, NULL),
       (78, 'panel_download', 1, NULL, NULL),
       (79, 'panel_tutorial', 1, NULL, NULL),
       (80, 'panel_transcript', 1, NULL, NULL),
       (81, 'panel_profile', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) DEFAULT NULL,
    `description` longtext     DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191)  NOT NULL,
    `point`      decimal(5, 2) NOT NULL,
    `min_mark`   decimal(5, 2) NOT NULL,
    `max_mark`   decimal(5, 2) NOT NULL,
    `remark`     text DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `title`, `point`, `min_mark`, `max_mark`, `remark`, `status`, `created_at`, `updated_at`)
VALUES (1, 'A', '5.00', '80.00', '100.00', NULL, 1, NULL, NULL),
       (2, 'B', '4.00', '70.00', '79.99', NULL, 1, NULL, NULL),
       (3, 'C', '3.00', '60.00', '69.99', NULL, 1, NULL, NULL),
       (4, 'D', '2.00', '50.00', '59.99', NULL, 1, NULL, NULL),
       (5, 'E', '1.00', '40.00', '49.99', NULL, 1, NULL, NULL),
       (6, 'F', '0.00', '0.00', '39.99', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels`
(
    `id`             int(10) UNSIGNED NOT NULL,
    `name`           varchar(191) NOT NULL,
    `type`           tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 Boys, 2 Girls, 3 Staff, 4 Combain',
    `capacity`       varchar(191) DEFAULT NULL,
    `warden_name`    varchar(191) DEFAULT NULL,
    `warden_contact` text         DEFAULT NULL,
    `address`        text         DEFAULT NULL,
    `note`           text         DEFAULT NULL,
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_members`
--

CREATE TABLE `hostel_members`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `hostelable_type` varchar(191) NOT NULL,
    `hostelable_id`   bigint(20) UNSIGNED NOT NULL,
    `hostel_room_id`  int(10) UNSIGNED NOT NULL,
    `start_date`      date DEFAULT NULL,
    `end_date`        date DEFAULT NULL,
    `note`            text DEFAULT NULL,
    `status`          tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active',
    `created_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_rooms`
--

CREATE TABLE `hostel_rooms`
(
    `id`           int(10) UNSIGNED NOT NULL,
    `name`         varchar(191) NOT NULL,
    `hostel_id`    int(10) UNSIGNED NOT NULL,
    `room_type_id` int(10) UNSIGNED NOT NULL,
    `bed`          int(11) NOT NULL DEFAULT 1,
    `fee` double(10,2) DEFAULT NULL,
    `description`  text DEFAULT NULL,
    `status`       tinyint(1) NOT NULL DEFAULT 1,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_room_types`
--

CREATE TABLE `hostel_room_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `fee` double(10,2) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `id_card_settings`
--

CREATE TABLE `id_card_settings`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `slug`          varchar(191) NOT NULL,
    `title`         varchar(191) DEFAULT NULL,
    `subtitle`      varchar(191) DEFAULT NULL,
    `logo`          text         DEFAULT NULL,
    `background`    text         DEFAULT NULL,
    `website_url`   varchar(191) DEFAULT NULL,
    `validity`      varchar(191) DEFAULT NULL,
    `address`       text         DEFAULT NULL,
    `prefix`        varchar(191) DEFAULT NULL,
    `student_photo` tinyint(1) NOT NULL DEFAULT 0,
    `signature`     tinyint(1) NOT NULL DEFAULT 0,
    `barcode`       tinyint(1) NOT NULL DEFAULT 0,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `category_id`    int(10) UNSIGNED NOT NULL,
    `title`          varchar(191)   NOT NULL,
    `invoice_id`     varchar(191) DEFAULT NULL,
    `amount`         decimal(10, 2) NOT NULL,
    `date`           date           NOT NULL,
    `reference`      varchar(191) DEFAULT NULL,
    `payment_method` int(11) DEFAULT NULL,
    `note`           text         DEFAULT NULL,
    `attach`         text         DEFAULT NULL,
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_categories`
--

CREATE TABLE `income_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_returns`
--

CREATE TABLE `issue_returns`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `member_id`   bigint(20) UNSIGNED NOT NULL,
    `book_id`     bigint(20) UNSIGNED NOT NULL,
    `issue_date`  date DEFAULT NULL,
    `due_date`    date DEFAULT NULL,
    `return_date` date DEFAULT NULL,
    `penalty` double(10,2) DEFAULT NULL,
    `status`      tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Lost, 1 Issued, 2 Returned',
    `issued_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `received_by` bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `name`          varchar(191) NOT NULL,
    `category_id`   int(10) UNSIGNED NOT NULL,
    `unit`          varchar(191) DEFAULT NULL,
    `serial_number` varchar(191) DEFAULT NULL,
    `quantity`      int(11) NOT NULL DEFAULT 0,
    `description`   longtext     DEFAULT NULL,
    `attach`        text         DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_issues`
--

CREATE TABLE `item_issues`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `item_id`     int(10) UNSIGNED NOT NULL,
    `user_id`     bigint(20) UNSIGNED NOT NULL,
    `quantity`    int(11) NOT NULL DEFAULT 1,
    `issue_date`  date DEFAULT NULL,
    `due_date`    date DEFAULT NULL,
    `return_date` date DEFAULT NULL,
    `penalty` double(10,2) DEFAULT NULL,
    `note`        text DEFAULT NULL,
    `attach`      text DEFAULT NULL,
    `status`      tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Lost, 1 Issued, 2 Returned',
    `issued_by`   bigint(20) UNSIGNED DEFAULT NULL,
    `received_by` bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_stocks`
--

CREATE TABLE `item_stocks`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `item_id`        int(10) UNSIGNED NOT NULL,
    `supplier_id`    int(10) UNSIGNED NOT NULL,
    `store_id`       int(10) UNSIGNED NOT NULL,
    `quantity`       int(11) NOT NULL DEFAULT 1,
    `price`          decimal(10, 2) DEFAULT NULL,
    `date`           date NOT NULL,
    `reference`      varchar(191)   DEFAULT NULL,
    `payment_method` int(11) DEFAULT NULL,
    `description`    text           DEFAULT NULL,
    `attach`         text           DEFAULT NULL,
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_stores`
--

CREATE TABLE `item_stores`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `store_no`   varchar(191) NOT NULL,
    `in_charge`  varchar(191) DEFAULT NULL,
    `email`      varchar(191) DEFAULT NULL,
    `phone`      varchar(191) DEFAULT NULL,
    `address`    text         DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_suppliers`
--

CREATE TABLE `item_suppliers`
(
    `id`                   int(10) UNSIGNED NOT NULL,
    `title`                varchar(191) NOT NULL,
    `email`                varchar(191) DEFAULT NULL,
    `phone`                varchar(191) DEFAULT NULL,
    `address`              text         DEFAULT NULL,
    `contact_person`       varchar(191) DEFAULT NULL,
    `designation`          varchar(191) DEFAULT NULL,
    `contact_person_email` varchar(191) DEFAULT NULL,
    `contact_person_phone` varchar(191) DEFAULT NULL,
    `description`          text         DEFAULT NULL,
    `status`               tinyint(1) NOT NULL DEFAULT 1,
    `created_at`           timestamp NULL DEFAULT NULL,
    `updated_at`           timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs`
(
    `id`           bigint(20) UNSIGNED NOT NULL,
    `queue`        varchar(191) NOT NULL,
    `payload`      longtext     NOT NULL,
    `attempts`     tinyint(3) UNSIGNED NOT NULL,
    `reserved_at`  int(10) UNSIGNED DEFAULT NULL,
    `available_at` int(10) UNSIGNED NOT NULL,
    `created_at`   int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `name`        varchar(191) NOT NULL,
    `code`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `direction`   tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 LTR, 1 RTL',
    `default`     tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Not Default, 1 Default',
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `description`, `direction`, `default`, `status`, `created_at`,
                         `updated_at`)
VALUES (1, 'English', 'en', NULL, 0, 1, 1, '2024-09-30 11:34:15', '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `type_id`    int(10) UNSIGNED NOT NULL,
    `user_id`    bigint(20) UNSIGNED NOT NULL,
    `review_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `apply_date` date NOT NULL,
    `from_date`  date NOT NULL,
    `to_date`    date NOT NULL,
    `reason`     text DEFAULT NULL,
    `attach`     text DEFAULT NULL,
    `note`       text DEFAULT NULL,
    `pay_type`   tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Paid & 2 Unpaid',
    `status`     tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 Pending, 1 Approved and 2 Rejected',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `limit`       int(11) NOT NULL DEFAULT 0,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `title`, `slug`, `limit`, `description`, `status`, `created_at`, `updated_at`)
VALUES (1, 'Casual Leave', 'casual-leave', 0, NULL, 1, NULL, NULL),
       (2, 'Sick Leave', 'sick-leave', 0, NULL, 1, NULL, NULL),
       (3, 'Maternity Leave', 'maternity-leave', 0, NULL, 1, NULL, NULL),
       (4, 'Marriage Leave', 'marriage-leave', 0, NULL, 1, NULL, NULL),
       (5, 'Bereavement Leave', 'bereavement-leave', 0, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `library_members`
--

CREATE TABLE `library_members`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `memberable_type` varchar(191) NOT NULL,
    `memberable_id`   bigint(20) UNSIGNED NOT NULL,
    `library_id`      varchar(191) NOT NULL,
    `date`            date         NOT NULL,
    `status`          tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active',
    `created_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings`
(
    `id`           int(10) UNSIGNED NOT NULL,
    `driver`       varchar(191) NOT NULL,
    `host`         varchar(191) NOT NULL,
    `port`         varchar(191) NOT NULL,
    `username`     varchar(191) NOT NULL,
    `password`     varchar(191) NOT NULL,
    `encryption`   varchar(191) NOT NULL,
    `sender_email` varchar(191) DEFAULT NULL,
    `sender_name`  varchar(191) DEFAULT NULL,
    `reply_email`  varchar(191) DEFAULT NULL,
    `status`       tinyint(1) NOT NULL DEFAULT 1,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_settings`
--

INSERT INTO `mail_settings` (`id`, `driver`, `host`, `port`, `username`, `password`, `encryption`, `sender_email`,
                             `sender_name`, `reply_email`, `status`, `created_at`, `updated_at`)
VALUES (1, 'smtp', 'smtp.mailtrap.io', '2525', '5b1c119ce5a400', 'e177cd2e8894b5', 'tls', 'info@mail.com',
        'Info Company', 'info@mail.com', 1, '2024-09-30 11:34:15', '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_settings`
--

CREATE TABLE `marksheet_settings`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `title`         varchar(191) NOT NULL,
    `header_left`   text                  DEFAULT NULL,
    `header_center` text                  DEFAULT NULL,
    `header_right`  text                  DEFAULT NULL,
    `body`          longtext              DEFAULT NULL,
    `footer_left`   text                  DEFAULT NULL,
    `footer_center` text                  DEFAULT NULL,
    `footer_right`  text                  DEFAULT NULL,
    `logo_left`     text                  DEFAULT NULL,
    `logo_right`    text                  DEFAULT NULL,
    `background`    text                  DEFAULT NULL,
    `width`         varchar(191) NOT NULL DEFAULT 'auto',
    `height`        varchar(191) NOT NULL DEFAULT 'auto',
    `student_photo` tinyint(1) NOT NULL DEFAULT 0,
    `barcode`       tinyint(1) NOT NULL DEFAULT 0,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_schedules`
--

CREATE TABLE `meeting_schedules`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `type_id`     int(10) UNSIGNED NOT NULL,
    `user_id`     int(10) UNSIGNED DEFAULT NULL,
    `name`        varchar(191) NOT NULL,
    `father_name` varchar(191) DEFAULT NULL,
    `phone`       varchar(191) DEFAULT NULL,
    `email`       varchar(191) DEFAULT NULL,
    `address`     text         DEFAULT NULL,
    `purpose`     text         DEFAULT NULL,
    `note`        text         DEFAULT NULL,
    `id_no`       varchar(191) DEFAULT NULL,
    `token`       varchar(191) DEFAULT NULL,
    `date`        date         NOT NULL,
    `in_time`     time         DEFAULT NULL,
    `out_time`    time         DEFAULT NULL,
    `persons`     varchar(191) DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Canceled, 1 Pending, 2 Progress, 3 Finished',
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_types`
--

CREATE TABLE `meeting_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations`
(
    `id`        int(10) UNSIGNED NOT NULL,
    `migration` varchar(191) NOT NULL,
    `batch`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (1, '2014_10_12_000000_create_users_table', 1),
       (2, '2014_10_12_100000_create_password_resets_table', 1),
       (3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
       (4, '2021_06_04_092405_create_faculties_table', 1),
       (5, '2021_06_04_102314_create_programs_table', 1),
       (6, '2021_06_04_114619_create_batches_table', 1),
       (7, '2021_06_04_120154_create_sessions_table', 1),
       (8, '2021_06_04_131456_create_semesters_table', 1),
       (9, '2021_06_04_132856_create_sections_table', 1),
       (10, '2021_06_04_141432_create_class_rooms_table', 1),
       (11, '2021_06_05_121933_create_income_categories_table', 1),
       (12, '2021_06_05_125236_create_incomes_table', 1),
       (13, '2021_06_05_144224_create_expense_categories_table', 1),
       (14, '2021_06_05_150317_create_expenses_table', 1),
       (15, '2021_06_07_152605_create_subjects_table', 1),
       (16, '2021_06_07_155306_create_enroll_subjects_table', 1),
       (17, '2021_06_07_160042_create_enroll_subject_subject_table', 1),
       (18, '2021_06_08_102053_create_program_subject_table', 1),
       (19, '2021_06_08_105550_create_batch_program_table', 1),
       (20, '2021_06_08_125338_create_program_semester_table', 1),
       (21, '2021_06_08_125531_create_program_class_room_table', 1),
       (22, '2021_06_08_180439_create_program_session_table', 1),
       (23, '2021_06_08_182844_create_program_semester_sections_table', 1),
       (24, '2021_06_09_133442_create_class_routines_table', 1),
       (25, '2021_06_12_153215_create_departments_table', 1),
       (26, '2021_06_12_155411_create_designations_table', 1),
       (27, '2021_06_13_075755_create_leave_types_table', 1),
       (28, '2021_06_13_125451_create_leaves_table', 1),
       (29, '2021_06_13_173512_create_work_shift_types_table', 1),
       (30, '2021_06_13_175400_create_tax_settings_table', 1),
       (31, '2021_06_13_193417_create_user_program_table', 1),
       (32, '2021_06_15_184223_create_staff_attendances_table', 1),
       (33, '2021_06_16_180912_create_staff_hourly_attendances_table', 1),
       (34, '2021_06_17_083411_create_payrolls_table', 1),
       (35, '2021_06_17_183706_create_payroll_details_table', 1),
       (36, '2021_06_22_185503_create_jobs_table', 1),
       (37, '2021_07_04_172713_create_application_settings_table', 1),
       (38, '2021_07_06_121630_create_applications_table', 1),
       (39, '2021_07_07_081616_create_students_table', 1),
       (40, '2021_07_07_182329_create_student_relatives_table', 1),
       (41, '2021_07_07_190034_create_documents_table', 1),
       (42, '2021_07_07_192727_create_docables_table', 1),
       (43, '2021_07_08_054948_create_student_enrolls_table', 1),
       (44, '2021_07_08_172152_create_student_transfers_table', 1),
       (45, '2021_07_08_195650_create_transfer_creadits_table', 1),
       (46, '2021_07_09_061940_create_status_types_table', 1),
       (47, '2021_07_09_092958_create_status_type_student_table', 1),
       (48, '2021_07_09_163443_create_student_enroll_subject_table', 1),
       (49, '2021_07_09_173413_create_student_leaves_table', 1),
       (50, '2021_07_09_194126_create_student_attendances_table', 1),
       (51, '2021_07_17_160726_create_events_table', 1),
       (52, '2021_07_18_074323_create_notice_categories_table', 1),
       (53, '2021_07_18_080209_create_notices_table', 1),
       (54, '2021_07_18_105550_create_noticeables_table', 1),
       (55, '2021_07_19_182908_create_email_notifies_table', 1),
       (56, '2021_07_19_200327_create_s_m_s_notifies_table', 1),
       (57, '2021_09_01_070002_create_exam_types_table', 1),
       (58, '2021_09_01_071547_create_result_contributions_table', 1),
       (59, '2021_09_01_084615_create_grades_table', 1),
       (60, '2021_09_02_184433_create_exams_table', 1),
       (61, '2021_09_04_101915_create_subject_markings_table', 1),
       (62, '2021_09_27_183257_create_certificate_templates_table', 1),
       (63, '2021_10_01_163600_create_certificates_table', 1),
       (64, '2021_10_15_182241_create_marksheet_settings_table', 1),
       (65, '2022_01_21_142336_create_print_settings_table', 1),
       (66, '2022_01_21_170648_create_visit_purposes_table', 1),
       (67, '2022_01_21_171901_create_visitors_table', 1),
       (68, '2022_01_21_185105_create_postal_exchange_types_table', 1),
       (69, '2022_01_21_185152_create_postal_exchanges_table', 1),
       (70, '2022_01_21_185201_create_phone_logs_table', 1),
       (71, '2022_01_22_103339_create_complain_types_table', 1),
       (72, '2022_01_22_103551_create_complain_sources_table', 1),
       (73, '2022_01_22_103657_create_complains_table', 1),
       (74, '2022_01_23_103439_create_enquiry_sources_table', 1),
       (75, '2022_01_23_110653_create_enquiry_references_table', 1),
       (76, '2022_01_23_114509_create_enquiries_table', 1),
       (77, '2022_01_23_192650_create_meeting_types_table', 1),
       (78, '2022_01_23_202252_create_meeting_schedules_table', 1),
       (79, '2022_01_24_174515_create_assignments_table', 1),
       (80, '2022_01_24_179252_create_student_assignments_table', 1),
       (81, '2022_01_24_181419_create_content_types_table', 1),
       (82, '2022_01_25_165931_create_contents_table', 1),
       (83, '2022_01_26_105511_create_contentables_table', 1),
       (84, '2022_01_27_100200_create_notifications_table', 1),
       (85, '2022_01_28_131433_create_book_categories_table', 1),
       (86, '2022_01_28_173902_create_books_table', 1),
       (87, '2022_01_28_195224_create_book_requests_table', 1),
       (88, '2022_01_29_045003_create_outside_users_table', 1),
       (89, '2022_01_29_045120_create_library_members_table', 1),
       (90, '2022_01_29_093915_create_issue_returns_table', 1),
       (91, '2022_01_31_061950_create_notes_table', 1),
       (92, '2022_02_15_173515_create_fees_categories_table', 1),
       (93, '2022_02_15_182124_create_fees_masters_table', 1),
       (94, '2022_02_16_100327_create_fees_master_student_enroll', 1),
       (95, '2022_02_26_184930_create_fees_fines_table', 1),
       (96, '2022_02_26_191642_create_fees_category_fees_fine_table', 1),
       (97, '2022_03_04_172257_create_fees_discounts_table', 1),
       (98, '2022_03_05_132058_create_fees_category_fees_discount_table', 1),
       (99, '2022_03_05_132541_create_fees_discount_status_type_table', 1),
       (100, '2022_03_05_195051_create_fees_table', 1),
       (101, '2022_03_05_203440_create_transactions_table', 1),
       (102, '2022_03_10_131324_create_exam_routines_table', 1),
       (103, '2022_03_10_131936_create_exam_routine_user_table', 1),
       (104, '2022_03_10_132124_create_exam_routine_room_table', 1),
       (105, '2022_03_31_074913_create_id_card_settings_table', 1),
       (106, '2022_04_01_125726_create_settings_table', 1),
       (107, '2022_04_01_210417_create_languages_table', 1),
       (108, '2022_04_02_144303_create_permission_tables', 1),
       (109, '2022_04_03_103141_create_mail_settings_table', 1),
       (110, '2022_04_03_173021_create_s_m_s_settings_table', 1),
       (111, '2022_04_03_174009_create_schedule_settings_table', 1),
       (112, '2022_04_04_123222_create_provinces_table', 1),
       (113, '2022_04_04_173222_create_districts_table', 1),
       (114, '2022_11_20_171503_create_item_categories_table', 1),
       (115, '2022_11_20_182303_create_item_stores_table', 1),
       (116, '2022_11_20_185841_create_item_suppliers_table', 1),
       (117, '2022_11_21_190954_create_items_table', 1),
       (118, '2022_11_21_194218_create_item_stocks_table', 1),
       (119, '2022_11_21_200834_create_item_issues_table', 1),
       (120, '2022_12_08_140339_create_hostel_room_types_table', 1),
       (121, '2022_12_08_193208_create_hostels_table', 1),
       (122, '2022_12_10_203126_create_hostel_rooms_table', 1),
       (123, '2022_12_14_181050_create_hostel_members_table', 1),
       (124, '2022_12_22_112935_create_transport_routes_table', 1),
       (125, '2022_12_23_110116_create_transport_vehicles_table', 1),
       (126, '2022_12_23_112400_create_transport_route_transport_vehicle_table', 1),
       (127, '2022_12_24_121402_create_transport_members_table', 1),
       (128, '2022_12_29_173356_add_fields_to_tables', 1),
       (129, '2023_08_12_153552_add_fields_v3_to_table', 1),
       (130, '2023_08_12_174813_create_fields_table', 1),
       (131, '2023_08_15_010030_create_topbar_settings_table', 1),
       (132, '2023_08_15_010553_create_social_settings_table', 1),
       (133, '2023_08_15_025440_create_sliders_table', 1),
       (134, '2023_08_15_034340_create_features_table', 1),
       (135, '2023_08_15_043734_create_about_us_table', 1),
       (136, '2023_08_15_112651_create_faqs_table', 1),
       (137, '2023_08_15_115731_create_testimonials_table', 1),
       (138, '2023_08_15_121544_create_call_to_actions_table', 1),
       (139, '2023_08_16_172019_create_galleries_table', 1),
       (140, '2023_08_16_172620_create_courses_table', 1),
       (141, '2023_08_16_173224_create_web_events_table', 1),
       (142, '2023_08_16_173331_create_news_table', 1),
       (143, '2023_08_23_142818_create_pages_table', 1),
       (144, '2024_07_12_150232_create_failed_jobs_table', 1),
       (145, '2024_08_29_170852_add_fields_v4_to_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions`
(
    `permission_id` bigint(20) UNSIGNED NOT NULL,
    `model_type`    varchar(191) NOT NULL,
    `model_id`      bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles`
(
    `role_id`    bigint(20) UNSIGNED NOT NULL,
    `model_type` varchar(191) NOT NULL,
    `model_id`   bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES (1, 'App\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news`
(
    `id`               int(10) UNSIGNED NOT NULL,
    `language_id`      int(10) UNSIGNED NOT NULL,
    `title`            varchar(191) NOT NULL,
    `slug`             varchar(191) NOT NULL,
    `date`             date         NOT NULL,
    `description`      longtext     NOT NULL,
    `meta_title`       varchar(191) DEFAULT NULL,
    `meta_description` text         DEFAULT NULL,
    `attach`           text         DEFAULT NULL,
    `status`           tinyint(1) NOT NULL DEFAULT 1,
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `noteable_type` varchar(191) NOT NULL,
    `noteable_id`   bigint(20) UNSIGNED NOT NULL,
    `title`         varchar(191) NOT NULL,
    `description`   longtext DEFAULT NULL,
    `attach`        text     DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `noticeables`
--

CREATE TABLE `noticeables`
(
    `notice_id`       bigint(20) NOT NULL,
    `noticeable_id`   bigint(20) NOT NULL,
    `noticeable_type` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `faculty_id`  int(10) UNSIGNED DEFAULT NULL,
    `program_id`  int(10) UNSIGNED DEFAULT NULL,
    `session_id`  int(10) UNSIGNED DEFAULT NULL,
    `semester_id` int(10) UNSIGNED DEFAULT NULL,
    `section_id`  int(10) UNSIGNED DEFAULT NULL,
    `category_id` int(10) UNSIGNED NOT NULL,
    `notice_no`   varchar(191) NOT NULL,
    `title`       varchar(191) NOT NULL,
    `description` longtext DEFAULT NULL,
    `date`        date         NOT NULL,
    `attach`      text     DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice_categories`
--

CREATE TABLE `notice_categories`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications`
(
    `id`              char(36)     NOT NULL,
    `type`            varchar(191) NOT NULL,
    `notifiable_type` varchar(191) NOT NULL,
    `notifiable_id`   bigint(20) UNSIGNED NOT NULL,
    `data`            text         NOT NULL,
    `read_at`         timestamp NULL DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outside_users`
--

CREATE TABLE `outside_users`
(
    `id`                 bigint(20) UNSIGNED NOT NULL,
    `first_name`         varchar(191) NOT NULL,
    `last_name`          varchar(191) NOT NULL,
    `father_name`        varchar(191) DEFAULT NULL,
    `mother_name`        varchar(191) DEFAULT NULL,
    `father_occupation`  varchar(191) DEFAULT NULL,
    `mother_occupation`  varchar(191) DEFAULT NULL,
    `father_photo`       text         DEFAULT NULL,
    `mother_photo`       text         DEFAULT NULL,
    `email`              varchar(191) DEFAULT NULL,
    `phone`              varchar(191) DEFAULT NULL,
    `country`            varchar(191) DEFAULT NULL,
    `present_province`   int(10) UNSIGNED DEFAULT NULL,
    `present_district`   int(10) UNSIGNED DEFAULT NULL,
    `present_village`    text         DEFAULT NULL,
    `present_address`    text         DEFAULT NULL,
    `permanent_province` int(10) UNSIGNED DEFAULT NULL,
    `permanent_district` int(10) UNSIGNED DEFAULT NULL,
    `permanent_village`  text         DEFAULT NULL,
    `permanent_address`  text         DEFAULT NULL,
    `education_level`    varchar(191) DEFAULT NULL,
    `occupation`         varchar(191) DEFAULT NULL,
    `gender`             tinyint(4) NOT NULL COMMENT '1 Male, 2 Female & 3 Other',
    `dob`                date         NOT NULL,
    `religion`           varchar(191) DEFAULT NULL,
    `caste`              varchar(191) DEFAULT NULL,
    `mother_tongue`      varchar(191) DEFAULT NULL,
    `marital_status`     tinyint(4) DEFAULT NULL,
    `blood_group`        tinyint(4) DEFAULT NULL,
    `nationality`        varchar(191) DEFAULT NULL,
    `national_id`        varchar(191) DEFAULT NULL,
    `passport_no`        varchar(191) DEFAULT NULL,
    `photo`              text         DEFAULT NULL,
    `signature`          text         DEFAULT NULL,
    `status`             tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active',
    `created_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`         timestamp NULL DEFAULT NULL,
    `updated_at`         timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages`
(
    `id`               int(10) UNSIGNED NOT NULL,
    `language_id`      int(10) UNSIGNED NOT NULL,
    `title`            varchar(191) NOT NULL,
    `slug`             varchar(191) NOT NULL,
    `description`      longtext     NOT NULL,
    `meta_title`       varchar(191) DEFAULT NULL,
    `meta_description` text         DEFAULT NULL,
    `attach`           text         DEFAULT NULL,
    `status`           tinyint(1) NOT NULL DEFAULT 1,
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets`
(
    `email`      varchar(191) NOT NULL,
    `token`      varchar(191) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `user_id`        bigint(20) UNSIGNED NOT NULL,
    `basic_salary` double(10,2) NOT NULL DEFAULT 0.00,
    `salary_type`    tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Fixed & 2 Hourly',
    `total_earning` double(10,2) NOT NULL,
    `total_allowance` double(10,2) NOT NULL DEFAULT 0.00,
    `bonus` double(10,2) NOT NULL DEFAULT 0.00,
    `total_deduction` double(10,2) NOT NULL DEFAULT 0.00,
    `gross_salary` double(10,2) NOT NULL,
    `tax` double(10,2) NOT NULL DEFAULT 0.00,
    `net_salary` double(10,2) NOT NULL,
    `salary_month`   date NOT NULL,
    `pay_date`       date DEFAULT NULL,
    `payment_method` int(11) DEFAULT NULL,
    `note`           text DEFAULT NULL,
    `status`         tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 Unpaid, 1 Paid',
    `created_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_details`
--

CREATE TABLE `payroll_details`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `payroll_id` bigint(20) UNSIGNED NOT NULL,
    `title`      varchar(191)            DEFAULT NULL,
    `amount`     decimal(10, 2) NOT NULL DEFAULT 0.00,
    `status`     tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Deduction, 1 Allowance',
    `created_by` bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `name`       varchar(191) NOT NULL,
    `group`      varchar(191) NOT NULL,
    `title`      varchar(191) NOT NULL,
    `guard_name` varchar(191) NOT NULL DEFAULT 'web',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `title`, `guard_name`, `created_at`, `updated_at`)
VALUES (1, 'application-view', 'Application', 'View', 'web', NULL, NULL),
       (2, 'application-create', 'Application', 'Admission', 'web', NULL, NULL),
       (3, 'application-edit', 'Application', 'Action', 'web', NULL, NULL),
       (4, 'application-delete', 'Application', 'Delete', 'web', NULL, NULL),
       (5, 'student-view', 'Student', 'View', 'web', NULL, NULL),
       (6, 'student-create', 'Student', 'Create', 'web', NULL, NULL),
       (7, 'student-edit', 'Student', 'Edit', 'web', NULL, NULL),
       (8, 'student-delete', 'Student', 'Delete', 'web', NULL, NULL),
       (9, 'student-import', 'Student', 'Import', 'web', NULL, NULL),
       (10, 'student-password-print', 'Student', 'Password Print', 'web', NULL, NULL),
       (11, 'student-password-change', 'Student', 'Password Change', 'web', NULL, NULL),
       (12, 'student-card', 'Student', 'ID Card', 'web', NULL, NULL),
       (13, 'id-card-setting-view', 'ID Card', 'Setting', 'web', NULL, NULL),
       (14, 'student-transfer-in-view', 'Transfer In', 'View', 'web', NULL, NULL),
       (15, 'student-transfer-in-create', 'Transfer In', 'Transfer', 'web', NULL, NULL),
       (16, 'student-transfer-in-edit', 'Transfer In', 'Edit', 'web', NULL, NULL),
       (17, 'student-transfer-out-view', 'Transfer Out', 'View', 'web', NULL, NULL),
       (18, 'student-transfer-out-create', 'Transfer Out', 'Transfer', 'web', NULL, NULL),
       (19, 'student-transfer-out-edit', 'Transfer Out', 'Edit', 'web', NULL, NULL),
       (20, 'status-type-view', 'Status Type', 'View', 'web', NULL, NULL),
       (21, 'status-type-create', 'Status Type', 'Create', 'web', NULL, NULL),
       (22, 'status-type-edit', 'Status Type', 'Edit', 'web', NULL, NULL),
       (23, 'status-type-delete', 'Status Type', 'Delete', 'web', NULL, NULL),
       (24, 'student-attendance-action', 'Student Attendance', 'Manage', 'web', NULL, NULL),
       (25, 'student-attendance-report', 'Student Attendance', 'Report', 'web', NULL, NULL),
       (26, 'student-attendance-import', 'Student Attendance', 'Import', 'web', NULL, NULL),
       (27, 'student-leave-manage-view', 'Student Leave', 'View', 'web', NULL, NULL),
       (28, 'student-leave-manage-edit', 'Student Leave', 'Action', 'web', NULL, NULL),
       (29, 'student-leave-manage-delete', 'Student Leave', 'Delete', 'web', NULL, NULL),
       (30, 'student-note-view', 'Student Note', 'View', 'web', NULL, NULL),
       (31, 'student-note-create', 'Student Note', 'Create', 'web', NULL, NULL),
       (32, 'student-note-edit', 'Student Note', 'Edit', 'web', NULL, NULL),
       (33, 'student-note-delete', 'Student Note', 'Delete', 'web', NULL, NULL),
       (34, 'student-enroll-single', 'Enrollments', 'Single Enroll', 'web', NULL, NULL),
       (35, 'student-enroll-group', 'Enrollments', 'Group Enroll', 'web', NULL, NULL),
       (36, 'student-enroll-adddrop', 'Enrollments', 'Course Add Drop', 'web', NULL, NULL),
       (37, 'student-enroll-complete', 'Enrollments', 'Course Graduation', 'web', NULL, NULL),
       (38, 'student-enroll-alumni', 'Enrollments', 'Alumni List', 'web', NULL, NULL),
       (39, 'faculty-view', 'Faculty', 'View', 'web', NULL, NULL),
       (40, 'faculty-create', 'Faculty', 'Create', 'web', NULL, NULL),
       (41, 'faculty-edit', 'Faculty', 'Edit', 'web', NULL, NULL),
       (42, 'faculty-delete', 'Faculty', 'Delete', 'web', NULL, NULL),
       (43, 'program-view', 'Program', 'View', 'web', NULL, NULL),
       (44, 'program-create', 'Program', 'Create', 'web', NULL, NULL),
       (45, 'program-edit', 'Program', 'Edit', 'web', NULL, NULL),
       (46, 'program-delete', 'Program', 'Delete', 'web', NULL, NULL),
       (47, 'batch-view', 'Batch', 'View', 'web', NULL, NULL),
       (48, 'batch-create', 'Batch', 'Create', 'web', NULL, NULL),
       (49, 'batch-edit', 'Batch', 'Edit', 'web', NULL, NULL),
       (50, 'batch-delete', 'Batch', 'Delete', 'web', NULL, NULL),
       (51, 'session-view', 'Session', 'View', 'web', NULL, NULL),
       (52, 'session-create', 'Session', 'Create', 'web', NULL, NULL),
       (53, 'session-edit', 'Session', 'Edit', 'web', NULL, NULL),
       (54, 'session-delete', 'Session', 'Delete', 'web', NULL, NULL),
       (55, 'semester-view', 'Semester', 'View', 'web', NULL, NULL),
       (56, 'semester-create', 'Semester', 'Create', 'web', NULL, NULL),
       (57, 'semester-edit', 'Semester', 'Edit', 'web', NULL, NULL),
       (58, 'semester-delete', 'Semester', 'Delete', 'web', NULL, NULL),
       (59, 'section-view', 'Section', 'View', 'web', NULL, NULL),
       (60, 'section-create', 'Section', 'Create', 'web', NULL, NULL),
       (61, 'section-edit', 'Section', 'Edit', 'web', NULL, NULL),
       (62, 'section-delete', 'Section', 'Delete', 'web', NULL, NULL),
       (63, 'class-room-view', 'Class Room', 'View', 'web', NULL, NULL),
       (64, 'class-room-create', 'Class Room', 'Create', 'web', NULL, NULL),
       (65, 'class-room-edit', 'Class Room', 'Edit', 'web', NULL, NULL),
       (66, 'class-room-delete', 'Class Room', 'Delete', 'web', NULL, NULL),
       (67, 'subject-view', 'Course', 'View', 'web', NULL, NULL),
       (68, 'subject-create', 'Course', 'Create', 'web', NULL, NULL),
       (69, 'subject-edit', 'Course', 'Edit', 'web', NULL, NULL),
       (70, 'subject-delete', 'Course', 'Delete', 'web', NULL, NULL),
       (71, 'subject-import', 'Course', 'Import', 'web', NULL, NULL),
       (72, 'enroll-subject-view', 'Enroll Course', 'View', 'web', NULL, NULL),
       (73, 'enroll-subject-create', 'Enroll Course', 'Create', 'web', NULL, NULL),
       (74, 'enroll-subject-edit', 'Enroll Course', 'Edit', 'web', NULL, NULL),
       (75, 'enroll-subject-delete', 'Enroll Course', 'Delete', 'web', NULL, NULL),
       (76, 'class-routine-view', 'Class Routine', 'View', 'web', NULL, NULL),
       (77, 'class-routine-create', 'Class Routine', 'Manage', 'web', NULL, NULL),
       (78, 'class-routine-print', 'Class Routine', 'Print', 'web', NULL, NULL),
       (79, 'class-routine-teacher', 'Class Routine', 'Teacher', 'web', NULL, NULL),
       (80, 'exam-routine-view', 'Exam Routine', 'View', 'web', NULL, NULL),
       (81, 'exam-routine-create', 'Exam Routine', 'Manage', 'web', NULL, NULL),
       (82, 'exam-routine-edit', 'Exam Routine', 'Edit', 'web', NULL, NULL),
       (83, 'exam-routine-delete', 'Exam Routine', 'Delete', 'web', NULL, NULL),
       (84, 'exam-routine-print', 'Exam Routine', 'Print', 'web', NULL, NULL),
       (85, 'routine-setting-class', 'Routine Setting', 'Class Routine', 'web', NULL, NULL),
       (86, 'routine-setting-exam', 'Routine Setting', 'Exam Routine', 'web', NULL, NULL),
       (87, 'exam-attendance', 'Exam', 'Attendance', 'web', NULL, NULL),
       (88, 'exam-marking', 'Exam', 'Mark Ledger', 'web', NULL, NULL),
       (89, 'exam-result', 'Exam', 'Result', 'web', NULL, NULL),
       (90, 'exam-import', 'Exam', 'Import', 'web', NULL, NULL),
       (91, 'subject-marking', 'Course Final', 'Mark Ledger', 'web', NULL, NULL),
       (92, 'subject-result', 'Course Final', 'Result', 'web', NULL, NULL),
       (93, 'grade-view', 'Grading System', 'View', 'web', NULL, NULL),
       (94, 'grade-create', 'Grading System', 'Create', 'web', NULL, NULL),
       (95, 'grade-edit', 'Grading System', 'Edit', 'web', NULL, NULL),
       (96, 'grade-delete', 'Grading System', 'Delete', 'web', NULL, NULL),
       (97, 'exam-type-view', 'Exam Type', 'View', 'web', NULL, NULL),
       (98, 'exam-type-create', 'Exam Type', 'Create', 'web', NULL, NULL),
       (99, 'exam-type-edit', 'Exam Type', 'Edit', 'web', NULL, NULL),
       (100, 'exam-type-delete', 'Exam Type', 'Delete', 'web', NULL, NULL),
       (101, 'admit-card-view', 'Admit Card', 'View', 'web', NULL, NULL),
       (102, 'admit-card-print', 'Admit Card', 'Print', 'web', NULL, NULL),
       (103, 'admit-card-download', 'Admit Card', 'Download', 'web', NULL, NULL),
       (104, 'admit-setting-view', 'Admit Card', 'Setting', 'web', NULL, NULL),
       (105, 'result-contribution-view', 'Mark Distribution', 'Setting', 'web', NULL, NULL),
       (106, 'assignment-view', 'Assignment', 'View', 'web', NULL, NULL),
       (107, 'assignment-create', 'Assignment', 'Create', 'web', NULL, NULL),
       (108, 'assignment-edit', 'Assignment', 'Edit', 'web', NULL, NULL),
       (109, 'assignment-delete', 'Assignment', 'Delete', 'web', NULL, NULL),
       (110, 'assignment-marking', 'Assignment', 'Mark Ledger', 'web', NULL, NULL),
       (111, 'content-view', 'Content', 'View', 'web', NULL, NULL),
       (112, 'content-create', 'Content', 'Create', 'web', NULL, NULL),
       (113, 'content-edit', 'Content', 'Edit', 'web', NULL, NULL),
       (114, 'content-delete', 'Content', 'Delete', 'web', NULL, NULL),
       (115, 'content-type-view', 'Content Type', 'View', 'web', NULL, NULL),
       (116, 'content-type-create', 'Content Type', 'Create', 'web', NULL, NULL),
       (117, 'content-type-edit', 'Content Type', 'Edit', 'web', NULL, NULL),
       (118, 'content-type-delete', 'Content Type', 'Delete', 'web', NULL, NULL),
       (119, 'fees-student-due', 'Student Fees', 'Fees Due', 'web', NULL, NULL),
       (120, 'fees-student-quick-assign', 'Student Fees', 'Quick Assign', 'web', NULL, NULL),
       (121, 'fees-student-quick-received', 'Student Fees', 'Quick Received', 'web', NULL, NULL),
       (122, 'fees-student-report', 'Student Fees', 'Report', 'web', NULL, NULL),
       (123, 'fees-student-action', 'Student Fees', 'Action', 'web', NULL, NULL),
       (124, 'fees-student-print', 'Student Fees', 'Print', 'web', NULL, NULL),
       (125, 'fees-receipt-view', 'Fees Receipt', 'Setting', 'web', NULL, NULL),
       (126, 'fees-master-create', 'Assign Fees', 'Manage', 'web', NULL, NULL),
       (127, 'fees-master-view', 'Assign Fees', 'Report', 'web', NULL, NULL),
       (128, 'fees-category-view', 'Fees Type', 'View', 'web', NULL, NULL),
       (129, 'fees-category-create', 'Fees Type', 'Create', 'web', NULL, NULL),
       (130, 'fees-category-edit', 'Fees Type', 'Edit', 'web', NULL, NULL),
       (131, 'fees-category-delete', 'Fees Type', 'Delete', 'web', NULL, NULL),
       (132, 'fees-discount-view', 'Fees Discount', 'View', 'web', NULL, NULL),
       (133, 'fees-discount-create', 'Fees Discount', 'Create', 'web', NULL, NULL),
       (134, 'fees-discount-edit', 'Fees Discount', 'Edit', 'web', NULL, NULL),
       (135, 'fees-discount-delete', 'Fees Discount', 'Delete', 'web', NULL, NULL),
       (136, 'fees-fine-view', 'Fees Fine', 'View', 'web', NULL, NULL),
       (137, 'fees-fine-create', 'Fees Fine', 'Create', 'web', NULL, NULL),
       (138, 'fees-fine-edit', 'Fees Fine', 'Edit', 'web', NULL, NULL),
       (139, 'fees-fine-delete', 'Fees Fine', 'Delete', 'web', NULL, NULL),
       (140, 'user-view', 'Staff List', 'View', 'web', NULL, NULL),
       (141, 'user-create', 'Staff List', 'Create', 'web', NULL, NULL),
       (142, 'user-edit', 'Staff List', 'Edit', 'web', NULL, NULL),
       (143, 'user-delete', 'Staff List', 'Delete', 'web', NULL, NULL),
       (144, 'user-import', 'Staff List', 'Import', 'web', NULL, NULL),
       (145, 'user-password-change', 'Staff List', 'Password Change', 'web', NULL, NULL),
       (146, 'staff-note-view', 'Staff Note', 'View', 'web', NULL, NULL),
       (147, 'staff-note-create', 'Staff Note', 'Create', 'web', NULL, NULL),
       (148, 'staff-note-edit', 'Staff Note', 'Edit', 'web', NULL, NULL),
       (149, 'staff-note-delete', 'Staff Note', 'Delete', 'web', NULL, NULL),
       (150, 'payroll-view', 'Payroll', 'View', 'web', NULL, NULL),
       (151, 'payroll-action', 'Payroll', 'Action', 'web', NULL, NULL),
       (152, 'payroll-report', 'Payroll', 'Report', 'web', NULL, NULL),
       (153, 'payroll-print', 'Payroll', 'Print', 'web', NULL, NULL),
       (154, 'pay-slip-setting-view', 'Pay Slip', 'Setting', 'web', NULL, NULL),
       (155, 'work-shift-type-view', 'Work Shift Type', 'View', 'web', NULL, NULL),
       (156, 'work-shift-type-create', 'Work Shift Type', 'Create', 'web', NULL, NULL),
       (157, 'work-shift-type-edit', 'Work Shift Type', 'Edit', 'web', NULL, NULL),
       (158, 'work-shift-type-delete', 'Work Shift Type', 'Delete', 'web', NULL, NULL),
       (159, 'tax-setting-view', 'Tax Setting', 'View', 'web', NULL, NULL),
       (160, 'tax-setting-create', 'Tax Setting', 'Create', 'web', NULL, NULL),
       (161, 'tax-setting-edit', 'Tax Setting', 'Edit', 'web', NULL, NULL),
       (162, 'tax-setting-delete', 'Tax Setting', 'Delete', 'web', NULL, NULL),
       (163, 'designation-view', 'Designation', 'View', 'web', NULL, NULL),
       (164, 'designation-create', 'Designation', 'Create', 'web', NULL, NULL),
       (165, 'designation-edit', 'Designation', 'Edit', 'web', NULL, NULL),
       (166, 'designation-delete', 'Designation', 'Delete', 'web', NULL, NULL),
       (167, 'department-view', 'Department', 'View', 'web', NULL, NULL),
       (168, 'department-create', 'Department', 'Create', 'web', NULL, NULL),
       (169, 'department-edit', 'Department', 'Edit', 'web', NULL, NULL),
       (170, 'department-delete', 'Department', 'Delete', 'web', NULL, NULL),
       (171, 'staff-daily-attendance-action', 'Staff Daily Attendance', 'Manage', 'web', NULL, NULL),
       (172, 'staff-daily-attendance-report', 'Staff Daily Attendance', 'Report', 'web', NULL, NULL),
       (173, 'staff-hourly-attendance-action', 'Staff Hourly Attendance', 'Manage', 'web', NULL, NULL),
       (174, 'staff-hourly-attendance-report', 'Staff Hourly Attendance', 'Report', 'web', NULL, NULL),
       (175, 'staff-leave-view', 'Staff Apply Leave', 'View', 'web', NULL, NULL),
       (176, 'staff-leave-create', 'Staff Apply Leave', 'Apply', 'web', NULL, NULL),
       (177, 'staff-leave-delete', 'Staff Apply Leave', 'Delete', 'web', NULL, NULL),
       (178, 'leave-type-view', 'Leave Type', 'View', 'web', NULL, NULL),
       (179, 'leave-type-create', 'Leave Type', 'Create', 'web', NULL, NULL),
       (180, 'leave-type-edit', 'Leave Type', 'Edit', 'web', NULL, NULL),
       (181, 'leave-type-delete', 'Leave Type', 'Delete', 'web', NULL, NULL),
       (182, 'staff-leave-manage-view', 'Staff Leave Manage', 'View', 'web', NULL, NULL),
       (183, 'staff-leave-manage-edit', 'Staff Leave Manage', 'Action', 'web', NULL, NULL),
       (184, 'staff-leave-manage-delete', 'Staff Leave Manage', 'Delete', 'web', NULL, NULL),
       (185, 'income-view', 'Income', 'View', 'web', NULL, NULL),
       (186, 'income-create', 'Income', 'Create', 'web', NULL, NULL),
       (187, 'income-edit', 'Income', 'Edit', 'web', NULL, NULL),
       (188, 'income-delete', 'Income', 'Delete', 'web', NULL, NULL),
       (189, 'income-category-view', 'Income Category', 'View', 'web', NULL, NULL),
       (190, 'income-category-create', 'Income Category', 'Create', 'web', NULL, NULL),
       (191, 'income-category-edit', 'Income Category', 'Edit', 'web', NULL, NULL),
       (192, 'income-category-delete', 'Income Category', 'Delete', 'web', NULL, NULL),
       (193, 'expense-view', 'Expense', 'View', 'web', NULL, NULL),
       (194, 'expense-create', 'Expense', 'Create', 'web', NULL, NULL),
       (195, 'expense-edit', 'Expense', 'Edit', 'web', NULL, NULL),
       (196, 'expense-delete', 'Expense', 'Delete', 'web', NULL, NULL),
       (197, 'expense-category-view', 'Expense Category', 'View', 'web', NULL, NULL),
       (198, 'expense-category-create', 'Expense Category', 'Create', 'web', NULL, NULL),
       (199, 'expense-category-edit', 'Expense Category', 'Edit', 'web', NULL, NULL),
       (200, 'expense-category-delete', 'Expense Category', 'Delete', 'web', NULL, NULL),
       (201, 'outcome-view', 'Outcome Overview', 'View', 'web', NULL, NULL),
       (202, 'email-notify-view', 'Send Email', 'View', 'web', NULL, NULL),
       (203, 'email-notify-create', 'Send Email', 'Send', 'web', NULL, NULL),
       (204, 'email-notify-delete', 'Send Email', 'Delete', 'web', NULL, NULL),
       (205, 'sms-notify-view', 'Send SMS', 'View', 'web', NULL, NULL),
       (206, 'sms-notify-create', 'Send SMS', 'Send', 'web', NULL, NULL),
       (207, 'sms-notify-delete', 'Send SMS', 'Delete', 'web', NULL, NULL),
       (208, 'event-view', 'Event', 'View', 'web', NULL, NULL),
       (209, 'event-create', 'Event', 'Create', 'web', NULL, NULL),
       (210, 'event-edit', 'Event', 'Edit', 'web', NULL, NULL),
       (211, 'event-delete', 'Event', 'Delete', 'web', NULL, NULL),
       (212, 'event-calendar', 'Event', 'Calendar', 'web', NULL, NULL),
       (213, 'notice-view', 'Notice List', 'View', 'web', NULL, NULL),
       (214, 'notice-create', 'Notice List', 'Create', 'web', NULL, NULL),
       (215, 'notice-edit', 'Notice List', 'Edit', 'web', NULL, NULL),
       (216, 'notice-delete', 'Notice List', 'Delete', 'web', NULL, NULL),
       (217, 'notice-category-view', 'Notice Category', 'View', 'web', NULL, NULL),
       (218, 'notice-category-create', 'Notice Category', 'Create', 'web', NULL, NULL),
       (219, 'notice-category-edit', 'Notice Category', 'Edit', 'web', NULL, NULL),
       (220, 'notice-category-delete', 'Notice Category', 'Delete', 'web', NULL, NULL),
       (221, 'book-issue-view', 'Issue Book', 'View', 'web', NULL, NULL),
       (222, 'book-issue-action', 'Issue Book', 'Action', 'web', NULL, NULL),
       (223, 'book-issue-delete', 'Issue Book', 'Delete', 'web', NULL, NULL),
       (224, 'library-member-view', 'Library Member', 'View', 'web', NULL, NULL),
       (225, 'library-member-create', 'Library Member', 'Create', 'web', NULL, NULL),
       (226, 'library-member-edit', 'Library Member', 'Edit', 'web', NULL, NULL),
       (227, 'library-member-delete', 'Library Member', 'Delete', 'web', NULL, NULL),
       (228, 'library-member-card', 'Library Member', 'Card Print', 'web', NULL, NULL),
       (229, 'library-card-setting-view', 'Library Card', 'Setting', 'web', NULL, NULL),
       (230, 'book-view', 'Book List', 'View', 'web', NULL, NULL),
       (231, 'book-create', 'Book List', 'Create', 'web', NULL, NULL),
       (232, 'book-edit', 'Book List', 'Edit', 'web', NULL, NULL),
       (233, 'book-delete', 'Book List', 'Delete', 'web', NULL, NULL),
       (234, 'book-import', 'Book List', 'Import', 'web', NULL, NULL),
       (235, 'book-print', 'Book List', 'Token Print', 'web', NULL, NULL),
       (236, 'book-request-view', 'Book Request', 'View', 'web', NULL, NULL),
       (237, 'book-request-create', 'Book Request', 'Create', 'web', NULL, NULL),
       (238, 'book-request-edit', 'Book Request', 'Edit', 'web', NULL, NULL),
       (239, 'book-request-delete', 'Book Request', 'Delete', 'web', NULL, NULL),
       (240, 'book-category-view', 'Book Category', 'View', 'web', NULL, NULL),
       (241, 'book-category-create', 'Book Category', 'Create', 'web', NULL, NULL),
       (242, 'book-category-edit', 'Book Category', 'Edit', 'web', NULL, NULL),
       (243, 'book-category-delete', 'Book Category', 'Delete', 'web', NULL, NULL),
       (244, 'item-issue-view', 'Issue Item', 'View', 'web', NULL, NULL),
       (245, 'item-issue-action', 'Issue Item', 'Action', 'web', NULL, NULL),
       (246, 'item-issue-delete', 'Issue Item', 'Delete', 'web', NULL, NULL),
       (247, 'item-stock-view', 'Item Stock', 'View', 'web', NULL, NULL),
       (248, 'item-stock-create', 'Item Stock', 'Create', 'web', NULL, NULL),
       (249, 'item-stock-edit', 'Item Stock', 'Edit', 'web', NULL, NULL),
       (250, 'item-stock-delete', 'Item Stock', 'Delete', 'web', NULL, NULL),
       (251, 'item-view', 'Item List', 'View', 'web', NULL, NULL),
       (252, 'item-create', 'Item List', 'Create', 'web', NULL, NULL),
       (253, 'item-edit', 'Item List', 'Edit', 'web', NULL, NULL),
       (254, 'item-delete', 'Item List', 'Delete', 'web', NULL, NULL),
       (255, 'item-store-view', 'Store', 'View', 'web', NULL, NULL),
       (256, 'item-store-create', 'Store', 'Create', 'web', NULL, NULL),
       (257, 'item-store-edit', 'Store', 'Edit', 'web', NULL, NULL),
       (258, 'item-store-delete', 'Store', 'Delete', 'web', NULL, NULL),
       (259, 'item-supplier-view', 'Supplier', 'View', 'web', NULL, NULL),
       (260, 'item-supplier-create', 'Supplier', 'Create', 'web', NULL, NULL),
       (261, 'item-supplier-edit', 'Supplier', 'Edit', 'web', NULL, NULL),
       (262, 'item-supplier-delete', 'Supplier', 'Delete', 'web', NULL, NULL),
       (263, 'item-category-view', 'Item Category', 'View', 'web', NULL, NULL),
       (264, 'item-category-create', 'Item Category', 'Create', 'web', NULL, NULL),
       (265, 'item-category-edit', 'Item Category', 'Edit', 'web', NULL, NULL),
       (266, 'item-category-delete', 'Item Category', 'Delete', 'web', NULL, NULL),
       (267, 'hostel-member-view', 'Hostel Member', 'View', 'web', NULL, NULL),
       (268, 'hostel-member-create', 'Hostel Member', 'Manage', 'web', NULL, NULL),
       (269, 'hostel-room-view', 'Hostel Room', 'View', 'web', NULL, NULL),
       (270, 'hostel-room-create', 'Hostel Room', 'Create', 'web', NULL, NULL),
       (271, 'hostel-room-edit', 'Hostel Room', 'Edit', 'web', NULL, NULL),
       (272, 'hostel-room-delete', 'Hostel Room', 'Delete', 'web', NULL, NULL),
       (273, 'hostel-view', 'Hostel', 'View', 'web', NULL, NULL),
       (274, 'hostel-create', 'Hostel', 'Create', 'web', NULL, NULL),
       (275, 'hostel-edit', 'Hostel', 'Edit', 'web', NULL, NULL),
       (276, 'hostel-delete', 'Hostel', 'Delete', 'web', NULL, NULL),
       (277, 'room-type-view', 'Room Type', 'View', 'web', NULL, NULL),
       (278, 'room-type-create', 'Room Type', 'Create', 'web', NULL, NULL),
       (279, 'room-type-edit', 'Room Type', 'Edit', 'web', NULL, NULL),
       (280, 'room-type-delete', 'Room Type', 'Delete', 'web', NULL, NULL),
       (281, 'transport-member-view', 'Transport Member', 'View', 'web', NULL, NULL),
       (282, 'transport-member-create', 'Transport Member', 'Manage', 'web', NULL, NULL),
       (283, 'transport-vehicle-view', 'Transport Vehicle', 'View', 'web', NULL, NULL),
       (284, 'transport-vehicle-create', 'Transport Vehicle', 'Create', 'web', NULL, NULL),
       (285, 'transport-vehicle-edit', 'Transport Vehicle', 'Edit', 'web', NULL, NULL),
       (286, 'transport-vehicle-delete', 'Transport Vehicle', 'Delete', 'web', NULL, NULL),
       (287, 'transport-route-view', 'Transport Route', 'View', 'web', NULL, NULL),
       (288, 'transport-route-create', 'Transport Route', 'Create', 'web', NULL, NULL),
       (289, 'transport-route-edit', 'Transport Route', 'Edit', 'web', NULL, NULL),
       (290, 'transport-route-delete', 'Transport Route', 'Delete', 'web', NULL, NULL),
       (291, 'visitor-view', 'Visitor', 'View', 'web', NULL, NULL),
       (292, 'visitor-create', 'Visitor', 'Create', 'web', NULL, NULL),
       (293, 'visitor-edit', 'Visitor', 'Edit', 'web', NULL, NULL),
       (294, 'visitor-delete', 'Visitor', 'Delete', 'web', NULL, NULL),
       (295, 'visitor-print', 'Visitor', 'Token Print', 'web', NULL, NULL),
       (296, 'visit-purpose-view', 'Visit Purpose', 'View', 'web', NULL, NULL),
       (297, 'visit-purpose-create', 'Visit Purpose', 'Create', 'web', NULL, NULL),
       (298, 'visit-purpose-edit', 'Visit Purpose', 'Edit', 'web', NULL, NULL),
       (299, 'visit-purpose-delete', 'Visit Purpose', 'Delete', 'web', NULL, NULL),
       (300, 'visitor-token-setting-view', 'Visitor Token', 'Setting', 'web', NULL, NULL),
       (301, 'phone-log-view', 'Phone Log', 'View', 'web', NULL, NULL),
       (302, 'phone-log-create', 'Phone Log', 'Create', 'web', NULL, NULL),
       (303, 'phone-log-edit', 'Phone Log', 'Edit', 'web', NULL, NULL),
       (304, 'phone-log-delete', 'Phone Log', 'Delete', 'web', NULL, NULL),
       (305, 'enquiry-view', 'Enquiry', 'View', 'web', NULL, NULL),
       (306, 'enquiry-create', 'Enquiry', 'Create', 'web', NULL, NULL),
       (307, 'enquiry-edit', 'Enquiry', 'Edit', 'web', NULL, NULL),
       (308, 'enquiry-delete', 'Enquiry', 'Delete', 'web', NULL, NULL),
       (309, 'enquiry-reference-view', 'Enquiry Reference', 'View', 'web', NULL, NULL),
       (310, 'enquiry-reference-create', 'Enquiry Reference', 'Create', 'web', NULL, NULL),
       (311, 'enquiry-reference-edit', 'Enquiry Reference', 'Edit', 'web', NULL, NULL),
       (312, 'enquiry-reference-delete', 'Enquiry Reference', 'Delete', 'web', NULL, NULL),
       (313, 'enquiry-source-view', 'Enquiry Source', 'View', 'web', NULL, NULL),
       (314, 'enquiry-source-create', 'Enquiry Source', 'Create', 'web', NULL, NULL),
       (315, 'enquiry-source-edit', 'Enquiry Source', 'Edit', 'web', NULL, NULL),
       (316, 'enquiry-source-delete', 'Enquiry Source', 'Delete', 'web', NULL, NULL),
       (317, 'complain-view', 'Complain', 'View', 'web', NULL, NULL),
       (318, 'complain-create', 'Complain', 'Create', 'web', NULL, NULL),
       (319, 'complain-edit', 'Complain', 'Edit', 'web', NULL, NULL),
       (320, 'complain-delete', 'Complain', 'Delete', 'web', NULL, NULL),
       (321, 'complain-type-view', 'Complain Type', 'View', 'web', NULL, NULL),
       (322, 'complain-type-create', 'Complain Type', 'Create', 'web', NULL, NULL),
       (323, 'complain-type-edit', 'Complain Type', 'Edit', 'web', NULL, NULL),
       (324, 'complain-type-delete', 'Complain Type', 'Delete', 'web', NULL, NULL),
       (325, 'complain-source-view', 'Complain Source', 'View', 'web', NULL, NULL),
       (326, 'complain-source-create', 'Complain Source', 'Create', 'web', NULL, NULL),
       (327, 'complain-source-edit', 'Complain Source', 'Edit', 'web', NULL, NULL),
       (328, 'complain-source-delete', 'Complain Source', 'Delete', 'web', NULL, NULL),
       (329, 'postal-exchange-view', 'Postal Exchange', 'View', 'web', NULL, NULL),
       (330, 'postal-exchange-create', 'Postal Exchange', 'Create', 'web', NULL, NULL),
       (331, 'postal-exchange-edit', 'Postal Exchange', 'Edit', 'web', NULL, NULL),
       (332, 'postal-exchange-delete', 'Postal Exchange', 'Delete', 'web', NULL, NULL),
       (333, 'postal-type-view', 'Postal Type', 'View', 'web', NULL, NULL),
       (334, 'postal-type-create', 'Postal Type', 'Create', 'web', NULL, NULL),
       (335, 'postal-type-edit', 'Postal Type', 'Edit', 'web', NULL, NULL),
       (336, 'postal-type-delete', 'Postal Type', 'Delete', 'web', NULL, NULL),
       (337, 'meeting-view', 'Meeting Schedule', 'View', 'web', NULL, NULL),
       (338, 'meeting-create', 'Meeting Schedule', 'Create', 'web', NULL, NULL),
       (339, 'meeting-edit', 'Meeting Schedule', 'Edit', 'web', NULL, NULL),
       (340, 'meeting-delete', 'Meeting Schedule', 'Delete', 'web', NULL, NULL),
       (341, 'meeting-type-view', 'Meeting Type', 'View', 'web', NULL, NULL),
       (342, 'meeting-type-create', 'Meeting Type', 'Create', 'web', NULL, NULL),
       (343, 'meeting-type-edit', 'Meeting Type', 'Edit', 'web', NULL, NULL),
       (344, 'meeting-type-delete', 'Meeting Type', 'Delete', 'web', NULL, NULL),
       (345, 'marksheet-view', 'Marksheet', 'View', 'web', NULL, NULL),
       (346, 'marksheet-print', 'Marksheet', 'Print', 'web', NULL, NULL),
       (347, 'marksheet-download', 'Marksheet', 'Download', 'web', NULL, NULL),
       (348, 'marksheet-setting-view', 'Marksheet', 'Setting', 'web', NULL, NULL),
       (349, 'certificate-view', 'Certificate', 'View', 'web', NULL, NULL),
       (350, 'certificate-create', 'Certificate', 'Genarate', 'web', NULL, NULL),
       (351, 'certificate-edit', 'Certificate', 'Edit', 'web', NULL, NULL),
       (352, 'certificate-print', 'Certificate', 'Print', 'web', NULL, NULL),
       (353, 'certificate-download', 'Certificate', 'Download', 'web', NULL, NULL),
       (354, 'certificate-template-view', 'Certificate Template', 'View', 'web', NULL, NULL),
       (355, 'certificate-template-create', 'Certificate Template', 'Create', 'web', NULL, NULL),
       (356, 'certificate-template-edit', 'Certificate Template', 'Edit', 'web', NULL, NULL),
       (357, 'certificate-template-delete', 'Certificate Template', 'Delete', 'web', NULL, NULL),
       (358, 'report-student-progress', 'Reports', 'Student Progress', 'web', NULL, NULL),
       (359, 'report-subject-students', 'Reports', 'Course Students', 'web', NULL, NULL),
       (360, 'report-student-attendance', 'Reports', 'Student Attendance', 'web', NULL, NULL),
       (361, 'report-subject-attendance', 'Reports', 'Subject Attendance', 'web', NULL, NULL),
       (362, 'report-collected-fees', 'Reports', 'Collected Fees', 'web', NULL, NULL),
       (363, 'report-student-fees', 'Reports', 'Student Fees', 'web', NULL, NULL),
       (364, 'report-salary-paid', 'Reports', 'Salary Paid', 'web', NULL, NULL),
       (365, 'report-staff-leaves', 'Reports', 'Staff Leaves', 'web', NULL, NULL),
       (366, 'report-income', 'Reports', 'Total Income', 'web', NULL, NULL),
       (367, 'report-expense', 'Reports', 'Total Expense', 'web', NULL, NULL),
       (368, 'report-library', 'Reports', 'Library History', 'web', NULL, NULL),
       (369, 'report-book-return', 'Reports', 'Book Return Due', 'web', NULL, NULL),
       (370, 'report-inventory', 'Reports', 'Inventory History', 'web', NULL, NULL),
       (371, 'report-hostel', 'Reports', 'Hostel Members', 'web', NULL, NULL),
       (372, 'report-transport', 'Reports', 'Transport Members', 'web', NULL, NULL),
       (373, 'topbar-setting-view', 'Contact Setting', 'Manage', 'web', NULL, NULL),
       (374, 'social-setting-view', 'Social Setting', 'Manage', 'web', NULL, NULL),
       (375, 'slider-view', 'Slider', 'View', 'web', NULL, NULL),
       (376, 'slider-create', 'Slider', 'Create', 'web', NULL, NULL),
       (377, 'slider-edit', 'Slider', 'Edit', 'web', NULL, NULL),
       (378, 'slider-delete', 'Slider', 'Delete', 'web', NULL, NULL),
       (379, 'about-us-view', 'About Us', 'Manage', 'web', NULL, NULL),
       (380, 'feature-view', 'Feature', 'View', 'web', NULL, NULL),
       (381, 'feature-create', 'Feature', 'Create', 'web', NULL, NULL),
       (382, 'feature-edit', 'Feature', 'Edit', 'web', NULL, NULL),
       (383, 'feature-delete', 'Feature', 'Delete', 'web', NULL, NULL),
       (384, 'course-view', 'Course', 'View', 'web', NULL, NULL),
       (385, 'course-create', 'Course', 'Create', 'web', NULL, NULL),
       (386, 'course-edit', 'Course', 'Edit', 'web', NULL, NULL),
       (387, 'course-delete', 'Course', 'Delete', 'web', NULL, NULL),
       (388, 'web-event-view', 'Web Event', 'View', 'web', NULL, NULL),
       (389, 'web-event-create', 'Web Event', 'Create', 'web', NULL, NULL),
       (390, 'web-event-edit', 'Web Event', 'Edit', 'web', NULL, NULL),
       (391, 'web-event-delete', 'Web Event', 'Delete', 'web', NULL, NULL),
       (392, 'news-view', 'News', 'View', 'web', NULL, NULL),
       (393, 'news-create', 'News', 'Create', 'web', NULL, NULL),
       (394, 'news-edit', 'News', 'Edit', 'web', NULL, NULL),
       (395, 'news-delete', 'News', 'Delete', 'web', NULL, NULL),
       (396, 'gallery-view', 'Gallery', 'View', 'web', NULL, NULL),
       (397, 'gallery-create', 'Gallery', 'Create', 'web', NULL, NULL),
       (398, 'gallery-edit', 'Gallery', 'Edit', 'web', NULL, NULL),
       (399, 'gallery-delete', 'Gallery', 'Delete', 'web', NULL, NULL),
       (400, 'faq-view', 'Faq', 'View', 'web', NULL, NULL),
       (401, 'faq-create', 'Faq', 'Create', 'web', NULL, NULL),
       (402, 'faq-edit', 'Faq', 'Edit', 'web', NULL, NULL),
       (403, 'faq-delete', 'Faq', 'Delete', 'web', NULL, NULL),
       (404, 'testimonial-view', 'Testimonial', 'View', 'web', NULL, NULL),
       (405, 'testimonial-create', 'Testimonial', 'Create', 'web', NULL, NULL),
       (406, 'testimonial-edit', 'Testimonial', 'Edit', 'web', NULL, NULL),
       (407, 'testimonial-delete', 'Testimonial', 'Delete', 'web', NULL, NULL),
       (408, 'page-view', 'Footer Page', 'View', 'web', NULL, NULL),
       (409, 'page-create', 'Footer Page', 'Create', 'web', NULL, NULL),
       (410, 'page-edit', 'Footer Page', 'Edit', 'web', NULL, NULL),
       (411, 'page-delete', 'Footer Page', 'Delete', 'web', NULL, NULL),
       (412, 'call-to-action-view', 'Call To Action', 'Manage', 'web', NULL, NULL),
       (413, 'province-view', 'State/Province', 'View', 'web', NULL, NULL),
       (414, 'province-create', 'State/Province', 'Create', 'web', NULL, NULL),
       (415, 'province-edit', 'State/Province', 'Edit', 'web', NULL, NULL),
       (416, 'province-delete', 'State/Province', 'Delete', 'web', NULL, NULL),
       (417, 'district-view', 'District/City', 'View', 'web', NULL, NULL),
       (418, 'district-create', 'District/City', 'Create', 'web', NULL, NULL),
       (419, 'district-edit', 'District/City', 'Edit', 'web', NULL, NULL),
       (420, 'district-delete', 'District/City', 'Delete', 'web', NULL, NULL),
       (421, 'language-view', 'Language', 'View', 'web', NULL, NULL),
       (422, 'language-create', 'Language', 'Create', 'web', NULL, NULL),
       (423, 'language-edit', 'Language', 'Edit', 'web', NULL, NULL),
       (424, 'language-delete', 'Language', 'Delete', 'web', NULL, NULL),
       (425, 'translations-view', 'Translation', 'View', 'web', NULL, NULL),
       (426, 'translations-create', 'Translation', 'Create', 'web', NULL, NULL),
       (427, 'translations-delete', 'Translation', 'Delete', 'web', NULL, NULL),
       (428, 'setting-view', 'Setting', 'General', 'web', NULL, NULL),
       (429, 'setting-mail', 'Setting', 'Mail Setting', 'web', NULL, NULL),
       (430, 'setting-sms', 'Setting', 'SMS Getaways', 'web', NULL, NULL),
       (431, 'setting-payment', 'Setting', 'Payment Getaways', 'web', NULL, NULL),
       (432, 'application-setting-view', 'Application Setting', 'Manage', 'web', NULL, NULL),
       (433, 'role-view', 'Role and Permissions', 'View', 'web', NULL, NULL),
       (434, 'role-create', 'Role and Permissions', 'Create', 'web', NULL, NULL),
       (435, 'role-edit', 'Role and Permissions', 'Edit', 'web', NULL, NULL),
       (436, 'role-delete', 'Role and Permissions', 'Delete', 'web', NULL, NULL),
       (437, 'field-staff', 'Field Setting', 'Staff', 'web', NULL, NULL),
       (438, 'field-student', 'Field Setting', 'Student', 'web', NULL, NULL),
       (439, 'field-application', 'Field Setting', 'Application', 'web', NULL, NULL),
       (440, 'student-panel-view', 'Student Panel', 'Manage', 'web', NULL, NULL),
       (441, 'profile-view', 'My Profile', 'View', 'web', NULL, NULL),
       (442, 'profile-edit', 'My Profile', 'Edit', 'web', NULL, NULL),
       (443, 'profile-account', 'My Profile', 'Account', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `tokenable_type` varchar(191) NOT NULL,
    `tokenable_id`   bigint(20) UNSIGNED NOT NULL,
    `name`           varchar(191) NOT NULL,
    `token`          varchar(64)  NOT NULL,
    `abilities`      text DEFAULT NULL,
    `last_used_at`   timestamp NULL DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phone_logs`
--

CREATE TABLE `phone_logs`
(
    `id`             bigint(20) UNSIGNED NOT NULL,
    `name`           varchar(191) DEFAULT NULL,
    `phone`          varchar(191) NOT NULL,
    `date`           date         NOT NULL,
    `follow_up_date` date         DEFAULT NULL,
    `call_duration`  varchar(191) DEFAULT NULL,
    `start_time`     time         DEFAULT NULL,
    `end_time`       time         DEFAULT NULL,
    `purpose`        text         DEFAULT NULL,
    `note`           text         DEFAULT NULL,
    `call_type`      tinyint(4) NOT NULL COMMENT '1 Income & 2 Outgoing',
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`     bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postal_exchanges`
--

CREATE TABLE `postal_exchanges`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `type`        tinyint(4) NOT NULL COMMENT '1 Import & 2 Export',
    `category_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `reference`   text DEFAULT NULL,
    `from`        text DEFAULT NULL,
    `to`          text DEFAULT NULL,
    `note`        text DEFAULT NULL,
    `date`        date DEFAULT NULL,
    `attach`      text DEFAULT NULL,
    `status`      tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 On Hold, 2 Progress, 3 Received, 0 Delivered',
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postal_exchange_types`
--

CREATE TABLE `postal_exchange_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `print_settings`
--

CREATE TABLE `print_settings`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `slug`          varchar(191) NOT NULL,
    `title`         text                  DEFAULT NULL,
    `header_left`   text                  DEFAULT NULL,
    `header_center` text                  DEFAULT NULL,
    `header_right`  text                  DEFAULT NULL,
    `body`          longtext              DEFAULT NULL,
    `footer_left`   text                  DEFAULT NULL,
    `footer_center` text                  DEFAULT NULL,
    `footer_right`  text                  DEFAULT NULL,
    `logo_left`     text                  DEFAULT NULL,
    `logo_right`    text                  DEFAULT NULL,
    `background`    text                  DEFAULT NULL,
    `width`         varchar(191) NOT NULL DEFAULT 'auto',
    `height`        varchar(191) NOT NULL DEFAULT 'auto',
    `prefix`        varchar(191)          DEFAULT NULL,
    `student_photo` tinyint(1) NOT NULL DEFAULT 0,
    `barcode`       tinyint(1) NOT NULL DEFAULT 0,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs`
(
    `id`           int(10) UNSIGNED NOT NULL,
    `faculty_id`   int(10) UNSIGNED NOT NULL,
    `title`        varchar(191) NOT NULL,
    `slug`         varchar(191) NOT NULL,
    `shortcode`    varchar(191) DEFAULT NULL,
    `registration` tinyint(1) NOT NULL DEFAULT 1,
    `status`       tinyint(1) NOT NULL DEFAULT 1,
    `created_at`   timestamp NULL DEFAULT NULL,
    `updated_at`   timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_class_room`
--

CREATE TABLE `program_class_room`
(
    `program_id`    int(10) UNSIGNED NOT NULL,
    `class_room_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_semester`
--

CREATE TABLE `program_semester`
(
    `program_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_semester_sections`
--

CREATE TABLE `program_semester_sections`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `section_id`  int(10) UNSIGNED NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_session`
--

CREATE TABLE `program_session`
(
    `program_id` int(10) UNSIGNED NOT NULL,
    `session_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_subject`
--

CREATE TABLE `program_subject`
(
    `program_id` int(10) UNSIGNED NOT NULL,
    `subject_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result_contributions`
--

CREATE TABLE `result_contributions`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `attendances` decimal(5, 2) NOT NULL DEFAULT 0.00,
    `assignments` decimal(5, 2) NOT NULL DEFAULT 0.00,
    `activities`  decimal(5, 2) NOT NULL DEFAULT 0.00,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `result_contributions`
--

INSERT INTO `result_contributions` (`id`, `attendances`, `assignments`, `activities`, `status`, `created_at`,
                                    `updated_at`)
VALUES (1, '10.00', '10.00', '10.00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `name`       varchar(191) NOT NULL,
    `slug`       varchar(191) NOT NULL,
    `guard_name` varchar(191) NOT NULL DEFAULT 'web',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `guard_name`, `created_at`, `updated_at`)
VALUES (1, 'Super Admin', 'super-admin', 'web', '2024-09-30 11:34:14', '2024-09-30 11:34:14'),
       (2, 'Admin', 'admin', 'web', NULL, NULL),
       (3, 'Accountant', 'accountant', 'web', NULL, NULL),
       (4, 'Librarian', 'librarian', 'web', NULL, NULL),
       (5, 'Receptionist', 'receptionist', 'web', NULL, NULL),
       (6, 'Teacher', 'teacher', 'web', NULL, NULL),
       (7, 'Office Assistant', 'office-assistant', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions`
(
    `permission_id` bigint(20) UNSIGNED NOT NULL,
    `role_id`       bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`)
VALUES (1, 1),
       (2, 1),
       (3, 1),
       (4, 1),
       (5, 1),
       (6, 1),
       (7, 1),
       (8, 1),
       (9, 1),
       (10, 1),
       (11, 1),
       (12, 1),
       (13, 1),
       (14, 1),
       (15, 1),
       (16, 1),
       (17, 1),
       (18, 1),
       (19, 1),
       (20, 1),
       (21, 1),
       (22, 1),
       (23, 1),
       (24, 1),
       (25, 1),
       (26, 1),
       (27, 1),
       (28, 1),
       (29, 1),
       (30, 1),
       (31, 1),
       (32, 1),
       (33, 1),
       (34, 1),
       (35, 1),
       (36, 1),
       (37, 1),
       (38, 1),
       (39, 1),
       (40, 1),
       (41, 1),
       (42, 1),
       (43, 1),
       (44, 1),
       (45, 1),
       (46, 1),
       (47, 1),
       (48, 1),
       (49, 1),
       (50, 1),
       (51, 1),
       (52, 1),
       (53, 1),
       (54, 1),
       (55, 1),
       (56, 1),
       (57, 1),
       (58, 1),
       (59, 1),
       (60, 1),
       (61, 1),
       (62, 1),
       (63, 1),
       (64, 1),
       (65, 1),
       (66, 1),
       (67, 1),
       (68, 1),
       (69, 1),
       (70, 1),
       (71, 1),
       (72, 1),
       (73, 1),
       (74, 1),
       (75, 1),
       (76, 1),
       (77, 1),
       (78, 1),
       (79, 1),
       (80, 1),
       (81, 1),
       (82, 1),
       (83, 1),
       (84, 1),
       (85, 1),
       (86, 1),
       (87, 1),
       (88, 1),
       (89, 1),
       (90, 1),
       (91, 1),
       (92, 1),
       (93, 1),
       (94, 1),
       (95, 1),
       (96, 1),
       (97, 1),
       (98, 1),
       (99, 1),
       (100, 1),
       (101, 1),
       (102, 1),
       (103, 1),
       (104, 1),
       (105, 1),
       (106, 1),
       (107, 1),
       (108, 1),
       (109, 1),
       (110, 1),
       (111, 1),
       (112, 1),
       (113, 1),
       (114, 1),
       (115, 1),
       (116, 1),
       (117, 1),
       (118, 1),
       (119, 1),
       (120, 1),
       (121, 1),
       (122, 1),
       (123, 1),
       (124, 1),
       (125, 1),
       (126, 1),
       (127, 1),
       (128, 1),
       (129, 1),
       (130, 1),
       (131, 1),
       (132, 1),
       (133, 1),
       (134, 1),
       (135, 1),
       (136, 1),
       (137, 1),
       (138, 1),
       (139, 1),
       (140, 1),
       (141, 1),
       (142, 1),
       (143, 1),
       (144, 1),
       (145, 1),
       (146, 1),
       (147, 1),
       (148, 1),
       (149, 1),
       (150, 1),
       (151, 1),
       (152, 1),
       (153, 1),
       (154, 1),
       (155, 1),
       (156, 1),
       (157, 1),
       (158, 1),
       (159, 1),
       (160, 1),
       (161, 1),
       (162, 1),
       (163, 1),
       (164, 1),
       (165, 1),
       (166, 1),
       (167, 1),
       (168, 1),
       (169, 1),
       (170, 1),
       (171, 1),
       (172, 1),
       (173, 1),
       (174, 1),
       (175, 1),
       (176, 1),
       (177, 1),
       (178, 1),
       (179, 1),
       (180, 1),
       (181, 1),
       (182, 1),
       (183, 1),
       (184, 1),
       (185, 1),
       (186, 1),
       (187, 1),
       (188, 1),
       (189, 1),
       (190, 1),
       (191, 1),
       (192, 1),
       (193, 1),
       (194, 1),
       (195, 1),
       (196, 1),
       (197, 1),
       (198, 1),
       (199, 1),
       (200, 1),
       (201, 1),
       (202, 1),
       (203, 1),
       (204, 1),
       (205, 1),
       (206, 1),
       (207, 1),
       (208, 1),
       (209, 1),
       (210, 1),
       (211, 1),
       (212, 1),
       (213, 1),
       (214, 1),
       (215, 1),
       (216, 1),
       (217, 1),
       (218, 1),
       (219, 1),
       (220, 1),
       (221, 1),
       (222, 1),
       (223, 1),
       (224, 1),
       (225, 1),
       (226, 1),
       (227, 1),
       (228, 1),
       (229, 1),
       (230, 1),
       (231, 1),
       (232, 1),
       (233, 1),
       (234, 1),
       (235, 1),
       (236, 1),
       (237, 1),
       (238, 1),
       (239, 1),
       (240, 1),
       (241, 1),
       (242, 1),
       (243, 1),
       (244, 1),
       (245, 1),
       (246, 1),
       (247, 1),
       (248, 1),
       (249, 1),
       (250, 1),
       (251, 1),
       (252, 1),
       (253, 1),
       (254, 1),
       (255, 1),
       (256, 1),
       (257, 1),
       (258, 1),
       (259, 1),
       (260, 1),
       (261, 1),
       (262, 1),
       (263, 1),
       (264, 1),
       (265, 1),
       (266, 1),
       (267, 1),
       (268, 1),
       (269, 1),
       (270, 1),
       (271, 1),
       (272, 1),
       (273, 1),
       (274, 1),
       (275, 1),
       (276, 1),
       (277, 1),
       (278, 1),
       (279, 1),
       (280, 1),
       (281, 1),
       (282, 1),
       (283, 1),
       (284, 1),
       (285, 1),
       (286, 1),
       (287, 1),
       (288, 1),
       (289, 1),
       (290, 1),
       (291, 1),
       (292, 1),
       (293, 1),
       (294, 1),
       (295, 1),
       (296, 1),
       (297, 1),
       (298, 1),
       (299, 1),
       (300, 1),
       (301, 1),
       (302, 1),
       (303, 1),
       (304, 1),
       (305, 1),
       (306, 1),
       (307, 1),
       (308, 1),
       (309, 1),
       (310, 1),
       (311, 1),
       (312, 1),
       (313, 1),
       (314, 1),
       (315, 1),
       (316, 1),
       (317, 1),
       (318, 1),
       (319, 1),
       (320, 1),
       (321, 1),
       (322, 1),
       (323, 1),
       (324, 1),
       (325, 1),
       (326, 1),
       (327, 1),
       (328, 1),
       (329, 1),
       (330, 1),
       (331, 1),
       (332, 1),
       (333, 1),
       (334, 1),
       (335, 1),
       (336, 1),
       (337, 1),
       (338, 1),
       (339, 1),
       (340, 1),
       (341, 1),
       (342, 1),
       (343, 1),
       (344, 1),
       (345, 1),
       (346, 1),
       (347, 1),
       (348, 1),
       (349, 1),
       (350, 1),
       (351, 1),
       (352, 1),
       (353, 1),
       (354, 1),
       (355, 1),
       (356, 1),
       (357, 1),
       (358, 1),
       (359, 1),
       (360, 1),
       (361, 1),
       (362, 1),
       (363, 1),
       (364, 1),
       (365, 1),
       (366, 1),
       (367, 1),
       (368, 1),
       (369, 1),
       (370, 1),
       (371, 1),
       (372, 1),
       (373, 1),
       (374, 1),
       (375, 1),
       (376, 1),
       (377, 1),
       (378, 1),
       (379, 1),
       (380, 1),
       (381, 1),
       (382, 1),
       (383, 1),
       (384, 1),
       (385, 1),
       (386, 1),
       (387, 1),
       (388, 1),
       (389, 1),
       (390, 1),
       (391, 1),
       (392, 1),
       (393, 1),
       (394, 1),
       (395, 1),
       (396, 1),
       (397, 1),
       (398, 1),
       (399, 1),
       (400, 1),
       (401, 1),
       (402, 1),
       (403, 1),
       (404, 1),
       (405, 1),
       (406, 1),
       (407, 1),
       (408, 1),
       (409, 1),
       (410, 1),
       (411, 1),
       (412, 1),
       (413, 1),
       (414, 1),
       (415, 1),
       (416, 1),
       (417, 1),
       (418, 1),
       (419, 1),
       (420, 1),
       (421, 1),
       (422, 1),
       (423, 1),
       (424, 1),
       (425, 1),
       (426, 1),
       (427, 1),
       (428, 1),
       (429, 1),
       (430, 1),
       (431, 1),
       (432, 1),
       (433, 1),
       (434, 1),
       (435, 1),
       (436, 1),
       (437, 1),
       (438, 1),
       (439, 1),
       (440, 1),
       (441, 1),
       (442, 1),
       (443, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_settings`
--

CREATE TABLE `schedule_settings`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `slug`       varchar(191) NOT NULL,
    `day`        int(11) NOT NULL,
    `time`       time         NOT NULL,
    `email`      tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Inactive, 1 Active',
    `sms`        tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Inactive, 1 Active',
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `seat`       int(11) DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `year`       varchar(191) DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `title`      varchar(191) NOT NULL,
    `start_date` date DEFAULT NULL,
    `end_date`   date DEFAULT NULL,
    `current`    tinyint(1) NOT NULL DEFAULT 0,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `title`, `start_date`, `end_date`, `current`, `status`, `created_at`, `updated_at`)
VALUES (1, 'Spring-2022', '2022-01-01', '2022-04-30', 1, 1, '2024-09-30 11:34:15', '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings`
(
    `id`               int(10) UNSIGNED NOT NULL,
    `title`            varchar(191) NOT NULL,
    `academy_code`     varchar(191) DEFAULT NULL,
    `meta_title`       varchar(191) DEFAULT NULL,
    `meta_description` text         DEFAULT NULL,
    `meta_keywords`    text         DEFAULT NULL,
    `logo_path`        text         DEFAULT NULL,
    `favicon_path`     text         DEFAULT NULL,
    `phone`            varchar(191) DEFAULT NULL,
    `email`            varchar(191) DEFAULT NULL,
    `fax`              varchar(191) DEFAULT NULL,
    `address`          text         DEFAULT NULL,
    `language`         varchar(191) DEFAULT NULL,
    `date_format`      varchar(191) DEFAULT NULL,
    `time_format`      varchar(191) DEFAULT NULL,
    `week_start`       varchar(191) DEFAULT NULL,
    `time_zone`        varchar(191) DEFAULT NULL,
    `currency`         varchar(191) DEFAULT NULL,
    `currency_symbol`  varchar(191) DEFAULT NULL,
    `decimal_place`    int(11) NOT NULL DEFAULT 2,
    `copyright_text`   text         DEFAULT NULL,
    `status`           tinyint(1) NOT NULL DEFAULT 1,
    `created_at`       timestamp NULL DEFAULT NULL,
    `updated_at`       timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `academy_code`, `meta_title`, `meta_description`, `meta_keywords`, `logo_path`,
                        `favicon_path`, `phone`, `email`, `fax`, `address`, `language`, `date_format`, `time_format`,
                        `week_start`, `time_zone`, `currency`, `currency_symbol`, `decimal_place`, `copyright_text`,
                        `status`, `created_at`, `updated_at`)
VALUES (1, 'University System', NULL, 'University System', NULL, NULL, 'logo.png', 'favicon.png', '+880123456789',
        'example@mail.com', NULL, 'Mirpur, Dhaka', NULL, 'd-m-Y', 'h:i A', '1', 'Asia/Dhaka', 'USD', '$', 2,
        '2022 - University System | Created By_ <a href=\"https://hitechparks.com/\" target=\"_blank\">Hi-Tech Parks</a>',
        1, '2024-09-30 11:34:15', '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `sub_title`   text         DEFAULT NULL,
    `button_text` varchar(191) DEFAULT NULL,
    `button_link` varchar(191) DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_settings`
--

CREATE TABLE `social_settings`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `facebook`   varchar(191) DEFAULT NULL,
    `twitter`    varchar(191) DEFAULT NULL,
    `linkedin`   varchar(191) DEFAULT NULL,
    `instagram`  varchar(191) DEFAULT NULL,
    `pinterest`  varchar(191) DEFAULT NULL,
    `youtube`    varchar(191) DEFAULT NULL,
    `tiktok`     varchar(191) DEFAULT NULL,
    `skype`      varchar(191) DEFAULT NULL,
    `telegram`   varchar(191) DEFAULT NULL,
    `whatsapp`   varchar(191) DEFAULT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_settings`
--

INSERT INTO `social_settings` (`id`, `facebook`, `twitter`, `linkedin`, `instagram`, `pinterest`, `youtube`, `tiktok`,
                               `skype`, `telegram`, `whatsapp`, `status`, `created_at`, `updated_at`)
VALUES (1, 'https://www.facebook.com/HiTechParks/', 'https://twitter.com/hitechparks',
        'https://www.linkedin.com/company/hi-techparks/', NULL, 'https://www.pinterest.com/hitechparks/',
        'https://www.youtube.com/@hitechparks', NULL, 'hitechparks', NULL, '+8801740473189', 1, '2024-09-30 11:34:15',
        '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendances`
--

CREATE TABLE `staff_attendances`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `user_id`    bigint(20) UNSIGNED NOT NULL,
    `start_time` time DEFAULT NULL,
    `end_time`   time DEFAULT NULL,
    `date`       date NOT NULL,
    `attendance` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 Present, 2 Absent, 3 Leave, 4 Holiday',
    `note`       text DEFAULT NULL,
    `created_by` bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_hourly_attendances`
--

CREATE TABLE `staff_hourly_attendances`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `user_id`     bigint(20) UNSIGNED NOT NULL,
    `subject_id`  bigint(20) UNSIGNED NOT NULL,
    `session_id`  int(10) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `section_id`  int(10) UNSIGNED NOT NULL,
    `start_time`  time DEFAULT NULL,
    `end_time`    time DEFAULT NULL,
    `date`        date NOT NULL,
    `attendance`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 Present, 2 Absent, 3 Leave, 4 Holiday',
    `note`        text DEFAULT NULL,
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_types`
--

CREATE TABLE `status_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_types`
--

INSERT INTO `status_types` (`id`, `title`, `slug`, `description`, `status`, `created_at`, `updated_at`)
VALUES (1, 'New Admission', 'new-admission', NULL, 1, NULL, NULL),
       (2, 'Continue', 'continue', NULL, 1, NULL, NULL),
       (3, 'Pass Out', 'pass-out', NULL, 1, NULL, NULL),
       (4, 'Drop Out', 'drop-out', NULL, 1, NULL, NULL),
       (5, 'Transfer In', 'transfer-in', NULL, 1, NULL, NULL),
       (6, 'Transfer Out', 'transfer-out', NULL, 1, NULL, NULL),
       (7, 'Disabled', 'disabled', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_type_student`
--

CREATE TABLE `status_type_student`
(
    `status_type_id` int(10) UNSIGNED NOT NULL,
    `student_id`     bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students`
(
    `id`                       bigint(20) UNSIGNED NOT NULL,
    `student_id`               varchar(191) NOT NULL,
    `registration_no`          varchar(191) DEFAULT NULL,
    `batch_id`                 int(10) UNSIGNED DEFAULT NULL,
    `program_id`               int(10) UNSIGNED DEFAULT NULL,
    `admission_date`           date         DEFAULT NULL,
    `first_name`               varchar(191) NOT NULL,
    `last_name`                varchar(191) NOT NULL,
    `father_name`              varchar(191) DEFAULT NULL,
    `mother_name`              varchar(191) DEFAULT NULL,
    `father_occupation`        varchar(191) DEFAULT NULL,
    `mother_occupation`        varchar(191) DEFAULT NULL,
    `father_photo`             text         DEFAULT NULL,
    `mother_photo`             text         DEFAULT NULL,
    `email`                    varchar(191) NOT NULL,
    `email_verified_at`        timestamp NULL DEFAULT NULL,
    `password`                 varchar(191) NOT NULL,
    `password_text`            longtext     DEFAULT NULL,
    `country`                  varchar(191) DEFAULT NULL,
    `present_province`         int(10) UNSIGNED DEFAULT NULL,
    `present_district`         int(10) UNSIGNED DEFAULT NULL,
    `present_village`          text         DEFAULT NULL,
    `present_address`          text         DEFAULT NULL,
    `permanent_province`       int(10) UNSIGNED DEFAULT NULL,
    `permanent_district`       int(10) UNSIGNED DEFAULT NULL,
    `permanent_village`        text         DEFAULT NULL,
    `permanent_address`        text         DEFAULT NULL,
    `gender`                   tinyint(4) NOT NULL COMMENT '1 Male, 2 Female & 3 Other',
    `dob`                      date         NOT NULL,
    `phone`                    varchar(191) DEFAULT NULL,
    `emergency_phone`          varchar(191) DEFAULT NULL,
    `religion`                 varchar(191) DEFAULT NULL,
    `caste`                    varchar(191) DEFAULT NULL,
    `mother_tongue`            varchar(191) DEFAULT NULL,
    `marital_status`           tinyint(4) DEFAULT NULL,
    `blood_group`              tinyint(4) DEFAULT NULL,
    `nationality`              varchar(191) DEFAULT NULL,
    `national_id`              varchar(191) DEFAULT NULL,
    `passport_no`              varchar(191) DEFAULT NULL,
    `school_name`              text         DEFAULT NULL,
    `school_exam_id`           varchar(191) DEFAULT NULL,
    `school_graduation_field`  varchar(191) DEFAULT NULL,
    `school_graduation_year`   varchar(191) DEFAULT NULL,
    `school_graduation_point`  varchar(191) DEFAULT NULL,
    `school_transcript`        varchar(191) DEFAULT NULL,
    `school_certificate`       varchar(191) DEFAULT NULL,
    `collage_name`             text         DEFAULT NULL,
    `collage_exam_id`          varchar(191) DEFAULT NULL,
    `collage_graduation_field` varchar(191) DEFAULT NULL,
    `collage_graduation_year`  varchar(191) DEFAULT NULL,
    `collage_graduation_point` varchar(191) DEFAULT NULL,
    `collage_transcript`       varchar(191) DEFAULT NULL,
    `collage_certificate`      varchar(191) DEFAULT NULL,
    `photo`                    text         DEFAULT NULL,
    `signature`                text         DEFAULT NULL,
    `login`                    tinyint(1) NOT NULL DEFAULT 1,
    `status`                   tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active, 2 Passed Out, 3 Transfer Out',
    `is_transfer`              tinyint(4) DEFAULT 0 COMMENT '0 Not Transfer, 1 Transfer In & 2 Transfer Out',
    `remember_token`           varchar(100) DEFAULT NULL,
    `created_by`               bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`               bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`               timestamp NULL DEFAULT NULL,
    `updated_at`               timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_assignments`
--

CREATE TABLE `student_assignments`
(
    `id`                bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `assignment_id`     bigint(20) UNSIGNED NOT NULL,
    `marks`             decimal(5, 2) DEFAULT NULL,
    `attendance`        tinyint(4) DEFAULT NULL,
    `date`              date          DEFAULT NULL,
    `attach`            text          DEFAULT NULL,
    `created_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances`
(
    `id`                bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `subject_id`        bigint(20) UNSIGNED NOT NULL,
    `date`              date NOT NULL,
    `time`              time DEFAULT NULL,
    `attendance`        tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 Present, 2 Absent, 3 Leave, 4 Holiday',
    `note`              text DEFAULT NULL,
    `created_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_enrolls`
--

CREATE TABLE `student_enrolls`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `student_id`  bigint(20) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `session_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `section_id`  int(10) UNSIGNED NOT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll_subject`
--

CREATE TABLE `student_enroll_subject`
(
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `subject_id`        bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_leaves`
--

CREATE TABLE `student_leaves`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `student_id` bigint(20) UNSIGNED NOT NULL,
    `review_by`  bigint(20) UNSIGNED DEFAULT NULL,
    `apply_date` date NOT NULL,
    `from_date`  date NOT NULL,
    `to_date`    date NOT NULL,
    `subject`    varchar(191) DEFAULT NULL,
    `reason`     longtext     DEFAULT NULL,
    `attach`     text         DEFAULT NULL,
    `note`       text         DEFAULT NULL,
    `status`     tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 Pending, 1 Approved and 2 Rejected',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_relatives`
--

CREATE TABLE `student_relatives`
(
    `id`         bigint(20) UNSIGNED NOT NULL,
    `student_id` bigint(20) UNSIGNED NOT NULL,
    `relation`   varchar(191) DEFAULT NULL,
    `name`       varchar(191) DEFAULT NULL,
    `occupation` varchar(191) DEFAULT NULL,
    `email`      varchar(191) DEFAULT NULL,
    `phone`      varchar(191) DEFAULT NULL,
    `address`    text         DEFAULT NULL,
    `photo`      text         DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_transfers`
--

CREATE TABLE `student_transfers`
(
    `id`              bigint(20) UNSIGNED NOT NULL,
    `student_id`      bigint(20) UNSIGNED NOT NULL,
    `transfer_id`     varchar(191) NOT NULL,
    `university_name` varchar(191) NOT NULL,
    `date`            date         NOT NULL,
    `note`            longtext DEFAULT NULL,
    `status`          tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Transfer In, 1 Transfer Out',
    `created_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`      bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`      timestamp NULL DEFAULT NULL,
    `updated_at`      timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `title`         varchar(191) NOT NULL,
    `code`          varchar(191) NOT NULL,
    `credit_hour`   int(11) NOT NULL,
    `subject_type`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Optional & 1 Compulsory',
    `class_type`    tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Theory, 2 Practical & 3 Both',
    `total_marks`   decimal(5, 2) DEFAULT NULL,
    `passing_marks` decimal(5, 2) DEFAULT NULL,
    `description`   text          DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_markings`
--

CREATE TABLE `subject_markings`
(
    `id`                bigint(20) UNSIGNED NOT NULL,
    `student_enroll_id` bigint(20) UNSIGNED NOT NULL,
    `subject_id`        bigint(20) UNSIGNED NOT NULL,
    `exam_marks`        decimal(5, 2) DEFAULT NULL,
    `attendances`       decimal(5, 2) DEFAULT NULL,
    `assignments`       decimal(5, 2) DEFAULT NULL,
    `activities`        decimal(5, 2) DEFAULT NULL,
    `total_marks`       decimal(5, 2) NOT NULL,
    `publish_date`      date          DEFAULT NULL,
    `publish_time`      time          DEFAULT NULL,
    `status`            tinyint(1) NOT NULL DEFAULT 1,
    `created_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`        bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s_notifies`
--

CREATE TABLE `s_m_s_notifies`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `faculty_id`    int(10) UNSIGNED DEFAULT NULL,
    `program_id`    int(10) UNSIGNED DEFAULT NULL,
    `session_id`    int(10) UNSIGNED DEFAULT NULL,
    `semester_id`   int(10) UNSIGNED DEFAULT NULL,
    `section_id`    int(10) UNSIGNED DEFAULT NULL,
    `message`       text NOT NULL,
    `receive_count` int(11) DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s_settings`
--

CREATE TABLE `s_m_s_settings`
(
    `id`                int(10) UNSIGNED NOT NULL,
    `nexmo_key`         varchar(191) DEFAULT NULL,
    `nexmo_secret`      varchar(191) DEFAULT NULL,
    `nexmo_sender_name` varchar(191) DEFAULT NULL,
    `twilio_sid`        varchar(191) DEFAULT NULL,
    `twilio_auth_token` varchar(191) DEFAULT NULL,
    `twilio_number`     varchar(191) DEFAULT NULL,
    `status`            tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Twilio, 2 Nexmo',
    `created_at`        timestamp NULL DEFAULT NULL,
    `updated_at`        timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s_m_s_settings`
--

INSERT INTO `s_m_s_settings` (`id`, `nexmo_key`, `nexmo_secret`, `nexmo_sender_name`, `twilio_sid`, `twilio_auth_token`,
                              `twilio_number`, `status`, `created_at`, `updated_at`)
VALUES (1, '7e29c3ce', '6gK9ve4soFO6RP5d', 'ABC', 'AC8f4bfd69c98ad28c8f3a1dc8a8cca836',
        '4c880b6a9061a145d5c2a92de7e51cdf', '+14154461617', 1, '2024-09-30 11:34:15', '2024-09-30 11:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

CREATE TABLE `tax_settings`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `min_amount` double(10,2) NOT NULL,
    `max_amount` double(10,2) NOT NULL,
    `percentange` double(4,2) NOT NULL,
    `max_no_taxable_amount` double(10,2) NOT NULL DEFAULT 0.00,
    `status`     tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_settings`
--

INSERT INTO `tax_settings` (`id`, `min_amount`, `max_amount`, `percentange`, `max_no_taxable_amount`, `status`,
                            `created_at`, `updated_at`)
VALUES (1, 0.00, 5000.00, 0.00, 0.00, 1, NULL, NULL),
       (2, 5001.00, 10000.00, 5.00, 5000.00, 1, NULL, NULL),
       (3, 10001.00, 20000.00, 10.00, 5000.00, 1, NULL, NULL),
       (4, 20001.00, 50000.00, 15.00, 5000.00, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `name`        varchar(191) NOT NULL,
    `designation` varchar(191) DEFAULT NULL,
    `description` text         NOT NULL,
    `rating` double(2,2) NOT NULL DEFAULT 0.99,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topbar_settings`
--

CREATE TABLE `topbar_settings`
(
    `id`            int(10) UNSIGNED NOT NULL,
    `address_title` varchar(191) DEFAULT NULL,
    `address`       text         DEFAULT NULL,
    `email`         varchar(191) DEFAULT NULL,
    `phone`         varchar(191) DEFAULT NULL,
    `working_hour`  varchar(191) DEFAULT NULL,
    `about_title`   varchar(191) DEFAULT NULL,
    `about_summery` text         DEFAULT NULL,
    `social_title`  varchar(191) DEFAULT NULL,
    `social_status` tinyint(1) NOT NULL DEFAULT 1,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions`
(
    `id`                   bigint(20) UNSIGNED NOT NULL,
    `transactionable_id`   bigint(20) NOT NULL,
    `transactionable_type` varchar(191)   NOT NULL,
    `transaction_id`       varchar(191)   NOT NULL,
    `amount`               decimal(10, 2) NOT NULL,
    `type`                 tinyint(4) NOT NULL COMMENT '1 Creadit & 2 Debit',
    `created_by`           bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`           bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`           timestamp NULL DEFAULT NULL,
    `updated_at`           timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_creadits`
--

CREATE TABLE `transfer_creadits`
(
    `id`          bigint(20) UNSIGNED NOT NULL,
    `student_id`  bigint(20) UNSIGNED NOT NULL,
    `program_id`  int(10) UNSIGNED NOT NULL,
    `session_id`  int(10) UNSIGNED NOT NULL,
    `semester_id` int(10) UNSIGNED NOT NULL,
    `subject_id`  bigint(20) UNSIGNED NOT NULL,
    `marks`       decimal(10, 2) DEFAULT NULL,
    `note`        text           DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_members`
--

CREATE TABLE `transport_members`
(
    `id`                   bigint(20) UNSIGNED NOT NULL,
    `transportable_type`   varchar(191) NOT NULL,
    `transportable_id`     bigint(20) UNSIGNED NOT NULL,
    `transport_route_id`   int(10) UNSIGNED NOT NULL,
    `transport_vehicle_id` int(10) UNSIGNED NOT NULL,
    `start_date`           date DEFAULT NULL,
    `end_date`             date DEFAULT NULL,
    `note`                 text DEFAULT NULL,
    `status`               tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active',
    `created_by`           bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`           bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`           timestamp NULL DEFAULT NULL,
    `updated_at`           timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_routes`
--

CREATE TABLE `transport_routes`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `fee` double(10,2) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_route_transport_vehicle`
--

CREATE TABLE `transport_route_transport_vehicle`
(
    `transport_route_id`   int(10) UNSIGNED NOT NULL,
    `transport_vehicle_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_vehicles`
--

CREATE TABLE `transport_vehicles`
(
    `id`             int(10) UNSIGNED NOT NULL,
    `number`         varchar(191) NOT NULL,
    `type`           varchar(191) DEFAULT NULL,
    `model`          varchar(191) DEFAULT NULL,
    `capacity`       varchar(191) DEFAULT NULL,
    `year_made`      varchar(191) DEFAULT NULL,
    `driver_name`    varchar(191) DEFAULT NULL,
    `driver_license` text         DEFAULT NULL,
    `driver_contact` text         DEFAULT NULL,
    `note`           text         DEFAULT NULL,
    `status`         tinyint(1) NOT NULL DEFAULT 1,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
    `id`                 bigint(20) UNSIGNED NOT NULL,
    `staff_id`           varchar(191) NOT NULL,
    `department_id`      int(10) UNSIGNED DEFAULT NULL,
    `designation_id`     int(10) UNSIGNED DEFAULT NULL,
    `first_name`         varchar(191) NOT NULL,
    `last_name`          varchar(191) NOT NULL,
    `father_name`        varchar(191) DEFAULT NULL,
    `mother_name`        varchar(191) DEFAULT NULL,
    `email`              varchar(191) NOT NULL,
    `email_verified_at`  timestamp NULL DEFAULT NULL,
    `password`           varchar(191) NOT NULL,
    `password_text`      longtext     DEFAULT NULL,
    `gender`             tinyint(4) NOT NULL COMMENT '1 Male, 2 Female & 3 Other',
    `dob`                date         NOT NULL,
    `joining_date`       date         DEFAULT NULL,
    `ending_date`        date         DEFAULT NULL,
    `phone`              varchar(191) DEFAULT NULL,
    `emergency_phone`    varchar(191) DEFAULT NULL,
    `religion`           varchar(191) DEFAULT NULL,
    `caste`              varchar(191) DEFAULT NULL,
    `mother_tongue`      varchar(191) DEFAULT NULL,
    `marital_status`     tinyint(4) DEFAULT NULL,
    `blood_group`        tinyint(4) DEFAULT NULL,
    `nationality`        varchar(191) DEFAULT NULL,
    `national_id`        varchar(191) DEFAULT NULL,
    `passport_no`        varchar(191) DEFAULT NULL,
    `country`            varchar(191) DEFAULT NULL,
    `present_province`   int(10) UNSIGNED DEFAULT NULL,
    `present_district`   int(10) UNSIGNED DEFAULT NULL,
    `present_village`    text         DEFAULT NULL,
    `present_address`    text         DEFAULT NULL,
    `permanent_province` int(10) UNSIGNED DEFAULT NULL,
    `permanent_district` int(10) UNSIGNED DEFAULT NULL,
    `permanent_village`  text         DEFAULT NULL,
    `permanent_address`  text         DEFAULT NULL,
    `education_level`    varchar(191) DEFAULT NULL,
    `graduation_academy` varchar(191) DEFAULT NULL,
    `year_of_graduation` varchar(191) DEFAULT NULL,
    `graduation_field`   varchar(191) DEFAULT NULL,
    `experience`         longtext     DEFAULT NULL,
    `note`               longtext     DEFAULT NULL,
    `basic_salary` double(10,2) NOT NULL DEFAULT 0.00,
    `contract_type`      tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Full Time & 2 Part Time',
    `work_shift`         int(10) UNSIGNED DEFAULT NULL,
    `salary_type`        tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 Fixed & 2 Hourly',
    `epf_no`             text         DEFAULT NULL,
    `bank_account_name`  varchar(191) DEFAULT NULL,
    `bank_account_no`    varchar(191) DEFAULT NULL,
    `bank_name`          varchar(191) DEFAULT NULL,
    `ifsc_code`          varchar(191) DEFAULT NULL,
    `bank_brach`         varchar(191) DEFAULT NULL,
    `tin_no`             varchar(191) DEFAULT NULL,
    `photo`              text         DEFAULT NULL,
    `signature`          text         DEFAULT NULL,
    `resume`             text         DEFAULT NULL,
    `joining_letter`     text         DEFAULT NULL,
    `is_admin`           tinyint(1) NOT NULL DEFAULT 0,
    `login`              tinyint(1) NOT NULL DEFAULT 1,
    `status`             tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 Inactive, 1 Active',
    `remember_token`     varchar(100) DEFAULT NULL,
    `created_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`         bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`         timestamp NULL DEFAULT NULL,
    `updated_at`         timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_id`, `department_id`, `designation_id`, `first_name`, `last_name`, `father_name`,
                     `mother_name`, `email`, `email_verified_at`, `password`, `password_text`, `gender`, `dob`,
                     `joining_date`, `ending_date`, `phone`, `emergency_phone`, `religion`, `caste`, `mother_tongue`,
                     `marital_status`, `blood_group`, `nationality`, `national_id`, `passport_no`, `country`,
                     `present_province`, `present_district`, `present_village`, `present_address`, `permanent_province`,
                     `permanent_district`, `permanent_village`, `permanent_address`, `education_level`,
                     `graduation_academy`, `year_of_graduation`, `graduation_field`, `experience`, `note`,
                     `basic_salary`, `contract_type`, `work_shift`, `salary_type`, `epf_no`, `bank_account_name`,
                     `bank_account_no`, `bank_name`, `ifsc_code`, `bank_brach`, `tin_no`, `photo`, `signature`,
                     `resume`, `joining_letter`, `is_admin`, `login`, `status`, `remember_token`, `created_by`,
                     `updated_by`, `created_at`, `updated_at`)
VALUES (1, '1001', NULL, NULL, 'Super', 'Admin', NULL, NULL, 'admin@mail.com', NULL,
        '$2y$10$Q2SirTwELexkgxiFeheezOYpoE3P4IUu2yRJwi6zf6gdr2M/Lm1eK',
        'eyJpdiI6ImsrL0VtTFp1KzhlQmdySWVXTThCN2c9PSIsInZhbHVlIjoicUNJdlE4TTE0NjFlNkIzdFlzU0Vldz09IiwibWFjIjoiNWQ0MGJjMDNmYjBlNmM4ZjQ4YTk5MzQ4ZDE2MmFhNDZjYWFlMjJkZTk5MmY1MDgzY2Y5YzI1MTY3YWFiMTk2NCIsInRhZyI6IiJ9',
        0, '2000-01-01', NULL, NULL, '0123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
        NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 1, NULL, 1, NULL, NULL,
        NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1,
        'NlPo4Mr4KXcEw2Ltc2ujMwNh15VO405hLCeplSO1kDh7Gzr8r1J7ZnS3jixL', NULL, NULL, '2024-09-30 11:34:14',
        '2024-09-30 11:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_program`
--

CREATE TABLE `user_program`
(
    `user_id`    bigint(20) UNSIGNED NOT NULL,
    `program_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors`
(
    `id`            bigint(20) UNSIGNED NOT NULL,
    `purpose_id`    int(10) UNSIGNED NOT NULL,
    `department_id` int(10) UNSIGNED DEFAULT NULL,
    `name`          varchar(191) NOT NULL,
    `father_name`   varchar(191) DEFAULT NULL,
    `phone`         varchar(191) DEFAULT NULL,
    `email`         varchar(191) DEFAULT NULL,
    `address`       text         DEFAULT NULL,
    `visit_from`    text         DEFAULT NULL,
    `id_no`         varchar(191) DEFAULT NULL,
    `token`         varchar(191) DEFAULT NULL,
    `date`          date         NOT NULL,
    `in_time`       time         DEFAULT NULL,
    `out_time`      time         DEFAULT NULL,
    `persons`       varchar(191) DEFAULT NULL,
    `note`          text         DEFAULT NULL,
    `attach`        text         DEFAULT NULL,
    `status`        tinyint(1) NOT NULL DEFAULT 1,
    `created_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `updated_by`    bigint(20) UNSIGNED DEFAULT NULL,
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visit_purposes`
--

CREATE TABLE `visit_purposes`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_events`
--

CREATE TABLE `web_events`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `language_id` int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `date`        date         NOT NULL,
    `time`        time         DEFAULT NULL,
    `address`     varchar(191) DEFAULT NULL,
    `description` longtext     DEFAULT NULL,
    `attach`      text         DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_shift_types`
--

CREATE TABLE `work_shift_types`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `title`       varchar(191) NOT NULL,
    `slug`        varchar(191) NOT NULL,
    `description` text DEFAULT NULL,
    `status`      tinyint(1) NOT NULL DEFAULT 1,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_shift_types`
--

INSERT INTO `work_shift_types` (`id`, `title`, `slug`, `description`, `status`, `created_at`, `updated_at`)
VALUES (1, 'Morning', 'morning', NULL, 1, NULL, NULL),
       (2, 'Evening', 'evening', NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_email_unique` (`email`);

--
-- Indexes for table `application_settings`
--
ALTER TABLE `application_settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_settings_slug_unique` (`slug`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `assignments_subject_id_foreign` (`subject_id`),
  ADD KEY `assignments_assign_by_foreign` (`assign_by`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batches_title_unique` (`title`);

--
-- Indexes for table `batch_program`
--
ALTER TABLE `batch_program`
    ADD KEY `batch_program_batch_id_foreign` (`batch_id`),
  ADD KEY `batch_program_program_id_foreign` (`program_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`),
  ADD UNIQUE KEY `books_code_unique` (`code`),
  ADD KEY `books_category_id_foreign` (`category_id`);

--
-- Indexes for table `book_categories`
--
ALTER TABLE `book_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_categories_title_unique` (`title`),
  ADD UNIQUE KEY `book_categories_slug_unique` (`slug`);

--
-- Indexes for table `book_requests`
--
ALTER TABLE `book_requests`
    ADD PRIMARY KEY (`id`),
  ADD KEY `book_requests_category_id_foreign` (`category_id`);

--
-- Indexes for table `call_to_actions`
--
ALTER TABLE `call_to_actions`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
    ADD PRIMARY KEY (`id`),
  ADD KEY `certificates_template_id_foreign` (`template_id`),
  ADD KEY `certificates_student_id_foreign` (`student_id`);

--
-- Indexes for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_templates_title_unique` (`title`);

--
-- Indexes for table `class_rooms`
--
ALTER TABLE `class_rooms`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_rooms_title_unique` (`title`),
  ADD UNIQUE KEY `class_rooms_slug_unique` (`slug`);

--
-- Indexes for table `class_routines`
--
ALTER TABLE `class_routines`
    ADD PRIMARY KEY (`id`),
  ADD KEY `class_routines_teacher_id_foreign` (`teacher_id`),
  ADD KEY `class_routines_subject_id_foreign` (`subject_id`),
  ADD KEY `class_routines_room_id_foreign` (`room_id`),
  ADD KEY `class_routines_session_id_foreign` (`session_id`),
  ADD KEY `class_routines_program_id_foreign` (`program_id`),
  ADD KEY `class_routines_semester_id_foreign` (`semester_id`),
  ADD KEY `class_routines_section_id_foreign` (`section_id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
    ADD PRIMARY KEY (`id`),
  ADD KEY `complains_type_id_foreign` (`type_id`);

--
-- Indexes for table `complain_sources`
--
ALTER TABLE `complain_sources`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complain_sources_title_unique` (`title`),
  ADD UNIQUE KEY `complain_sources_slug_unique` (`slug`);

--
-- Indexes for table `complain_types`
--
ALTER TABLE `complain_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complain_types_title_unique` (`title`),
  ADD UNIQUE KEY `complain_types_slug_unique` (`slug`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
    ADD PRIMARY KEY (`id`),
  ADD KEY `contents_type_id_foreign` (`type_id`);

--
-- Indexes for table `content_types`
--
ALTER TABLE `content_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `content_types_title_unique` (`title`),
  ADD UNIQUE KEY `content_types_slug_unique` (`slug`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_title_unique` (`title`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_title_unique` (`title`),
  ADD UNIQUE KEY `departments_slug_unique` (`slug`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designations_title_unique` (`title`),
  ADD UNIQUE KEY `designations_slug_unique` (`slug`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `districts_province_id_foreign` (`province_id`);

--
-- Indexes for table `docables`
--
ALTER TABLE `docables`
    ADD UNIQUE KEY `docables_document_id_docable_id_docable_type_unique` (`document_id`,`docable_id`,`docable_type`),
    ADD KEY `docables_docable_type_docable_id_index` (`docable_type`,`docable_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_notifies`
--
ALTER TABLE `email_notifies`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry_references`
--
ALTER TABLE `enquiry_references`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enquiry_references_title_unique` (`title`),
  ADD UNIQUE KEY `enquiry_references_slug_unique` (`slug`);

--
-- Indexes for table `enquiry_sources`
--
ALTER TABLE `enquiry_sources`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enquiry_sources_title_unique` (`title`),
  ADD UNIQUE KEY `enquiry_sources_slug_unique` (`slug`);

--
-- Indexes for table `enroll_subjects`
--
ALTER TABLE `enroll_subjects`
    ADD PRIMARY KEY (`id`),
  ADD KEY `enroll_subjects_program_id_foreign` (`program_id`),
  ADD KEY `enroll_subjects_semester_id_foreign` (`semester_id`),
  ADD KEY `enroll_subjects_section_id_foreign` (`section_id`);

--
-- Indexes for table `enroll_subject_subject`
--
ALTER TABLE `enroll_subject_subject`
    ADD KEY `enroll_subject_subject_enroll_subject_id_foreign` (`enroll_subject_id`),
  ADD KEY `enroll_subject_subject_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
    ADD PRIMARY KEY (`id`),
  ADD KEY `exams_student_enroll_id_foreign` (`student_enroll_id`),
  ADD KEY `exams_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `exam_routines`
--
ALTER TABLE `exam_routines`
    ADD PRIMARY KEY (`id`),
  ADD KEY `exam_routines_exam_type_id_foreign` (`exam_type_id`),
  ADD KEY `exam_routines_session_id_foreign` (`session_id`),
  ADD KEY `exam_routines_program_id_foreign` (`program_id`),
  ADD KEY `exam_routines_semester_id_foreign` (`semester_id`),
  ADD KEY `exam_routines_section_id_foreign` (`section_id`),
  ADD KEY `exam_routines_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `exam_routine_room`
--
ALTER TABLE `exam_routine_room`
    ADD KEY `exam_routine_room_exam_routine_id_foreign` (`exam_routine_id`),
  ADD KEY `exam_routine_room_room_id_foreign` (`room_id`);

--
-- Indexes for table `exam_routine_user`
--
ALTER TABLE `exam_routine_user`
    ADD KEY `exam_routine_user_exam_routine_id_foreign` (`exam_routine_id`),
  ADD KEY `exam_routine_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_types_title_unique` (`title`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
    ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_id_foreign` (`category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_categories_title_unique` (`title`),
  ADD UNIQUE KEY `expense_categories_slug_unique` (`slug`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_title_unique` (`title`),
  ADD UNIQUE KEY `faculties_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faqs_title_unique` (`title`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `features_title_unique` (`title`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_categories`
--
ALTER TABLE `fees_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fees_categories_title_unique` (`title`),
  ADD UNIQUE KEY `fees_categories_slug_unique` (`slug`);

--
-- Indexes for table `fees_category_fees_discount`
--
ALTER TABLE `fees_category_fees_discount`
    ADD KEY `fees_category_fees_discount_fees_category_id_foreign` (`fees_category_id`),
  ADD KEY `fees_category_fees_discount_fees_discount_id_foreign` (`fees_discount_id`);

--
-- Indexes for table `fees_category_fees_fine`
--
ALTER TABLE `fees_category_fees_fine`
    ADD KEY `fees_category_fees_fine_fees_category_id_foreign` (`fees_category_id`),
  ADD KEY `fees_category_fees_fine_fees_fine_id_foreign` (`fees_fine_id`);

--
-- Indexes for table `fees_discounts`
--
ALTER TABLE `fees_discounts`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_discount_status_type`
--
ALTER TABLE `fees_discount_status_type`
    ADD KEY `fees_discount_status_type_fees_discount_id_foreign` (`fees_discount_id`),
  ADD KEY `fees_discount_status_type_status_type_id_foreign` (`status_type_id`);

--
-- Indexes for table `fees_fines`
--
ALTER TABLE `fees_fines`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_masters`
--
ALTER TABLE `fees_masters`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_master_student_enroll`
--
ALTER TABLE `fees_master_student_enroll`
    ADD KEY `fees_master_student_enroll_fees_master_id_foreign` (`fees_master_id`),
  ADD KEY `fees_master_student_enroll_student_enroll_id_foreign` (`student_enroll_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fields_slug_unique` (`slug`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grades_title_unique` (`title`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hostels_name_unique` (`name`);

--
-- Indexes for table `hostel_members`
--
ALTER TABLE `hostel_members`
    ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_members_hostelable_type_hostelable_id_index` (`hostelable_type`,`hostelable_id`),
  ADD KEY `hostel_members_hostel_room_id_foreign` (`hostel_room_id`);

--
-- Indexes for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
    ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_rooms_hostel_id_foreign` (`hostel_id`),
  ADD KEY `hostel_rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `hostel_room_types`
--
ALTER TABLE `hostel_room_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hostel_room_types_title_unique` (`title`);

--
-- Indexes for table `id_card_settings`
--
ALTER TABLE `id_card_settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_card_settings_slug_unique` (`slug`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
    ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_category_id_foreign` (`category_id`);

--
-- Indexes for table `income_categories`
--
ALTER TABLE `income_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `income_categories_title_unique` (`title`),
  ADD UNIQUE KEY `income_categories_slug_unique` (`slug`);

--
-- Indexes for table `issue_returns`
--
ALTER TABLE `issue_returns`
    ADD PRIMARY KEY (`id`),
  ADD KEY `issue_returns_member_id_foreign` (`member_id`),
  ADD KEY `issue_returns_book_id_foreign` (`book_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_name_unique` (`name`),
  ADD KEY `items_category_id_foreign` (`category_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_categories_title_unique` (`title`),
  ADD UNIQUE KEY `item_categories_slug_unique` (`slug`);

--
-- Indexes for table `item_issues`
--
ALTER TABLE `item_issues`
    ADD PRIMARY KEY (`id`),
  ADD KEY `item_issues_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_stocks`
--
ALTER TABLE `item_stocks`
    ADD PRIMARY KEY (`id`),
  ADD KEY `item_stocks_item_id_foreign` (`item_id`),
  ADD KEY `item_stocks_store_id_foreign` (`store_id`);

--
-- Indexes for table `item_stores`
--
ALTER TABLE `item_stores`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_stores_title_unique` (`title`),
  ADD UNIQUE KEY `item_stores_store_no_unique` (`store_no`);

--
-- Indexes for table `item_suppliers`
--
ALTER TABLE `item_suppliers`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_suppliers_title_unique` (`title`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
    ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
    ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_type_id_foreign` (`type_id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `leave_types_title_unique` (`title`),
  ADD UNIQUE KEY `leave_types_slug_unique` (`slug`);

--
-- Indexes for table `library_members`
--
ALTER TABLE `library_members`
    ADD PRIMARY KEY (`id`),
  ADD KEY `library_members_memberable_type_memberable_id_index` (`memberable_type`,`memberable_id`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marksheet_settings`
--
ALTER TABLE `marksheet_settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marksheet_settings_title_unique` (`title`);

--
-- Indexes for table `meeting_schedules`
--
ALTER TABLE `meeting_schedules`
    ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_schedules_type_id_foreign` (`type_id`);

--
-- Indexes for table `meeting_types`
--
ALTER TABLE `meeting_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meeting_types_title_unique` (`title`),
  ADD UNIQUE KEY `meeting_types_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
    ADD PRIMARY KEY (`permission_id`, `model_id`, `model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
    ADD PRIMARY KEY (`role_id`, `model_id`, `model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
    ADD PRIMARY KEY (`id`),
  ADD KEY `notes_noteable_type_noteable_id_index` (`noteable_type`,`noteable_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notices_notice_no_unique` (`notice_no`),
  ADD KEY `notices_category_id_foreign` (`category_id`);

--
-- Indexes for table `notice_categories`
--
ALTER TABLE `notice_categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notice_categories_title_unique` (`title`),
  ADD UNIQUE KEY `notice_categories_slug_unique` (`slug`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
    ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `outside_users`
--
ALTER TABLE `outside_users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `outside_users_email_unique` (`email`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_title_unique` (`title`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
    ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_details`
--
ALTER TABLE `payroll_details`
    ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_details_payroll_id_foreign` (`payroll_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `phone_logs`
--
ALTER TABLE `phone_logs`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postal_exchanges`
--
ALTER TABLE `postal_exchanges`
    ADD PRIMARY KEY (`id`),
  ADD KEY `postal_exchanges_category_id_foreign` (`category_id`);

--
-- Indexes for table `postal_exchange_types`
--
ALTER TABLE `postal_exchange_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `postal_exchange_types_title_unique` (`title`),
  ADD UNIQUE KEY `postal_exchange_types_slug_unique` (`slug`);

--
-- Indexes for table `print_settings`
--
ALTER TABLE `print_settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `print_settings_slug_unique` (`slug`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_title_unique` (`title`),
  ADD UNIQUE KEY `programs_slug_unique` (`slug`),
  ADD KEY `programs_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `program_class_room`
--
ALTER TABLE `program_class_room`
    ADD KEY `program_class_room_program_id_foreign` (`program_id`),
  ADD KEY `program_class_room_class_room_id_foreign` (`class_room_id`);

--
-- Indexes for table `program_semester`
--
ALTER TABLE `program_semester`
    ADD KEY `program_semester_program_id_foreign` (`program_id`),
  ADD KEY `program_semester_semester_id_foreign` (`semester_id`);

--
-- Indexes for table `program_semester_sections`
--
ALTER TABLE `program_semester_sections`
    ADD PRIMARY KEY (`id`),
  ADD KEY `program_semester_sections_program_id_foreign` (`program_id`),
  ADD KEY `program_semester_sections_semester_id_foreign` (`semester_id`),
  ADD KEY `program_semester_sections_section_id_foreign` (`section_id`);

--
-- Indexes for table `program_session`
--
ALTER TABLE `program_session`
    ADD KEY `program_session_program_id_foreign` (`program_id`),
  ADD KEY `program_session_session_id_foreign` (`session_id`);

--
-- Indexes for table `program_subject`
--
ALTER TABLE `program_subject`
    ADD KEY `program_subject_program_id_foreign` (`program_id`),
  ADD KEY `program_subject_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provinces_title_unique` (`title`),
  ADD UNIQUE KEY `provinces_slug_unique` (`slug`);

--
-- Indexes for table `result_contributions`
--
ALTER TABLE `result_contributions`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
    ADD PRIMARY KEY (`permission_id`, `role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedule_settings`
--
ALTER TABLE `schedule_settings`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedule_settings_slug_unique` (`slug`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sections_title_unique` (`title`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semesters_title_unique` (`title`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sessions_title_unique` (`title`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sliders_title_unique` (`title`);

--
-- Indexes for table `social_settings`
--
ALTER TABLE `social_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
    ADD PRIMARY KEY (`id`),
  ADD KEY `staff_attendances_user_id_foreign` (`user_id`);

--
-- Indexes for table `staff_hourly_attendances`
--
ALTER TABLE `staff_hourly_attendances`
    ADD PRIMARY KEY (`id`),
  ADD KEY `staff_hourly_attendances_user_id_foreign` (`user_id`),
  ADD KEY `staff_hourly_attendances_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `status_types`
--
ALTER TABLE `status_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_types_title_unique` (`title`),
  ADD UNIQUE KEY `status_types_slug_unique` (`slug`);

--
-- Indexes for table `status_type_student`
--
ALTER TABLE `status_type_student`
    ADD KEY `status_type_student_status_type_id_foreign` (`status_type_id`),
  ADD KEY `status_type_student_student_id_foreign` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `student_assignments`
--
ALTER TABLE `student_assignments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_assignments_student_enroll_id_foreign` (`student_enroll_id`),
  ADD KEY `student_assignments_assignment_id_foreign` (`assignment_id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_attendances_student_enroll_id_foreign` (`student_enroll_id`),
  ADD KEY `student_attendances_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `student_enrolls`
--
ALTER TABLE `student_enrolls`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_enrolls_student_id_foreign` (`student_id`),
  ADD KEY `student_enrolls_program_id_foreign` (`program_id`),
  ADD KEY `student_enrolls_session_id_foreign` (`session_id`),
  ADD KEY `student_enrolls_semester_id_foreign` (`semester_id`),
  ADD KEY `student_enrolls_section_id_foreign` (`section_id`);

--
-- Indexes for table `student_enroll_subject`
--
ALTER TABLE `student_enroll_subject`
    ADD KEY `student_enroll_subject_student_enroll_id_foreign` (`student_enroll_id`),
  ADD KEY `student_enroll_subject_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `student_leaves`
--
ALTER TABLE `student_leaves`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_leaves_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_relatives`
--
ALTER TABLE `student_relatives`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_relatives_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_transfers`
--
ALTER TABLE `student_transfers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `student_transfers_student_id_foreign` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_title_unique` (`title`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`);

--
-- Indexes for table `subject_markings`
--
ALTER TABLE `subject_markings`
    ADD PRIMARY KEY (`id`),
  ADD KEY `subject_markings_student_enroll_id_foreign` (`student_enroll_id`),
  ADD KEY `subject_markings_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `s_m_s_notifies`
--
ALTER TABLE `s_m_s_notifies`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_m_s_settings`
--
ALTER TABLE `s_m_s_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_settings`
--
ALTER TABLE `tax_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testimonials_name_unique` (`name`);

--
-- Indexes for table `topbar_settings`
--
ALTER TABLE `topbar_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_id_unique` (`transaction_id`);

--
-- Indexes for table `transfer_creadits`
--
ALTER TABLE `transfer_creadits`
    ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_creadits_student_id_foreign` (`student_id`),
  ADD KEY `transfer_creadits_program_id_foreign` (`program_id`),
  ADD KEY `transfer_creadits_session_id_foreign` (`session_id`),
  ADD KEY `transfer_creadits_semester_id_foreign` (`semester_id`),
  ADD KEY `transfer_creadits_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `transport_members`
--
ALTER TABLE `transport_members`
    ADD PRIMARY KEY (`id`),
  ADD KEY `transport_members_transportable_type_transportable_id_index` (`transportable_type`,`transportable_id`),
  ADD KEY `transport_members_transport_route_id_foreign` (`transport_route_id`),
  ADD KEY `transport_members_transport_vehicle_id_foreign` (`transport_vehicle_id`);

--
-- Indexes for table `transport_routes`
--
ALTER TABLE `transport_routes`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transport_routes_title_unique` (`title`);

--
-- Indexes for table `transport_route_transport_vehicle`
--
ALTER TABLE `transport_route_transport_vehicle`
    ADD KEY `transport_route_transport_vehicle_transport_route_id_foreign` (`transport_route_id`),
  ADD KEY `transport_route_transport_vehicle_transport_vehicle_id_foreign` (`transport_vehicle_id`);

--
-- Indexes for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_staff_id_unique` (`staff_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_program`
--
ALTER TABLE `user_program`
    ADD KEY `user_program_user_id_foreign` (`user_id`),
  ADD KEY `user_program_program_id_foreign` (`program_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
    ADD PRIMARY KEY (`id`),
  ADD KEY `visitors_purpose_id_foreign` (`purpose_id`);

--
-- Indexes for table `visit_purposes`
--
ALTER TABLE `visit_purposes`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visit_purposes_title_unique` (`title`),
  ADD UNIQUE KEY `visit_purposes_slug_unique` (`slug`);

--
-- Indexes for table `web_events`
--
ALTER TABLE `web_events`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_shift_types`
--
ALTER TABLE `work_shift_types`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_shift_types_title_unique` (`title`),
  ADD UNIQUE KEY `work_shift_types_slug_unique` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_settings`
--
ALTER TABLE `application_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_categories`
--
ALTER TABLE `book_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_requests`
--
ALTER TABLE `book_requests`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `call_to_actions`
--
ALTER TABLE `call_to_actions`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_rooms`
--
ALTER TABLE `class_rooms`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_routines`
--
ALTER TABLE `class_routines`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complain_sources`
--
ALTER TABLE `complain_sources`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complain_types`
--
ALTER TABLE `complain_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_types`
--
ALTER TABLE `content_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_notifies`
--
ALTER TABLE `email_notifies`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_references`
--
ALTER TABLE `enquiry_references`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_sources`
--
ALTER TABLE `enquiry_sources`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enroll_subjects`
--
ALTER TABLE `enroll_subjects`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_routines`
--
ALTER TABLE `exam_routines`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_categories`
--
ALTER TABLE `fees_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fees_discounts`
--
ALTER TABLE `fees_discounts`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_fines`
--
ALTER TABLE `fees_fines`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_masters`
--
ALTER TABLE `fees_masters`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_members`
--
ALTER TABLE `hostel_members`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_room_types`
--
ALTER TABLE `hostel_room_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_card_settings`
--
ALTER TABLE `id_card_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_categories`
--
ALTER TABLE `income_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_returns`
--
ALTER TABLE `issue_returns`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_issues`
--
ALTER TABLE `item_issues`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_stocks`
--
ALTER TABLE `item_stocks`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_stores`
--
ALTER TABLE `item_stores`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_suppliers`
--
ALTER TABLE `item_suppliers`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `library_members`
--
ALTER TABLE `library_members`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marksheet_settings`
--
ALTER TABLE `marksheet_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_schedules`
--
ALTER TABLE `meeting_schedules`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_types`
--
ALTER TABLE `meeting_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice_categories`
--
ALTER TABLE `notice_categories`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outside_users`
--
ALTER TABLE `outside_users`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_details`
--
ALTER TABLE `payroll_details`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_logs`
--
ALTER TABLE `phone_logs`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postal_exchanges`
--
ALTER TABLE `postal_exchanges`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postal_exchange_types`
--
ALTER TABLE `postal_exchange_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `print_settings`
--
ALTER TABLE `print_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_semester_sections`
--
ALTER TABLE `program_semester_sections`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result_contributions`
--
ALTER TABLE `result_contributions`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule_settings`
--
ALTER TABLE `schedule_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_settings`
--
ALTER TABLE `social_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_hourly_attendances`
--
ALTER TABLE `staff_hourly_attendances`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_types`
--
ALTER TABLE `status_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_assignments`
--
ALTER TABLE `student_assignments`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_enrolls`
--
ALTER TABLE `student_enrolls`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_leaves`
--
ALTER TABLE `student_leaves`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_relatives`
--
ALTER TABLE `student_relatives`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_transfers`
--
ALTER TABLE `student_transfers`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_markings`
--
ALTER TABLE `subject_markings`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s_m_s_notifies`
--
ALTER TABLE `s_m_s_notifies`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s_m_s_settings`
--
ALTER TABLE `s_m_s_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax_settings`
--
ALTER TABLE `tax_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topbar_settings`
--
ALTER TABLE `topbar_settings`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_creadits`
--
ALTER TABLE `transfer_creadits`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_members`
--
ALTER TABLE `transport_members`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_routes`
--
ALTER TABLE `transport_routes`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
    MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_purposes`
--
ALTER TABLE `visit_purposes`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_events`
--
ALTER TABLE `web_events`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_shift_types`
--
ALTER TABLE `work_shift_types`
    MODIFY `id` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
    ADD CONSTRAINT `assignments_assign_by_foreign` FOREIGN KEY (`assign_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `batch_program`
--
ALTER TABLE `batch_program`
    ADD CONSTRAINT `batch_program_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batch_program_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
    ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `book_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_requests`
--
ALTER TABLE `book_requests`
    ADD CONSTRAINT `book_requests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `book_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
    ADD CONSTRAINT `certificates_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `certificate_templates` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `class_routines`
--
ALTER TABLE `class_routines`
    ADD CONSTRAINT `class_routines_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_routines_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `class_rooms` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `class_routines_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `class_routines_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `class_routines_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `class_routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `class_routines_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `complains`
--
ALTER TABLE `complains`
    ADD CONSTRAINT `complains_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `complain_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
    ADD CONSTRAINT `contents_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `content_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
    ADD CONSTRAINT `districts_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `docables`
--
ALTER TABLE `docables`
    ADD CONSTRAINT `docables_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enroll_subjects`
--
ALTER TABLE `enroll_subjects`
    ADD CONSTRAINT `enroll_subjects_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_subjects_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `enroll_subjects_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `enroll_subject_subject`
--
ALTER TABLE `enroll_subject_subject`
    ADD CONSTRAINT `enroll_subject_subject_enroll_subject_id_foreign` FOREIGN KEY (`enroll_subject_id`) REFERENCES `enroll_subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_subject_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
    ADD CONSTRAINT `exams_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `exam_routines`
--
ALTER TABLE `exam_routines`
    ADD CONSTRAINT `exam_routines_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_routines_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `exam_routines_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `exam_routines_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `exam_routines_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `exam_routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `exam_routine_room`
--
ALTER TABLE `exam_routine_room`
    ADD CONSTRAINT `exam_routine_room_exam_routine_id_foreign` FOREIGN KEY (`exam_routine_id`) REFERENCES `exam_routines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_routine_room_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `class_rooms` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `exam_routine_user`
--
ALTER TABLE `exam_routine_user`
    ADD CONSTRAINT `exam_routine_user_exam_routine_id_foreign` FOREIGN KEY (`exam_routine_id`) REFERENCES `exam_routines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_routine_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
    ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fees_category_fees_discount`
--
ALTER TABLE `fees_category_fees_discount`
    ADD CONSTRAINT `fees_category_fees_discount_fees_category_id_foreign` FOREIGN KEY (`fees_category_id`) REFERENCES `fees_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_category_fees_discount_fees_discount_id_foreign` FOREIGN KEY (`fees_discount_id`) REFERENCES `fees_discounts` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `fees_category_fees_fine`
--
ALTER TABLE `fees_category_fees_fine`
    ADD CONSTRAINT `fees_category_fees_fine_fees_category_id_foreign` FOREIGN KEY (`fees_category_id`) REFERENCES `fees_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_category_fees_fine_fees_fine_id_foreign` FOREIGN KEY (`fees_fine_id`) REFERENCES `fees_fines` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `fees_discount_status_type`
--
ALTER TABLE `fees_discount_status_type`
    ADD CONSTRAINT `fees_discount_status_type_fees_discount_id_foreign` FOREIGN KEY (`fees_discount_id`) REFERENCES `fees_discounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_discount_status_type_status_type_id_foreign` FOREIGN KEY (`status_type_id`) REFERENCES `status_types` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `fees_master_student_enroll`
--
ALTER TABLE `fees_master_student_enroll`
    ADD CONSTRAINT `fees_master_student_enroll_fees_master_id_foreign` FOREIGN KEY (`fees_master_id`) REFERENCES `fees_masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_master_student_enroll_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `hostel_members`
--
ALTER TABLE `hostel_members`
    ADD CONSTRAINT `hostel_members_hostel_room_id_foreign` FOREIGN KEY (`hostel_room_id`) REFERENCES `hostel_rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostel_rooms`
--
ALTER TABLE `hostel_rooms`
    ADD CONSTRAINT `hostel_rooms_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostel_rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `hostel_room_types` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
    ADD CONSTRAINT `incomes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `income_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issue_returns`
--
ALTER TABLE `issue_returns`
    ADD CONSTRAINT `issue_returns_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_returns_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `library_members` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
    ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `item_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_issues`
--
ALTER TABLE `item_issues`
    ADD CONSTRAINT `item_issues_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_stocks`
--
ALTER TABLE `item_stocks`
    ADD CONSTRAINT `item_stocks_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_stocks_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `item_stores` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
    ADD CONSTRAINT `leaves_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `meeting_schedules`
--
ALTER TABLE `meeting_schedules`
    ADD CONSTRAINT `meeting_schedules_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `meeting_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
    ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
    ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
    ADD CONSTRAINT `notices_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `notice_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll_details`
--
ALTER TABLE `payroll_details`
    ADD CONSTRAINT `payroll_details_payroll_id_foreign` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `postal_exchanges`
--
ALTER TABLE `postal_exchanges`
    ADD CONSTRAINT `postal_exchanges_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `postal_exchange_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
    ADD CONSTRAINT `programs_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_class_room`
--
ALTER TABLE `program_class_room`
    ADD CONSTRAINT `program_class_room_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_class_room_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `program_semester`
--
ALTER TABLE `program_semester`
    ADD CONSTRAINT `program_semester_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_semester_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `program_semester_sections`
--
ALTER TABLE `program_semester_sections`
    ADD CONSTRAINT `program_semester_sections_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_semester_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `program_semester_sections_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `program_session`
--
ALTER TABLE `program_session`
    ADD CONSTRAINT `program_session_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_session_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `program_subject`
--
ALTER TABLE `program_subject`
    ADD CONSTRAINT `program_subject_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
    ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `staff_attendances`
--
ALTER TABLE `staff_attendances`
    ADD CONSTRAINT `staff_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_hourly_attendances`
--
ALTER TABLE `staff_hourly_attendances`
    ADD CONSTRAINT `staff_hourly_attendances_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_hourly_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `status_type_student`
--
ALTER TABLE `status_type_student`
    ADD CONSTRAINT `status_type_student_status_type_id_foreign` FOREIGN KEY (`status_type_id`) REFERENCES `status_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `status_type_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `student_assignments`
--
ALTER TABLE `student_assignments`
    ADD CONSTRAINT `student_assignments_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_assignments_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `student_attendances`
--
ALTER TABLE `student_attendances`
    ADD CONSTRAINT `student_attendances_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendances_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `student_enrolls`
--
ALTER TABLE `student_enrolls`
    ADD CONSTRAINT `student_enrolls_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_enrolls_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `student_enrolls_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `student_enrolls_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `student_enrolls_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `student_enroll_subject`
--
ALTER TABLE `student_enroll_subject`
    ADD CONSTRAINT `student_enroll_subject_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_enroll_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `student_leaves`
--
ALTER TABLE `student_leaves`
    ADD CONSTRAINT `student_leaves_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_relatives`
--
ALTER TABLE `student_relatives`
    ADD CONSTRAINT `student_relatives_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_transfers`
--
ALTER TABLE `student_transfers`
    ADD CONSTRAINT `student_transfers_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_markings`
--
ALTER TABLE `subject_markings`
    ADD CONSTRAINT `subject_markings_student_enroll_id_foreign` FOREIGN KEY (`student_enroll_id`) REFERENCES `student_enrolls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_markings_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `transfer_creadits`
--
ALTER TABLE `transfer_creadits`
    ADD CONSTRAINT `transfer_creadits_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfer_creadits_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON
DELETE
CASCADE,
  ADD CONSTRAINT `transfer_creadits_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `transfer_creadits_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE
CASCADE,
  ADD CONSTRAINT `transfer_creadits_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `transport_members`
--
ALTER TABLE `transport_members`
    ADD CONSTRAINT `transport_members_transport_route_id_foreign` FOREIGN KEY (`transport_route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_members_transport_vehicle_id_foreign` FOREIGN KEY (`transport_vehicle_id`) REFERENCES `transport_vehicles` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `transport_route_transport_vehicle`
--
ALTER TABLE `transport_route_transport_vehicle`
    ADD CONSTRAINT `transport_route_transport_vehicle_transport_route_id_foreign` FOREIGN KEY (`transport_route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_route_transport_vehicle_transport_vehicle_id_foreign` FOREIGN KEY (`transport_vehicle_id`) REFERENCES `transport_vehicles` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `user_program`
--
ALTER TABLE `user_program`
    ADD CONSTRAINT `user_program_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_program_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
    ADD CONSTRAINT `visitors_purpose_id_foreign` FOREIGN KEY (`purpose_id`) REFERENCES `visit_purposes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
