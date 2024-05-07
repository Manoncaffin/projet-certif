<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507091133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE volume (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announce ADD volume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE announce ADD CONSTRAINT FK_E6D6DD758FD80EEA FOREIGN KEY (volume_id) REFERENCES volume (id)');
        $this->addSql('CREATE INDEX IDX_E6D6DD758FD80EEA ON announce (volume_id)');
        // $this->addSql('ALTER TABLE material DROP volume');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595D8088C4F FOREIGN KEY (classification_material_id) REFERENCES classification_material (id)');
        $this->addSql('CREATE INDEX IDX_7CBE7595D8088C4F ON material (classification_material_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce DROP FOREIGN KEY FK_E6D6DD758FD80EEA');
        $this->addSql('DROP TABLE volume');
        $this->addSql('DROP INDEX IDX_E6D6DD758FD80EEA ON announce');
        $this->addSql('ALTER TABLE announce ADD volume VARCHAR(255) NOT NULL, DROP volume_id');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595D8088C4F');
        $this->addSql('DROP INDEX IDX_7CBE7595D8088C4F ON material');
        $this->addSql('ALTER TABLE material ADD volume VARCHAR(255) NOT NULL');
    }
}
