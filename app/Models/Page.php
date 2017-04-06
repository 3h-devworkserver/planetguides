<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Page extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
    protected $fillable = ['title','slug','content','status'];
 

}
