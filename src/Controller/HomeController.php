<?php

namespace App\Controller;

use App\Services\Weather;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Weather $weather) : Response
    {
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));

        return $this->render('home/index.html.twig', [
            'weather' => $weather->setWeather(),
            'date' => $date,
            ]);
    }
}