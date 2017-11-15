<table id="example3" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        @if(count($solicitudes) > 0)
            @foreach($solicitudes as $solicitud)
                <tr id="{{$solicitud->id_solicitud}}">
                    <td>{{$solicitud->id_solicitud }}</td>
                    <td>{{$solicitud->nombre_persona}}</td>
                    <td>
                        <button type="button" data-toggle="modal" data-target="#ver_solicitud" class="btn btn-info btn-guardia-clear" id="details-solicitud">Detalles</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>