<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPages;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdition;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbExemplaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;


    /**
     * @ORM\Column(type="bigint")
     */
    private $isbn;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="livres",fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Editeur::class, inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $editeur;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, inversedBy="livres")
     */
    private $auteurs;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Emprunte::class, mappedBy="livre")
     */
    private $empruntess;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->empruntes = new ArrayCollection();
        $this->empruntess = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }

    public function setNbPages(int $nbPages): self
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }

    public function setDateEdition(\DateTimeInterface $dateEdition): self
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    public function getNbExemplaire(): ?int
    {
        return $this->nbExemplaire;
    }

    public function setNbExemplaire(int $nbExemplaire): self
    {
        $this->nbExemplaire = $nbExemplaire;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getBigint(): ?string
    {
        return $this->bigint;
    }

    public function setBigint(string $bigint): self
    {
        $this->bigint = $bigint;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs[] = $auteur;
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        $this->auteurs->removeElement($auteur);

        return $this;
    }
    public function __toString() {
        return $this->titre;
    }



    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Emprunte[]
     */
    public function getEmpruntess(): Collection
    {
        return $this->empruntess;
    }

    public function addEmpruntess(Emprunte $empruntess): self
    {
        if (!$this->empruntess->contains($empruntess)) {
            $this->empruntess[] = $empruntess;
            $empruntess->setLivre($this);
        }

        return $this;
    }

    public function removeEmpruntess(Emprunte $empruntess): self
    {
        if ($this->empruntess->removeElement($empruntess)) {
            // set the owning side to null (unless already changed)
            if ($empruntess->getLivre() === $this) {
                $empruntess->setLivre(null);
            }
        }

        return $this;
    }
}
