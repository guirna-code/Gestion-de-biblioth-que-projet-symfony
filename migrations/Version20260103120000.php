<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260103120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modify `user` table: ensure email, username, roles, password columns and unique email index';
    }

    public function up(Schema $schema): void
    {
        // WARNING: review and backup your DB before running this migration.
        // Add or modify columns to match the target schema.
        $this->addSql("ALTER TABLE `user` ADD COLUMN IF NOT EXISTS `email` VARCHAR(180) NOT NULL AFTER `id`");
        $this->addSql("ALTER TABLE `user` ADD COLUMN IF NOT EXISTS `username` VARCHAR(180) DEFAULT NULL AFTER `email`");
        $this->addSql("ALTER TABLE `user` ADD COLUMN IF NOT EXISTS `roles` JSON NOT NULL AFTER `username`");
        $this->addSql("ALTER TABLE `user` ADD COLUMN IF NOT EXISTS `password` VARCHAR(255) NOT NULL AFTER `roles`");

        // Ensure unique index on email (index name chosen to match your requested DDL)
        $this->addSql("ALTER TABLE `user` ADD UNIQUE INDEX UNIQ_8D93D649E7927C74 (`email`)");
    }

    public function down(Schema $schema): void
    {
        // Revert the schema changes where safe (dropping columns can be destructive).
        $this->addSql("ALTER TABLE `user` DROP INDEX UNIQ_8D93D649E7927C74");
        $this->addSql("ALTER TABLE `user` DROP COLUMN IF EXISTS `email`");
        $this->addSql("ALTER TABLE `user` DROP COLUMN IF EXISTS `username`");
        $this->addSql("ALTER TABLE `user` DROP COLUMN IF EXISTS `roles`");
        $this->addSql("ALTER TABLE `user` DROP COLUMN IF EXISTS `password`");
    }
}
