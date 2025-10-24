<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \MMBuxan\VeriFactu\Providers\VeriFactuServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configuración mínima para pruebas, por ejemplo:
        $app['config']->set('verifactu.issuer', [
            'name' => 'Test Issuer',
            'vat' => 'A00000000',
        ]);
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        putenv('VERIFACTU_CERT_PATH=certsDemo/Ciudadano_autenticacion_Activo.cer');
        $app['config']->set('verifactu.enable_breakdown_validation', true);
    }
} 