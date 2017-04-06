<?php

namespace App\Repositories\Backend\Dashboard;

use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Repositories\Backend\User\UserContract;

/**
 * Class EloquentDashboardRepository
 * @package App\Repositories\Dashboard
 */
class EloquentDashboardRepository implements DashboardContract
{
    /**
     * @var UserContract
     */
    protected $users;

    /**
     * @param UserContract                 $users
     */
    public function __construct(UserContract $users)
    {
        $this->users = $users;
    }

    
}