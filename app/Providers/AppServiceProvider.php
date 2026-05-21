<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AreaServiceInterface;
use App\Services\AreaService;
use App\Contracts\CargoServiceInterface;
use App\Services\CargoService;
use App\Contracts\CursadoServiceInterface;
use App\Services\CursadoService;
use App\Contracts\CursoServiceInterface;
use App\Services\CursoService;
use App\Contracts\EstadoAnualServiceInterface;
use App\Services\EstadoAnualService;
use App\Contracts\EstadoDiariaServiceInterface;
use App\Services\EstadoDiariaService;
use App\Contracts\PersonaCargoServiceInterface;
use App\Services\PersonaCargoService;
use App\Contracts\PersonaCargoCursadoServiceInterface;
use App\Services\PersonaCargoCursadoService;
use App\Contracts\PersonaServiceInterface;
use App\Services\PersonaService;
use App\Contracts\PlanificacionAnualServiceInterface;
use App\Services\PlanificacionAnualService;
use App\Contracts\PlanificacionDiariaServiceInterface;
use App\Services\PlanificacionDiariaService;
use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;
use App\Contracts\SitRevistaServiceInterface;
use App\Services\SitRevistaService;
use App\Repositories\AreaRepository;
use App\Contracts\Repositories\AreaRepositoryInterface;
use App\Repositories\CargoRepository;
use App\Contracts\Repositories\CargoRepositoryInterface;
use App\Repositories\CursadoRepository;
use App\Contracts\Repositories\CursadoRepositoryInterface;
use App\Repositories\CursoRepository;
use App\Contracts\Repositories\CursoRepositoryInterface;
use App\Contracts\EstadoAnualRepositoryInterface;
use App\Repositories\EstadoAnualRepository;
use App\Contracts\EstadoDiariaRepositoryInterface;
use App\Repositories\EstadoDiariaRepository;
use App\Contracts\Repositories\PersonaCargoRepositoryInterface;
use App\Repositories\PersonaCargoRepository;
use App\Contracts\Repositories\PersonaRepositoryInterface;
use App\Repositories\PersonaRepository;
use App\Contracts\Repositories\PlanificacionAnualRepositoryInterface;
use App\Repositories\PlanificacionAnualRepository;
use App\Contracts\Repositories\PlanificacionDiariaRepositoryInterface;
use App\Repositories\PlanificacionDiariaRepository;
use App\Contracts\Repositories\SitRevistaRepositoryInterface;
use App\Repositories\SitRevistaRepository;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AreaServiceInterface::class,
            AreaService::class
        );

        $this->app->bind(
            CargoServiceInterface::class,
            CargoService::class
        );

        $this->app->bind(
    CursadoServiceInterface::class,
    CursadoService::class


);
$this->app->bind(
    CursoServiceInterface::class,
    CursoService::class
);
$this->app->bind(
    EstadoAnualServiceInterface::class,
    EstadoAnualService::class
);
$this->app->bind(
    EstadoDiariaServiceInterface::class,
    EstadoDiariaService::class
);
$this->app->bind(
    PersonaCargoServiceInterface::class,
    PersonaCargoService::class
);
$this->app->bind(
    PersonaCargoCursadoServiceInterface::class,
    PersonaCargoCursadoService::class
);
$this->app->bind(
    PersonaServiceInterface::class,
    PersonaService::class
);
$this->app->bind(
    PlanificacionAnualServiceInterface::class,
    PlanificacionAnualService::class
);
$this->app->bind(
    PlanificacionDiariaServiceInterface::class,
    PlanificacionDiariaService::class
);
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

        $this->app->bind(
            PersonaCargoRepositoryInterface::class,
            PersonaCargoRepository::class
        );

        $this->app->bind(
            PersonaRepositoryInterface::class,
            PersonaRepository::class
        );

        $this->app->bind(
            PlanificacionAnualRepositoryInterface::class,
            PlanificacionAnualRepository::class
        );

        $this->app->bind(
            PlanificacionDiariaRepositoryInterface::class,
            PlanificacionDiariaRepository::class
        );

        $this->app->bind(
            SitRevistaRepositoryInterface::class,
            SitRevistaRepository::class
        );

        $this->app->bind(
            SitRevistaServiceInterface::class,
            SitRevistaService::class
        );
$this->app->bind(
    AreaRepositoryInterface::class,
    AreaRepository::class
);
$this->app->bind(
    CargoRepositoryInterface::class,
    CargoRepository::class
);
$this->app->bind(
    CursadoRepositoryInterface::class,
    CursadoRepository::class
);
$this->app->bind(
    CursoRepositoryInterface::class,
    CursoRepository::class
);
{
    $this->app->bind(
        EstadoAnualRepositoryInterface::class,
        EstadoAnualRepository::class
    );
}

{
    $this->app->bind(
        EstadoDiariaRepositoryInterface::class,
        EstadoDiariaRepository::class
    );
}

    }
}