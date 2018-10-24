<?php

namespace bupy7\activerecord\history\base;

/**
 * The shim file has been created because `object` has become a reserved word which can not be
 * used as class name in PHP 7.2.
 *
 * @since 1.1.2
 */

if (class_exists('yii\base\BaseObject')) {
    class BaseObject extends \yii\base\BaseObject {

    }
} else {
    class BaseObject extends \yii\base\Object {

    }
}
