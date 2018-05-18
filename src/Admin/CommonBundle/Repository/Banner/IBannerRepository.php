<?php
namespace Admin\CommonBundle\Repository\Banner;

interface IBannerRepository
{

    /**
     * Pega o local para cada Banner cadastrado
     * @return mixed
     */
    public function getLocalBannerUsados();

    /**
     * Pega o local para cada Banner cadastrado, exceto para um id especifico
     * @return mixed
     */
    public function getLocalBannerUsadosNotInId($entity);

    /**
     * Pega o local dos banners que não estiverem sendo usados pelos banners
     * @return mixed
     */
    public function getLocalBannerNaoUsados();

}