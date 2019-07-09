<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190709173934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD user_created_id INT NOT NULL, ADD user_updated_id INT NOT NULL, ADD active TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF987D8A8 FOREIGN KEY (user_created_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD316B011F FOREIGN KEY (user_updated_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF987D8A8 ON product (user_created_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD316B011F ON product (user_updated_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF987D8A8');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD316B011F');
        $this->addSql('DROP INDEX IDX_D34A04ADF987D8A8 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD316B011F ON product');
        $this->addSql('ALTER TABLE product DROP user_created_id, DROP user_updated_id, DROP active, DROP created_at, DROP updated_at');
    }
}
