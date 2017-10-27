<?php namespace App\Modules\Blog\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Uuid;

class Blog extends Model implements TaggableInterface {

    // TaggableTrait from Cartalyst
    use TaggableTrait;

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blogs';

		/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'category_id',
        'type',
        'slug',
        'name',
        'image',
        'excerpt',
        'description',
        'publish_date',
        'attributes',
        'options',
        'status',
		'index'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	    'attributes'  => 'object',
        // 'status'      => 'boolean'
	    // 'permissions' => 'array',
	    // 'is_admin' => 'boolean',
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

    /**
     * A blog belongs to a project.
     *
     */
    public function category()
    {

        return $this->belongsTo('App\Modules\Blog\Model\BlogCategory','category_id','id');

    }

	/**
	 * A blog belongs to a user.
	 *
	 */
	public function user()
    {

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

    // Scope query for slug field
    public function scopeTag($query, $string) {

        return $query->where('tag', $string)->firstOrFail();

    }

}
