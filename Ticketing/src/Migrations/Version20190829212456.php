<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829212456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buyer DROP nom, DROP prenom, DROP pays, DROP date_naissance, DROP type_ticket, DROP token');
        $this->addSql('ALTER TABLE ticket ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD date_naissance DATETIME NOT NULL, ADD tarif SMALLINT NOT NULL, DROP journee, DROP demi_journee, CHANGE buyer_id buyer_id INT DEFAULT NULL, CHANGE reduction reduction TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE buyer ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD pays VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD date_naissance DATETIME NOT NULL, ADD type_ticket INT NOT NULL, ADD token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE ticket ADD journee INT NOT NULL, ADD demi_journee INT NOT NULL, DROP nom, DROP prenom, DROP pays, DROP date_naissance, DROP tarif, CHANGE buyer_id buyer_id INT DEFAULT NULL, CHANGE reduction reduction TINYINT(1) DEFAULT \'NULL\'');
    }
}
