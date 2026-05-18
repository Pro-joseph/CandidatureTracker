<?php

namespace App\Providers;

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\Fichier;
use App\Policies\CandidaturePolicy;
use App\Policies\EntretienPolicy;
use App\Policies\FichierPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Candidature::class => CandidaturePolicy::class,
        Entretien::class   => EntretienPolicy::class,
        Fichier::class     => FichierPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}