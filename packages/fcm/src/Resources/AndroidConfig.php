<?php

namespace NotificationChannels\Fcm\Resources;

class AndroidConfig implements FcmResource
{
    /**
     * @var string|null
     */
    protected $collapseKey;

    /**
     * @var AndroidMessagePriority|null
     */
    protected $priority;

    /**
     * @var string|null
     */
    protected $ttl;

    /**
     * @var string|null
     */
    protected $restrictedPackageName;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var AndroidNotification|null
     */
    protected $notification;

    /**
     * @var AndroidFcmOptions|null
     */
    protected $fcmOptions;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self();
    }

    public function getCollapseKey(): ?string
    {
        return $this->collapseKey;
    }

    public function setCollapseKey(?string $collapseKey): self
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    public function getPriority(): ?AndroidMessagePriority
    {
        return $this->priority;
    }

    public function setPriority(?AndroidMessagePriority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTtl(): ?string
    {
        return $this->ttl;
    }

    public function setTtl(?string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getRestrictedPackageName(): ?string
    {
        return $this->restrictedPackageName;
    }

    public function setRestrictedPackageName(?string $restrictedPackageName): self
    {
        $this->restrictedPackageName = $restrictedPackageName;

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

    public function getNotification(): ?AndroidNotification
    {
        return $this->notification;
    }

    public function setNotification(?AndroidNotification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getFcmOptions(): ?AndroidFcmOptions
    {
        return $this->fcmOptions;
    }

    public function setFcmOptions(?AndroidFcmOptions $fcmOptions): self
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
            'collapse_key'            => $this->getCollapseKey(),
            'priority'                => !is_null($this->getPriority()) ? $this->getPriority()->label ?? $this->getPriority()->getValue() : null,
            'ttl'                     => $this->getTtl(),
            'restricted_package_name' => $this->getRestrictedPackageName(),
            'data'                    => $this->getData(),
            'notification'            => !is_null($this->getNotification()) ? $this->getNotification()->toArray() : null,
            'fcm_options'             => !is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];
    }
}
