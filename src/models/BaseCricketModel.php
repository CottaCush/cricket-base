<?php

namespace CottaCush\Cricket\Models;

use CottaCush\Cricket\Libs\Utils;
use yii\db\ActiveRecord;

/**
 * Class BaseCricketModel
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Models
 *
 * @property int $id
 */
class BaseCricketModel extends ActiveRecord
{
    public function getEncodedId()
    {
        return Utils::encodeId($this->id);
    }
}
