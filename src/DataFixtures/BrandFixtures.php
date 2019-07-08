<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Brand;
use App\DataFixtures\UserFixtures;

class BrandFixtures extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
    $brands = [
      'Xiaomi' => 'Xiaomi é uma empresa chinesa de produtos eletrônicos com sede em Pequim, na China. Terceira maior distribuidora de smartphones do mundo, a Xiaomi projeta, desenvolve e vende celulares, aplicativos móveis e eletrônicos de consumo.',
      'Huawei' => 'A Huawei é uma empresa multinacional de equipamentos para redes e telecomunicações sediada na cidade de Shenzhen, província de Guangdong, na China. É a maior fornecedora de equipamentos para redes e telecomunicações do mundo, tendo ultrapassado a sueca Ericsson em 2012.',
      'Microsoft' => 'Microsoft Corporation é uma empresa transnacional americana com sede em Redmond, Washington, que desenvolve, fabrica, licencia, apoia e vende softwares de computador, produtos eletrônicos, computadores e serviços pessoais.',
      'IBM' => 'A International Business Machines Corporation é uma empresa dos Estados Unidos voltada para a área de informática. A empresa é uma das poucas na área de tecnologia da informação com uma história contínua que remonta ao século XIX.',
      'Toshiba' => 'Toshiba Corporation, comumente conhecida como Toshiba e estilizada como TOSHIBA, é um conglomerado multinacional japonês sediado em Tóquio, Japão.',
      'Lenovo' => 'Lenovo Group Ltd. ou Lenovo PC International, frequentemente encurtada para Lenovo, é uma multinacional chinesa de tecnologia, situada em Pequim, China, e Morrisville, EUA.',
      'Dell' => 'Dell, Inc., ou simplesmente Dell, é uma empresa de hardware de computador dos Estados Unidos, empregando mais de 106.700 pessoas no mundo inteiro.',
      'Acer' => 'Acer Incorporated, ou simplesmente Acer, é uma empresa sediada em Nova Taipé, Taiwan. Inaugurada no ano de 2000, é a primeira empresa taiwanesa a se tornar uma multinacional e a terceira maior fabricante de PCs do planeta.',
      'HP' => 'A Hewlett-Packard Company é uma companhia de tecnologia da informação multinacional americana, até sua divisão, ocorrida em 2015. Tem sua sede em Palo Alto, na Califórnia, Estados Unidos.',
      'Apple' => 'Apple Inc. é uma empresa multinacional norte-americana que tem o objetivo de projetar e comercializar produtos eletrônicos de consumo, software de computador e computadores pessoais.'
    ];

    // create 10 brands! Bam!
    foreach($brands as $name => $description) {
      $brand = new Brand();
      $brand->setName($name);
      $brand->setDescription($description);
      $brand->setActive(true);
      $brand->setUserCreated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $brand->setUserUpdated($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
      $brand->setCreatedAt(new \DateTime('now'));
      $brand->setUpdatedAt(new \DateTime('now'));

      $manager->persist($brand);
    }

		$manager->flush();
  }
  
  public function getDependencies() {
    return array(
      UserFixtures::class,
    );
  }
}
