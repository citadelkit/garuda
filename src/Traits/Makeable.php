<?php 

namespace CitadelKit\Garuda\Traits;

use Illuminate\Support\Str;

trait Makeable {

    protected $field = 'id';
    protected $title = 'ID';

    public static function make($name, $title = "")
    {
        $obj = new static();
        $obj->field = Str::snake($name);
        $obj->title = $title == "" ? $name : $title;
        return $obj;
    }
}