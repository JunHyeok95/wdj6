<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        // $this->registerPolicies();

        //관리자 권한   app\User참고
        Gate::before(function ($user) {
            if ($user->isAdmin()) return true;
        });

        //수정권한
        Gate::define('update', function ($user, $model) {
            //사용자 아이디와 모델의 user_id속성이 같은지를 비교 
            return $user->id === $model->user_id;
        });

        //삭제권한
        Gate::define('delete', function ($user, $model) {
            // \Log::info("모델 유저 : " . $model->user_id);
            return $user->id === $model->user_id;
        });
        //멤버추가
        Gate::define('member_create', function($user, $model){
            return $user->id <= 7;
        });
        //멤버 수정, 삭제
        Gate::define('member_edit', function($user, $model){
            // \Log::info("접속 유저 : " . $user->id);
            // \Log::info("모델 유저 : " . $model->id);
            return $user->id - 1 === $model->id;

        });
    
    }
}
