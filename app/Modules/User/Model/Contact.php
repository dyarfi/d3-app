<?php namespace App\Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
   
    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

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
        'name',
        'email',
        'subject',
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

    // Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1);

    }

}
