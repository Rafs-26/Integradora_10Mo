<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2d5016;
            padding-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        .title {
            color: #2d5016;
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .date-range {
            color: #888;
            font-size: 12px;
            font-style: italic;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            color: #2d5016;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            text-align: center;
        }
        .stats-cell.header {
            background-color: #2d5016;
            color: white;
            font-weight: bold;
        }
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #2d5016;
        }
        .stats-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #2d5016;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }
        .highlight {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 10px 0;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-validado {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rechazado {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $titulo }}</div>
        <div class="subtitle">Universidad Tecnológica de Hermosillo</div>
        <div class="subtitle">Sistema de Gestión de Estadías</div>
        @if($fechaInicio || $fechaFin)
            <div class="date-range">
                Período: 
                @if($fechaInicio)
                    {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                @else
                    Inicio
                @endif
                - 
                @if($fechaFin)
                    {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                @else
                    {{ date('d/m/Y') }}
                @endif
            </div>
        @endif
        <div class="date-range">Generado el: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    @if($tipoReporte === 'estadisticas_generales')
        <div class="section">
            <div class="section-title">Resumen Ejecutivo</div>
            <div class="stats-grid">
                <div class="stats-row">
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['total_estadias'] }}</div>
                        <div class="stats-label">Total Estadías</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['estadias_activas'] }}</div>
                        <div class="stats-label">Estadías Activas</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['estadias_completadas'] }}</div>
                        <div class="stats-label">Estadías Completadas</div>
                    </div>
                </div>
                <div class="stats-row">
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['total_estudiantes'] }}</div>
                        <div class="stats-label">Total Estudiantes</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['total_empresas'] }}</div>
                        <div class="stats-label">Total Empresas</div>
                    </div>
                    <div class="stats-cell">
                        <div class="stats-number">{{ $data['documentos_pendientes'] }}</div>
                        <div class="stats-label">Documentos Pendientes</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($tipoReporte === 'estudiantes_por_carrera')
        <div class="section">
            <div class="section-title">Distribución de Estudiantes por Carrera</div>
            @if($data->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Carrera</th>
                            <th style="text-align: center;">Número de Estudiantes</th>
                            <th style="text-align: center;">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = $data->sum('total'); @endphp
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->carrera }}</td>
                                <td style="text-align: center;">{{ $item->total }}</td>
                                <td style="text-align: center;">{{ $total > 0 ? round(($item->total / $total) * 100, 1) : 0 }}%</td>
                            </tr>
                        @endforeach
                        <tr style="background-color: #e9ecef; font-weight: bold;">
                            <td>TOTAL</td>
                            <td style="text-align: center;">{{ $total }}</td>
                            <td style="text-align: center;">100%</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="no-data">No hay datos disponibles para el período seleccionado.</div>
            @endif
        </div>
    @endif

    @if($tipoReporte === 'empresas_activas')
        <div class="section">
            <div class="section-title">Top 20 Empresas Más Activas</div>
            @if($data->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Empresa</th>
                            <th>Sector</th>
                            <th style="text-align: center;">Estudiantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $empresa)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $empresa->nombre }}</td>
                                <td>{{ $empresa->sector ?? 'No especificado' }}</td>
                                <td style="text-align: center;">{{ $empresa->estadias_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No hay datos disponibles para el período seleccionado.</div>
            @endif
        </div>
    @endif

    @if($tipoReporte === 'documentos_pendientes')
        <div class="section">
            <div class="section-title">Documentos Pendientes de Revisión</div>
            @if($data->count() > 0)
                <div class="highlight">
                    <strong>Total de documentos pendientes:</strong> {{ $data->count() }}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Empresa</th>
                            <th>Tipo Documento</th>
                            <th>Fecha Subida</th>
                            <th>Días Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $documento)
                            <tr>
                                <td>{{ $documento->estudiante->user->name }}</td>
                                <td>{{ $documento->estadia->empresa->nombre ?? 'No asignada' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $documento->tipo_documento)) }}</td>
                                <td>{{ $documento->created_at->format('d/m/Y') }}</td>
                                <td style="text-align: center;
                                    @if($documento->created_at->diffInDays(now()) > 7) color: #dc3545; font-weight: bold; @endif">
                                    {{ $documento->created_at->diffInDays(now()) }} días
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No hay documentos pendientes en el período seleccionado.</div>
            @endif
        </div>
    @endif

    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de Estadías</p>
        <p>Universidad Tecnológica de Hermosillo - {{ date('Y') }}</p>
    </div>
</body>
</html>