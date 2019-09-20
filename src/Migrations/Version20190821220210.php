<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190821220210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buyer ADD token VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD date_naissance DATETIME NOT NULL, ADD tarif SMALLINT NOT NULL, CHANGE buyer_id buyer_id INT DEFAULT NULL, CHANGE reduction reduction TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buyer DROP token');
        $this->addSql('ALTER TABLE ticket DROP nom, DROP prenom, DROP pays, DROP date_naissance, DROP tarif, CHANGE buyer_id buyer_id INT DEFAULT NULL, CHANGE reduction reduction TINYINT(1) DEFAULT \'NULL\'');
    }
}
