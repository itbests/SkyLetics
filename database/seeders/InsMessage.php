<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsMessage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message')->insert(['message' => 'El dato ingresado no puede ser nulo [%s1]', 'cause' => 'El dato ingresado no puede ser NULO', 'solution' => 'Ingrese el valor requerido', 'message_type' => 'E', 'params' => 'Y', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'El mensaje indicado [%s1] no recibe parámetros', 'cause' => 'El mensaje indicado no tiene parámetros configurados', 'solution' => 'Verifique el mensaje y los parámetros ingresados', 'message_type' => 'E', 'params' => 'Y', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'El %s1 ingresado [%s2] no existe en la base de datos', 'cause' => 'El dato ingrersado no existe en la BD', 'solution' => 'Verifique la información ingresada', 'message_type' => 'E', 'params' => 'Y', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'Su sesión ha sido cerrada por inactividad o por haber ingresado al sistema desde otro dispositivo', 'cause' => 'Sesión de usuario finalizada!', 'solution' => 'Por favor ingrese nuevamente', 'message_type' => 'E', 'params' => 'N', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'No se pudo establecer comunicación con el servicio: [%s1]', 'cause' => 'Error de Comunicación', 'solution' => 'Por favor verifique la URL y los parametros necesarios para consumir el servicio', 'message_type' => 'E', 'params' => 'Y', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'El mensaje con ID [%s1] requiere parámetros para su visualización', 'cause' => 'El mensaje indicado está configurado para recibir parámetros', 'solution' => 'Por favor indique los parámetros requeridos', 'message_type' => 'E', 'params' => 'Y', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'La contraseña actual ingresada es incorrecta', 'cause' => 'La contraseña actual ingresada no es válida', 'solution' => 'Por favor verifique e intenta nuevamente', 'message_type' => 'E', 'params' => 'N', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'La confimación de nueva contraseña a fallado', 'cause' => 'La nueva contraseña y su confirmación son diferentes', 'solution' => 'Por favor verifique los datos ingresados e intente nuevamente', 'message_type' => 'E', 'params' => 'N', 'module_id' => '1', 'status_id' => 1]);
        DB::table('message')->insert(['message' => 'Contraseña actualizada satisactoriamente', 'cause' => 'Su contraseña ha sido actualizada', 'solution' => '', 'message_type' => 'S', 'params' => 'N', 'module_id' => '1', 'status_id' => 1]);
    }
}
