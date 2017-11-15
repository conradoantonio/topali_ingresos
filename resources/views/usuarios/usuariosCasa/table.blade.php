<table class="table table-hover" id="example3">
    <thead class="centered">    
        <th>ID</th>
        <th class="hide">Folio</th>
        <th>Responsable</th>
        <th class="hide">Coto id</th>
        <th class="hide">Coto</th>
        <th class="hide">Subcoto id</th>
        <th class="hide">Subcoto</th>
        <th class="hide">Correo</th>
        <th class="hide">Calle o manzana</th>
        <th class="hide">Contraseè´–a plana</th>
        <th>Acciones</th>
    </thead>
    <tbody id="tabla-casas" class="">
        @if(count($casas) > 0)
            @foreach($casas as $casa)
                <tr>
                    <td>{{$casa->id}}</td>
                    <td class="hide">{{$casa->folio_casa}}</td>
                    <td>{{$casa->responsable}}</td>
                    <td class="hide">{{$casa->coto_id}}</td>
                    <td class="hide">{{$casa->coto_nombre}}</td>
                    <td class="hide">{{$casa->subcoto_id ? $casa->subcoto_id : 'No aplica'}}</td>
                    <td class="hide">{{$casa->subcoto_nombre ? $casa->subcoto_nombre : 'No aplica'}}</td>
                    <td class="hide">{{$casa->correo}}</td>
                    <td class="hide">{{$casa->calle_manzana}}</td>
                    <td class="hide">{{$casa->contra}}</td>
                    <td>
                        <button type="button" class="btn btn-info editar-casa btn-guardia-edit" status-casa="">Editar</button>
                        <button type="button" class="btn btn-danger eliminar-casa btn-guardia-delete" status-casa="3">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="8">No hay casas disponibles</td>
        @endif  
    </tbody>
</table>