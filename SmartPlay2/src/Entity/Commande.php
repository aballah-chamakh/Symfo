<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    //private $id;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $num_cde;

    /**
     * @ORM\Column(type="date")
     */
    private $date_cde;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_cde;

    /**
     * @ORM\Column(type="integer")
     */
    private $remise_cde;

    /**
     * @ORM\Column(type="integer")
     */
    private $mnt_cde;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(referencedColumnName="code_clt")
     */
    private $code_clt_cde;
/*
    public function getId(): ?int
    {
        return $this->id;
    }
*/
    public function getNumCde(): ?int
    {
        return $this->num_cde;
    }

    public function setNumCde(int $num_cde): self
    {
        $this->num_cde = $num_cde;

        return $this;
    }

    public function getDateCde(): ?\DateTimeInterface
    {
        return $this->date_cde;
    }

    public function setDateCde(\DateTimeInterface $date_cde): self
    {
        $this->date_cde = $date_cde;

        return $this;
    }

    public function getHeureCde(): ?\DateTimeInterface
    {
        return $this->heure_cde;
    }

    public function setHeureCde(\DateTimeInterface $heure_cde): self
    {
        $this->heure_cde = $heure_cde;

        return $this;
    }

    public function getRemiseCde(): ?int
    {
        return $this->remise_cde;
    }

    public function setRemiseCde(int $remise_cde): self
    {
        $this->remise_cde = $remise_cde;

        return $this;
    }

    public function getMntCde(): ?int
    {
        return $this->mnt_cde;
    }

    public function setMntCde(int $mnt_cde): self
    {
        $this->mnt_cde = $mnt_cde;

        return $this;
    }

    public function getCodeCltCde(): ?Client
    {
        return $this->code_clt_cde;
    }

    public function setCodeCltCde(?Client $code_clt_cde): self
    {
        $this->code_clt_cde = $code_clt_cde;

        return $this;
    }
}
