<?php namespace App\Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model {

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

	/**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'name',
        'slug',
        'description',
        'value',
        'help_text',
        'input_type',
        'editable',
        'weight',
        'attributes',
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
        'attributes'  => 'object',
        'status'      => 'boolean'

    ];

    // A task is owned by a user
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

        return $query->where('slug', $string)->first();

    }

    // Scope query for slug field
    public function scopeKey($query, $string) {

        return $query->where('key', $string)->first();

    }

    // Scope query for group field
    public function scopeGroup($query, $string) {

        return $query->where('group', $string)->get(['slug','group','key','value']);

    }

    public function setToConfig() {

        return $this->all(['group','key','value','slug','name','description','input_type'])->groupBy('group');

    }

}
