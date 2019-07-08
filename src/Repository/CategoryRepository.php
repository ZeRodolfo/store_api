<?php

namespace App\Repository;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Category;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends DefaultRepository
{
		protected $registry;
		protected $data = [];
		protected $errors;

    public function __construct(RegistryInterface $registry)
    {
				parent::__construct($registry, Category::class);
				
    		$this->registry = $registry;
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
		*/

		public function save(Category $category) {
			$this->clear();
	
			$em = $this->registry->getManager();
	
			try {
				$em->persist($category);
			} catch (Exception $ex) {
				$this->errors = $ex->getMessage();
	
				return false;
			} finally {
				$em->flush();
			}
	
			$this->data = $category;
	
			return true;
		}
	
		public function delete(Category $category) {
			$this->clear();
	
			$em = $this->registry->getManager();
	
			try {
				$em->remove($category);
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
			if ($this->data instanceof Category) {
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
