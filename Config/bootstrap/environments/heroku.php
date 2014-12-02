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
    Cache::config('default', array(
        'engine' => 'Memcached',
        'prefix' => 'mc_',
        'duration' => '+7 days',
        'servers' => explode(',', getenv('MEMCACHIER_SERVERS')),
        'compress' => false,
        'persistent' => 'memcachier',
        'login' => getenv('MEMCACHIER_USERNAME'),
        'password' => getenv('MEMCACHIER_PASSWORD'),
        'serialize' => 'php'
    ));

    // Session Settings
    Configure::write('Session', array(
        'defaults' => 'cache'
    ));
});
