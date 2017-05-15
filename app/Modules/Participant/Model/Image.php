<?php namespace App\Modules\Participant\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'participant_id',
			'type',
			'url',
			'title',
			'file_name',
			'attribute',
			'count',
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
        'attribute'   => 'array',
        'status'      => 'boolean'
    ];

    // An image is owned by user
    public function participant()  {

        return $this->belongsTo('App\Modules\User\Model\User','participant_id','id');
        
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
