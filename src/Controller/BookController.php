<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookController extends AbstractController
{
    private $entityManager;
    private $validator;
    private $paginator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->paginator = $paginator;
    }

    #[Route(path: '/books', name: 'main_book_list', methods: ['GET'])]
    public function index(): Response
    {
        $isAuthenticated = $this->isGranted('ROLE_USER');

        return $this->render('book/index.html.twig', [
            'isAuthenticated' => $isAuthenticated,
        ]);
    }

    #[Route(path: '/api/books', name: 'api_books', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $searchTerm = $request->query->get('search', ''); // Adjust to match Vue component
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 5); // Ensure default limit matches Vue component

        $queryBuilder = $this->entityManager->getRepository(Book::class)->createQueryBuilder('b')
            ->where('b.title LIKE :searchTerm OR b.author LIKE :searchTerm OR b.isbn LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('b.title', 'ASC');

        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );

        $totalPages = ceil($pagination->getTotalItemCount() / $limit);

        $books = [];
        foreach ($pagination->getItems() as $book) {
            $books[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn(),
                'publicationDate' => $book->getPublicationDate()->format('Y-m-d'),
                'genre' => $book->getGenre(),
                'numberOfCopies' => $book->getNumberOfCopies(),
            ];
        }

        return new JsonResponse([
            'books' => $books,
            'total' => $pagination->getTotalItemCount(),
            'totalPages' => $totalPages,
            'page' => $page,
            'limit' => $limit
        ]);
    }

    #[Route(path: '/api/books/{id}', name: 'api_book_show', methods: ['GET'])]
    public function show(Book $book): JsonResponse
    {
        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'publicationDate' => $book->getPublicationDate()->format('Y-m-d'),
            'genre' => $book->getGenre(),
            'numberOfCopies' => $book->getNumberOfCopies(),
        ];

        return new JsonResponse($data);
    }

    #[Route(path: '/api/books', name: 'api_book_new', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->isValidData($data)) {
            return new JsonResponse(['error' => 'Invalid data provided'], 400);
        }

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setIsbn($data['isbn']);
        $book->setPublicationDate(new \DateTime($data['publicationDate']));
        $book->setGenre($data['genre']);
        $book->setNumberOfCopies((int)$data['numberOfCopies']);

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Book registered successfully!'], 201);
    }

    #[Route(path: '/api/books/{id}', name: 'api_book_edit', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->isValidData($data)) {
            return new JsonResponse(['error' => 'Invalid data provided'], 400);
        }

        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return new JsonResponse(['error' => 'Book not found.'], Response::HTTP_NOT_FOUND);
        }

        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setIsbn($data['isbn']);
        $book->setPublicationDate(new \DateTime($data['publicationDate']));
        $book->setGenre($data['genre']);
        $book->setNumberOfCopies((int)$data['numberOfCopies']);

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], 400);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Book updated successfully!']);
    }

    #[Route(path: '/api/books/{id}', name: 'api_book_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return new JsonResponse(['error' => 'Book not found.'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Book deleted successfully!']);
    }

    private function isValidData(array $data): bool
    {
        $requiredFields = ['title', 'author', 'isbn', 'publicationDate', 'genre', 'numberOfCopies'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }

        return true;
    }
}
