<?php

namespace App\Controller;

use App\Entity\CarCategory;
use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/car', name: 'car_')]
class CarController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CarRepository $carRepository, CarCategoryRepository $carCategoryRepository ,PaginatorInterface $paginator, Request $request) : Response
    {
        $pagination = $paginator->paginate(
            $carRepository->queryFindAll(),
            $request->query->getInt('page', 1),
            20
        );

        $carCategories = $carCategoryRepository->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $pagination,
            'carCategories' => $carCategories,
        ]);
    }
    #[Route('/search', name: 'search', methods : ['GET'])]
    public function show(CarRepository $carRepository, PaginatorInterface $paginator, Request $request) : Response
    {
        $form = $this->createFormBuilder(null, [
            'method' => 'get',
            'csrf_protection' => false
        ])
            ->add('search', SearchType::class, [
                'attr' => [
                    'class' => 'form-control rounded',
                    'placeholder' => 'Recherche une voiture',
                ],
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Categories',
                'required' => false,
                'expanded' => true,
                'class' => CarCategory::class,
                'choice_label' => "name"
            ])

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $carCategory = $form->get('categories')->getData();
            $query = $carRepository->findLikeName($search, $carCategory);
        } else {
            $query = $carRepository->queryFindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('car/search_results.html.twig', [
            'cars' => $pagination,
            'form' => $form,
        ]);
    }
}