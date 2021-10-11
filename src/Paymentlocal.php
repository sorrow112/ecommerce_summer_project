<?php


namespace App;


class Paymentlocal
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var integer
     */
    private $numeroDeCarte;

    /**
     * @var string
     */
    private $codeDeVerification;

    private $dateExpiration;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed 
     */
    public function setNumeroDeCarte($numeroDeCarte): void
    {
        $this->numeroDeCarte = $numeroDeCarte;
    }

    public function getNumeroDeCarte()
    {
        return $this->numeroDeCarte;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function CodeDeVerification()
    {
        return $this->codeDeVerification;
    }

    /**
     * @param mixed
     */
    public function setCodeDeVerification($codeDeVerification): void
    {
        $this->codeDeVerification = $codeDeVerification;
    }

    /**
     * @return string
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * @param string
     */
    public function setDateExpiration($dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }
}