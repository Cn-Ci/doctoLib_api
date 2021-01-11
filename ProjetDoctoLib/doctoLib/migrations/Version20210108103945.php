<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108103945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE praticien ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE praticien ADD CONSTRAINT FK_D9A27D34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_D9A27D34DE7DC5C ON praticien (adresse_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE praticien DROP FOREIGN KEY FK_D9A27D34DE7DC5C');
        $this->addSql('DROP INDEX IDX_D9A27D34DE7DC5C ON praticien');
        $this->addSql('ALTER TABLE praticien DROP adresse_id');
    }
}
