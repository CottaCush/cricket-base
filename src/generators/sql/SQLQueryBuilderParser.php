<?php

namespace CottaCush\Cricket\Generators\SQL;

use CottaCush\Cricket\Interfaces\CricketQueryableInterface;
use CottaCush\Cricket\Models\Query;
use CottaCush\Cricket\Traits\ValueGetter;
use yii\helpers\ArrayHelper;

class SQLQueryBuilderParser
{
    use ValueGetter;

    private $hasPlaceholdersReplaced = false;
    private $placeholderValues;
    private $hasInputPlaceholders;

    public $query;

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
     * @param CricketQueryableInterface $report
     * @param array $placeholderValues
     * @param null $db
     * @param string $function
     * @param array $paginationExtras
     * @return array
     * @throws \CottaCush\Cricket\Exceptions\SQLQueryGenerationException
     */
    public function parse(
        CricketQueryableInterface $report,
        $placeholderValues = [],
        $db = null,
        $function = SQLGenerator::QUERY_ALL,
        $paginationExtras = []
    ) {
        /** @var Query $queryObj */
        $queryObj = $report->query;
        $page = ArrayHelper::getValue($paginationExtras, 'page');
        $paginate = boolval(ArrayHelper::getValue($paginationExtras, 'paginate'));

        $shouldReplacePlaceholders = !empty($placeholderValues); //Should the placeholders be replaced in the query
        $this->hasInputPlaceholders = count($queryObj->inputPlaceholders);

        if (!empty($paginationExtras) && $page) {
            $this->query = ArrayHelper::getValue($paginationExtras, 'query_string');
            $this->hasPlaceholdersReplaced = true;
        } else {
            $this->query = $queryObj->getQuery();
        }

        $data = [];

        if (!$this->hasInputPlaceholders && !$paginate) { // Report has only session placeholders or none
            $shouldReplacePlaceholders = true;
            $placeholders = $queryObj->sessionPlaceholders;
            $placeholderValues = [];

            foreach ($placeholders as $placeholder) {
                $placeholderValues[$placeholder->name] = $this->getSessionVariable($placeholder->description);
            }
        }

        //If there are placeholders to be injected into the query before execution and not the first page
        if ($shouldReplacePlaceholders && !$page) {
            $queryBuilder = new SQLQueryBuilder($queryObj, $placeholderValues);
            $this->query = $queryBuilder->buildQuery();

            $generator = new SQLGenerator($this->query, $db);
            $data = $generator->generateResult($function, $paginate, $page);

            $this->hasPlaceholdersReplaced = true;
        } else {
            if (!$this->hasInputPlaceholders || $page) { //No session placeholders and no submission
                $generator = new SQLGenerator($this->query, $db);
                $data = $generator->generateResult($function, $paginate, $page);
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
