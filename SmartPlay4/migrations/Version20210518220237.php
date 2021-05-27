<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518220237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE remise_cde remise_cde DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ligne_cde ADD num_cde INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B991E96B1 FOREIGN KEY (num_cde) REFERENCES commande (num_cde)');
        $this->addSql('CREATE INDEX IDX_5B71680B991E96B1 ON ligne_cde (num_cde)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE remise_cde remise_cde INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B991E96B1');
        $this->addSql('DROP INDEX IDX_5B71680B991E96B1 ON ligne_cde');
        $this->addSql('ALTER TABLE ligne_cde DROP num_cde');
    }
}
