<?php
namespace src;

class Config {
    const BASE_DIR = '/liberacaoAcesso/public';

    const DB_DRIVER = 'pgsql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'liberacao_acesso';
    CONST DB_USER = 'postgres';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}