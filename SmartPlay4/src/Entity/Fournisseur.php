<?php

namespace App\Entity;
use App\Entity\Jouet ;
use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $code_four;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_four;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adr_four;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel_four;

    /**
     * @ORM\OneToMany(targetEntity=Jouet::class, mappedBy="fournisseur")
     */
    private $code_jouet;

    /**
     * @ORM\OneToMany(targetEntity="Jouet", mappedBy="code_four_jouet", cascade={"persist"})
     */
    private $jouet;

    public function __construct()
    {
        $this->code_jouet = new ArrayCollection();
    }

/*
    public function getId(): ?int
    {
        return $this->id;
    }
*/

    public function getCodeFour(): ?int
    {
        return $this->code_four;
    }

    public function setCodeFour(int $code_four): self
    {
        $this->code_four = $code_four;

        return $this;
    }

    public function getDesFour(): ?string
    {
        return $this->des_four;
    }

    public function setDesFour(string $des_four): self
    {
        $this->des_four = $des_four;

        return $this;
    }

    public function getAdrFour(): ?string
    {
        return $this->adr_four;
    }

    public function setAdrFour(?string $adr_four): self
    {
        $this->adr_four = $adr_four;

        return $this;
    }

    public function getTelFour(): ?string
    {
        return $this->tel_four;
    }

    public function setTelFour(?string $tel_four): self
    {
        $this->tel_four = $tel_four;

        return $this;
    }

    /**
     * @return Collection|Jouet[]
     */
    public function getCodeJouet(): Collection
    {
        return $this->code_jouet;
    }

    public function addCodeJouet(Jouet $codeJouet): self
    {
        if (!$this->code_jouet->contains($codeJouet)) {
            $this->code_jouet[] = $codeJouet;
            $codeJouet->setFournisseur($this);
        }

        return $this;
    }

    public function removeCodeJouet(Jouet $codeJouet): self
    {
        if ($this->code_jouet->removeElement($codeJouet)) {
            // set the owning side to null (unless already changed)
            if ($codeJouet->getFournisseur() === $this) {
                $codeJouet->setFournisseur(null);
            }
        }

        return $this;
    }
}
