<?php namespace App\Modules\Page\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'slug',
        'name',
        'description',
        'attributes',
        'options',
        'status'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
     * A page belongs to a menu.
     *
     */    
    public function menu() {

        return $this->belongsTo('App\Modules\Page\Model\Menu','menu_id','id');

    }

    /**
     * A page belongs to a user.
     *
     */
    public function user() {
        
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
