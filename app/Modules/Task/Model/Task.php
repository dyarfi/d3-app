<?php namespace App\Modules\Task\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Uuid;

class Task extends Model {

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

    // Mediable Eloquent Model
    use Mediable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
        'user_id',
        'status'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        //'editable'    => 'boolean',
        //'attributes'  => 'object',
        //'status'      => 'boolean'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot() {
        // Parent boot
        parent::boot();
        // Set model
        $model = new Self;        
        // Set new Uuid
        self::saving(function ($model) {
            if (!$model->uuid){
                $model->uuid = (string) Uuid::generate(4);
            }
        });        
    }

    // a task is owned by a user
    public function user()  {

        return $this->belongsTo('App\Modules\User\Model\User','user_id','id');

    }

    // Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1);

    }

    // Scope query for slug field
    public function scopeSlug($query, $string) {

        return $query->where('slug', $string)->firstOrFail();

    }

}
