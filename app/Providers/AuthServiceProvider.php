<?php

namespace App\Providers;

use App\Models\CommentComplaint;
use App\Models\Complaint;
use App\Models\Expense;
use App\Policies\CommentComplaintPolicy;
use App\Policies\ComplaintPolicy;
use App\Policies\ExpensePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Complaint::class => ComplaintPolicy::class,
        Expense::class => ExpensePolicy::class,
        CommentComplaint::class=>CommentComplaintPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
