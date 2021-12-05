<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211204233801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, selected_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, has_rounds TINYINT(1) NOT NULL, INDEX IDX_232B318CE90B237A (selected_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_map (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_88F7B97EE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, secret VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE played_game (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, game_map_id INT DEFAULT NULL, date DATETIME NOT NULL, score_final VARCHAR(255) NOT NULL, INDEX IDX_54BE8039E48FD905 (game_id), INDEX IDX_54BE80392EF0F2AC (game_map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_score (id INT AUTO_INCREMENT NOT NULL, played_game_id INT NOT NULL, player_id INT NOT NULL, kills INT NOT NULL, deaths INT NOT NULL, assists INT NOT NULL, round INT DEFAULT NULL, round_style VARCHAR(255) DEFAULT NULL, INDEX IDX_8DEB4C175AA11DBB (played_game_id), INDEX IDX_8DEB4C1799E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, selected_group_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649E90B237A (selected_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE90B237A FOREIGN KEY (selected_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE game_map ADD CONSTRAINT FK_88F7B97EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE played_game ADD CONSTRAINT FK_54BE8039E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE played_game ADD CONSTRAINT FK_54BE80392EF0F2AC FOREIGN KEY (game_map_id) REFERENCES game_map (id)');
        $this->addSql('ALTER TABLE player_score ADD CONSTRAINT FK_8DEB4C175AA11DBB FOREIGN KEY (played_game_id) REFERENCES played_game (id)');
        $this->addSql('ALTER TABLE player_score ADD CONSTRAINT FK_8DEB4C1799E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E90B237A FOREIGN KEY (selected_group_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_map DROP FOREIGN KEY FK_88F7B97EE48FD905');
        $this->addSql('ALTER TABLE played_game DROP FOREIGN KEY FK_54BE8039E48FD905');
        $this->addSql('ALTER TABLE played_game DROP FOREIGN KEY FK_54BE80392EF0F2AC');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE90B237A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E90B237A');
        $this->addSql('ALTER TABLE player_score DROP FOREIGN KEY FK_8DEB4C175AA11DBB');
        $this->addSql('ALTER TABLE player_score DROP FOREIGN KEY FK_8DEB4C1799E6F5DF');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_map');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE played_game');
        $this->addSql('DROP TABLE player_score');
        $this->addSql('DROP TABLE user');
    }
}
