<?php namespace App\Modules\Portfolio\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Plank\Mediable\Mediable;
use Uuid;

class Portfolio extends Model implements TaggableInterface {

    // TaggableTrait from Cartalyst
    use TaggableTrait;

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

    // Mediable Eloquent Model from Plank
    use Mediable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'portfolios';

		/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'uuid',        
        'project_id',
        'client_id',
        'slug',
        'name',
        'image',
        'description',
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
	 * A portfolio can have many clients.
	 *
	 */
	//public function clients()
	//{
		//return $this->hasMany('App\Modules\Portfolio\Model\Portfolio','portfolio_id');
	//}

    /**
     * A portfolio belongs to a client.
     *
     */
    public function client()
    {

        return $this->belongsTo('App\Modules\Portfolio\Model\Client','client_id','id');

    }

    /**
     * A portfolio belongs to a project.
     *
     */
    public function project()
    {

        return $this->belongsTo('App\Modules\Portfolio\Model\Project','project_id','id');

    }

	/**
	 * A portfolio belongs to a user.
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

}
