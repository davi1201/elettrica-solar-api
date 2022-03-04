<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <title>SubSolar</title>
    <style>
        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }

        @font-face {
            font-family: 'Roboto';
            src: url('https://fonts.googleapis.com/css?family=Roboto)}}') format('truetype');
        }

        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif !important;
        }

        #header {
            position: relative;
        }

        #header div {
            position: absolute;
            top: 0;
        }

        .position-absolute {
            position: absolute;
        }

        .position-relative {
            position: relative;
        }

        h2 {
            background: #fff;
            display: inline-block;
            padding: 20px;
            color: #fe8824;
        }

        #description img {
            width: 100% !important;
        }

        #description {
            text-align: justify !important;
        }

        .page-break {
            page-break-after: always;
        }

        #test {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .price-container {
            padding: 40px 0;
            background-color: #fe8824;
            color: #fff;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table th {
            border: 1px solid #000;
            padding: 10px;
        }

        .table tr {
            margin-top: -1px !important;
            font-size: 14px;
        }

        .table td {
            padding: 10px;
            border: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .border h2 {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div id="header">
        <div id="container-header">
            <img src="{{ public_path('images/capa_projeto.jpg') }}" alt="" width="100%">
        </div>
        <div class="border" style="margin-top: 785px; margin-left: 50px">
            <h2>{{ $project->client->name }}</h2>
        </div>
    </div>

    <div>
        <img src="{{ public_path('images/img-1.jpg') }}" alt="" width="100%">
    </div>

    <img src="{{ public_path('images/img-2.jpg') }}" alt="" width="100%">

    <div>
        <div style="position: fixed; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000;">
            <img src="{{ public_path('images/img-3.jpg') }}" alt="" width="100%">
        </div>
        <div style="margin: 150px 40px 40px 40px; z-index: 9999">
            <div>
                <strong>Proposta:</strong> <span>{{ $project->id }}</span> <br>
                <strong>Data:</strong> <span style="color: #fe8824">{{ date('d/m/Y', strtotime($project->created_at)) }}</span> <br>
                <strong>Estimativa de geração:</strong> <span>{{ intval($project_custon->power_estimate) }} (kWh)</span> <br>
                <strong>Quantidade de painéis:</strong> <span>{{ $project_custon->panel_quantity }}</span> <br>
                <strong>Quantidade de kits:</strong> <span>{{ $project->projectProduct->quantity }}</span> <br>
                
                @if($project->metreage !== null)
                    <strong>Metragem do telhado:</strong> <span>{{ $project->metreage }}</span> <br>
                @endif
                
                <strong>Irradiação:</strong> <span>{{ number_format((float)$average, 2, '.', '') }}</span> <br>
                @if(is_object($agent))
                <strong>Agente:</strong> <span>{{ $agent->name }}</span> <br>
                @endif
                <strong>Cidade:</strong> <span>{{ $project->city->name }} - {{ $project->city->province->initial }}</span> <br>
            </div>

            <div>
                <h3>{{ $project_custon->description }}</h3>
            </div>

            @if(!empty($project_custon->tranformer))

            <h3>Transformadores</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Descrição</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-transform: uppercase">
                            {{ $project_custon->transformer }} {{ $project_custon->transformer_kva }} 
                        </td>
                        <td class="text-center">
                            {{ $project_custon->transformer_quantity }}
                        </td>
                    </tr>
                </tbody>
            </table>

            @endif

            <h3>Componentes do Kit</h3>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Descrição</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-transform: uppercase">
                            {{ $project_custon->panel }}
                        </td>
                        <td class="text-center">
                            {{ $project_custon->panel_quantity }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase">
                            {{ $project_custon->inverter }} {{ $project_custon->inverter_power }}KWP
                        </td>
                        <td class="text-center">
                            {{ $project_custon->inverter_quantity }}
                        </td>
                    </tr>                    
                </tbody>
            </table>

        </div>
    </div>
    <div class="page-break"></div>
    <div>
        <div style="position: fixed; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000;">
            <img src="{{ public_path('images/img-4.jpg') }}" alt="" width="100%">
        </div>
        <div style="margin: 150px 40px 10px 40px; z-index: 9999">
            <div class="price-container">
                <div style="text-align: center">
                    <h1 style="margin: 0; padding:0">
                        R$ @convert($project_custon->value)
                    </h1>
                    <div style="text-transform: uppercase; margin-top: 15px;">
                        <span>SIMULAÇÃO S/ ENTRADA: R$: </span>
                        <strong>36</strong> x <strong>@convert((($project_custon->value * $admin->percentage_financing) + $project_custon->value) / 36) </strong> /
                        <strong>48</strong> x <strong>@convert((($project_custon->value * $admin->percentage_financing) + $project_custon->value) / 48)</strong> /
                        <strong>60</strong> x <strong>@convert((($project_custon->value * $admin->percentage_financing) + $project_custon->value) / 60)</strong>
                    </div>
                    <div style="margin-top: 15px;">
                        <span><strong>90</strong> DIAS DE CARÊNCIA</span>
                    </div>
                </div>
            </div>
        </div
        <div style="text-align: center; color: red">
            <span>***Proposta válida por <strong>2 Dias</strong> </span>
        </div>
    </div>
</body>

</html>