<?php

namespace App\Infrastructure\Services;

use App\Domain\Generator\Generator;
use App\Domain\Generator\GeneratorArrangement;
use App\Domain\Solar\Panel;
use App\Entities\MiscellaneousOption;
use App\Entities\Project;
use App\Infrastructure\Repository\ProductRepository;

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
}
