<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Category;
use App\DataFixtures\UserFixtures;

use \DateTime;

class CategoryFixtures extends Fixture implements DependentFixtureInterface {
  public function load(ObjectManager $manager) {

    $categories = [
      [
        'name' => 'Agronegócios',
        'description' => 'Agronegócio é a junção de inúmeras atividades que envolvem de forma direta ou indireta, toda a cadeia produtiva agrícola ou pecuária.',
        'children' => [
          'Adubo Orgânico' => 'São adubos obtidos por meio de matéria de origem vegetal ou animal, como esterco, farinhas, bagaços, cascas e restos de vegetais, decompostos ou ainda em estágio de decomposição. Esses materiais sofrem decomposição e podem ser produzidos pelo homem por meio da compostagem.',
          'Agricultura' => 'Agricultura é o conjunto de técnicas utilizadas para cultivar plantas com o objetivo de obter alimentos, bebidas, fibras, energia, matéria-prima para roupas, construções, medicamentos, ferramentas, ou apenas para contemplação estética. A quem trabalha na agricultura chama-se agricultor.',
          'Agroindústria' => 'Agronegócio é a junção de inúmeras atividades que envolvem de forma direta ou indireta, toda a cadeia produtiva agrícola ou pecuária.',
          'Agrotóxicos' => 'Agrotóxicos, defensivos agrícolas, pesticidas, praguicidas, biocidas, agroquímicos, produtos fitofarmacêuticos ou produtos fitossanitários são designações genéricas para os vários produtos químicos usados ​​na agricultura.',
          'Equipamentos Agrícolas' => 'São aqueles que desempenham funções agrículas e vários setores. ... Existem diversos tipos de equipamentos agrícolas, alguns são manuais, que são utilizados na agricultura familiar e outros são maquinas gigantes, para agricultura em larga escala.',
          'Equipamentos de Irrigação' => 'Irrigação é uma técnica utilizada na agricultura desenvolvida durante o império persa aquemênida que tem, por objetivo, o fornecimento controlado de água para as plantas em quantidade suficiente e no momento certo, assegurando a produtividade e a sobrevivência da plantação. ',
          'Fazendas' => 'Uma fazenda, herdade, machamba, roça ou quinta é uma propriedade rural agrícola, geralmente composta por um imóvel e um terreno destinado à prática da agricultura e da pecuária. A propriedade, geralmente, inclui diversas estruturas com o objetivo primário de produção e gerenciamento de alimentos, como também de gado.',
          'Fertilizantes' => 'Fertilizantes são qualquer tipo de substância aplicada ao solo ou tecidos vegetais para prover um ou mais nutrientes essenciais ao crescimento das plantas. São aplicados na agricultura com o intuito de melhorar a produção.',
          'Floriculturas' => 'Floricultura designa um ramo da horticultura focado no cultivo de plantas floríferas e ornamentais de forma industrializada, destinadas a jardins e ao comércio.'
        ]
      ]
    ];

    for ($line = 0; $line < count($categories); $line++) {
      $categoryParent = new Category();
      $categoryParent->setName($categories[$line]['name']);
      $categoryParent->setDescription($categories[$line]['description']);
      $categoryParent->setActive(true);
      $categoryParent->setParent(NULL);
      $categoryParent->setUserCreated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $categoryParent->setUserUpdated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $categoryParent->setCreatedAt(new DateTime('now'));
      $categoryParent->setUpdatedAt(new DateTime('now'));

      $manager->persist($categoryParent);

      $childrens = $categories[$line]['children'];
      foreach ($childrens as $name => $description) {
        $category = new Category();
        $category->setName($name);
        $category->setDescription($description);
        $category->setActive(true);
        $category->setParent($categoryParent);
        $category->setUserCreated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $category->setUserUpdated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $category->setCreatedAt(new DateTime('now'));
        $category->setUpdatedAt(new DateTime('now'));

        $manager->persist($category);
      }
    }

    $manager->flush();
  }

  public function getDependencies() {
    return array(
      UserFixtures::class,
    );
  }
}