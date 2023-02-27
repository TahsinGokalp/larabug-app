<?php

namespace NotificationChannels\Fcm\Resources;

class WebpushFcmOptions implements FcmResource
{
    /**
     * @var string|null
     */
    protected $link;

    /**
     * @var string|null
     */
    protected $analyticsLabel;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

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
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'link' => $this->getLink(),
            'analytics_label' => $this->getAnalyticsLabel(),
        ];
    }
}
