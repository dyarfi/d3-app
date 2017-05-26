<?php namespace App\Modules\Portfolio\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';

		/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
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
        // 'status'      => 'boolean',
	    // 'permissions' => 'array'
	    // 'is_admin' => 'boolean',
	];

	/**
	 * A user can have many tasks.
	 *
	 */
	public function pages()
	{
		return $this->hasMany('App\Modules\Client\Model\Client','client_id');
	}

	/**
	 * A client belongs to a user.
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
