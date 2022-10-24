<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024101925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movil ADD marca_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movil ADD CONSTRAINT FK_64824ACB81EF0041 FOREIGN KEY (marca_id) REFERENCES marca (id)');
        $this->addSql('CREATE INDEX IDX_64824ACB81EF0041 ON movil (marca_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movil DROP FOREIGN KEY FK_64824ACB81EF0041');
        $this->addSql('DROP INDEX IDX_64824ACB81EF0041 ON movil');
        $this->addSql('ALTER TABLE movil DROP marca_id');
    }
}
