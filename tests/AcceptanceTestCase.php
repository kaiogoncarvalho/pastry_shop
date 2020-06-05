<?php

namespace Test;

use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Test\Traits\DatabaseMigrationsOnce;
use Test\Traits\CreateDatabaseTest;

abstract class AcceptanceTestCase extends TestCase
{
    use DatabaseMigrationsOnce, DatabaseTransactions, CreateDatabaseTest;

    protected function setUpTraits(){
        $this->runCreateDatabaseTest();
        $this->runDatabaseMigrationsOnce();
        parent::setUpTraits();
    }

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }
}
