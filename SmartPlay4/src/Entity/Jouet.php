<?php

namespace App\Entity;

use App\Repository\JouetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JouetRepository::class)
 */
class Jouet
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
    private $code_jouet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_jouet;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_stock_jouet;

    /**
     * @ORM\Column(type="float")
     */
    private $PU_jouet;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class)
     * @ORM\JoinColumn(name="code_four_jouet",referencedColumnName="code_four")
     * 
     */
    private $code_four_jouet;

/*
    public function getId(): ?int
    {
        return $this->id;
    }
*/

    public function getCodeJouet(): ?int
    {
        return $this->code_jouet;
    }

    public function setCodeJouet(int $code_jouet): self
    {
        $this->code_jouet = $code_jouet;

        return $this;
    }

    public function getDesJouet(): ?string
    {
        return $this->des_jouet;
    }

    public function setDesJouet(string $des_jouet): self
    {
        $this->des_jouet = $des_jouet;

        return $this;
    }

    public function getQteStockJouet(): ?int
    {
        return $this->qte_stock_jouet;
    }

    public function setQteStockJouet(int $qte_stock_jouet): self
    {
        $this->qte_stock_jouet = $qte_stock_jouet;

        return $this;
    }

    public function getPUJouet(): ?float
    {
        return $this->PU_jouet;
    }

    public function setPUJouet(float $PU_jouet): self
    {
        $this->PU_jouet = $PU_jouet;

        return $this;
    }

    public function getCodeFourJouet(): ?Fournisseur
    {
        return $this->code_four_jouet;
    }

    public function setCodeFourJouet(?Fournisseur $code_four_jouet): self
    {
        $this->code_four_jouet = $code_four_jouet;

        return $this;
    }
}
