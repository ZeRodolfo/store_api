<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704145552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, user_created_id INT NOT NULL, user_updated_id INT NOT NULL, name VARCHAR(200) NOT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_1C52F958F987D8A8 (user_created_id), INDEX IDX_1C52F958316B011F (user_updated_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F958F987D8A8 FOREIGN KEY (user_created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F958316B011F FOREIGN KEY (user_updated_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE brand');
    }
}
