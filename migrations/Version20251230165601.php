<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251230165601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE auteur auteur VARCHAR(255) NOT NULL, CHANGE isbn isbn VARCHAR(20) DEFAULT NULL, CHANGE disponible disponible VARCHAR(20) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_ID ON user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE titre titre VARCHAR(10) NOT NULL, CHANGE auteur auteur VARCHAR(10) NOT NULL, CHANGE isbn isbn VARCHAR(10) DEFAULT NULL, CHANGE disponible disponible VARCHAR(10) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_ID ON `user` (id)');
    }
}
