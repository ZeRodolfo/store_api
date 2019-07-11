<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends DefaultRepository
{
    protected $registry;
    protected $data = [];
    protected $errors;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);

        $this->registry = $registry;
    }

    // /**
    //  * @return Person[] Returns an array of Person objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Person
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(Person $person) {
        $this->clear();

        $em = $this->registry->getManager();

        try {
            $em->persist($person);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();

            return false;
        } finally {
            $em->flush();
        }

        $this->data = $person;

        return true;
    }

    public function toJSON() {
        if ($this->data instanceof Person) {
            return $this->data->toJSON();
        } else {
            $collections = [];

            foreach ($this->data as $data) {
                $collections[] = $data->toJSON();
            }

            return $collections;
        }
    }
}
