<?php
namespace Mongolid\Query;

use Mongolid\Connection\Connection;
use Mongolid\Connection\Pool;

/**
 * Represents a query being made to the database trought a connection in the
 * Pool
 *
 * @package  Mongolid
 */
class Query
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Pool $connectionPool
     */
    public function __construct(Pool $connectionPool)
    {
        $this->connection = $connectionPool->getConnection();
    }

    /**
     * Performs the save() operation into MongoDB.
     * @return boolean
     */
    public function save($collection, $document)
    {
        $result = $this->connection->getRawConnection()
            ->test->$collection->save($document);

        return $this->parseResult($result);
    }

    /**
     * Performs the update() operation into MongoDB.
     * @return boolean
     */
    public function update($collection, $document)
    {
        if (! isset($document['_id'])) {
            return false;
        }

        $result = $this->connection->getRawConnection()
            ->test->$collection->update(['_id' => $document['_id']] $document);

        return $this->parseResult($result);
    }

    /**
     * Performs the insert() operation into MongoDB.
     * @return boolean
     */
    public function insert($collection, $document)
    {
        $result = $this->connection->getRawConnection()
            ->test->$collection->insert($document);

        return $this->parseResult($result);
    }

    /**
     * Interprets the MongoDB response to understand if an 'ok' has retured
     * @param  array   $results
     * @return boolean Success
     */
    protected function parseResult(array $results)
    {
        return isset($results['ok']) && $results['ok']?: false;
    }
}
