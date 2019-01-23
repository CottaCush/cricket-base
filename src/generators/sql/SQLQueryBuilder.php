<?php

namespace CottaCush\Cricket\Generators\SQL;

use CottaCush\Cricket\Interfaces\QueryInterface;
use yii\helpers\ArrayHelper;

/**
 * Class SQLQueryBuilder
 * @package CottaCush\Cricket\Generators\SQL
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLQueryBuilder
{
    const START_DATE_PLACEHOLDER = ':start';
    const END_DATE_PLACEHOLDER = ':end';

    public $query;
    public $data;

    public function __construct(QueryInterface $query, array $data)
    {
        $this->query = $query;
        $this->data = $data;
    }

    public function buildQuery()
    {
        //TODO: Validate the query using the placeholders with the data sent
        $query = $this->query->getQuery();

        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                $value = "'" . implode("', '", $value) . "'";
            }
            $query = str_replace($key, $value, $query);
        }
        return $query;
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param $filterPlaceholders
     * @return mixed
     */
    public function buildDashboardQuery($filterPlaceholders)
    {
        $query = $this->query->getQuery();
        $placeholdersMap = ArrayHelper::map($filterPlaceholders, 'name', 'description');
        $startDate = ArrayHelper::getValue($this->data, 'startDate');
        $endDate = ArrayHelper::getValue($this->data, 'endDate');

        if ($startDate) {
            $query = $this->replacePlaceholder(
                $query,
                "'" . self::START_DATE_PLACEHOLDER . "'",
                $placeholdersMap[self::START_DATE_PLACEHOLDER],
                $startDate,
                '>='
            );
        }
        if ($endDate) {
            $query = $this->replacePlaceholder(
                $query,
                "'" . self::END_DATE_PLACEHOLDER . "'",
                $placeholdersMap[self::END_DATE_PLACEHOLDER],
                $endDate,
                '<='
            );
        }
        return $query;
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param $string
     * @param $match
     * @param $field
     * @param $filterValue
     * @param $operator
     * @return mixed
     */
    private function replacePlaceholder($string, $match, $field, $filterValue, $operator)
    {
        $initialMatchStart = stripos($string, $match);
        if ($initialMatchStart == 0) {
            return $string;
        }
        $firstOccurrence = $initialMatchStart + strlen($match); //end of first match
        $placeholderPosition = stripos($string, $match, $firstOccurrence) - $firstOccurrence;
        $placeholderSeparator = substr($string, $initialMatchStart, $placeholderPosition);
        $totalPlaceholderLength = strlen($placeholderSeparator) + (strlen($match) * 2);
        $string = substr_replace(
            $string,
            $this->parseFilterCondition($field, $operator, $filterValue),
            $initialMatchStart,
            $totalPlaceholderLength
        );
        return $string;
    }

    /**
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param $field
     * @param $filterValue
     * @param $operator
     * @return string
     */
    private function parseFilterCondition($field, $filterValue, $operator)
    {
        return "DATE($field) $filterValue '$operator'";
    }
}
