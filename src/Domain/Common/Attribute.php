<?php

namespace RakutenSDK\Domain\Common;

use RakutenSDK\Core\Domain\BaseObject;

/**
 * @method string  getLabel()
 * @method string  getKey()
 * @method bool isMandatory()
 * @method string getValueType() can be "Text" "Number" "Boolean" "Date"
 * @method string hasValuesList()
 * @method string getValuesList()
 * @method bool isWithValues()
 * @method bool isMultipleValues()
 * @method string getUnits()
 * @method string getUnit()
 */
class Attribute extends BaseObject
{
    protected static array $mapping = [
        'hasvalues' => 'with_values',
        'multivalued' => 'multiple_values',
        'valuetype' => 'value_type',
        'valueslist/value' => 'values_list',
    ];

    protected static array $dataTypes = [
        'with_values' => 'boolval',
        'multiple_values' => 'boolval',
        'mandatory' => 'boolval',
    ];

}
