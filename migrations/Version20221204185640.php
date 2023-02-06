<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221204185640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solicitudes (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, fecha DATE NOT NULL, curso INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medidas DROP FOREIGN KEY FK_FF9C1C2AA76ED395');
        $this->addSql('ALTER TABLE medidas ADD CONSTRAINT FK_FF9C1C2AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE solicitudes');
        $this->addSql('ALTER TABLE medidas DROP FOREIGN KEY FK_FF9C1C2AA76ED395');
        $this->addSql('ALTER TABLE medidas ADD CONSTRAINT FK_FF9C1C2AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
