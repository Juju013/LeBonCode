<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/advert")
 */
class AdvertController extends AbstractController
{
    /**
     * @Route("/", name="app_advert_index", methods={ "GET" })
     */
    public function index(Request $request, AdvertRepository $advertRepository): Response
    {
        return $this->render('advert/index.html.twig', [
            'adverts' => $advertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/search", name="app_advert_search", methods={ "GET" })
     */
    public function search(Request $request, AdvertRepository $advertRepository): Response
    {
        $title = $request->get("title", null);
        $priceMin = $request->get("price-min", null);
        $priceMax = $request->get("price-max", null);

        return $this->render('advert/index.html.twig', [
            'adverts' => $advertRepository->findBySearch($title, $priceMin, $priceMax)
        ]);
    }

    /**
     * @Route("/new", name="app_advert_new", methods={ "GET", "POST" })
     */
    public function new(Request $request, AdvertRepository $advertRepository): Response
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $advertRepository->save($advert, true);

            return $this->redirectToRoute('app_advert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('advert/new.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    /**
     * @Entity("Advert", expr="repository.find(id)")
     * @Route("/{id}", name="app_advert_show", methods={ "GET" })
     */
    public function show(Advert $advert): Response
    {
        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
        ]);
    }

    /**
     * @Entity("Advert", expr="repository.find(id)")
     * @Route("/{id}/edit", name="app_advert_edit", methods={ "GET", "PATCH" })
     */
    public function edit(Request $request, Advert $advert, AdvertRepository $advertRepository): Response
    {
        $form = $this->createForm(AdvertType::class, $advert, [ 'is_edit' => true ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $advertRepository->save($advert, true);

            return $this->redirectToRoute('app_advert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    /**
     * @Entity("Advert", expr="repository.find(id)")
     * @Route("/{id}", name="app_advert_delete", methods={ "DELETE" })
     */
    public function delete(Request $request, Advert $advert, AdvertRepository $advertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$advert->getId(), $request->request->get('_token'))) {
            $advert->setIsEnabled(false);
            $advertRepository->save($advert, true);
        }

        return $this->redirectToRoute('app_advert_index', [], Response::HTTP_SEE_OTHER);
    }
}
