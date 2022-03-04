<?php

namespace App\Infrastructure\Services\Aldo;

class AldoExtractor
{
    public function extractComponents(string $descricaoTecnica, $asArray = false)
    {
        $components = $this->convertComponentsInArray($descricaoTecnica);

        if ($asArray) {
            return $components;
        }

        return $components->map(function (Component $component) {
            return $component->getQuantity() . ' ' .$component->getDescription();
        })->implode("<br>\n");
    }

    public function convertComponentsInArray(string $componentsText)
    {
        $pattern = '/<br\s?\/?>\s?/i';
        $splitterComponents = preg_split($pattern, $componentsText);

        return collect(array_filter($splitterComponents))
            ->filter(function ($description) {
                return preg_match('/^\d+\s?.*$/', $description);
            })
            ->map(function ($description) {
                $arrayDescription = explode(' ', $description, 2);
                return $this->extractComponent($arrayDescription[1], $description);
            });
    }

    public function extractComponent(string $arrayDescription, string $description)
    {
        $component = new Component();
        $component->setDescription($arrayDescription)
            ->setQuantity($this->extractQuantity($description))
            ->setKw($this->extractKw($description))
            ->setKva($this->extractKva($description));

        return $component;
    }

    public function extractQuantity(string $description): int
    {
        $pattern = '/^\d+/i';

        if (!preg_match($pattern, $description, $matches)) {
            return 0;
        }

        return collect($matches)->first();
    }

    public function extractKva(string $description): float
    {
        $pattern = '/(\d+[\.,]*\d*)\s?kva/i';

        if (!preg_match($pattern, $description, $matches)) {
            return 0;
        }

        $number = collect($matches)->last();

        return resolve('number-format')->parse($number);
    }

    public function extractKw(string $description): float
    {
        $pattern = '/(\d+[\.,]*\d*)\s?kw/i';

        if (!preg_match($pattern, $description, $matches)) {
            return 0;
        }

        $number = collect($matches)->last();

        if (is_numeric($number)) {
            return $number;
        }


        $parse = resolve('number-format')->parse($number);
        if ($parse === false) {
            return 0;
        }

        return $parse;
    }
}
