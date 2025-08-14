<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Enquiry;
use App\Policies\EnquiryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Enquiry::class => EnquiryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
        
    }
}
