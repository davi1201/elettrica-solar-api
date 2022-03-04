<?php

namespace App\Domain\Solar;

class Panel
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var float
     */
    private $power;
    /**
     * @var string
     */
    private $type;
    /**
     * @var float
     */
    private $utilArea;
    /**
     * @var float
     */
    private $panelEfficiency;
    /**
     * @var float
     */
    private $systemEfficiency;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $category;

    /**
     * Panel constructor.
     * @param string $id
     * @param string $name
     * @param float $power
     * @param string $type
     * @param float $utilArea
     * @param float $panelEfficiency
     * @param float $systemEfficiency
     */
    public function __construct(string $id, string $name, float $power, string $type, string $category, float $utilArea, float $panelEfficiency, float $systemEfficiency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->power = $power;
        $this->type = $type;
        $this->utilArea = $utilArea;
        $this->panelEfficiency = $panelEfficiency;
        $this->systemEfficiency = $systemEfficiency;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Panel
     */
    public function setType(string $type): Panel
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getCategoryDescription()
    {
        switch ($this->category) {
            case 'tile':
                return 'Telhas';
            default:
                return 'Paineis';
        }
    }

    /**
     * @return float
     */
    public function getUtilArea(): float
    {
        return $this->utilArea;
    }

    /**
     * @return float
     */
    public function getPanelEfficiency(): float
    {
        return $this->panelEfficiency;
    }

    public function getPowerDescription()
    {
        return resolve('number-format')->format($this->power * 1000);
    }

    /**
     * @return float
     */
    public function getSystemEfficiency(): float
    {
        return $this->systemEfficiency;
    }

    public function count(float $irradiation, float $averageConsume, $project)
    {

        $panels = $averageConsume / ($irradiation * $this->getPower() * (365 / 12) * $this->getSystemEfficiency());

        if ($this->getId() === 'solar-tile') {
            $panels *= 1.87;
        }

        return ceil($panels);
    }

    public function countByGeneratorPower(float $power)
    {
        return ceil($power / $this->getPower());
    }

    public function getMinimumGeneratorPower(int $panelsCount)
    {
        return $panelsCount * $this->getPower();
    }

    public function getAnnualGeneration(int $panelsCount, float $irradiation)
    {
        return intval(
            $panelsCount * ($irradiation * $this->getPower() * (365 / 12) * $this->getSystemEfficiency())
        );
    }

    public function estimatedCount(float $irradiation, float $averageConsume, string $inverterBrand, string $panelType)
    {

        $panels = $averageConsume / ($irradiation * $this->getPower() * (365 / 12) * $this->getSystemEfficiency());

        if ($this->getId() === 'solar-tile') {
            $panels *= 1.87;
        }

        return ceil($panels);
    }
}
