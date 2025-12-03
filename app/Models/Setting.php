<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
<<<<<<< HEAD
=======
    protected $fillable = ['key', 'value', 'group'];

    // Helper to get setting by key
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Helper to set setting
    public static function set($key, $value, $group = 'general')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
}
