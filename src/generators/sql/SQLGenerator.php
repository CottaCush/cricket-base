<?php

namespace CottaCush\Cricket\Generators\SQL;

use CottaCush\Cricket\Exceptions\SQLQueryGenerationException;
use CottaCush\Cricket\Interfaces\GeneratorInterface;
use Exception;
use Yii;
use yii\db\Connection;

/**
 * Class SQLGenerator
 * @package CottaCush\Cricket\Generators\SQL
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLGenerator implements GeneratorInterface
{
    private $query;
    private $db;

    private $isFreshConnection = false;

    const QUERY_ALL = 'queryAll';
    const QUERY_ONE = 'queryOne';
    const QUERY_COLUMN = 'queryColumn';
    const QUERY_SCALAR = 'queryScalar';
    const QUERY_LIMIT = 20;

    public function __construct($query, Connection $db = null)
    {
        $this->query = $query;
        $this->db = $db;

        if (is_null($db)) {
            $this->db = Yii::$app->db;
        }
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param string $function
     * @param bool $paginate
     * @param null $page
     * @return array
     * @throws SQLQueryGenerationException
     */
    public function generateResult($function = self::QUERY_ALL, $paginate = false, $page = null)
    {
        try {
            $this->openConnection();
            $count = 0;
            $this->query = rtrim($this->query, ';');
            if ($paginate) {
                if (!$page) { // first page of pagination
                    $count =  $this->db->createCommand("SELECT COUNT(*) as total FROM ($this->query) a")
                        ->{self::QUERY_SCALAR}();
                }
                $from = $page ? ($page - 1) * self::QUERY_LIMIT : 0;
                $result = $this->db->createCommand("$this->query LIMIT $from, " . self::QUERY_LIMIT)
                    ->{self::QUERY_ALL}();
            } else {
                $result = $this->db->createCommand($this->query)->{$function}();
            }
            $this->closeConnection();
        } catch (Exception $e) {
            throw new SQLQueryGenerationException($e->getMessage());
        }
        return ['data' => $result, 'count' => $count];
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @throws \yii\db\Exception
     */
    private function openConnection()
    {
        if (is_null($this->db) || !$this->db->isActive) {
            $this->isFreshConnection = true;
            $this->db->open();
        }
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     */
    private function closeConnection()
    {
        if (!$this->isFreshConnection) {
            $this->db->close();
        }
    }
}
