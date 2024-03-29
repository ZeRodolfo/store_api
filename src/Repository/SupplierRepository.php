<?php

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends DefaultRepository
{
    protected $registry;
    protected $data = [];
    protected $errors;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Supplier::class);

        $this->registry = $registry;
    }

    // /**
    //  * @return Supplier[] Returns an array of Supplier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Supplier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(Supplier $supplier) {
        $this->clear();

        $em = $this->registry->getManager();

        try {
            $em->persist($supplier);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();

            return false;
        } finally {
            $em->flush();
        }

        $this->data = $supplier;

        return true;
    }

    public function delete(Supplier $supplier) {
        $this->clear();

        $em = $this->registry->getManager();

        try {
            $em->remove($supplier);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();

            return false;
        } finally {
            $em->flush();
        }

        $this->data = [];

        return true;
    }

    public function toJSON() {
        if ($this->data instanceof Supplier) {
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
