<?php

namespace NotificationChannels\Fcm;

use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\FcmOptions;
use NotificationChannels\Fcm\Resources\Notification;
use NotificationChannels\Fcm\Resources\WebpushConfig;

class FcmMessage implements Message
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var Notification|null
     */
    protected $notification;

    /**
     * @var AndroidConfig|null
     */
    protected $android;

    /**
     * @var WebpushConfig|null
     */
    protected $webpush;

    /**
     * @var ApnsConfig|null
     */
    protected $apns;

    /**
     * @var FcmOptions|null
     */
    protected $fcmOptions;

    /**
     * @var string|null
     */
    protected $token;

    /**
     * @var string|null
     */
    protected $topic;

    /**
     * @var string|null
     */
    protected $condition;

    public static function create(): self
    {
        return new self();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getAndroid(): ?AndroidConfig
    {
        return $this->android;
    }

    public function setAndroid(?AndroidConfig $android): self
    {
        $this->android = $android;

        return $this;
    }

    public function getWebpush(): ?WebpushConfig
    {
        return $this->webpush;
    }

    public function setWebpush(?WebpushConfig $webpush): self
    {
        $this->webpush = $webpush;

        return $this;
    }

    public function getApns(): ?ApnsConfig
    {
        return $this->apns;
    }

    public function setApns(?ApnsConfig $apns): self
    {
        $this->apns = $apns;

        return $this;
    }

    public function getFcmOptions(): ?FcmOptions
    {
        return $this->fcmOptions;
    }

    public function setFcmOptions(?FcmOptions $fcmOptions): self
    {
        $this->fcmOptions = $fcmOptions;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function toArray()
    {
        $data = [
            'name'         => $this->getName(),
            'data'         => $this->getData(),
            'notification' => !is_null($this->getNotification()) ? $this->getNotification()->toArray() : null,
            'android'      => !is_null($this->getAndroid()) ? $this->getAndroid()->toArray() : null,
            'webpush'      => !is_null($this->getWebpush()) ? $this->getWebpush()->toArray() : null,
            'apns'         => !is_null($this->getApns()) ? $this->getApns()->toArray() : null,
            'fcm_options'  => !is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];

        if ($token = $this->getToken()) {
            $data['token'] = $token;
        }

        if ($topic = $this->getTopic()) {
            $data['topic'] = $topic;
        }

        if ($condition = $this->getCondition()) {
            $data['condition'] = $condition;
        }

        return $data;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
