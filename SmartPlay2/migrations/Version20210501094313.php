<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210501094313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jouet DROP FOREIGN KEY FK_6B3DFFD85D20E737');
        $this->addSql('DROP INDEX IDX_6B3DFFD85D20E737 ON jouet');
        $this->addSql('ALTER TABLE jouet CHANGE code_four_jouet_id code_four_jouet INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jouet ADD CONSTRAINT FK_6B3DFFD85B8743C3 FOREIGN KEY (code_four_jouet) REFERENCES fournisseur (code_four)');
        $this->addSql('CREATE INDEX IDX_6B3DFFD85B8743C3 ON jouet (code_four_jouet)');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B1DA9D220');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680BCFFB02A6');
        $this->addSql('DROP INDEX IDX_5B71680BCFFB02A6 ON ligne_cde');
        $this->addSql('DROP INDEX IDX_5B71680B1DA9D220 ON ligne_cde');
        $this->addSql('ALTER TABLE ligne_cde DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ligne_cde ADD num_cde_ligne INT NOT NULL, ADD code_jouet_ligne INT NOT NULL, DROP num_cde_ligne_id, DROP code_jouet_ligne_id');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B101C86AC FOREIGN KEY (num_cde_ligne) REFERENCES commande (num_cde)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680BE64383DC FOREIGN KEY (code_jouet_ligne) REFERENCES jouet (code_jouet)');
        $this->addSql('CREATE INDEX IDX_5B71680B101C86AC ON ligne_cde (num_cde_ligne)');
        $this->addSql('CREATE INDEX IDX_5B71680BE64383DC ON ligne_cde (code_jouet_ligne)');
        $this->addSql('ALTER TABLE ligne_cde ADD PRIMARY KEY (num_cde_ligne, code_jouet_ligne)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jouet DROP FOREIGN KEY FK_6B3DFFD85B8743C3');
        $this->addSql('DROP INDEX IDX_6B3DFFD85B8743C3 ON jouet');
        $this->addSql('ALTER TABLE jouet CHANGE code_four_jouet code_four_jouet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jouet ADD CONSTRAINT FK_6B3DFFD85D20E737 FOREIGN KEY (code_four_jouet_id) REFERENCES fournisseur (code_four)');
        $this->addSql('CREATE INDEX IDX_6B3DFFD85D20E737 ON jouet (code_four_jouet_id)');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B101C86AC');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680BE64383DC');
        $this->addSql('DROP INDEX IDX_5B71680B101C86AC ON ligne_cde');
        $this->addSql('DROP INDEX IDX_5B71680BE64383DC ON ligne_cde');
        $this->addSql('ALTER TABLE ligne_cde DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE ligne_cde ADD num_cde_ligne_id INT NOT NULL, ADD code_jouet_ligne_id INT NOT NULL, DROP num_cde_ligne, DROP code_jouet_ligne');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B1DA9D220 FOREIGN KEY (code_jouet_ligne_id) REFERENCES jouet (code_jouet)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680BCFFB02A6 FOREIGN KEY (num_cde_ligne_id) REFERENCES commande (num_cde)');
        $this->addSql('CREATE INDEX IDX_5B71680BCFFB02A6 ON ligne_cde (num_cde_ligne_id)');
        $this->addSql('CREATE INDEX IDX_5B71680B1DA9D220 ON ligne_cde (code_jouet_ligne_id)');
        $this->addSql('ALTER TABLE ligne_cde ADD PRIMARY KEY (num_cde_ligne_id, code_jouet_ligne_id)');
    }
}
