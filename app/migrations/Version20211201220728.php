<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201220728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD has_rounds TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE player_score ADD kills INT NOT NULL, ADD deaths INT NOT NULL, ADD assists INT NOT NULL, ADD round INT DEFAULT NULL, ADD round_style VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP has_rounds');
        $this->addSql('ALTER TABLE player_score DROP kills, DROP deaths, DROP assists, DROP round, DROP round_style');
    }
}
