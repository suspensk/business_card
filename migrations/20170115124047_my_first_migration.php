<?php

use \App\Migration\Migration;

class MyFirstMigration extends Migration
{
    public function up()
    {
//        $this->schema->create('widgets', function(Illuminate\Database\Schema\Blueprint $table){
//            // Auto-increment id
//            $table->increments('id');
//            $table->integer('serial_numberx');
//            $table->string('namey');
//            // Required for Eloquent's created_at and updated_at columns
//            $table->timestamps();
//        });
        $this->execute("


CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL,
  `book-title` varchar(250) NOT NULL DEFAULT '0',
  `author` varchar(250) NOT NULL DEFAULT '0',
  `amazon_url` varchar(250) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `text` text,
  `text-en` text,
  `category` int(11) DEFAULT NULL,
  `meta-description` text,
  `meta-keywords` text,
  `visible` enum('0','1') DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `edited` timestamp NULL DEFAULT NULL,
  `user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poems`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `poems` (
  `id` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `text` text,
  `num` int(11) DEFAULT NULL,
  `visible` enum('0','1') DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `writing_date` timestamp NULL DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poem_category`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `poem_category` (
  `id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `category` enum('book','film') DEFAULT NULL,
  `content` text,
  `source` varchar(50) DEFAULT NULL,
  `published` enum('0','1') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `review_attachment`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `review_attachment` (
  `review` int(11) DEFAULT NULL,
  `attachment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jan 11, 2017 at 10:27 AM
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`), ADD KEY `FK_pages_pages` (`parent`), ADD KEY `FK_pages_users` (`user`);

--
-- Indexes for table `poems`
--
ALTER TABLE `poems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poem_category`
--
ALTER TABLE `poem_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_attachment`
--
ALTER TABLE `review_attachment`
  ADD UNIQUE KEY `review_attachement` (`review`,`attachment`), ADD KEY `FK_review_attachement_attachement` (`attachment`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `poems`
--
ALTER TABLE `poems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `poem_category`
--
ALTER TABLE `poem_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
ADD CONSTRAINT `FK_pages_pages` FOREIGN KEY (`parent`) REFERENCES `pages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `review_attachment`
--
ALTER TABLE `review_attachment`
ADD CONSTRAINT `FK_review_attachment_attachement` FOREIGN KEY (`attachment`) REFERENCES `attachments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_review_attachment_reviews` FOREIGN KEY (`review`) REFERENCES `reviews` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

");

    }
    public function down()
    {
        $this->schema->drop('widgets');
    }
}
