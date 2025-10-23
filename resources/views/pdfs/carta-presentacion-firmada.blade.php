<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Presentación - Firmada</title>
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
        .digital-signature {
            margin: 20px auto;
            max-width: 200px;
            max-height: 75px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 20px auto 10px;
        }
        .approval-stamp {
            position: absolute;
            top: 150px;
            right: 50px;
            width: 120px;
            height: 120px;
            border: 3px solid #2d5016;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 10px;
            font-weight: bold;
            color: #2d5016;
            background-color: rgba(45, 80, 22, 0.1);
        }
        .comments-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f0f8ff;
            border-left: 4px solid #007bff;
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
        .verification-code {
            position: absolute;
            bottom: 100px;
            right: 20px;
            font-size: 8px;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- Sello de aprobación -->
    <div class="approval-stamp">
        <div>APROBADO</div>
        <div>DIRECTOR</div>
        <div style="font-size: 8px; margin-top: 5px;">{{ $fecha_generacion }}</div>
    </div>

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
            @if(isset($firma_path) && file_exists($firma_path))
            <div class="digital-signature">
                <img src="{{ $firma_path }}" alt="Firma Digital" style="max-width: 100%; max-height: 100%;">
            </div>
            @endif
            <div class="signature-line"></div>
            <strong>{{ $director->name }}</strong><br>
            Director Académico<br>
            Universidad Tecnológica de Hermosillo<br>
            <small style="color: #666;">Documento firmado digitalmente el {{ $fecha_generacion }}</small>
        </div>
    </div>

    <!-- Código de verificación -->
    <div class="verification-code">
        Código de verificación: UTH-{{ strtoupper(substr(md5($carta->id . $fecha_generacion), 0, 8)) }}
    </div>

    <div class="footer">
        <p>Universidad Tecnológica de Hermosillo | Dirección Académica</p>
        <p>Blvd. Tecnológico s/n, Col. El Sahuaro, Hermosillo, Sonora, México | Tel: (662) 262-9400</p>
        <p style="margin-top: 5px; font-size: 8px;">Este documento ha sido firmado digitalmente y es válido para todos los efectos legales.</p>
    </div>
</body>
</html>