<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['key', 'value'];

    private static $options = [];

    public static function item($key, $default = '', $newInstance = false)
    {
        if ($newInstance === false && isset(self::$options[$key])) {
            return self::$options[$key];
        }

        $value = self::query()->where(['key' => $key])->first();

        self::$options[$key] = $value ? $value->value : $default;

        return self::$options[$key];
    }

    public static function setItem($key, $value)
    {
        $query = self::query()->where('key', $key)->first();

        $model = $query ? $query : (new self());

        return $model->fill(['key' => $key, 'value' => $value])->save();
    }
}
