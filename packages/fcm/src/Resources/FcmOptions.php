<?php

namespace NotificationChannels\Fcm\Resources;

class FcmOptions implements FcmResource
{
    /**
     * @var string|null
     */
    protected $analyticsLabel;

    public function getAnalyticsLabel(): ?string
    {
        return $this->analyticsLabel;
    }

    public function setAnalyticsLabel(?string $analyticsLabel): self
    {
        $this->analyticsLabel = $analyticsLabel;

        return $this;
    }

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'analytics_label' => $this->getAnalyticsLabel(),
        ];
    }
}
