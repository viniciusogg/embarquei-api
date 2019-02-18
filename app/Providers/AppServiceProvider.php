<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\UsuarioService;
use App\Services\EstudanteService;
use App\Services\CursoService;
use App\Services\InstituicaoEnsinoService;
use App\Services\PontoParadaService;
use App\Services\TrajetoService;
use App\Services\AuthService;
use App\Services\RotaService;
use App\Services\HorarioSemanalEstudanteService;
use App\Services\MotoristaService;
use App\Services\VeiculoTransporteService;
use App\Services\AdministradorService;
use App\Services\CidadeService;
use App\Services\HorarioTrajetoService;
use App\Services\ListaPresencaService;
use App\Services\CheckinService;
use App\Services\FeedbackService;

use App\Repositories\Abstraction\UsuarioRepositoryInterface;
use App\Repositories\Abstraction\EstudanteRepositoryInterface;
use App\Repositories\Abstraction\CursoRepositoryInterface;
use App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface;
use App\Repositories\Abstraction\PontoParadaRepositoryInterface;
use App\Repositories\Abstraction\TrajetoRepositoryInterface;
use App\Repositories\Abstraction\RotaRepositoryInterface;
use App\Repositories\Abstraction\HorarioSemanalEstudanteRepositoryInterface;
use App\Repositories\Abstraction\MotoristaRepositoryInterface;
use App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface;
use App\Repositories\Abstraction\AdministradorRepositoryInterface;
use App\Repositories\Abstraction\CidadeRepositoryInterface;
use App\Repositories\Abstraction\HorarioTrajetoRepositoryInterface;
use App\Repositories\Abstraction\ListaPresencaRepositoryInterface;
use App\Repositories\Abstraction\CheckinRepositoryInterface;
use App\Repositories\Abstraction\FeedbackRepositoryInterface;

use App\Repositories\Implementation\UsuarioRepositoryConcrete;
use App\Repositories\Implementation\EstudanteRepositoryConcrete;
use App\Repositories\Implementation\CursoRepositoryConcrete;
use App\Repositories\Implementation\InstituicaoEnsinoRepositoryConcrete;
use App\Repositories\Implementation\PontoParadaRepositoryConcrete;
use App\Repositories\Implementation\TrajetoRepositoryConcrete;
use App\Repositories\Implementation\RotaRepositoryConcrete;
use App\Repositories\Implementation\HorarioSemanalEstudanteRepositoryConcrete;
use App\Repositories\Implementation\MotoristaRepositoryConcrete;
use App\Repositories\Implementation\VeiculoTransporteRepositoryConcrete;
use App\Repositories\Implementation\AdministradorRepositoryConcrete;
use App\Repositories\Implementation\CidadeRepositoryConcrete;
use App\Repositories\Implementation\HorarioTrajetoRepositoryConcrete;
use App\Repositories\Implementation\ListaPresencaRepositoryConcrete;
use App\Repositories\Implementation\CheckinRepositoryConcrete;
use App\Repositories\Implementation\FeedbackRepositoryConcrete;

use App\Entities\InstituicaoEnsino;
use App\Entities\Usuario;
use App\Entities\Estudante;
use App\Entities\Curso;
use App\Entities\PontoParada;
use App\Entities\Trajeto;
use App\Entities\Rota;
use App\Entities\HorarioSemanalEstudante;
use App\Entities\Motorista;
use App\Entities\VeiculoTransporte;
use App\Entities\Administrador;
use App\Entities\Cidade;
use App\Entities\HorarioTrajeto;
use App\Entities\ListaPresenca;
use App\Entities\Checkin;
use App\Entities\Feedback;

use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()  // REGISTRAR SERVICES AQUI
    {
        Passport::ignoreMigrations();

        /**
         * REPOSITORIES
         */
        $this->app->bind(UsuarioRepositoryInterface::class, function($app) {
            return new UsuarioRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Usuario::class)
            );
        });
        
        $this->app->bind(EstudanteRepositoryInterface::class, function($app) {
            return new EstudanteRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Estudante::class)
            );
        });        

        $this->app->bind(CursoRepositoryInterface::class, function($app) {
            return new CursoRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Curso::class)
            );
        });
        
        $this->app->bind(InstituicaoEnsinoRepositoryInterface::class, function($app) {
            return new InstituicaoEnsinoRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(InstituicaoEnsino::class)
            );
        });
        
        $this->app->bind(PontoParadaRepositoryInterface::class, function($app) {
            return new PontoParadaRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(PontoParada::class)
            );
        });        

        $this->app->bind(TrajetoRepositoryInterface::class, function($app) {
            return new TrajetoRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Trajeto::class)
            );
        });        

        $this->app->bind(RotaRepositoryInterface::class, function($app) {
            return new RotaRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Rota::class)
            );
        });        
        
        $this->app->bind(HorarioSemanalEstudanteRepositoryInterface::class, function($app) {
            return new HorarioSemanalEstudanteRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(HorarioSemanalEstudante::class)
            );
        });
        
        $this->app->bind(MotoristaRepositoryInterface::class, function($app) {
            return new MotoristaRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Motorista::class)
            );
        });        
        
        $this->app->bind(VeiculoTransporteRepositoryInterface::class, function($app) {
            return new VeiculoTransporteRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(VeiculoTransporte::class)
            );
        });
        
        $this->app->bind(AdministradorRepositoryInterface::class, function($app) {
            return new AdministradorRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Administrador::class)
            );
        });        
        
        $this->app->bind(CidadeRepositoryInterface::class, function($app) {
            return new CidadeRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Cidade::class)
            );
        }); 
        
        $this->app->bind(HorarioTrajetoRepositoryInterface::class, function($app) {
            return new HorarioTrajetoRepositoryConcrete(
                    $app['em'],
                    $app['em']->getClassMetaData(HorarioTrajeto::class)
            );
        });
        
        $this->app->bind(ListaPresencaRepositoryInterface::class, function($app) {
            return new ListaPresencaRepositoryConcrete(
                    $app['em'],
                    $app['em']->getClassMetaData(ListaPresenca::class)
            );
        });

        $this->app->bind(CheckinRepositoryInterface::class, function($app) {
            return new CheckinRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Checkin::class)
            );
        });

        $this->app->bind(FeedbackRepositoryInterface::class, function($app) {
            return new FeedbackRepositoryConcrete(
                $app['em'],
                $app['em']->getClassMetaData(Feedback::class)
            );
        });
        
        /**
         * SERVICES
         */
        $this->app->bind(AuthService::class, function($app)
        {
            return new AuthService($app);
        });
        
        $this->app->bind(UsuarioService::class, function($app)
        {
            return new UsuarioService(
                    $app->make('App\Repositories\Abstraction\UsuarioRepositoryInterface')
            );
        });
        
        $this->app->bind(EstudanteService::class, function($app)
        {
            return new EstudanteService(
                    $app->make('App\Repositories\Abstraction\EstudanteRepositoryInterface'),
                    new ListaPresencaService($app->make('App\Repositories\Abstraction\ListaPresencaRepositoryInterface'))
                    /*,
                    new CursoService($app->make('App\Repositories\Abstraction\CursoRepositoryInterface')),
                    new HorarioSemanalEstudanteService($app->
                            make('App\Repositories\Abstraction\HorarioSemanalEstudanteRepositoryInterface'))*/
            );
        });
        
        $this->app->bind(CursoService::class, function($app)
        {
            return new CursoService(
                    $app->make('App\Repositories\Abstraction\CursoRepositoryInterface')
            );
        });          
        
        $this->app->bind(InstituicaoEnsinoService::class, function($app)
        {
            return new InstituicaoEnsinoService(
                    $app->make('App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface')
            );
        });          
        
        $this->app->bind(PontoParadaService::class, function($app)
        {
            return new PontoParadaService(
                    $app->make('App\Repositories\Abstraction\PontoParadaRepositoryInterface')
            );
        });        

        $this->app->bind(TrajetoService::class, function($app)
        {
            return new TrajetoService(
                    $app->make('App\Repositories\Abstraction\TrajetoRepositoryInterface')
            );
        });        
        
        $this->app->bind(RotaService::class, function($app)
        {
            return new RotaService(
                    $app->make('App\Repositories\Abstraction\RotaRepositoryInterface')
            );
        });         
        
        $this->app->bind(HorarioSemanalEstudanteService::class, function($app)
        {
            return new HorarioSemanalEstudanteService(
                    $app->make('App\Repositories\Abstraction\HorarioSemanalEstudanteRepositoryInterface')
            );
        });        
        
        $this->app->bind(MotoristaService::class, function($app)
        {
            return new MotoristaService(
                    $app->make('App\Repositories\Abstraction\MotoristaRepositoryInterface')
            );
        });
        
        $this->app->bind(VeiculoTransporteService::class, function($app)
        {
            return new VeiculoTransporteService(
                    $app->make('App\Repositories\Abstraction\VeiculoTransporteRepositoryInterface')
            );
        });
        
        $this->app->bind(AdministradorService::class, function($app)
        {
            return new AdministradorService(
                    $app->make('App\Repositories\Abstraction\AdministradorRepositoryInterface'),
                    new InstituicaoEnsinoService($app->make('App\Repositories\Abstraction\InstituicaoEnsinoRepositoryInterface'))
            );
        });        

        $this->app->bind(CidadeService::class, function($app)
        {
            return new CidadeService(
                    $app->make('App\Repositories\Abstraction\CidadeRepositoryInterface')
            );
        });        
        
        $this->app->bind(HorarioTrajetoService::class, function($app)
        {
            return new HorarioTrajetoService(
                    $app->make('App\Repositories\Abstraction\HorarioTrajetoRepositoryInterface')
            );
        });
        
        $this->app->bind(ListaPresencaService::class, function($app)
        {
            return new ListaPresencaService(
                    $app->make('App\Repositories\Abstraction\ListaPresencaRepositoryInterface')
            );
        });

        $this->app->bind(CheckinService::class, function($app)
        {
            return new CheckinService(
                $app->make('App\Repositories\Abstraction\CheckinRepositoryInterface')
            );
        });

        $this->app->bind(FeedbackService::class, function($app)
        {
            return new FeedbackService(
                $app->make('App\Repositories\Abstraction\FeedbackRepositoryInterface')
            );
        });
    }
}
