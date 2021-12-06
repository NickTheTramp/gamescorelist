<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206184436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE played_game ADD selected_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE played_game ADD CONSTRAINT FK_54BE8039E90B237A FOREIGN KEY (selected_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_54BE8039E90B237A ON played_game (selected_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE played_game DROP FOREIGN KEY FK_54BE8039E90B237A');
        $this->addSql('DROP INDEX IDX_54BE8039E90B237A ON played_game');
        $this->addSql('ALTER TABLE played_game DROP selected_group_id');
    }
}
