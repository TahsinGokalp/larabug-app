<?php

namespace NotificationChannels\Fcm\Resources;

class WebpushConfig implements FcmResource
{
    /**
     * @var array|null
     */
    protected $headers;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var array|null
     */
    protected $notification;

    /**
     * @var WebpushFcmOptions|null
     */
    protected $fcmOptions;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function setHeaders(?array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getNotification(): ?array
    {
        return $this->notification;
    }

    public function setNotification(?array $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getFcmOptions(): ?WebpushFcmOptions
    {
        return $this->fcmOptions;
    }

    public function setFcmOptions(?WebpushFcmOptions $fcmOptions): self
    {
        $this->fcmOptions = $fcmOptions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'headers' => $this->getHeaders(),
            'data' => $this->getData(),
            'notification' => $this->getNotification(),
            'fcm_options' => ! is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];
    }
}
