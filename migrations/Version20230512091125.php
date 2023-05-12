<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512091125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse DROP FOREIGN KEY FK_351B0C7EA4AEAFEA');
        $this->addSql('ALTER TABLE analyse ADD CONSTRAINT FK_351B0C7EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7A4AEAFEA');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A4AEAFEA');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE pdf DROP FOREIGN KEY FK_EF0DB8CA4AEAFEA');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8CA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf DROP FOREIGN KEY FK_EF0DB8CA4AEAFEA');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8CA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A4AEAFEA');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7A4AEAFEA');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analyse DROP FOREIGN KEY FK_351B0C7EA4AEAFEA');
        $this->addSql('ALTER TABLE analyse ADD CONSTRAINT FK_351B0C7EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
