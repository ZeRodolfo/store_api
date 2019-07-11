<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends DefaultRepository
{
    protected $registry;
		protected $data = [];
        protected $errors;
        
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);

        $this->registry = $registry;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(Product $product) {
        $this->clear();

        $em = $this->registry->getManager();

        try {
            $em->persist($product);
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();

            return false;
        } finally {
            $em->flush();
        }

        $this->data = $product;

        return true;
    }

    public function toJSON() {
        if ($this->data instanceof Product) {
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
