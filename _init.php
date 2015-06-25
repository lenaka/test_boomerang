<?php
require_once 'lib/Command.php';

/*
 * Launch only once!
 * Init DB data
 */
class Init extends Command
{
    public function Run()
    {
        if (!$this->Db->Query("
        DROP TABLE IF EXISTS `users`"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `uname` varchar(50) NOT NULL DEFAULT '',
          PRIMARY KEY (`id`),
          UNIQUE KEY `uname` (`uname`),
          KEY `name` (`uname`)
        ) ENGINE=InnoDB"))
        { echo $this->Db->Error(); }
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("DROP TABLE IF EXISTS `score`"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        CREATE TABLE `score` (
          `user_id` int(11) NOT NULL,
          `value` int(11) NOT NULL,
          `score_date` date NOT NULL,
          KEY `FKscore2user_id` (`user_id`),
          KEY `score_date` (`score_date`),
          CONSTRAINT `FKscore2user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (1, 'Анна')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (2, 'Борис')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (3, 'Владимир')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (4, 'Георгий')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (5, 'Дмитрий')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (6, 'Евгений')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (7, 'Жанна')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (8, 'Зинаида')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (9, 'Мария')"))
        { echo $this->Db->Error(); }
        if (!$this->Db->Query("
        INSERT INTO `users` VALUES (10, 'Николай')"))
        { echo $this->Db->Error(); }

        for ($i=0; $i<100; $i++)
        {
            $userId = rand(1, 10);
            $score = rand(16, 99);
            $date = new DateTime('2015-'.rand(1,6).'-'.rand(1,28));
            echo "score: {$userId}, {$score}, ".$date->format('d.m.Y')."<br>\n";
            $this->Db->Query("
            INSERT INTO score (user_id, value, score_date)
            VALUES ({$userId}, {$score}, '".$date->format('Y-m-d')."')
            ");
        }
    }
}
$i = new Init($config);
$i->Run();
