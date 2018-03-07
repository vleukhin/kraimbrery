<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vsleuhin@ya.ru
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $casts = [
        'photos' => 'array'
    ];

    protected $fillable = [
        'name',
        'url',
        'photos'
    ];
}