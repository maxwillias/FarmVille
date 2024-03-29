<?php

namespace App\Entity;

use App\Repository\GadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GadoRepository::class)]
class Gado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $codigo = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'Insira valor positivo para peso.'
    )]
    private ?float $leite = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'Insira valor positivo para peso.'
    )]
    private ?float $racao = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'Insira valor positivo para peso.'
    )]
    private ?float $peso = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\LessThanOrEqual(
        'today', 
        message:'Essa data deve ser menor ou igual a data atual.'
    )]
    private ?\DateTimeInterface $nascimento = null;

    #[ORM\ManyToOne(inversedBy: 'gados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fazenda $fazenda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getLeite(): ?float
    {
        return $this->leite;
    }

    public function setLeite(float $leite): static
    {
        $this->leite = $leite;

        return $this;
    }

    public function getRacao(): ?float
    {
        return $this->racao;
    }

    public function setRacao(float $racao): static
    {
        $this->racao = $racao;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getNascimento(): ?\DateTimeInterface
    {
        return $this->nascimento;
    }

    public function setNascimento(\DateTimeInterface $nascimento): static
    {
        $this->nascimento = $nascimento;

        return $this;
    }

    public function getFazenda(): ?Fazenda
    {
        return $this->fazenda;
    }

    public function setFazenda(?Fazenda $fazenda): static
    {
        $this->fazenda = $fazenda;

        return $this;
    }
}
