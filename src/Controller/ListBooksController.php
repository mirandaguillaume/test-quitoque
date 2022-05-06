<?php

namespace App\Controller;

use App\Repository\BibliothequeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListBooksController extends AbstractController
{
    public function __construct(private BibliothequeRepository $bibliothequeRepository)
    {}

    #[Route('/books/index', name: 'app_list_books')]
    public function index(): Response
    {
        return $this->render(
            'books/list.html.twig',
            [
                'books' => $this->bibliothequeRepository->findAll()
            ]
        );
    }

    #[Route('/books/list/{header}/{value}', name: 'app_list_by')]
    public function listBy(string $header, string $value)
    {
        return $this->render(
            'books/list.html.twig',
            [
                'books' => $this->bibliothequeRepository->findAllFrom($header, $value)
            ]
        );
    }

    #[Route('/list/show/{id}', name: 'app_show')]
    public function show(int $id)
    {
        return $this->render(
            'books/show.html.twig',
            [
                'book' => $this->bibliothequeRepository->find($id)
            ]
        );
    }
}
