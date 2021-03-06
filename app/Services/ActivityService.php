<?php

namespace App\Services;

use App\Modules\User\Model\Log;
use Illuminate\Support\Facades\Schema;
// If auth()->user_id does not exist use Sentinel Auth or other Auth class
use Sentinel;

class ActivityService
{
    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    /**
     * All activities
     *
     * @return  Collection
     */
    public function getByUser($userId, $paginate = null)
    {
        $query = $this->model->where('user', $userId);

        if (!is_null($paginate)) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    /**
     * Create an activity record
     *
     * @param  string $description
     * @return  Log
     */
    public function log($description = '')
    {   
        
        if(Sentinel::getUser() != null || auth()->id() != false) {
            $payload = [
                'user_id' => isset(auth()->id) ? auth()->id() : Sentinel::getUser()->id,
                'description' => $description,
                'request' => [
                    'url' => request()->url(),
                    'method' => request()->method(),
                    'query' => request()->fullUrl(),
                    'secure' => request()->secure(),
                    'client_ip' => request()->ip(),
                    'payload' => request()->all(),
                ],
            ];

            return $this->model->create($payload);
        }
    }
}
