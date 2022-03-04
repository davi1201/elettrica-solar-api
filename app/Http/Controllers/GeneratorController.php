<?php

namespace App\Http\Controllers;

use App\Domain\Generator\Generator;
use App\Domain\Solar\Panel;
use App\Entities\City;
use App\Entities\MiscellaneousOption;
use App\Entities\Product;
use App\Infrastructure\Facades\Repository\PanelRepository;
use App\Infrastructure\Repository\SolarPotentialRepository;
use App\Infrastructure\Services\GeneratorService;
use App\Infrastructure\Services\Project\GeneratorTransformer;
use App\Model\ConfigAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneratorController extends Controller
{
    /**
     * @var GeneratorTransformer
     */
    private $generatorTransformer;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $generator_service;

    public function __construct(GeneratorService $generatorService, GeneratorTransformer $generatorTransformer)
    {
        $this->generator_service = $generatorService;
        $this->generatorTransformer = $generatorTransformer;
    }

    public function index(Request $request)

    // (float $power, int $tension, MiscellaneousOption $roof, Panel $panel, string $inverter = null)
    {

        $product = Product::find('');
        $roof = MiscellaneousOption::find(1);
        $res = $this->generator_service->getArrangement(1000, 220, $roof, $product, null);
        dd($res);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function getKits(Request $request)
    {
        $generatorService = new GeneratorService();
        $solarPotentialRepository = new SolarPotentialRepository();
        $configAdmin = ConfigAdmin::find(1);
        #$requestData = json_decode($request->message, true);
        $requestData = $request->all();
        $xmlCombinations = DB::table('products_combinations')->whereIn('panel', ['JINKO', 'PHONO'] )->whereIn('power_inverter', ['GROWATT'])->get();
        $roof = MiscellaneousOption::find($requestData['roof_type_id']);
        $irradiation = $solarPotentialRepository->getByCity(City::find($requestData['city_id']));
        // var_dump($xmlCombinations);
        foreach ($xmlCombinations as $xmlCombination) {
            $data = [
                'panel_type' => strtolower($xmlCombination->panel),
                'inverter_brand' => strtolower($xmlCombination->power_inverter)
            ];
            $panel = PanelRepository::findPanelById($data['panel_type']);

            $estimatePanels = $panel->estimatedCount($irradiation->average, $requestData['power'], $data['inverter_brand'], $data['panel_type']);
            $estimatePower = $panel->getMinimumGeneratorPower($estimatePanels);
            $arrangement = $generatorService->getArrangement($estimatePower, $requestData['voltage_stand'], $roof, $panel, $data['inverter_brand']);

            // dd($panel->getPower());

            $generatorInfo['estimate_power'] = 0;
            $generatorInfo['panel_count'] = 0;
            $generatorInfo['price'] = 0;
            $generatorInfo['power'] = 0;
            $generatorInfo['generators'] = [];
            $generatorInfo['transformers'] = [];
            foreach ($arrangement as $generator) {
                // dd($generator->getProduct()->potencia);
                /* @var $generator Generator */
                $generatorInfo['estimate_power'] += $generator->getEstimateEnergyGeneration($irradiation->average);
                $generatorInfo['panel_count'] += $generator->getPanelCount();
                $generatorInfo['price'] += $generator->getProduct()->preco;
                // $generator['panel'] = $generator->getPanel();

                /* @var $transformers Product[] */
                $transformers = $this->generatorTransformer->getTransformers($generator);
                if (in_array('Error', $transformers)) {
                    continue;
                }
                    $generatorInfo['power'] += $generator->getProduct()->potencia;
                    $generatorInfo['generators'][$generator->getProduct()->codigo] = isset($generatorInfo['generators'][$generator->getProduct()->codigo]) ? $generatorInfo['generators'][$generator->getProduct()->codigo] + 1 : 1;
                    if (count($transformers) > 0) {
                    $generatorInfo['price'] += array_reduce($transformers, function ($sum, $transformer) {
                        $sum += $transformer->preco;
                        return $sum;
                    });
                    foreach ($transformers as $transformer) {
                        $generatorInfo['transformers'][$transformer->codigo] = isset($generatorInfo['transformers'][$transformer->codigo]) ? $generatorInfo['transformers'][$transformer->codigo] + 1 : 1;
                    }
                }

            }
            $response = [];
            $response['total_estimate_power'] = $generatorInfo['estimate_power'];
            $response['generators_total_panels'] = $generatorInfo['panel_count'];
            $response['generators_total_price'] = $generatorInfo['price'] ;
            $response['price'] = ($generatorInfo['price'] * $configAdmin->percentage_sale) + $generatorInfo['price'];
            $response['power'] = $generatorInfo['power'];
            $response['generators'] = $generatorInfo['generators'];
            $response['transformers'] = $generatorInfo['transformers'];

            if ($data['inverter_brand'] === 'growatt'
                // || $data['inverter_brand'] === 'fronius'
                // || $data['inverter_brand'] === 'refusol'
            ) {
                $json[$data['panel_type']][$data['inverter_brand']] = $response;
            }


        }
        return response()->json($json);
    }
}
