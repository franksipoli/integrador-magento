<?php

/**
 * PoliticaDescontoController
 *
 * @author Frank Sipoli
 * @copyright 2016 Editora Positivo
 */
Class PoliticaDescontoController extends BaseController
{

    public function index()
    {
        $this->data['title'] = 'Welcome to Slim Starter Application';
        App::render('welcome.twig', $this->data);
    }
}
