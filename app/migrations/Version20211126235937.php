<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126235937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_map (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, INDEX IDX_88F7B97EE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_map ADD CONSTRAINT FK_88F7B97EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE played_game ADD game_map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE played_game ADD CONSTRAINT FK_54BE80392EF0F2AC FOREIGN KEY (game_map_id) REFERENCES game_map (id)');
        $this->addSql('CREATE INDEX IDX_54BE80392EF0F2AC ON played_game (game_map_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE played_game DROP FOREIGN KEY FK_54BE80392EF0F2AC');
        $this->addSql('DROP TABLE game_map');
        $this->addSql('DROP INDEX IDX_54BE80392EF0F2AC ON played_game');
        $this->addSql('ALTER TABLE played_game DROP game_map_id');
    }
}
