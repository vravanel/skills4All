<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\CarCategory;
use App\Form\CarType;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/car')]
class AdminCarController extends AbstractController
{
    #[Route('/', name: 'app_admin_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createFormBuilder(null, [
            'method'=> 'get'
        ])
            ->add('search', SearchType::class)
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();

            $query = $carRepository->findLikeName($search);
        } else {
            $query = $carRepository->queryFindAll();
        }
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('admin/admin_car/index.html.twig', [
            'cars' => $pagination,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_admin_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);
            $this->addFlash('success', 'Vous avez ajouté ' . $car->getName() . '!');

            return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('admin/admin_car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);
            $this->addFlash('success', 'Vous avez édité ' . $car->getName() . '!');
            return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
            $this->addFlash('danger', 'Vous avez supprimé ' . $car->getName() . '!');
        }

        return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
