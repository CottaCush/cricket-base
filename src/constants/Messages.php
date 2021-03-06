<?php

namespace CottaCush\Cricket\Constants;

class Messages
{
    const RECORD_NOT_FOUND = 'Record not found';

    const ENTITY_REPORT = 'Report';
    const ENTITY_DASHBOARD = 'Dashboard';

    public static function getNotFoundMessage($entity = 'Record')
    {
        return sprintf('%s not found', $entity);
    }
}
