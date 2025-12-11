<?php

class DatabaseConfig {
    // const DB_HOST = 'localhost';
    const DB_NAME = 'db-shoes.sqlite';
    // const DB_USER = 'sa';
    // const DB_PASS = '123';

    // const SITE_NAME = 'Shoe Shop';
    // const BASE_URL = 'http://localhost/shoe_shop';
    const DB_PATH = '/'.self::DB_NAME;


}
return new DatabaseConfig();