<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405090713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_attribute_value ADD attribute_id INT NOT NULL');
        $this->addSql('ALTER TABLE genus_attribute_value ADD CONSTRAINT FK_C526F031B6E62EFA FOREIGN KEY (attribute_id) REFERENCES genus_attribute (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C526F031B6E62EFA ON genus_attribute_value (attribute_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_attribute_value DROP FOREIGN KEY FK_C526F031B6E62EFA');
        $this->addSql('DROP INDEX UNIQ_C526F031B6E62EFA ON genus_attribute_value');
        $this->addSql('ALTER TABLE genus_attribute_value DROP attribute_id');
    }
}
