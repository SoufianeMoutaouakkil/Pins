<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522224118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pin ADD COLUMN image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pin ADD COLUMN image_size INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE pin ADD COLUMN updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE pin ADD COLUMN created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pin AS SELECT id, title, description FROM pin');
        $this->addSql('DROP TABLE pin');
        $this->addSql('CREATE TABLE pin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('INSERT INTO pin (id, title, description) SELECT id, title, description FROM __temp__pin');
        $this->addSql('DROP TABLE __temp__pin');
    }
}
