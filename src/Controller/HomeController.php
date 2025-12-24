<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController {
    #[Route (path: '/', name: "home")]
    function index (Request $request): Response {
        dd($request);
        return new Response ('Bienvennue ' . $request->query->get('name', 'Invité') . ' sur notre site web !');
    }
}