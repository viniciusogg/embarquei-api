<?php

namespace DoctrineProxies\__CG__\App\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class VeiculoTransporte extends \App\Entities\VeiculoTransporte implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'capacidade', 'placa', 'tipo', 'cor', 'imagem', 'instituicoesEnsino'];
        }

        return ['__isInitialized__', 'id', 'capacidade', 'placa', 'tipo', 'cor', 'imagem', 'instituicoesEnsino'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (VeiculoTransporte $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCapacidade()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapacidade', []);

        return parent::getCapacidade();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlaca()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlaca', []);

        return parent::getPlaca();
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', []);

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function getCor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCor', []);

        return parent::getCor();
    }

    /**
     * {@inheritDoc}
     */
    public function getImagem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImagem', []);

        return parent::getImagem();
    }

    /**
     * {@inheritDoc}
     */
    public function getInstituicoesEnsino()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInstituicoesEnsino', []);

        return parent::getInstituicoesEnsino();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setCapacidade($capacidade)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCapacidade', [$capacidade]);

        return parent::setCapacidade($capacidade);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlaca($placa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlaca', [$placa]);

        return parent::setPlaca($placa);
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', [$tipo]);

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function setCor($cor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCor', [$cor]);

        return parent::setCor($cor);
    }

    /**
     * {@inheritDoc}
     */
    public function setImagem($imagem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImagem', [$imagem]);

        return parent::setImagem($imagem);
    }

    /**
     * {@inheritDoc}
     */
    public function setInstituicoesEnsino($instituicoesEnsino)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInstituicoesEnsino', [$instituicoesEnsino]);

        return parent::setInstituicoesEnsino($instituicoesEnsino);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', []);

        return parent::toArray();
    }

}
