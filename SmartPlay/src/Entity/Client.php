<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $code_clt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_clt;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel_clt;
    /*
    public function getId(): ?int
    {
        return $this->id;
    }*/

    public function getCodeClt(): ?int
    {
        return $this->code_clt;
    }

    public function setCodeClt(int $code_clt): self
    {
        $this->code_clt = $code_clt;

        return $this;
    }

    public function getDesClt(): ?string
    {
        return $this->des_clt;
    }

    public function setDesClt(string $des_clt): self
    {
        $this->des_clt = $des_clt;

        return $this;
    }

    public function getTelFour(): ?string
    {
        return $this->tel_four;
    }

    public function setTelFour(string $tel_four): self
    {
        $this->tel_four = $tel_four;

        return $this;
    }

    public function getTelClt(): ?string
    {
        return $this->tel_clt;
    }

    public function setTelClt(string $tel_clt): self
    {
        $this->tel_clt = $tel_clt;

        return $this;
    }
}