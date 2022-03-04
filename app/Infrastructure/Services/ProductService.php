<?php


namespace App\Infrastructure\Services;

use App\Entities\MiscellaneousOption;
use App\Entities\Product;
use App\Entities\ProductCombination;
use App\Exceptions\AldoException;
use App\Infrastructure\Aldo\AldoProducts;
use App\Infrastructure\Services\Aldo\AldoExtractor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * @var AldoProducts
     */
    private $aldoProducts;

    /**
     * ProductService constructor.
     * @param AldoProducts $aldoProducts
     */
    public function __construct(AldoProducts $aldoProducts)
    {
        $this->aldoProducts = $aldoProducts;
    }

    public function import()
    {
        Product::query()->update(['active' => false]);
        $this->aldoProducts->get();
        $this->aldoProducts->parse([$this, 'process']);


        return true;

    }

    public function process(array $data, array $innerData = [])
    {
        try {
            DB::beginTransaction();

            $importTypes = ['GERADOR', 'TRANSFORMADOR'];
            if (!empty($innerData['TIPO_PRODUTO']) && in_array($innerData['TIPO_PRODUTO'], $importTypes)) {
                $product = $this->findOrNew($data['codigo']);

                if ($product->exists) {
                    $data = ['preco' => $data['preco'], 'active' => true];
                }

                if (isset($data['descricao'])) {
                    $data['potencia'] = $this->getPotencia($data['descricao']);
                }

                if (isset($data['descricao_tecnica'])) {
                    $data['descricao_tecnica'] = utf8_encode($data['descricao_tecnica']);
                }

                if (isset($data['marca_site'])) {
                    $data['marca'] = $data['marca_site'];
                }

                if (isset($innerData['POTENCIA_W'])) {
                    $data['potencia'] = $innerData['POTENCIA_W']/1;
                }

                $data['telhado'] = $innerData['TIPO_ESTRUTURA'] ?? null;
                $product->fill($data);
                $product->save();

                if ($innerData['TIPO_PRODUTO'] == 'GERADOR') {
                    $this->saveCombination($innerData);
                }
            }

            DB::commit();

        } catch (AldoException $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error('[import] Aldo webservice return an error');
        }

    }

    private function saveCombination($data)
    {
        $panel = isset($data['MARCA_PAINEL']) ? strtok($data['MARCA_PAINEL'],' ') : null;
        $powerInverter = $data['MARCA_INVERSOR'] ?? null;
        $roofType = $data['TIPO_ESTRUTURA'] ?? null;

        $data = ['panel' => $panel, 'power_inverter' => $powerInverter];

        if (in_array(null, $data, true)) {
            return;
        }

        if ($roofType) {
            $miscData = ['slug' => Str::slug($roofType), 'label' => $roofType, 'type' => 'roof_type_xml'];

            $miscellaneousOption = MiscellaneousOption::firstOrNew($miscData);
            $miscellaneousOption->save();
        }

        $productCombination = ProductCombination::firstOrNew($data);
        $productCombination->save();
    }

    private function getPotencia(string $descricao) {
        $extractor = resolve(AldoExtractor::class);
        /* @var $extractor AldoExtractor */

        return $extractor->extractKw($descricao);
    }

    private function findOrNew($codigo): Product
    {
        $product = Product::find($codigo);

        if (null === $product) {
            return new Product();
        }

        return $product;
    }
}
