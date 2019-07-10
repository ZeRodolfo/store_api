<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190710202927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, user_created_id INT NOT NULL, user_updated_id INT NOT NULL, name VARCHAR(255) NOT NULL, type ENUM(\'physical\', \'legal\') NOT NULL COMMENT \'(DC2Type:enum_person)\', company VARCHAR(255) NOT NULL, cpf VARCHAR(15) DEFAULT NULL, cnpj VARCHAR(15) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, gender ENUM(\'male\', \'female\') DEFAULT NULL COMMENT \'(DC2Type:enum_gender)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_34DCD176F987D8A8 (user_created_id), INDEX IDX_34DCD176316B011F (user_updated_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176F987D8A8 FOREIGN KEY (user_created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176316B011F FOREIGN KEY (user_updated_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE person');
    }
}
