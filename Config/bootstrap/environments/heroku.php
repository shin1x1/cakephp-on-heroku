<?php
Environment::configure('heroku', false, [
], function () {
    /**
     * Configures default file logging options
     */
    App::uses('CakeLog', 'Log');
    App::uses('ConsoleOutput', 'Console');
    CakeLog::config('debug', [
        'engine' => 'ConsoleLog',
        'stream' => new ConsoleOutput(),
    ]);
    CakeLog::config('error', [
        'engine' => 'ConsoleLog',
        'stream' => new ConsoleOutput('php://stderr'),
    ]);

    // Database settings
    if (empty(getenv('DATABASE_URL'))) {
        throw new CakeException('no DATABASE_URL environment variable');
    }
    $url = parse_url(getenv('DATABASE_URL'));
    Configure::write('DATABASE_OPTIONS', [
        'datasource' => 'Database/Postgres',
        'persistent' => false,
        'host' => $url['host'],
        'login' => $url['user'],
        'password' => $url['pass'],
        'database' => substr($url['path'], 1),
    ]);

    // Cache settings
    if (empty(getenv('REDISCLOUD_URL'))) {
        throw new CakeException('no REDISCLOUD_URL environment variable');
    }
    $url = parse_url(getenv('REDISCLOUD_URL'));
    var_dump($url);
    Cache::config('default', [
        'engine' => 'Redis',
        'server' => $url['host'],
        'port' => $url['port'],
        'compress' => false,
        'password' => $url['pass'],
        'serialize' => 'php'
    ]);

    // Session Settings
    Configure::write('Session', [
        'defaults' => 'cache',
    ]);
});
