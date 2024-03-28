<?php

namespace App\Entity;

use App\Repository\VeterinarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeterinarioRepository::class)]
class Veterinario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nome = null;

    #[ORM\Column(length: 20)]
    private ?string $crmv = null;

    #[ORM\ManyToMany(targetEntity: Fazenda::class, mappedBy: 'veterinarios')]
    private Collection $fazendas;

    public function __construct()
    {
        $this->fazendas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCrmv(): ?string
    {
        return $this->crmv;
    }

    public function setCrmv(string $crmv): static
    {
        $this->crmv = $crmv;

        return $this;
    }

    /**
     * @return Collection<int, Fazenda>
     */
    public function getFazendas(): Collection
    {
        return $this->fazendas;
    }

    public function addFazenda(Fazenda $fazenda): static
    {
        if (!$this->fazendas->contains($fazenda)) {
            $this->fazendas->add($fazenda);
            $fazenda->addVeterinario($this);
        }

        return $this;
    }

    public function removeFazenda(Fazenda $fazenda): static
    {
        if ($this->fazendas->removeElement($fazenda)) {
            $fazenda->removeVeterinario($this);
        }

        return $this;
    }
}
