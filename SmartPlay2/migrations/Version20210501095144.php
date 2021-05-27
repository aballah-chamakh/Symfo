<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210501095144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B8768E694');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B991E96B1');
        $this->addSql('DROP INDEX IDX_5B71680B8768E694 ON ligne_cde');
        $this->addSql('DROP INDEX IDX_5B71680B991E96B1 ON ligne_cde');
        $this->addSql('ALTER TABLE ligne_cde DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ligne_cde ADD code_jouet_lign INT NOT NULL, DROP num_cde, DROP code_jouet');
        $this->addSql('ALTER TABLE ligne_cde ADD PRIMARY KEY (code_jouet_lign)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_cde DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ligne_cde ADD code_jouet INT NOT NULL, CHANGE code_jouet_lign num_cde INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B8768E694 FOREIGN KEY (code_jouet) REFERENCES jouet (code_jouet)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B991E96B1 FOREIGN KEY (num_cde) REFERENCES commande (num_cde)');
        $this->addSql('CREATE INDEX IDX_5B71680B8768E694 ON ligne_cde (code_jouet)');
        $this->addSql('CREATE INDEX IDX_5B71680B991E96B1 ON ligne_cde (num_cde)');
        $this->addSql('ALTER TABLE ligne_cde ADD PRIMARY KEY (num_cde, code_jouet)');
    }
}
