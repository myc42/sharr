<?php

namespace App\Entity;

use App\Repository\CodeSpaceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodeSpaceRepository::class)]
class CodeSpace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $txt_input = null;

    #[ORM\Column]
    private ?bool $is_register = null;

    #[ORM\Column]
    private ?bool $is_update = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_expire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_create = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getTxtInput(): ?string
    {
        return $this->txt_input;
    }

    public function setTxtInput(?string $txt_input): static
    {
        $this->txt_input = $txt_input;

        return $this;
    }

    public function isRegister(): ?bool
    {
        return $this->is_register;
    }

    public function setIsRegister(bool $is_register): static
    {
        $this->is_register = $is_register;

        return $this;
    }

    public function isUpdate(): ?bool
    {
        return $this->is_update;
    }

    public function setIsUpdate(bool $is_update): static
    {
        $this->is_update = $is_update;

        return $this;
    }

    public function getDateExpire(): ?\DateTime
    {
        return $this->date_expire;
    }

    public function setDateExpire(\DateTime $date_expire): static
    {
        $this->date_expire = $date_expire;

        return $this;
    }

    public function getDateCreate(): ?\DateTime
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTime $date_create): static
    {
        $this->date_create = $date_create;

        return $this;
    }
}
