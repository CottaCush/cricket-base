<?php

namespace CottaCush\Cricket\Generators\SQL;

use CottaCush\Cricket\Interfaces\CricketQueryableInterface;
use CottaCush\Cricket\Traits\ValueGetter;

class SQLQueryBuilderParser
{
    use ValueGetter;

    private $hasPlaceholdersReplaced = false;
    private $placeholderValues;
    private $hasInputPlaceholders;

    public $query;

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param CricketQueryableInterface $report
     * @param array $placeholderValues
     * @param null $db
     * @param string $function
     * @return array
     * @throws \CottaCush\Cricket\Exceptions\SQLQueryGenerationException
     */
    public function parse(
        CricketQueryableInterface $report,
        $placeholderValues = [],
        $db = null,
        $function = SQLGenerator::QUERY_ALL
    ) {
        $queryObj = $report->query;
        $shouldReplacePlaceholders = !empty($placeholderValues); //Should the placeholders be replaced in the query
        $this->hasInputPlaceholders = count($queryObj->inputPlaceholders);

        $this->query = $queryObj->getQuery();
        $data = [];

        if (!$this->hasInputPlaceholders) { // Report has only session placeholders or none
            $shouldReplacePlaceholders = true;
            $placeholders = $queryObj->sessionPlaceholders;
            $placeholderValues = [];

            foreach ($placeholders as $placeholder) {
                $placeholderValues[$placeholder->name] = $this->getSessionVariable($placeholder->description);
            }
        }

        if ($shouldReplacePlaceholders) { //If there are placeholders to be injected into the query before execution
            $queryBuilder = new SQLQueryBuilder($queryObj, $placeholderValues);
            $this->query = $queryBuilder->buildQuery();

            $generator = new SQLGenerator($this->query, $db);
            $data = $generator->generateResult($function);

            $this->hasPlaceholdersReplaced = true;
        } else {
            if (!$this->hasInputPlaceholders) { //No session placeholders and no submission
                $generator = new SQLGenerator($this->query, $db);
                $data = $generator->generateResult($function);
            }
        }

        return $data;
    }

    public function arePlaceholdersReplaced()
    {
        return $this->hasPlaceholdersReplaced;
    }

    /**
     * @return mixed
     */
    public function getPlaceholderValues()
    {
        return $this->placeholderValues;
    }

    public function hasInputPlaceholders()
    {
        return $this->hasInputPlaceholders;
    }
}
