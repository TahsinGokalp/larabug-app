<?php

namespace NotificationChannels\Fcm\Resources;

class Notification implements FcmResource
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
    protected $image;

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
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'image' => $this->getImage(),
        ];
    }
}
