@extends('layouts.document')

@section('title', 'Order Document')

@php
    $timezone = request()->input('timezone', 'UTC');
    $carbon = \Carbon\Carbon::now()->setTimezone($timezone);
@endphp

@section('content')
    <table style="width: 100%;">
        <thead>
            <tr>
                <td class="text-center" style="text-align: left;">
                    Fecha: {{ $carbon->translatedFormat('j \d\e F \d\e Y') }}
                </td>
                <td class="text-center" style="text-align: right;">
                    Hora: {{ $carbon->translatedFormat('H:i') }}
                </td>
            </tr>
        </thead>
    </table>
    <h2 class="text-center">Declaración de consentimiento informado de Rayos X</h2>
    <p>
        Dentro de las normas éticas exigidas, se encuentra el deber de informar adecuada y oportunamente a todos sus
        pacientes los riesgos que pueden derivarse del tratamiento que les será practicado, solicitando sus conocimientos
        anticipadamente. Por tanto, el presente documento escrito pretende informar a usted y su familia (en caso de que
        aplique) acerca del procedimiento que se le practicará.
    </p>
    <p>
        El procedimiento que se le practicará a usted es: ______________________________.
    </p>
    <p>
        <b>¿Qué es?</b> Un rayo X o radiografía es un médico, no invasivo, que ayuda a los médicos a diagnosticar las
        condiciones médicas de los pacientes.
    </p>

    <p>
        <b>¿Para qué sirve?</b> Las radiografías utilizan radiaciones ionizantes que traspasan el cuerpo para obtener
        imágenes sin producir dolor en el paciente. Una radiografía es una imagen de las estructuras internas del cuerpo
        producidas por
        la exposición a una fuente controlada de los rayos X y que registra en una película fotográfica o en un sistema
        digital
        como un CD.
    </p>

    <p>
        <b>¿Para qué se utiliza?</b> Se utiliza para diagnosticar una gran variedad de afecciones, como fracturas óseas,
        enfermedades pulmonares, entre otros. En algunos casos, sirve como primera aproximación, pero puede que no sea
        suficiente para
        hacer un diagnóstico. La radiografía permitirá que el médico obtenga información para escoger la mejor técnica para
        continuar profundizando y llegar a determinar claramente qué enfermedad sufre.
    </p>
    <h3>
        RIESGOS DEL PROCEDIMIENTO
    </h3>
    <p>
        Existen riesgos asociados con los Rayos X, pero una radiografía simple utiliza una pequeña cantidad de radiación
        equivalente a la que todos recibimos de la atmósfera durante un periodo de dos o tres días.
    </p>
    <p>
        Los pacientes que estén o puedan estar embarazadas deben informarlo al médico radiólogo o al tecnólogo que le
        atienda antes de la realización del examen, quien le explicará los riesgos y beneficios. Si es necesario realizar
        esta prueba se cubrirá el abdomen y la pelvis con un delantal de plomo ya que el feto es más sensible a la radiación
        especialmente durante la embriogénesis (primeras 12 semanas de embarazo).
    </p>
    <h3>
        BENEFICIOS DEL PROCEDIMIENTO.
    </h3>
    <ul>
        <li>
            Las radiografías reflejan la manera más rápida y fácil para un médico de visualizar y evaluar lesiones en los
            huesos, incluyendo fracturas y anormalidades en las articulaciones tales como la artritis.
        </li>
        <li>
            Permiten determinar la presencia de lesiones en diferentes órganos, como en los pulmones o en el abdomen.
        </li>
        <li>
            Teniendo en cuenta la rapidez y facilidad que brindan las imágenes de rayos X, es de especial utilidad en los
            casos de diagnóstico y tratamiento de emergencia.
        </li>
        <li>
            No queda radiación en el cuerpo de un paciente luego de realizar el examen de rayos X.
        </li>
    </ul>
    <div style="page-break-after: always;"></div>
    <h3>
        DECLARACIÓN DE CONSENTIMIENTO INFORMADO:
    </h3>
    <p>
        He facilitado la información completa que conozco y me ha sido solicitada, sobre los antecedentes personales,
        familiares y de mi estado de salud. Soy consciente de que omitir estos datos puede afectar mi estado de salud en
        caso de estar gestante. Estoy de acuerdo con el procedimiento que se me va a realizar; he sido informada de los
        inconvenientes de este, se me ha explicado de forma clara en qué consiste, los beneficios y posibles riesgos del
        procedimiento. He escuchado, leído y comprendido la información recibida. He tomado consciente y libremente la
        decisión de autorizar el procedimiento.
    </p>

    <div class="section">
        <label>Nombre completo del paciente:</label>
        <div class="field">&nbsp;</div>

        <label>Cédula de ciudadanía:</label>
        <div class="field">&nbsp;</div>

        <div class="signature">Firma del paciente o huella según el caso</div>
    </div>

    <div class="section">
        <label>Nombre completo del representante (si procede):</label>
        <div class="field">&nbsp;</div>

        <label>Cédula de ciudadanía:</label>
        <div class="field">&nbsp;</div>

        <div class="signature">Firma del representante o huella según el caso</div>
    </div>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 40px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #004080;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 25px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        .field {
            border-bottom: 1px solid #666;
            padding: 5px 0;
            margin-bottom: 10px;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
        }
    </style>
@endsection