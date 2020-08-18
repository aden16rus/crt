<?php


namespace App\Services;


use App\Entity\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * MovieService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->doctrine = $em;
    }

    /**
     * Retrieve movies from bd
     *
     * @return ArrayCollection
     */
    public function getAllMovies(): ArrayCollection
    {
        $data = $this->doctrine->getRepository(Movie::class)
        ->findAll();

        return new ArrayCollection($data);
    }

    /**
     * Get movie by id
     * @param int $id
     * @return object
     */
    public function getMovie(int $id): ?object
    {
        return $this->doctrine->getRepository(Movie::class)
            ->find($id);
    }
}