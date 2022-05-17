<?php

namespace App\Infrastructure\Services;

use App\Domain\Generator\Generator;
use App\Domain\Generator\GeneratorArrangement;
use App\Domain\Solar\Panel;
use App\Entities\MiscellaneousOption;
use App\Entities\Project;
use App\Entities\SolarPotential;
use App\Infrastructure\Repository\ProductRepository;
use Illuminate\Support\Facades\Http;

class GeneratorService
{
    public function getArrangement(float $power, int $tension, MiscellaneousOption $roof, Panel $panel, string $inverter = null)
    {
        $arrangement = $this->makeSingleArrangement($power, $tension, $roof, $panel, $inverter);

        if ($arrangement->count() > 0) {
            return $arrangement;
        }

        return $this->makeCompositeArrangement($power, $tension, $roof, $panel, $inverter);
    }

    private function makeSingleArrangement(float $power, int $tension, MiscellaneousOption $roof, Panel $panel, string $inverter = null): GeneratorArrangement
    {
        if ($power < 9) {
            $tension = 220;
        }
        $arrangement = new GeneratorArrangement();
        $productRepository = new ProductRepository();
        $product = $productRepository->findGenerator($power, $tension, $roof, $panel, $inverter);

        if ($product === null) {
            return $arrangement;
        }

        return $arrangement->push(
            $this->buildGenerator($product, $roof, $panel, false)
        );
    }

    private function makeCompositeArrangement(float $estimatePower, int $tension, MiscellaneousOption $roof, Panel $panel, string $inverter = null): GeneratorArrangement
    {
        $generators = new GeneratorArrangement();
        $product = null;
        $count = 1;
        $productRepository = new ProductRepository();

        while ($count < config('subsolar.arrangement_max_size')) {
            $power = $estimatePower / $count;
            $product = $productRepository->findGenerator($power, 380, $roof, $panel, $inverter);

            if ($product !== null) {
                break;
            }

            $count++;
        }

        if ($product === null) {
            return $generators;
        }

        for ($i = 0; $i < $count; $i++) {
            $generators->push(
                $this->buildGenerator($product, $roof, $panel, $tension === 220)
            );
        }
        return $generators;
    }

    public function buildGenerator($product, MiscellaneousOption $roof, Panel $panel, bool $overcapacity)
    {
        return new Generator($product, $roof, $panel, $overcapacity);
    }

    public function createInternalCodeGenerator(array $data, Project $project, bool $transformer)
    {
        $roof_type = MiscellaneousOption::query()->where('slug', $data['roof_type'])->first();

        $md5 = md5($data['code']);

        $internalCode = sprintf('%s-%s', strtoupper(substr($md5, 0, 8)), $roof_type->id);

        if ($transformer) {
            $internalCode = sprintf('%s-%s', $internalCode, $project->id);
        }

        return $internalCode;
    }

    public function createInternalCode(string $uuid)
    {
        $md5 = md5($uuid);

        return strtoupper(substr($md5, 0, 8));
    }

    public function getKitsSolFacil($power, $roof_type)
    {
        $telhado = MiscellaneousOption::find($roof_type);
        $range_min = 1000;
        if ($power >= 10000 && $power <= 20000) $range_min = 5000;

        if ($power > 20000) $range_min = 10000;


        $url = env('SOLFACIL_URL_PROD') . 
                    '?min_power=' . ($power - $range_min) . 
                    '&max_power=' . $power . 
                    '&page=1&page_size=10&roof_types[0]=' . 
                    $telhado->solfacil_ref .
                    '&order_by_field=price&order_by_direction=asc';
        // dd($url);
        $response = Http::withHeaders([
                            'api-access-key' => env('SOLFACIL_KEY_PROD'),
                            'api-secret-key' => env('SOLFACIL_PASSWOR_PRODD')
                        ])
                        ->acceptJson()
                        ->get($url);

        $kits = $response->json();

        return $kits['data'];
    }
}
