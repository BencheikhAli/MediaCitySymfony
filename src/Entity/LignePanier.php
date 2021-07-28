<?php

namespace App\Entity;

class LignePanier
{
    private $produit;
    private $quantite;

    public function getProduit(): ?Product
    {
        return $this->produit;
    }

    public function setProduit(Product $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}

