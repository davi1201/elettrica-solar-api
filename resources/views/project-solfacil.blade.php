<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <title>Elettrica Solar</title>
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
            display: inline-block;
            color: #fff;
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
            padding: 10px;
        }

        .table tr {
            margin-top: -1px !important;
            font-size: 12px;
        }

        .table td {
            padding: 10px;
            border: 1px solid #CCCED7;
        }

        .text-center {
            text-align: center;
        }

        .border h2 {
            border-radius: 10px;
        }        

        .card .card-header {
            background-color: #F5F5F5;
            border: 1px solid #CCCED7;
            height: 50px;
            line-height: 13px;
            position: relative;
            padding-left: 10px;
        }

        .card .card-header img {
            position: absolute;
            width: 25px;
            top: 10px;
        }

        .card .card-header h4 {
            padding-left: 45px;
        }

        .card-content {
            border-left: 1px solid #CCCED7;
            border-right: 1px solid #CCCED7;
            padding-bottom: 0;
        }

        .card-content ul {
            padding: 0;
            margin-top: 0px;
        }

        .card-content ul li {
            list-style: none;
            border-bottom: 1px solid #CCCED7;
            padding-top: 16px;
            padding-bottom: 12px;
        }
    </style>
</head>

<body>
    <div id="header">
        <div id="container-header">
            <img src="{{ public_path('images/capa_projeto.jpg') }}" alt="" width="100%">
        </div>
        <div style="margin-top: 970px; margin-left: 55px">
            <h2>{{ $project->client->name }}</h2>
        </div>
    </div>

    <div>
        <img src="{{ public_path('images/02.jpg') }}" alt="" width="100%">
    </div>

    <img src="{{ public_path('images/img-1.jpg') }}" alt="" width="100%">

    <div>
        <div style="position: fixed; left: 0px; top: 0px; right: -1px; bottom: 0px; text-align: center;z-index: -1000;">
            <img src="{{ public_path('images/04.jpg') }}" alt="" width="100%">
        </div>
        <div style="margin: 130px 40px 40px 40px; z-index: 9999">
            <span style="font-size: 22px;">
                A <strong style="color: #FF7900;">Elettrica Solar</strong> é uma empresa de energia <br>
                solar fotovoltaica que trabalha com as <br>
                melhores marcas e equipamentos nacionais <br>
                e internacionais
            </span> 

            <br> <br>
            <span>A Energia solar é uma fonte renovável e pode ser grande aliada <br> para a economia em sua casa, empresa ou indústria.</span>

            <div class="card" style="margin-top: 30px;">
                <div class="card-header">
                   <img src="{{ public_path('images/icon.svg') }}" alt=""> <h4>ESCOPO DO PROJETO</h4>
                </div>
                <div class="card-content">
                    <ul>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Proposta:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                #{{ $project->id }}
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Data:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span style="color: #FF7900">{{ date('d/m/Y', strtotime($project->created_at)) }}</span>
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Estimativa de geração:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span>{{ intval($product->estimate_power) }} (kWh)</span>
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Quantidade de painéis:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span>{{ $product->panel_count }}</span>
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Quantidade de kits:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span>{{ $product->quantity }}</span>
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Irradiação:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span>{{ number_format((float)$average, 2, '.', '') }}</span>
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Agente:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                @if(is_object($agent))
                                <span>{{ $agent->name }}</span>
                                @endif
                            </div>
                        </li>
                        <li>
                            <div style="display: inline-block; width: 210px; text-align: right;">
                                Cidade:
                            </div>
                            <div style="display: inline-block; width: 250px;"></div> 
                            <div style="display: inline-block; width: 210px;">
                                <span>{{ $project->city->name }} - {{ $project->city->province->initial }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="font-size: 13px;">
                * A geração estimada não é linear, sofrendo variação nos diferentes meses do ano. <br>
                * Valor calculado com base na média histórica de radiação da região, e sujeito a variação das condições climáticas.
            </div>

            <div style="background-color: #F5F5F5; border: 1px solid #CCCED7; padding: 10px 40px; margin-top: 30px; width: 101%; margin-left: -40px;">
                <h2 style="color: #333 !important; font-size: 22px;">
                    {{ $description }}
                </h2>
            </div>            
        </div>
    </div>
    <div class="page-break"></div>
    <div>
        <div style="position: fixed; left: 0px; top: 0px; right: -1px; bottom: 0px; text-align: center;z-index: -1000;">
            <img src="{{ public_path('images/05.jpg') }}" alt="" width="100%">
        </div>
        <div style="margin: 130px 40px 10px 40px; z-index: 9999">        
            <div class="card" style="margin-top: 20px;">
                <div class="card-header" style="position: relative;">
                   <img src="{{ public_path('images/icon.svg') }}" alt=""> <h4>COMPONENTES DO KIT</h4>
                   <div style="position: absolute; right: 0px; top: 0; display: inline-block; border-left: 1px solid #CCCED7; text-align: center; height: 50px; width: 130px;">
                    <h4 style="padding-left: 0;">QUANTIDADE</h4>
                   </div>
                </div>
                <div class="card-content">
                    <table class="table">
                        <tbody>
                            @foreach($components as $component)
                            <tr>
                                <td style="text-transform: uppercase">
                                    {{ $component['description'] }}
                                </td>
                                <td class="text-center" style="width: 109.5px;">
                                    {{ $component['quantity'] }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card" style="bottom: 356.5px; position: fixed; right: 40px; left: 40px;">
                <div class="card-header" style="position: relative;">
                   <img src="{{ public_path('images/icon.svg') }}" alt=""> <h4>VALOR DA PROPOSTA</h4>
                </div>
                <div class="card-content" style="background-color: #fff; padding: 10px 40px; color: #333;">
                    <h2 style="color: #333 !important; margin-top: 0px;">R$ @convert($project->price)</h2>
                    <div style="margin-top: 10px;">
                        <span>SIMULAÇÃO S/ ENTRADA:</span>
                        <div>
                            <strong>36</strong> x <strong style="padding-right: 15px ;">@convert((($project->price * $admin->percentage_financing) + $project->price) / 36)</strong>|
                            <strong style="padding-left: 15px;">48</strong> x <strong style="padding-right: 15px;">@convert((($project->price * $admin->percentage_financing) + $project->price) / 48)</strong>|
                            <strong style="padding-left: 15px;">60</strong> x <strong style="padding-right: 15px;">@convert((($project->price * $admin->percentage_financing) + $project->price) / 60)</strong>|
                            <strong style="padding-left: 15px;">72</strong> x <strong>@convert((($project->price * $admin->percentage_financing) + $project->price) / 72)</strong>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px; margin-top: 20px;">
                        <img src="{{ public_path('images/proposta.jpg') }}" style="width: 200px; margin-top: 10px; padding-right: 20px;" alt=""> <span style="color: #FF7900;">ATÉ 90 DIAS DE CARÊNCIA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>