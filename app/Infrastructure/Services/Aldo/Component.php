<?php


namespace App\Infrastructure\Services\Aldo;


class Component
{
    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var float
     */
    protected $kva;
    /**
     * @var float
     */
    protected $kw;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Component
     */
    public function setQuantity(int $quantity): Component
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Component
     */
    public function setDescription(string $description): Component
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getKva(): float
    {
        if (!empty($this->kva)) {
            return $this->kva;
        }

        if (empty($this->kw)) {
            return 0;
        }

        return $this->kw / 0.737;
    }

    /**
     * @param float $kva
     * @return Component
     */
    public function setKva(float $kva): Component
    {
        $this->kva = $kva;
        return $this;
    }

    /**
     * @return float
     */
    public function getKw(): float
    {
        return $this->kw;
    }

    /**
     * @param float $kw
     * @return Component
     */
    public function setKw(float $kw): Component
    {
        $this->kw = $kw;
        return $this;
    }

    public function is(string $description): bool
    {
        $pattern = sprintf('/\b%s\b/i', $description);

        return preg_match($pattern, $this->description);
    }
}
