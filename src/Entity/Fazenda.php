<?php

namespace App\Entity;

use App\Repository\FazendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FazendaRepository::class)]
class Fazenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?float $tamanho = null;

    #[ORM\Column(length: 50)]
    private ?string $responsavel = null;

    #[ORM\ManyToMany(targetEntity: Veterinario::class, inversedBy: 'fazendas')]
    private Collection $veterinarios;

    #[ORM\OneToMany(targetEntity: Gado::class, mappedBy: 'fazenda')]
    private Collection $gados;

    public function __construct()
    {
        $this->veterinarios = new ArrayCollection();
        $this->gados = new ArrayCollection();
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

    public function getTamanho(): ?float
    {
        return $this->tamanho;
    }

    public function setTamanho(float $tamanho): static
    {
        $this->tamanho = $tamanho;

        return $this;
    }

    public function getResponsavel(): ?string
    {
        return $this->responsavel;
    }

    public function setResponsavel(string $responsavel): static
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    /**
     * @return Collection<int, Veterinario>
     */
    public function getVeterinarios(): Collection
    {
        return $this->veterinarios;
    }

    public function addVeterinario(Veterinario $veterinario): static
    {
        if (!$this->veterinarios->contains($veterinario)) {
            $this->veterinarios->add($veterinario);
        }

        return $this;
    }

    public function removeVeterinario(Veterinario $veterinario): static
    {
        $this->veterinarios->removeElement($veterinario);

        return $this;
    }

    /**
     * @return Collection<int, Gado>
     */
    public function getGados(): Collection
    {
        return $this->gados;
    }

    public function addGado(Gado $gado): static
    {
        if (!$this->gados->contains($gado)) {
            $this->gados->add($gado);
            $gado->setFazenda($this);
        }

        return $this;
    }

    public function removeGado(Gado $gado): static
    {
        if ($this->gados->removeElement($gado)) {
            // set the owning side to null (unless already changed)
            if ($gado->getFazenda() === $this) {
                $gado->setFazenda(null);
            }
        }

        return $this;
    }
}
