<?php

use PHPUnit\Framework\TestCase;
use EloquentFilter\TestClass\User;
use EloquentFilter\TestClass\Client;
use EloquentFilter\TestClass\UserFilter;
use Mockery as m;

class ModelFilterChildTest extends TestCase
{
    public function testGetRelatedModel()
    {
        $userMock = m::mock('User');
        $userQueryMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $hasManyMock = m::mock('Illuminate\Database\Eloquent\Relations\HasMany');

        $userQueryMock->shouldReceive('getModel')->once()->andReturn($userMock);

        $userMock->shouldReceive('clients')->once()->andReturn($hasManyMock);

        $hasManyMock->shouldReceive('getRelated')->once()->andReturn(new Client);

        $client = (new UserFilter($userQueryMock))->getRelatedModel('clients');

        $this->assertEquals($client, new Client);
    }

    public function tearDown()
    {
        m::close();
    }
}
