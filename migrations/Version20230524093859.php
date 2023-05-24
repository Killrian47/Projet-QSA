<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524093859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE76AB213CC');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7DAA83D7F');
        $this->addSql('DROP INDEX IDX_2C649BE7DAA83D7F ON echantillon');
        $this->addSql('DROP INDEX IDX_2C649BE76AB213CC ON echantillon');
        $this->addSql('ALTER TABLE echantillon DROP lieu_id, DROP stockage_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echantillon ADD lieu_id INT DEFAULT NULL, ADD stockage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE76AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7DAA83D7F FOREIGN KEY (stockage_id) REFERENCES stockage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2C649BE7DAA83D7F ON echantillon (stockage_id)');
        $this->addSql('CREATE INDEX IDX_2C649BE76AB213CC ON echantillon (lieu_id)');
    }
}
