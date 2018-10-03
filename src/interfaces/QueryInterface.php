<?php

namespace CottaCush\Cricket\Interfaces;

/**
 * Interface QueryInterface
 * @package CottaCush\Cricket\Interfaces
 *
 * @property PlaceholderInterface[] $placeholders
 * @property PlaceholderInterface[] $inputPlaceholders
 * @property PlaceholderInterface[] $sessionPlaceholders
 * @property PlaceholderInterface[] $dropdownPlaceholders
 */
interface QueryInterface
{
    public function getQuery();

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @return PlaceholderInterface[]
     */
    public function getPlaceholders();

    public function getInputPlaceholders();

    public function getSessionPlaceholders();

    public function hasInputPlaceholders();

    public function getPlaceholderQueries();

    public function getDropdownPlaceholders();
}
