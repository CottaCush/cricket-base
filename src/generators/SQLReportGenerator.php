<?php

namespace CottaCush\Cricket\Generators;

use CottaCush\Cricket\Exceptions\SQLReportGenerationException;
use CottaCush\Cricket\Interfaces\ReportGeneratorInterface;
use Exception;
use Yii;
use yii\db\Connection;

/**
 * Class SQLReportGenerator
 * @package CottaCush\Cricket\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLReportGenerator implements ReportGeneratorInterface
{
    private $query;
    private $db;

    private $isFreshConnection = false;

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
     * @return array
     * @throws SQLReportGenerationException
     */
    public function generateReport()
    {
        try {
            $this->openConnection();
            $result = $this->db->createCommand($this->query)->queryAll();
            $this->closeConnection();
        } catch (Exception $e) {
            throw new SQLReportGenerationException($e->getMessage());
        }
        return $result;
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