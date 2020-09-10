<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin think\Model
 */
class runtimeinfo extends Model
{
    protected $name = 'runtimeinfo';
    protected $pk = 'solution_id';
}
