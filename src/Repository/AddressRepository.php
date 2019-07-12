<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends DefaultRepository
{
    protected $registry;
    protected $data = [];
    protected $errors;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);

        $this->registry = $registry;
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(Address $address) {
        $this->clear();

        $em = $this->registry->getManager();

        try {
            $em->persist($address);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();

            return false;
        } finally {
            $em->flush();
        }

        $this->data = $address;

        return true;
    }

    public function toJSON() {
        if ($this->data instanceof Address) {
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
