<?php

namespace App\Message;

class EmailMessage
{
    private string $email;
    private array $context;

    const MAIL_PASSWORD_RESET = "password_reset";
    private string $type;

    public function __construct(string $email, string $type, array $context = [])
    {
        $this->email = $email;
        $this->type = $type;
        $this->context = $context;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
