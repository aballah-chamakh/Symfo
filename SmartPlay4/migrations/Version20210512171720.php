<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210512171720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (code_clt INT AUTO_INCREMENT NOT NULL, des_clt VARCHAR(255) NOT NULL, tel_clt VARCHAR(255) NOT NULL, PRIMARY KEY(code_clt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (num_cde INT AUTO_INCREMENT NOT NULL, code_clt_cde_id INT DEFAULT NULL, date_cde DATE NOT NULL, heure_cde TIME NOT NULL, remise_cde INT NOT NULL, mnt_cde INT NOT NULL, INDEX IDX_6EEAA67DC10EE90D (code_clt_cde_id), PRIMARY KEY(num_cde)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (code_four INT AUTO_INCREMENT NOT NULL, des_four VARCHAR(255) NOT NULL, adr_four VARCHAR(255) DEFAULT NULL, tel_four VARCHAR(255) DEFAULT NULL, PRIMARY KEY(code_four)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jouet (code_jouet INT AUTO_INCREMENT NOT NULL, code_four_jouet INT DEFAULT NULL, des_jouet VARCHAR(255) NOT NULL, qte_stock_jouet INT NOT NULL, pu_jouet DOUBLE PRECISION NOT NULL, INDEX IDX_6B3DFFD85B8743C3 (code_four_jouet), PRIMARY KEY(code_jouet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_cde (num_cde_ligne INT NOT NULL, code_jouet_ligne INT NOT NULL, qte_ligne INT NOT NULL, remise_ligne INT NOT NULL, INDEX IDX_5B71680B101C86AC (num_cde_ligne), INDEX IDX_5B71680BE64383DC (code_jouet_ligne), PRIMARY KEY(num_cde_ligne, code_jouet_ligne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC10EE90D FOREIGN KEY (code_clt_cde_id) REFERENCES client (code_clt)');
        $this->addSql('ALTER TABLE jouet ADD CONSTRAINT FK_6B3DFFD85B8743C3 FOREIGN KEY (code_four_jouet) REFERENCES fournisseur (code_four)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B101C86AC FOREIGN KEY (num_cde_ligne) REFERENCES commande (num_cde)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680BE64383DC FOREIGN KEY (code_jouet_ligne) REFERENCES jouet (code_jouet)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC10EE90D');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B101C86AC');
        $this->addSql('ALTER TABLE jouet DROP FOREIGN KEY FK_6B3DFFD85B8743C3');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680BE64383DC');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE jouet');
        $this->addSql('DROP TABLE ligne_cde');
    }
}
