<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	if (Auth::check()) {
		return redirect()->action('logController@index');
	} else {
    	return view('welcome');//login
    }
});

/*-- Rutas para el login --*/
Route::resource('log', 'logController');
Route::post('login', 'logController@store');
Route::get('logout', 'logController@logout');

/*-- Rutas para el dashboard --*/
Route::get('/dashboard','logController@index');//Carga solo el panel administrativo

/*-- Rutas para la creación de usuarios negocios HOLA MUNDO --*/

/*-- Rutas para casas --*/
Route::get('/casas','CasasController@index');//Carga solo el panel administrativo

/*-- Rutas para la pestaña de usuariosSistema --*/
Route::get('/usuarios/sistema','UsuariosController@index');//Carga la tabla de usuarios del sistema
Route::post('/usuarios/sistema/validar_usuario', 'UsuariosController@validar_usuario');//Checa si un usuario del sistema existe
Route::post('/usuarios/sistema/guardar_usuario', 'UsuariosController@guardar_usuario');//Guarda un usuario del sistema
Route::post('/usuarios/sistema/guardar_foto_usuario_sistema', 'UsuariosController@guardar_foto_usuario_sistema');//Guarda la foto de perfil de un usuario del sistema
Route::post('/usuarios/sistema/eliminar_usuario', 'UsuariosController@eliminar_usuario');//Elimina un usuario del sistema
Route::post('/usuarios/sistema/change_password', 'UsuariosController@change_password');//Elimina un usuario del sistema
	
/*-- Rutas para la pestaña de usuarios de casa --*/
Route::get('/usuarios/casas','UsuariosController@usuarios_casa');//Carga la tabla de usuarios de casa.
Route::post('/casas/guardar_usuario_casa', 'UsuariosController@guardar_casa');//Guarda una nueva casa con su respectivo usuario.
Route::post('/casas/editar_usuario_casa', 'UsuariosController@editar_casa');//Edita las preferencias de una casa existente.
Route::post('/casas/eliminar_usuario_casa', 'CasasController@eliminar_casa');//Cambia el status de una casa a 0.

/*-- Rutas para la pestaña de usuarios de guardia --*/
Route::get('/usuarios/guardia','UsuariosController@usuarios_guardia');//Carga la tabla de usuarios guardias.
Route::post('/guardia/guardar_usuario_guardia', 'UsuariosController@guardar_guardia');//Guarda una nueva casa con su respectivo usuario.
Route::post('/guardia/editar_usuario_guardia', 'UsuariosController@editar_guardia');//Edita las preferencias de una casa existente.
Route::post('/guardia/eliminar_usuario_guardia', 'UsuariosController@eliminar_guardia');//Cambia el status de una casa a 0.

/*-- Rutas para la pestaña de solicitudes de ingreso para casa --*/
Route::get('/solicitar/ingreso/coto','SolicitudesController@index');//Carga la tabla de solicitudes de un usuario de casa.
Route::post('/solicitud/ingreso/guardar_solicitud', 'SolicitudesController@guardar_solicitud_ingreso_coto');//Guarda una nueva solicitud de ingreso al coto.
Route::get('/solicitud/ingreso/show/{id}', 'SolicitudesController@show');//Mostrar detalles de una solicitud

/*-- Rutas para la pestaña de solicitudes de ingreso para guardia --*/
Route::get('/solicitudes/ingreso/coto','SolicitudesController@solicitudes_ingreso_coto');//Carga la tabla de solicitudes de ingreso de un coto.
Route::post('/solicitudes/ingreso/checar', 'SolicitudesController@checar_solicitud_ingreso_coto');//Marca como checada una solicitud de ingreso al coto.

/*-- Rutas para la pestaña de cotos y negocios --*/
/*-- Rutas para los cotos --*/
Route::get('/administrar/cotos','CotosController@index');//Carga la tabla de cotos
Route::post('/administrar/cotos','CotosController@index');//filtrado de cotos
Route::post('/administrar/cotos/guardar_coto','CotosController@guardar_coto');//Guarda un nuevo coto
Route::post('/administrar/cotos/editar_coto','CotosController@editar_coto');//Edita un coto
Route::post('/administrar/cotos/eliminar_coto','CotosController@eliminar_coto');//Elimina un coto
/*-- Rutas para los negocios --*/
Route::get('/administrar/negocios','NegociosController@index');//Carga la tabla de negocios
Route::post('/administrar/negocios/guardar_negocio','NegociosController@guardar_negocio');//Guarda un nuevo negocio
Route::post('/administrar/negocios/editar_negocio','NegociosController@editar_negocio');//Edita un negocio
Route::post('/administrar/negocios/eliminar_negocio','NegociosController@eliminar_negocio');//Elimina un negocio

/*-- Rutas para la pestaña de subcotos y departamentos --*/
/*-- Rutas para los subcotos --*/
Route::get('/administrar/subcotos','SubcotosController@index');//Carga la tabla de subcotos
Route::post('/administrar/subcotos/guardar_subcoto','SubcotosController@guardar_subcoto');//Guarda un nuevo subcoto
Route::post('/administrar/subcotos/editar_subcoto','SubcotosController@editar_subcoto');//Edita un subcoto
Route::post('/administrar/subcotos/eliminar_subcoto','SubcotosController@eliminar_subcoto');//Elimina un subcoto
/*-- Rutas para los departamentos --*/
Route::get('/administrar/departamentos','DepartamentosController@index');//Carga la tabla de departamentos
Route::post('/administrar/departamentos/guardar_departamento','DepartamentosController@guardar_departamento');//Guarda un nuevo departamento
Route::post('/administrar/departamentos/editar_departamento','DepartamentosController@editar_departamento');//Edita un departamento
Route::post('/administrar/departamentos/eliminar_departamento','DepartamentosController@eliminar_departamento');//Elimina un departamento

/*-- Rutas para el módulo de ingresos --*/
Route::get('/administrar/ingresos/cotos','IngresosController@ingresos_cotos');//Carga la tabla de ingresos de los cotos
Route::get('/administrar/historial/ingresos','IngresosController@historial_ingresos');//Filtra la tabla de ingresos de los cotos por fechas
Route::post('/administrar/historial/ingresos','IngresosController@historial_ingresos');//Filtra la tabla de ingresos de los cotos por fechas
Route::get('/administrar/ingresos/negocios','IngresosController@ingresos_negocios');//Carga la tabla de ingresos de los negocios
Route::get('/ingresos/cotos/formulario','IngresosController@form_ingresos_cotos');//Carga el formulario para ingresos de coto
Route::get('/ingresos/negocios/formulario','IngresosController@form_ingresos_negocios');//Carga el formulario para ingresos de negocios
Route::post('/ingresos/cotos/guardar_ingreso','IngresosController@guardar_ingreso');//Guarda un ingreso en el sistema
Route::post('/ingresos/marcar_salida','IngresosController@marcar_salida');//Finaliza la visita de una persona.

/*-- Rutas para el módulo de egresos --*/
Route::get('/administrar/egresos/cotos','EgresosController@egresos_cotos');//Carga la tabla de egresos de los cotos.
Route::get('/egresos/cotos/excel','EgresosController@exportar_egresos_coto');//Exporta a excel los egresos realizados.

/**/
Route::post('/getSolicitudesPesrsona','SolicitudesController@get_solicitud_persona');
Route::post('/getSolicitudesPesrsonaCasa','SolicitudesController@get_solicitud_persona_by_casa');

Route::get('/administrar/cotos/add/{id?}','CotosController@create');
Route::get('/cotos/exportar/{inicio}/{fin}','CotosController@exportar');
Route::get('/ingresos/exportar/{inicio}/{fin}/{tipo_ingreso}','IngresosController@exportar');

Route::get('/ingreso_cotos/{id_servicio}','IngresosController@ingresos_by_service');
Route::get('/egreso_cotos/{id_servicio}','IngresosController@egresos_by_service');
Route::get('/casas_cotos/{id_servicio}','IngresosController@casas_by_service');


/*Route::get('/servicios','ServiciosController@index');
Route::get('/servicios/add','ServiciosController@create');*/