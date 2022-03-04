<?php

namespace App\Entities;

use App\Infrastructure\Services\Aldo\AldoExtractor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'codigo';

    protected $keyType = 'string';

    protected $fillable = [
        'codigo',
        'marca',
        'telhado',
        'categoria',
        'descricao',
        'unidade',
        'preco',
        'precoeup',
        'peso',
        'descricao_tecnica',
        'foto',
        'potencia',
        'active',
    ];

    protected $casts = [
        'preco' => 'float',
        'precoeup' => 'float',
        'peso' => 'float',
        'potencia' => 'float',
    ];

    public function getPowerInverterAttribute()
    {
        $result = preg_match_all('/(\d+) INVERSOR/i', $this->descricao_tecnica, $output_array);

        if ($result === false) {
            throw new \RuntimeException('Unable to count solar inverter');
        }

        $value = collect($output_array)->last();

        return (int)$value[0];
    }

    public function getDescriptionAttribute()
    {
        $extractor = resolve(AldoExtractor::class);
        /* @var $extractor AldoExtractor */

        return $extractor->extractComponents($this->descricao_tecnica);
    }

    public function getComponentsAttribute()
    {
        $extractor = resolve(AldoExtractor::class);
        /* @var $extractor AldoExtractor */

        return $extractor->extractComponents($this->descricao_tecnica, true);
    }

    public function setDescricaoTecnicaAttribute($value)
    {
        $this->attributes['descricao_tecnica'] = utf8_decode($value);
    }

    public function setPrecoAttribute($value)
    {
        $this->attributes['preco'] = is_string($value) ? $this->parseFloat($value) : $value;
    }

    public function setPrecoeupAttribute($value)
    {
        $this->attributes['precoeup'] = is_string($value) ? $this->parseFloat($value) : $value;
    }

    public function setPesoAttribute($value)
    {
        $this->attributes['peso'] = is_string($value) ? $this->parseFloat($value) : $value;
    }

    public function setPotenciaAttribute($value)
    {
        $this->attributes['potencia'] = is_string($value) ? $this->parseFloat($value) : $value;
    }

    private function parseFloat($value)
    {
        $formatter = new \NumberFormatter('pt_BR', \NumberFormatter::DECIMAL);
        $convertedValue = $formatter->parse($value);

        if ($convertedValue === false) {
            Log::warning(sprintf('[conversion] Failed to parse "%s" to float', $value));
            return 0;
        }

        return $convertedValue;
    }
}
