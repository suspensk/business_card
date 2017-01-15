<?php

use \App\Migration\Migration;

class BooksChanges extends Migration
{
    public function up()
    {
        $this->execute("
ALTER TABLE `books`
	CHANGE COLUMN `book-title` `title` VARCHAR(250) NOT NULL DEFAULT '0' AFTER `id`;
        ");
    }
}
