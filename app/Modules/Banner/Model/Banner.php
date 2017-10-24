<?php namespace App\Modules\Banner\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'banners';

	/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'image',
        'index',
        'attributes',
        'options',
        'end_date',
        'user_id',
        'status'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    // Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1)->orderBy('created_at','desc');

    }

    // Scope query for slug field
    public function scopeSlug($query, $string) {

        return $query->where('slug', $string)->firstOrFail();

    }

}
