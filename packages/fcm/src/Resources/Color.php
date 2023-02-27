<?php

namespace NotificationChannels\Fcm\Resources;

class Color implements FcmResource
{
    /**
     * @var float|null
     */
    protected $red;

    /**
     * @var float|null
     */
    protected $green;

    /**
     * @var float|null
     */
    protected $blue;

    /**
     * @var float|null
     */
    protected $alpha;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    public function getRed(): ?float
    {
        return $this->red;
    }

    public function setRed(?float $red): self
    {
        $this->red = $red;

        return $this;
    }

    public function getGreen(): ?float
    {
        return $this->green;
    }

    public function setGreen(?float $green): self
    {
        $this->green = $green;

        return $this;
    }

    public function getBlue(): ?float
    {
        return $this->blue;
    }

    public function setBlue(?float $blue): self
    {
        $this->blue = $blue;

        return $this;
    }

    public function getAlpha(): ?float
    {
        return $this->alpha;
    }

    public function setAlpha(?float $alpha): self
    {
        $this->alpha = $alpha;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'red' => $this->getRed(),
            'green' => $this->getGreen(),
            'blue' => $this->getBlue(),
            'alpha' => $this->getAlpha(),
        ];
    }
}
