<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Presentación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2d5016;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2d5016;
            margin-bottom: 10px;
        }
        .university-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .date {
            text-align: right;
            margin-bottom: 30px;
            font-size: 12px;
        }
        .recipient {
            margin-bottom: 30px;
        }
        .recipient-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .recipient-position {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .company-name {
            font-weight: bold;
            font-size: 13px;
        }
        .content {
            text-align: justify;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .student-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #2d5016;
            margin: 20px 0;
        }
        .student-info h4 {
            margin: 0 0 10px 0;
            color: #2d5016;
            font-size: 14px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            display: inline-block;
        }
        .info-value {
            flex: 1;
        }
        .signature {
            margin-top: 60px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 0 auto 10px auto;
        }
        .signature-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .signature-title {
            font-size: 12px;
            color: #666;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .internship-period {
            background-color: #e8f5e8;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            color: #2d5016;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">UNIVERSIDAD TECNOLÓGICA DE HERMOSILLO</div>
        <div class="university-info">División de Ingeniería en Sistemas Computacionales</div>
        <div class="university-info">Coordinación de Estadías Profesionales</div>
    </div>

    <div class="date">
        Hermosillo, Sonora a {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
    </div>

    <div class="recipient">
        <div class="recipient-name">{{ $solicitud->dirigida_a }}</div>
        @if($solicitud->cargo_destinatario)
        <div class="recipient-position">{{ $solicitud->cargo_destinatario }}</div>
        @endif
        <div class="company-name">{{ $solicitud->estadia->empresa->nombre }}</div>
        <div>Presente.</div>
    </div>

    <div class="content">
        <p><strong>ASUNTO: PRESENTACIÓN DE ESTUDIANTE PARA ESTADÍA PROFESIONAL</strong></p>
        
        <p>Por medio de la presente, me dirijo a usted con el fin de presentar formalmente al estudiante que realizará su Estadía Profesional en su prestigiosa empresa.</p>
        
        <div class="student-info">
            <h4>DATOS DEL ESTUDIANTE:</h4>
            <div class="info-row">
                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $solicitud->estudiante->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Matrícula:</span>
                <span class="info-value">{{ $solicitud->estudiante->matricula }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Carrera:</span>
                <span class="info-value">{{ $solicitud->estudiante->carrera->nombre ?? 'Ingeniería en Sistemas Computacionales' }}</span>
            </div>
            @if($solicitud->estudiante->especialidad)
            <div class="info-row">
                <span class="info-label">Especialidad:</span>
                <span class="info-value">{{ $solicitud->estudiante->especialidad->nombre }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">NSS:</span>
                <span class="info-value">{{ $solicitud->estudiante->nss ?? 'En trámite' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cuatrimestre:</span>
                <span class="info-value">{{ $solicitud->estudiante->cuatrimestre ?? '9°' }} Cuatrimestre</span>
            </div>
        </div>

        <div class="internship-period">
            PERÍODO DE ESTADÍA: 12 SEMANAS
            @if($solicitud->estadia->fecha_inicio && $solicitud->estadia->fecha_fin)
            <br>
            ({{ \Carbon\Carbon::parse($solicitud->estadia->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM') }} al 
            {{ \Carbon\Carbon::parse($solicitud->estadia->fecha_fin)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }})
            @endif
        </div>

        <p>El estudiante antes mencionado ha cumplido satisfactoriamente con los requisitos académicos establecidos por nuestra institución y se encuentra debidamente preparado para realizar su Estadía Profesional, la cual constituye una parte fundamental de su formación académica.</p>
        
        <p>Durante este período, el estudiante aplicará los conocimientos teóricos y prácticos adquiridos durante su formación académica, contribuyendo al desarrollo de proyectos específicos de su área de especialización bajo la supervisión de personal calificado de su empresa.</p>
        
        <p>Agradecemos de antemano la oportunidad que brindan a nuestros estudiantes para complementar su formación profesional, y quedamos a su disposición para cualquier aclaración o información adicional que requieran.</p>
        
        @if($solicitud->observaciones && $solicitud->observaciones !== 'Solicitud generada automáticamente')
        <p><strong>Observaciones adicionales:</strong> {{ $solicitud->observaciones }}</p>
        @endif
        
        <p>Sin otro particular por el momento, aprovecho la ocasión para enviarle un cordial saludo.</p>
    </div>

    <div class="signature">
        <div class="signature-line"></div>
        <div class="signature-name">
            @if($director)
                {{ $director->user->name }}
            @else
                [Nombre del Director]
            @endif
        </div>
        <div class="signature-title">
            @if($director && $director->titulo)
                {{ $director->titulo }}
            @else
                Director de Carrera
            @endif
        </div>
        <div class="signature-title">Ingeniería en Sistemas Computacionales</div>
        <div class="signature-title">Universidad Tecnológica de Hermosillo</div>
    </div>

    <div class="footer">
        <p>Universidad Tecnológica de Hermosillo | Blvd. Tecnológico s/n, Villa de Seris, 83287 Hermosillo, Son.</p>
        <p>Tel: (662) 262-9400 | www.uth.edu.mx</p>
    </div>
</body>
</html>