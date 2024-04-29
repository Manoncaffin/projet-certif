<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429141928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce ADD classification_id INT NOT NULL, DROP materials, DROP photos');
        $this->addSql('ALTER TABLE announce ADD CONSTRAINT FK_E6D6DD752A86559F FOREIGN KEY (classification_id) REFERENCES classification_material (id)');
        $this->addSql('CREATE INDEX IDX_E6D6DD752A86559F ON announce (classification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce DROP FOREIGN KEY FK_E6D6DD752A86559F');
        $this->addSql('DROP INDEX IDX_E6D6DD752A86559F ON announce');
        $this->addSql('ALTER TABLE announce ADD materials VARCHAR(255) NOT NULL, ADD photos VARCHAR(255) NOT NULL, DROP classification_id');
    }
}
