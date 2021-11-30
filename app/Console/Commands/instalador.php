<?php

namespace App\Console\Commands;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
// ,Hola esto es una prueba de git 
class instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando ejecuta el instalador inicial del proyecto.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      if(!$this->verificar()){
	$rol = $this->crearRolSuperAdmin();
	$usuario = $this->crearUsuarioSuperAdmin();
	$usuario->roles()->attach($rol);
	$this->line('El Rol y Usuaio Administrador se crearon correctamente');
      }else{
	$this->error('No se pudo ejecutar el instalador, por que hay un rol crerado.');
      }
    }

    private function verificar(){
      return Rol::find(1);
    }

    private function crearRolSuperAdmin(){
      $rol = "Super Administrador";
      return Rol::create([
	'nombre' => $rol,
	'slug' => Str::slug($rol, '-')
      ]);    
    }

    private function crearUsuarioSuperAdmin(){
      return Usuario::create([
	'nombre' => 'admin',
	'email' => 'josias.qr@hotmail.com',
	'password' => Hash::make('admin'),
	'estado' => 1
      ]);
    }

}
