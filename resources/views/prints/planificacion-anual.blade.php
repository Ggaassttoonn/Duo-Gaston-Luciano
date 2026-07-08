<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planificación Anual</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            color: #2c3e50;
        }
        .container {
            max-width: 850px;
            margin: auto;
            border: 2px solid #e67e22;
            padding: 30px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h1 { text-align: center; color: #2c3e50; border-bottom: 3px solid #e67e22; padding-bottom: 10px; margin-bottom: 25px; font-size: 24px; }
        h2 { color: #3498db; margin-top: 25px; margin-bottom: 10px; font-size: 18px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .info-box { background: #fff; padding: 12px; border-left: 5px solid #e67e22; border-radius: 4px; font-size: 14px; }
        .info-box.full { grid-column: 1 / -1; }
        .section-content { background: #fff; padding: 15px; border-radius: 4px; border: 1px solid #ddd; line-height: 1.8; white-space: pre-wrap; }
        footer { margin-top: 30px; font-size: 0.8em; color: #999; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }

        @media print {
            body { padding: 0; }
            .container { border: none; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Planificación Anual</h1>

        <div class="info-grid">
            <div class="info-box">
                <strong>Docente:</strong>
                {{ $planificacion->personaCargoCursado->personaCargo->persona->apellidos ?? '' }},
                {{ $planificacion->personaCargoCursado->personaCargo->persona->nombres ?? '' }}
            </div>
            <div class="info-box">
                <strong>DNI:</strong>
                {{ $planificacion->personaCargoCursado->personaCargo->persona->dni ?? '' }}
            </div>
            <div class="info-box">
                <strong>Cargo:</strong>
                {{ $planificacion->personaCargoCursado->personaCargo->cargo->cargo ?? '' }}
            </div>
            <div class="info-box">
                <strong>Situación Revista:</strong>
                {{ $planificacion->personaCargoCursado->personaCargo->sitRevista->revista ?? '' }}
            </div>
            <div class="info-box">
                <strong>Curso:</strong>
                {{ $planificacion->personaCargoCursado->cursado->curso->ciclo ?? '' }}
                {{ $planificacion->personaCargoCursado->cursado->curso->grado ?? '' }}
                "{{ $planificacion->personaCargoCursado->cursado->curso->seccion ?? '' }}"
                - {{ $planificacion->personaCargoCursado->cursado->curso->turno ?? '' }}
            </div>
            <div class="info-box">
                <strong>Año Lectivo:</strong>
                {{ $planificacion->personaCargoCursado->cursado->anio_lectivo ?? '' }}
            </div>
            <div class="info-box">
                <strong>Área:</strong>
                {{ $planificacion->area->area ?? '' }}
                ({{ $planificacion->area->tipo ?? '' }})
            </div>
            <div class="info-box">
                <strong>Fecha Presentación:</strong>
                {{ $planificacion->fecha_presentacion?->format('d/m/Y') }}
            </div>
            <div class="info-box">
                <strong>Tipo:</strong>
                {{ $planificacion->tipo_planificacion }}
            </div>
        </div>

        <h2>Aprendizajes Esperados</h2>
        <div class="section-content">{{ $planificacion->aprendizajes_esperados }}</div>

        <h2>Saberes</h2>
        <div class="section-content">{{ $planificacion->saberes }}</div>

        <h2>Criterios de Evaluación</h2>
        <div class="section-content">{{ $planificacion->criterios }}</div>

        @if ($planificacion->diagnostico)
        <h2>Diagnóstico</h2>
        <div class="section-content">{{ $planificacion->diagnostico }}</div>
        @endif

        @if ($planificacion->bibliografia)
        <h2>Bibliografía</h2>
        <div class="section-content">{{ $planificacion->bibliografia }}</div>
        @endif

        @if ($planificacion->estadosAnuales->isNotEmpty())
        <h2>Estados</h2>
        <div class="section-content">
            <ul>
                @foreach ($planificacion->estadosAnuales as $estado)
                    <li>{{ $estado->estado }} - {{ $estado->fecha?->format('d/m/Y') }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <footer>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </footer>
    </div>
</body>
</html>
