<?php

namespace CottaCush\Cricket\Interfaces;

/**
 * Interface CricketQueryableInterface
 * @package CottaCush\Cricket\Interfaces
 * @property string type
 */
interface CricketQueryableInterface
{
    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return QueryInterface
     */
    public function getQuery();
}
