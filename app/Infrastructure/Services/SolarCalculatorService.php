<?php


namespace App\Infrastructure\Services;


use App\Domain\Solar\Panel;
use Illuminate\Support\Collection;

class SolarCalculatorService
{
    /**
     * @var Collection
     */
    protected $panels = null;

    /**
     * SolarCalculatorService constructor.
     * @param Collection $panels
     */
    public function __construct(Collection $panels)
    {
        $this->panels = $panels;
    }

    public function findPanelById(string $id): Panel
    {
        $data = $this->panels->where('id', $id)->first();

        return $this->build($data);
    }

    private function build(array $data): Panel
    {
        /* @var $panel Panel */
        $panel = resolve(Panel::class, $data);

        return $panel;
    }
}
