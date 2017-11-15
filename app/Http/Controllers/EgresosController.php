<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ingreso;
use App\Guardia;
use App\Coto;
use Excel, Input, File;
use Redirect;
use Session;

class EgresosController extends Controller
{
    /**
     * Despliega la lista de ingresos por coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function egresos_cotos()
    {
        if (auth()->check()) {
            $title = "Egresos de coto";
            $menu = "Egresos";
            $servicio_id = $this->obtener_coto_usuario();
            $egresos = Ingreso::obtener_ingresos_personas($servicio_id, 1);
            return view('egresos.cotos.index', ['egresos' => $egresos, 'menu' => $menu, 'title' => $title]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Exporta todos los egresos de coto.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportar_egresos_coto()
    {
        $servicio_id = $this->obtener_coto_usuario();
        $egresos = Ingreso::obtener_ingresos_personas_excel($servicio_id, 1);

        Excel::create('Lista de egresos', function($excel) use($egresos) {
            $excel->sheet('Hoja 1', function($sheet) use($egresos) {
                $sheet->cells('A:K', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($egresos);
            });
        })->export('xlsx');

        return ['msg'=>'Excel creado'];
    }
    
    /**
     * Regresa el id del coto vinculado al usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function obtener_coto_usuario()
    {
        if (auth()->check()) {
            if(Session::get('privilegio') == "Guardia") {
                 return Coto::where('guardia_users_id', auth()->user()->id)->pluck('id');
            }
            /*if(Session::get('privilegio') == "Administrador Coto") {*/
                return Coto::where('users_id', auth()->user()->id)->pluck('id');
            /*}*/
        } else {
            return Redirect::to('/');
        }
    }
}
