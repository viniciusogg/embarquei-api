<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Traits\CriaArrayObjetoTrait;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="pontos_parada")
 */
class PontoParada 
{
    use CriaArrayObjetoTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected $nome;

    /** @ORM\Column(type="integer", nullable=false) */    
    protected $ordem;
    
    /** 
     * @ORM\JoinColumn(nullable=true)
     * @ORM\ManyToMany(targetEntity="Estudante", mappedBy="pontosParada", fetch="EAGER")
     */
    protected $estudantes;

    /** 
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity="Trajeto", inversedBy="pontosParada", fetch="EAGER")
     */
    protected $trajeto;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\OneToOne(targetEntity="Geolocalizacao", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    protected $geolocalizacao;

    public function __construct()
    {
        $this->estudantes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTrajeto()
    {
        return $this->trajeto;
    }

    public function getEstudantes()
    {
        return $this->estudantes;
    }

    public function getOrdem() 
    {
        return $this->ordem;
    }

    public function getGeolocalizacao()
    {
        return $this->geolocalizacao;
    }

    public function setGeolocalizacao($geolocalizacao)
    {
        $this->geolocalizacao = $geolocalizacao;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEstudantes($estudantes)
    {
        $this->estudantes = $estudantes;
    }

    public function setTrajeto($trajeto)
    {
        $this->trajeto = $trajeto;
    }
    
    public function setOrdem($ordem) 
    {
        $this->ordem = $ordem;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'ordem' => $this->ordem,
            'estudantes' => $this->retornarArrayEstudantes($this->estudantes),
            'trajeto' => [
                'id' => $this->trajeto->getId(), 
                'tipo' => $this->trajeto->getTipo()
            ],
            'geolocalizacao' => $this->geolocalizacao->toArray()
         );
    }

    protected function retornarArrayEstudantes($objetos)
    {
        $array = [];

        if ($objetos)
        {
            foreach ($objetos as $objeto)
            {
                $array[] = [
                    'id' => $objeto->getId(),
                    'nome' => $objeto->getNome(),
                    'sobrenome' => $objeto->getSobrenome(),
                    'numeroCelular' => $objeto->getNumeroCelular(),
                    'foto' => $objeto->getFoto()->toArray(),
                    'ativo' => $objeto->getAtivo(),
                    'beta' => $objeto->getBeta(),
                    'horariosSemanaisEstudante' => $this->retornarArrayObjetos($objeto->getHorariosSemanaisEstudante()),
                    'curso' => $objeto->getCurso()->toArray(),
                    'endereco' => $objeto->getEndereco()->toArray(),
                    'comprovanteMatricula' => $objeto->getComprovanteMatricula()->toArray()
                ];
            }
            return $array;
        }
        return null;
    }
}
