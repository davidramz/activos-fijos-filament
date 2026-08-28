@php($activos = $getState() ?? collect())

<div class="w-full overflow-x-auto">
    @if ($activos->isEmpty())
        <p class="fi-in-placeholder">No tiene activos asignados.</p>
    @else
        <table class="fi-ta-table w-full text-start">
            <thead>
                <tr>
                    <th>Inventario</th>
                    <th>Material</th>
                    <th>Número de Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Código</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activos as $activo)
                    <tr>
                        <td>{{ $activo->numero_inventario }}</td>
                        <td>{{ $activo->material?->nombre ?? '-' }}</td>
                        <td>{{ $activo->numero_serie ?? '-' }}</td>
                        <td>{{ $activo->material?->marca ?? '-' }}</td>
                        <td>{{ $activo->material?->modelo ?? '-' }}</td>
                        <td>{{ $activo->material?->codigo ?? '-' }}</td>
                        <td>{{ $activo->costo !== null ? \Illuminate\Support\Number::currency($activo->costo, 'MXN') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>