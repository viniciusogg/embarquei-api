<?php

namespace App\Entities;

use App\Entities\Usuario;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/** @ORM\Entity */
class Estudante extends Usuario 
{
    use CriaArrayObjetoTrait;
    
    /** @ORM\Column(type="string", nullable=false, unique=true) */
    protected $foto; // Caminho no sistema de arquivos

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToMany(targetEntity="HorarioSemanalEstudante", mappedBy="estudante", cascade={"all"}, fetch="EAGER") 
     */
    protected $horariosSemanaisEstudante;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Curso", fetch="EAGER") 
     */
    protected $curso;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToOne(targetEntity="Endereco",  cascade={"all"}, fetch="EAGER") 
     */
    protected $endereco;

    /** 
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="ComprovanteMatricula",  cascade={"all"}, fetch="EAGER") 
     */
    protected $comprovanteMatricula;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToMany(targetEntity="PontoParada", inversedBy="estudantes", fetch="EAGER") 
     */
    protected $pontosParada;

    public function __construct()
    {
        $this->horariosSemanaisEstudante = new ArrayCollection();
        $this->pontosParada = new ArrayCollection();
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getHorariosSemanaisEstudante()
    {
        return $this->horariosSemanaisEstudante;
    }

    public function getCurso()
    {
        return $this->curso;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getComprovanteMatricula()
    {
        return $this->comprovanteMatricula;
    }

    public function getPontosParada()
    {
        return $this->pontosParada;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function setHorariosSemanaisEstudante($horariosSemanaisEstudante)
    {
        $this->horariosSemanaisEstudante = $horariosSemanaisEstudante;
    }

    public function setCurso($curso)
    {
        $this->curso = $curso;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function setComprovanteMatricula($comprovanteMatricula)
    {
        $this->comprovanteMatricula = $comprovanteMatricula;
    }

    public function setPontosParada($pontosParada)
    {
        $this->pontosParada = $pontosParada;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'numeroCelular' => $this->numeroCelular,
            'foto' => $this->foto,
            'ativo' => $this->ativo,
            'horariosSemanaisEstudante' => $this->retornarArrayObjetos($this->horariosSemanaisEstudante),
            'curso' => $this->curso->toArray(),
            'endereco' => $this->endereco->toArray(),
            'comprovanteMatricula' => $this->comprovanteMatricula->toArray(),
            'pontosParada' => $this->retornarArrayObjetos($this->pontosParada)
         );
    }

}
