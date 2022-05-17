<?php

namespace App\Http\Controllers;

use App\Entities\City;
use App\Entities\Product;
use App\Infrastructure\Repository\Filters\ProjectFilter;
use App\Infrastructure\Repository\ProjectRepository;
use App\Infrastructure\Repository\SolarPotentialRepository;
use App\Infrastructure\Services\ProjectService;
use App\Model\Agent;
use App\Model\ConfigAdmin;
use App\Model\Project;
use App\Model\ProjectProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $project_service;
    protected $project_repository;

    public function __construct(ProjectService $projectService, ProjectRepository $projectRepository)
    {
        $this->project_service = $projectService;
        $this->project_repository = $projectRepository;
    }

    public function index(Request $request)
    {

        $filter = new ProjectFilter($request->query());

        $projects = $this->project_repository->getList($filter);

        // foreach ($projects as $project) {
        //     if ( isset($project->projectProduct->productCuston)) {
        //         $project['custon'] = true;
        //     } else {
        //         $project['custon'] = false;
        //     }
        // }
        return response()->json($projects, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $project = $this->project_service->create($data);

        return response()->json($project, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project_product = ProjectProduct::where('project_id', $project->id)->first();
        $data =  $this->project_service->findById($project_product->product_code);
        $project->load('client.addresses.city.province');

        foreach ($data as $key => $value) {
            foreach ($data[$key]['components'] as $chave => $component) {
                preg_match('/(\s*[0-9]+)+/', $component, $matches);
                if (count($matches) > 0) {
                    $data[$key]['components'][$chave] = [
                        'quantity' => $matches[0],
                        'description' => str_replace($matches[0], '', $component)
                    ];
                }
            }
        }

        $modules = $data[0]['kit_modules'][0]['amount'] . ' Painéis ' . 
                    $data[0]['kit_modules'][0]['item']['attributes'][0]['value'] . ' ' . 
                    $data[0]['kit_modules'][0]['item']['attributes'][1]['value'];

        $inverter = ' | Inversor ' . $data[0]['kit_inverters'][0]['item']['power'] / 1000 . 'Kwp ' .
                                $data[0]['kit_inverters'][0]['item']['attributes'][0]['value'] . ' ' .
                                $data[0]['kit_inverters'][0]['item']['attributes'][5]['value'];
        $description = $modules . $inverter;
        
        $loads = [
            'project' => $project,
            'product' => $project_product,
            'kit' => $data[0],
            'agent' => $project->agent,
            'components' => $data[0]['components'],
            'admin' => ConfigAdmin::find(1),
            'description' => $description
        ];
        return response()->json($loads, 200);
    }

    protected function generatePaybackChart(array $data)
    {
        $paybackYears[] = [
            "Anos",
            "R$",
            ['type' => 'string', 'role' => 'tooltip', 'p' => ['html' => true]],
            ['type' => 'string', 'role' => 'style'],
        ];

        for ($i = 0; $i < sizeof($data); $i++) {
            $xAxisLabel = $i == 0 ? 'Hoje' : "{$i}";

            $formattedValue = $this->getNumberFormatted($data[$i], ',', '.');
            $string = "<div class='chart-tooltip' style='width: 120px'>Ano {$xAxisLabel}<br><strong>R$ {$formattedValue}</strong></div>";
            $value = (float)$this->getNumberFormatted($data[$i], ',', '');

            $paybackYears[] = [
                $xAxisLabel,
                $value,
                $string,
                $data[$i] > 0 ? 'color: #48C596' : 'color: #FBE45A',
            ];
        }

        $minChartColumn = min($data);

        return [
            $paybackYears,
            $minChartColumn,
        ];
    }

    protected function generatePayBack($estimatedValue, $estimatedPower, $consumptionOffPeak, $kwOffPeakPrice, $demand = null, $kwOnDemandPrice = null)
    {
        $estimatedValue = $estimatedValue * -1;

        $monthlyConsume = $consumptionOffPeak;
        $annualGeneration = $estimatedPower * 12;
        if ($demand) {
            $yearConsume = $monthlyConsume * 12;
        } else {
            $yearConsume = ($monthlyConsume - 100) * 12;
        }

        $valueSavedYears = [
            $estimatedValue
        ];

        $degradatePanel = 1;

        for ($i = 0; $i < 25; $i++) {
            if ($i > 0) {
                $degradatePanel = $degradatePanel * 0.994;
                $kwOffPeakPrice = $kwOffPeakPrice * 1.07;
                $kwOnDemandPrice = $kwOnDemandPrice * 1.07;
            }
            $minor = ($annualGeneration * $degradatePanel) < $yearConsume ? ($annualGeneration * $degradatePanel) : $yearConsume;

            $cost = $minor * $kwOffPeakPrice;

            $estimatedValue = $estimatedValue + ($cost - ($demand * 12 * $kwOnDemandPrice));

            $valueSavedYears[] = $estimatedValue;
        }

        return $valueSavedYears;
    }

    public function showPdfSolfacil(Project $project)
    {
        $pdf = App::make('dompdf.wrapper');
        $project_product = ProjectProduct::where('project_id', $project->id)->first();
        $data =  $this->project_service->findById($project_product->product_code);

        $solarPotentialRepository = new SolarPotentialRepository();
        $irradiation = $solarPotentialRepository->getByCity(City::find($project->city_id));

        foreach ($data as $key => $value) {            
            $components = explode(PHP_EOL, $data[$key]['description']);
            $data[$key]['components'] = $components;
            $data[$key]['price_cost'] = round($data[$key]['price'] / 100, 2);
            $data[$key]['price'] = $data[$key]['price'] / 100;
            $data[$key]['price'] = round($data[$key]['price'] + ($data[$key]['price'] * 0.50), 2);
        }
        
        foreach ($data as $key => $value) {
            foreach ($data[$key]['components'] as $chave => $component) {
                preg_match('/(\s*[0-9]+)+/', $component, $matches);
                if (count($matches) > 0) {
                    $data[$key]['components'][$chave] = [
                        'quantity' => $matches[0],
                        'description' => str_replace($matches[0], '', $component)
                    ];
                }
            }
        }

        $modules = $data[0]['kit_modules'][0]['amount'] . ' Painéis ' . 
                    $data[0]['kit_modules'][0]['item']['attributes'][0]['value'] . ' ' . 
                    $data[0]['kit_modules'][0]['item']['attributes'][1]['value'];

        $inverter = ' | Inversor ' . $data[0]['kit_inverters'][0]['item']['power'] / 1000 . 'Kwp ' .
                                $data[0]['kit_inverters'][0]['item']['attributes'][0]['value'] . ' ' .
                                $data[0]['kit_inverters'][0]['item']['attributes'][5]['value'];
        $description = $modules . $inverter;
        
        $loads = [
            'project' => $project,
            'product' => $project_product,
            'kit' => $data[0],
            'average' => $irradiation->average,
            'agent' => $project->agent,
            'components' => $data[0]['components'],
            'admin' => ConfigAdmin::find(1),
            'description' => $description
        ];

        
        // dd($description);
        // dd($loads['kit']['kit_inverters'][0]['item']);
        $html = view('project-solfacil', $loads)->render();       

        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function showPdf(Project $project)
    {
        $solarPotentialRepository = new SolarPotentialRepository();
        $irradiation = $solarPotentialRepository->getByCity(City::find($project->city_id));

        $pdf = App::make('dompdf.wrapper');
        $project->load('client.addresses.city.province');
        $components = $project->projectProduct->product->components;
        $discounts = $project->discounts;
        
        if (count($discounts) > 0) {
            $last_discount = $discounts->last();
            $value_project = $last_discount->price_with_discount;
        } else {
            $value_project = $project->price;
        }

        $transformers = false;

        if (count($project->transformers) > 0) {
            $transformers = $project->transformers;
        }

        $loads = [
            'project' => $project,
            'product' => $project->projectProduct->product,
            'agent' => $project->agent,
            'components' => $components,
            'transformers' => $transformers,
            'average' => $irradiation->average,
            'admin' => ConfigAdmin::find(1),
        ];

        // dd($loads);
        
        // $paybackData = $this->generatePayBack(
        //     $project->final_cost,
        //     $project->information->estimate_generation_power,
        //     $project->information->average_consume,
        //     $project->kwh_price
        // );

        // $paybackInstallmentData = $this->generatePayBack(
        //     $project->final_cost * 1.45,
        //     $project->information->estimate_generation_power,
        //     $project->information->average_consume,
        //     $project->kwh_price
        // );

        // list($paybackChart, $minPaybackChartColumn) = $this->generatePaybackChart($paybackData);
        // $maxPaybackChartColumn = end($paybackChart);

        // list($paybackInstallmentsChart, $minPaybackInstallmentsChartColumn) = $this->generatePaybackChart($paybackInstallmentData);
        // $maxPaybackInstallmentsChartColumn = end($paybackInstallmentsChart);

        // if ($hasChart) {
        //     $potentialByMonth = $solarPotentialRepository->getByCity($project->city);
        //     $estimatedPanels = $project->getTotalPanel();
        //     $estimatedByMonth[] = ["Mês", "Kw", ['type' => 'string', 'role'=> 'tooltip', 'p'=> ['html'=> true]]];
        //     $monthsBr = getMonthsPtBr();

        //     for($i = 1; $i <= sizeof($monthsBr); $i++) {
        //         $date = (\DateTime::createFromFormat('!m', $i));
        //         $month = strtolower($date->format('F'));
        //         $monthLabel = $monthsBr[$date->format('n')];
        //         $value = $project->panel->getAnnualGeneration($estimatedPanels, $potentialByMonth->{$month} / 1000);
        //         $formattedValue = number_format($value,2,',', '.');

        //         $estimatedByMonth[] = [
        //             substr($monthLabel, 0, 3),
        //             $value,
        //             "<div class='chart-tooltip'>{$monthLabel}<br><strong>{$formattedValue}</strong></div>"
        //         ];
        //         $estimated[] = $value;
        //     }

        //     $minChartColumn = min($estimated);
        //     $round = (int)round($minChartColumn, -3);

        //     $mod = (int)str_pad('1', strlen($minChartColumn), '0');

        //     if ($round >= $minChartColumn) {
        //         $minChartColumn = $minChartColumn - ($minChartColumn % $mod) - ($mod / 2);
        //     } else {
        //         $minChartColumn = $round - ($mod / 2);
        //     }
        // }

        if ($project->projectProduct->productCuston) {
            $loads['project_custon'] = $project->projectProduct->productCuston;
            $html = view('project-custon', $loads)->render();    
        } else  {
            $html = view('project', $loads)->render();
        }

        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $this->project_service->update($project, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
