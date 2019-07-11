<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190711025725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_created_id INT NOT NULL, user_updated_id INT NOT NULL, supplier_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, number INT NOT NULL, postal_code VARCHAR(10) NOT NULL, complement VARCHAR(255) DEFAULT NULL, note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D4E6F81F987D8A8 (user_created_id), INDEX IDX_D4E6F81316B011F (user_updated_id), INDEX IDX_D4E6F812ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81F987D8A8 FOREIGN KEY (user_created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81316B011F FOREIGN KEY (user_updated_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F812ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE address');
    }
}
