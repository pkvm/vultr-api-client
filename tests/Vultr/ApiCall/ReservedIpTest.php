<?php

namespace Vultr\Tests;

use Vultr\VultrClient;

class ReservedIpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VultrClient
     */
    protected $client;

    /**
     * @var JsonData
     */
    protected $jsonData;

    protected function setUp()
    {
        $adapterClass = 'Vultr\Adapter\\' . getenv('ADAPTER');

        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $this->client = new VultrClient($adapter);
    }

    public function testGetList()
    {
        $result = $this->client->reservedIp()->getList();

        $this->assertArrayHasKey('subnet', array_shift($result));
    }

    public function testAttach()
    {
        $result = $this->client->reservedIp()->attach('127.0.0.1', 1255);

        $this->assertInternalType('int', $result);
    }

    public function testDetach()
    {
        $result = $this->client->reservedIp()->detach('127.0.0.1', 1255);

        $this->assertInternalType('int', $result);
    }

    public function testCreate()
    {
        $result = $this->client->reservedIp()->create(1, 'v6');

        $this->assertInternalType('int', $result);
    }

    /**
     * @expectedException              \Vultr\Exception\ApiException
     * @expectedExceptionMessageRegExp #IP type must be one of .*\.#
     */
    public function testCreateException()
    {
        $this->client->reservedIp()->create(1, 'v42');
    }

    public function testDestroy()
    {
        $result = $this->client->reservedIp()->destroy(1);

        $this->assertInternalType('int', $result);
    }
}
