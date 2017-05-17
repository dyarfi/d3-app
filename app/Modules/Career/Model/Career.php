<?php namespace App\Modules\Career\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'careers';

	/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'requirement',
        'responsibility',
        'facility',
        'image',
        'attributes',
        'options',
        'end_date',
        'division_id',
        'status'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    public function division() {

        return $this->belongsTo('App\Modules\Career\Model\Division','division_id','id');

    }

    // Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1)->orderBy('created_at','desc');

    }

    // Scope query for slug field
    public function scopeSlug($query, $string) {

        return $query->where('slug', $string)->firstOrFail();

    }

}
