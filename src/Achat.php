<?php

namespace App;

class Achat
{
    private $date;
    private $commandID;
    private $products = [];
    private $montant;

    public function getDate()
    {
        return $this->date;
    }


    public function setCommandID($date): void
    {
        $this->commandID = $commandID;
    }
    public function getCommandID()
    {
        return $this->commandID;
    }


    public function setDate($date): void
    {
        $this->date = $date;
    }
    public function getProducts()
    {
        return $this->products;
    }


    public function addProduct(int $product): self
    {

            $this->products[] = $product;

    }
    public function getMontant()
    {
        return $this->Montant;
    }


    public function setMontant($Montant): void
    {
        $this->Montant = $Montant;
    }
}
