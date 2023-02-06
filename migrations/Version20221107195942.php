<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107195942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso ADD ud1 LONGTEXT DEFAULT NULL, ADD ud2 LONGTEXT DEFAULT NULL, ADD ud3 LONGTEXT DEFAULT NULL, ADD ud4 LONGTEXT DEFAULT NULL, ADD ud5 LONGTEXT DEFAULT NULL, ADD video1 VARCHAR(255) DEFAULT NULL, ADD video2 VARCHAR(255) DEFAULT NULL, ADD video3 VARCHAR(255) DEFAULT NULL, ADD video4 VARCHAR(255) DEFAULT NULL, ADD video5 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso DROP ud1, DROP ud2, DROP ud3, DROP ud4, DROP ud5, DROP video1, DROP video2, DROP video3, DROP video4, DROP video5');
    }
}
