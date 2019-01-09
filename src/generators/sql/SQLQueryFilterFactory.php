<?php

namespace CottaCush\Cricket\Generators\SQL;

use CottaCush\Cricket\Exceptions\SQLQueryGenerationException;
use CottaCush\Cricket\Interfaces\PlaceholderInterface;
use CottaCush\Cricket\Interfaces\QueryInterface;
use CottaCush\Cricket\Models\PlaceholderType;
use CottaCush\Cricket\Traits\ValueGetter;
use kartik\select2\Select2;
use yii\db\ActiveQuery;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class SQLQueryFilterFactory
 * @package CottaCush\Cricket\Generators
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class SQLQueryFilterFactory
{
    use ValueGetter;

    public $placeholder;
    public $database;

    public function __construct(PlaceholderInterface $placeholder = null, Connection $database = null)
    {
        $this->database = $database;
        $this->placeholder = $placeholder;
    }

    public function createWidget($value = null)
    {
        $name = ArrayHelper::getValue($this->placeholder, 'name');
        $type = ArrayHelper::getValue($this->placeholder, 'placeholder_type');
        $description = ArrayHelper::getValue($this->placeholder, 'description');

        switch ($type) {
            case PlaceholderType::TYPE_BOOLEAN:
                return Html::beginTag('div', ['class' => 'form-group col-sm-12']) .
                    Html::tag('label', $description, ['class' => 'control-label']) .
                    Html::radioList($name, $value, PlaceholderType::BOOLEAN_VALUES_MAP, [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $return = '<label class="cricket-radio-inline">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value .
                                '" checked="' . $checked . '" required>';
                            $return .= ucwords($label);
                            $return .= '</label>';

                            return $return;
                        },
                    ]) .
                    Html::endTag('div');
                break;

            case PlaceholderType::TYPE_DATE:
                return Html::beginTag('div', ['class' => 'form-group col-sm-12']) .
                    Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput(
                        $name,
                        $value,
                        ['class' => 'form-control date-picker', 'required' => true, 'autocomplete' => "off"]
                    ) .
                    Html::endTag('div');
                break;

            case PlaceholderType::TYPE_SESSION:
                return Html::hiddenInput($name, $this->getSessionVariable($description));
                break;

            case PlaceholderType::TYPE_DROPDOWN:
                try {
                    return $this->generateDropdown($value);
                } catch (SQLQueryGenerationException $e) {
                }
                break;

            default:
                return Html::beginTag('div', ['class' => 'form-group col-sm-12']) .
                    Html::label($description, $name, ['class' => 'control-label']) .
                    Html::textInput(
                        $name,
                        $value,
                        ['class' => 'form-control', 'required' => true, 'autocomplete' => "off"]
                    ) .
                    Html::endTag('div');
                break;
        }
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param PlaceholderInterface $placeholder
     */
    public function setPlaceholder(PlaceholderInterface $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @author Olawale Lawal <wale@cottacush.com>
     * @param null $value
     * @return string
     * @throws SQLQueryGenerationException
     */
    private function generateDropdown($value = null)
    {
        /** @var QueryInterface $dropdownQuery */
        $dropdownQuery = $this->placeholder->getDropdownQuery()->one(); //Get the report used as dropdown placeholder
        $html = '';

        if (!$dropdownQuery) {
            return $html;
        }

        //Get the placeholders of the dropdown query
        $placeholders = $dropdownQuery->getPlaceholders();

        if ($placeholders instanceof ActiveQuery) {
            $placeholders = $placeholders->asArray()->all();
        }

        //Set the value of each placeholder
        $placeholderValues = [];
        foreach ($placeholders as $placeholder) {
            $placeholderValues[$placeholder['name']] = $this->getSessionVariable($placeholder['description']);
        }

        //Build the query from the report to get data
        $queryBuilder = new SQLQueryBuilder($dropdownQuery, $placeholderValues);
        $generator = new SQLGenerator($queryBuilder->buildQuery(), $this->database);
        $data = $generator->generateResult();

        if (count($data)) {
            $data = ArrayHelper::map($data, 'key', 'value');
        }

        //Generate the dropdown from the values
        $html .= Html::beginTag('div', ['class' => 'form-group col-sm-12']) .
            Html::label($dropdownQuery->name, $this->placeholder->getName(), ['class' => 'control-label']) .
            Select2::widget([
                'name' => $this->placeholder->getName(),
                'value' => $value,
                'data' => $data,
                'options' => [
                    'multiple' => true, 'placeholder' => 'Select ' . $dropdownQuery->name, 'required' => true,
                    'data-error' => 'Choose an operation'
                ]
            ]) .
            Html::endTag('div');
        return $html;
    }
}
