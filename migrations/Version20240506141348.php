<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506141348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce CHANGE volume volume VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595D8088C4F');
        $this->addSql('DROP INDEX IDX_7CBE7595D8088C4F ON material');
        $this->addSql('ALTER TABLE material DROP classification_material_id');
        // $this->addSql('ALTER TABLE user DROP professionnal');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce CHANGE volume volume INT NOT NULL');
        $this->addSql('ALTER TABLE material ADD classification_material_id INT NOT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595D8088C4F FOREIGN KEY (classification_material_id) REFERENCES classification_material (id)');
        $this->addSql('CREATE INDEX IDX_7CBE7595D8088C4F ON material (classification_material_id)');
        $this->addSql('ALTER TABLE user ADD professionnal VARCHAR(255) NOT NULL');
    }
}
