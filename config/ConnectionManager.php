<?php

namespace Configuration;

use Illuminate\Database\Capsule\Manager;

/**
 * Responsável por encapsular o acesso ao banco de dados utilizando Eloquent
 * @author Carlos Eduardo L. Braz <carloseduardolbraz@gmail.com>
 * @package Configuration
 */
class ConnectionManager
{
    /**
     * Encapsula a conexão com o banco de dados
     *
     * @param string $databaseName
     * @return void
     */
    public static function createConnection($databaseName = 'default')
    {
        $databaseSettings = resolve('settings')['database'][$databaseName];
        $manager = new Manager();
        $manager->addConnection($databaseSettings);
        $manager->setAsGlobal();
        $manager->bootEloquent();
    }
}