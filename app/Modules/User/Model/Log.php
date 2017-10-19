<?php

namespace App\Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;
    
    public $table = "logs";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'description',
        'request',
    ];

    public static $rules = [
        'request' => 'required',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'request'  => 'object'
    ];

    /**
     * A log belongs to a user.
     *
     */
    public function user()
    {

        return $this->belongsTo('App\Modules\User\Model\User','user_id','id');

    }
}
