<?php

    class Tweet {
        protected $pdo;

        function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
    }


?>