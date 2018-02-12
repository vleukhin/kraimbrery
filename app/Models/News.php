<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    protected $fillable = [
        'title',
        'image',
        'text',
        'teaser',
        'url',
    ];

    public function getUrlAttribute()
    {
        return sprintf('/news-%s-%s', $this->id, $this->attributes['url']);
    }
}