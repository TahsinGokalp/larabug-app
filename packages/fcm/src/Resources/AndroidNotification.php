<?php

namespace NotificationChannels\Fcm\Resources;

class AndroidNotification implements FcmResource
{
    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var string|null
     */
    protected $icon;

    /**
     * @var string|null
     */
    protected $color;

    /**
     * @var string|null
     */
    protected $sound;

    /**
     * @var string|null
     */
    protected $tag;

    /**
     * @var string|null
     */
    protected $clickAction;

    /**
     * @var string|null
     */
    protected $bodyLocKey;

    /**
     * @var string[]|null
     */
    protected $bodyLocArgs;

    /**
     * @var string|null
     */
    protected $titleLocKey;

    /**
     * @var string[]|null
     */
    protected $titleLocArgs;

    /**
     * @var string|null
     */
    protected $channelId;

    /**
     * @var string|null
     */
    protected $ticker;

    /**
     * @var bool|null
     */
    protected $sticky;

    /**
     * @var string|null
     */
    protected $eventTime;

    /**
     * @var bool|null
     */
    protected $localOnly;

    /**
     * @var NotificationPriority|null
     */
    protected $notificationPriority;

    /**
     * @var bool|null
     */
    protected $defaultSound;

    /**
     * @var bool|null
     */
    protected $defaultVibrateTimings;

    /**
     * @var bool|null
     */
    protected $defaultLightSettings;

    /**
     * @var string[]|null
     */
    protected $vibrateTimings;

    /**
     * @var Visibility|null
     */
    protected $visibility;

    /**
     * @var int|null
     */
    protected $notificationCount;

    /**
     * @var LightSettings|null
     */
    protected $lightSettings;

    /**
     * @var string|null
     */
    protected $image;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSound(): ?string
    {
        return $this->sound;
    }

    public function setSound(?string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getClickAction(): ?string
    {
        return $this->clickAction;
    }

    public function setClickAction(?string $clickAction): self
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    public function getBodyLocKey(): ?string
    {
        return $this->bodyLocKey;
    }

    public function setBodyLocKey(?string $bodyLocKey): self
    {
        $this->bodyLocKey = $bodyLocKey;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getBodyLocArgs(): ?array
    {
        return $this->bodyLocArgs;
    }

    /**
     * @param string[]|null $bodyLocArgs
     */
    public function setBodyLocArgs(?array $bodyLocArgs): self
    {
        $this->bodyLocArgs = $bodyLocArgs;

        return $this;
    }

    public function getTitleLocKey(): ?string
    {
        return $this->titleLocKey;
    }

    public function setTitleLocKey(?string $titleLocKey): self
    {
        $this->titleLocKey = $titleLocKey;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getTitleLocArgs(): ?array
    {
        return $this->titleLocArgs;
    }

    /**
     * @param string[]|null $titleLocArgs
     */
    public function setTitleLocArgs(?array $titleLocArgs): self
    {
        $this->titleLocArgs = $titleLocArgs;

        return $this;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(?string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    public function setTicker(?string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    public function getSticky(): ?bool
    {
        return $this->sticky;
    }

    public function setSticky(?bool $sticky): self
    {
        $this->sticky = $sticky;

        return $this;
    }

    public function getEventTime(): ?string
    {
        return $this->eventTime;
    }

    public function setEventTime(?string $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    public function getLocalOnly(): ?bool
    {
        return $this->localOnly;
    }

    public function setLocalOnly(?bool $localOnly): self
    {
        $this->localOnly = $localOnly;

        return $this;
    }

    public function getNotificationPriority(): ?NotificationPriority
    {
        return $this->notificationPriority;
    }

    public function setNotificationPriority(?NotificationPriority $notificationPriority): self
    {
        $this->notificationPriority = $notificationPriority;

        return $this;
    }

    public function getDefaultSound(): ?bool
    {
        return $this->defaultSound;
    }

    public function setDefaultSound(?bool $defaultSound): self
    {
        $this->defaultSound = $defaultSound;

        return $this;
    }

    public function getDefaultVibrateTimings(): ?bool
    {
        return $this->defaultVibrateTimings;
    }

    public function setDefaultVibrateTimings(?bool $defaultVibrateTimings): self
    {
        $this->defaultVibrateTimings = $defaultVibrateTimings;

        return $this;
    }

    public function getDefaultLightSettings(): ?bool
    {
        return $this->defaultLightSettings;
    }

    public function setDefaultLightSettings(?bool $defaultLightSettings): self
    {
        $this->defaultLightSettings = $defaultLightSettings;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getVibrateTimings(): ?array
    {
        return $this->vibrateTimings;
    }

    /**
     * @param string[]|null $vibrateTimings
     */
    public function setVibrateTimings(?array $vibrateTimings): self
    {
        $this->vibrateTimings = $vibrateTimings;

        return $this;
    }

    public function getVisibility(): ?Visibility
    {
        return $this->visibility;
    }

    public function setVisibility(?Visibility $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getNotificationCount(): ?int
    {
        return $this->notificationCount;
    }

    public function setNotificationCount(?int $notificationCount): self
    {
        $this->notificationCount = $notificationCount;

        return $this;
    }

    public function getLightSettings(): ?LightSettings
    {
        return $this->lightSettings;
    }

    public function setLightSettings(?LightSettings $lightSettings): self
    {
        $this->lightSettings = $lightSettings;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'title'                   => $this->getTitle(),
            'body'                    => $this->getBody(),
            'icon'                    => $this->getIcon(),
            'color'                   => $this->getColor(),
            'sound'                   => $this->getSound(),
            'tag'                     => $this->getTag(),
            'click_action'            => $this->getClickAction(),
            'body_loc_key'            => $this->getBodyLocKey(),
            'body_loc_args'           => $this->getBodyLocArgs(),
            'title_loc_key'           => $this->getTitleLocKey(),
            'title_loc_args'          => $this->getTitleLocArgs(),
            'channel_id'              => $this->getChannelId(),
            'ticker'                  => $this->getTicker(),
            'sticky'                  => $this->getSticky(),
            'event_time'              => $this->getEventTime(),
            'local_only'              => $this->getLocalOnly(),
            'notification_priority'   => !is_null($this->getNotificationPriority()) ? $this->getNotificationPriority()->label ?? $this->getNotificationPriority()->getValue() : null,
            'default_sound'           => $this->getDefaultSound(),
            'default_vibrate_timings' => $this->getDefaultVibrateTimings(),
            'default_light_settings'  => $this->getDefaultLightSettings(),
            'vibrate_timings'         => $this->getVibrateTimings(),
            'visibility'              => !is_null($this->getVisibility()) ? $this->getVisibility()->label ?? $this->getVisibility()->getValue() : null,
            'notification_count'      => $this->getNotificationCount(),
            //'light_setings' => ! is_null($this->getLightSettings()) ? $this->getLightSettings()->toArray() : null,
            'image' => $this->getImage(),
        ];
    }
}
