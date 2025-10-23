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
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }
        .institution {
            font-weight: bold;
            font-size: 16px;
            color: #2d5016;
            margin-bottom: 5px;
        }
        .department {
            font-size: 14px;
            color: #666;
        }
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        .date {
            text-align: right;
            margin-bottom: 30px;
        }
        .recipient {
            margin-bottom: 20px;
        }
        .student-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #2d5016;
            margin: 20px 0;
        }
        .signature-section {
            margin-top: 60px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 40px auto 10px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <!-- Logo de la institución -->
            <svg width="80" height="80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="#2d5016"/>
                <text x="50" y="55" text-anchor="middle" fill="white" font-size="20" font-weight="bold">UTH</text>
            </svg>
        </div>
        <div class="institution">UNIVERSIDAD TECNOLÓGICA DE HERMOSILLO</div>
        <div class="department">Dirección Académica</div>
    </div>

    <div class="content">
        <div class="date">
            Hermosillo, Sonora a {{ $fecha_generacion }}
        </div>

        <div class="recipient">
            <strong>A QUIEN CORRESPONDA:</strong>
        </div>

        <p>Por medio de la presente, me dirijo a ustedes para presentar al estudiante:</p>

        <div class="student-info">
            <strong>Nombre:</strong> {{ $carta->estudiante->user->name }}<br>
            <strong>Matrícula:</strong> {{ $carta->estudiante->matricula }}<br>
            <strong>Carrera:</strong> {{ $carta->estudiante->carrera->nombre }}<br>
            <strong>Cuatrimestre:</strong> {{ $carta->estudiante->cuatrimestre }}°<br>
            @if($carta->empresa_nombre)
            <strong>Empresa solicitada:</strong> {{ $carta->empresa_nombre }}<br>
            @endif
        </div>

        <p>El estudiante antes mencionado se encuentra cursando el {{ $carta->estudiante->cuatrimestre }}° cuatrimestre de la carrera de {{ $carta->estudiante->carrera->nombre }} en esta institución educativa, y como parte de su formación académica, requiere realizar su estadía profesional.</p>

        <p>La estadía profesional tiene una duración de 15 semanas (525 horas) y tiene como objetivo que el estudiante aplique los conocimientos adquiridos durante su formación académica en un ambiente laboral real, contribuyendo al desarrollo de proyectos específicos de la empresa.</p>

        <p>El período propuesto para la realización de la estadía es:</p>
        <ul>
            <li><strong>Fecha de inicio:</strong> {{ $carta->fecha_inicio ? \Carbon\Carbon::parse($carta->fecha_inicio)->format('d/m/Y') : 'Por definir' }}</li>
            <li><strong>Fecha de término:</strong> {{ $carta->fecha_fin ? \Carbon\Carbon::parse($carta->fecha_fin)->format('d/m/Y') : 'Por definir' }}</li>
        </ul>

        <p>Durante este período, el estudiante estará bajo la supervisión académica de un profesor de la institución y bajo la supervisión técnica de un responsable designado por su empresa.</p>

        <p>Agradecemos de antemano la atención que puedan brindar a esta solicitud y quedamos a su disposición para cualquier aclaración o información adicional que requieran.</p>

        @if($carta->revisadaPorProfesor)
        <p><strong>Profesor revisor:</strong> {{ $carta->revisadaPorProfesor->name }}</p>
        @endif

        <div class="signature-section">
            <div class="signature-line"></div>
            <strong>{{ $director->name }}</strong><br>
            Director Académico<br>
            Universidad Tecnológica de Hermosillo
        </div>
    </div>

    <div class="footer">
        <p>Universidad Tecnológica de Hermosillo | Dirección Académica</p>
        <p>Blvd. Tecnológico s/n, Col. El Sahuaro, Hermosillo, Sonora, México | Tel: (662) 262-9400</p>
    </div>
</body>
</html>