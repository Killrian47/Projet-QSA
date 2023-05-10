<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510133421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE echantillon (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, number_of_order_id INT DEFAULT NULL, conditioning_id INT DEFAULT NULL, etat_physique_id INT DEFAULT NULL, lieu_id INT DEFAULT NULL, stockage_id INT DEFAULT NULL, analyse_id INT DEFAULT NULL, sampling_by_id INT DEFAULT NULL, product_name LONGTEXT DEFAULT NULL, number_of_batch LONGTEXT DEFAULT NULL, supplier VARCHAR(255) DEFAULT NULL, temperature_of_product INT DEFAULT NULL, temperature_of_enceinte INT DEFAULT NULL, date_of_manufacturing DATETIME DEFAULT NULL, dlc_or_dluo DATETIME DEFAULT NULL, date_of_sampling DATETIME DEFAULT NULL, analyse_dlc TINYINT(1) DEFAULT NULL, validation_dlc TINYINT(1) DEFAULT NULL, INDEX IDX_2C649BE7A4AEAFEA (entreprise_id), INDEX IDX_2C649BE715EECB0E (number_of_order_id), INDEX IDX_2C649BE74129ED12 (conditioning_id), INDEX IDX_2C649BE73EA44F4F (etat_physique_id), INDEX IDX_2C649BE76AB213CC (lieu_id), INDEX IDX_2C649BE7DAA83D7F (stockage_id), INDEX IDX_2C649BE71EFE06BF (analyse_id), INDEX IDX_2C649BE7FD79AD4F (sampling_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE715EECB0E FOREIGN KEY (number_of_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE74129ED12 FOREIGN KEY (conditioning_id) REFERENCES conditionnement (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE73EA44F4F FOREIGN KEY (etat_physique_id) REFERENCES etat_physique (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE76AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7DAA83D7F FOREIGN KEY (stockage_id) REFERENCES stockage (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE71EFE06BF FOREIGN KEY (analyse_id) REFERENCES analyse (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7FD79AD4F FOREIGN KEY (sampling_by_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE6703815EECB0E');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE670381EFE06BF');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE670383EA44F4F');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE670384129ED12');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE670386AB213CC');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE67038A4AEAFEA');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE67038DAA83D7F');
        $this->addSql('ALTER TABLE enchantillon DROP FOREIGN KEY FK_AFE67038FD79AD4F');
        $this->addSql('DROP TABLE enchantillon');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enchantillon (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, number_of_order_id INT DEFAULT NULL, conditioning_id INT DEFAULT NULL, etat_physique_id INT DEFAULT NULL, lieu_id INT DEFAULT NULL, stockage_id INT DEFAULT NULL, analyse_id INT DEFAULT NULL, sampling_by_id INT DEFAULT NULL, product_name LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, number_of_batch LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, supplier VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, temperature_of_product INT DEFAULT NULL, temperature_of_enceinte INT DEFAULT NULL, date_of_manufacturing DATETIME DEFAULT NULL, dlc_or_dluo DATETIME DEFAULT NULL, date_of_sampling DATETIME DEFAULT NULL, analyse_dlc TINYINT(1) DEFAULT NULL, validation_dlc TINYINT(1) DEFAULT NULL, INDEX IDX_AFE67038FD79AD4F (sampling_by_id), INDEX IDX_AFE67038DAA83D7F (stockage_id), INDEX IDX_AFE67038A4AEAFEA (entreprise_id), INDEX IDX_AFE670386AB213CC (lieu_id), INDEX IDX_AFE670384129ED12 (conditioning_id), INDEX IDX_AFE670383EA44F4F (etat_physique_id), INDEX IDX_AFE670381EFE06BF (analyse_id), INDEX IDX_AFE6703815EECB0E (number_of_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE6703815EECB0E FOREIGN KEY (number_of_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE670381EFE06BF FOREIGN KEY (analyse_id) REFERENCES analyse (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE670383EA44F4F FOREIGN KEY (etat_physique_id) REFERENCES etat_physique (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE670384129ED12 FOREIGN KEY (conditioning_id) REFERENCES conditionnement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE670386AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE67038A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE67038DAA83D7F FOREIGN KEY (stockage_id) REFERENCES stockage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE enchantillon ADD CONSTRAINT FK_AFE67038FD79AD4F FOREIGN KEY (sampling_by_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7A4AEAFEA');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE715EECB0E');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE74129ED12');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE73EA44F4F');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE76AB213CC');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7DAA83D7F');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE71EFE06BF');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7FD79AD4F');
        $this->addSql('DROP TABLE echantillon');
    }
}
