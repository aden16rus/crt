<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\MovieService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @var RouteCollectorInterface
     */
    private $routeCollector;

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MovieService
     */
    private $movieService;

    /**
     * HomeController constructor.
     *
     * @param RouteCollectorInterface $routeCollector
     * @param Environment $twig
     * @param MovieService $movieService
     */
    public function __construct(RouteCollectorInterface $routeCollector, Environment $twig, MovieService $movieService)
    {
        $this->routeCollector = $routeCollector;
        $this->twig = $twig;
        $this->movieService = $movieService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     *
     * @throws HttpBadRequestException
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $movies = $this->movieService->getAllMovies();
        try {
            $data = $this->twig->render('index.html.twig', [
                'trailers' => $movies,
            ]);
        } catch (Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     *
     * @throws HttpBadRequestException
     * @throws HttpNotFoundException
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $movie_id = $request->getAttribute('id');

        $m = $this->movieService->getMovie((int) $movie_id);

        if (!$m) {
            throw new HttpNotFoundException($request, 'Trailer Not Found');
        }

        try {
            $data = $this->twig->render('movie/index.html.twig', [
                'movie' => $m,
            ]);
        } catch (Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);

        return $response;
    }
}
