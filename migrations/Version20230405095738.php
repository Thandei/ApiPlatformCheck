<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405095738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_attribute_value DROP FOREIGN KEY FK_C526F031966F7FB6');
        $this->addSql('ALTER TABLE genus_attribute_value DROP FOREIGN KEY FK_C526F031B6E62EFA');
        $this->addSql('DROP TABLE genus_attribute_value');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genus_attribute_value (id INT AUTO_INCREMENT NOT NULL, pet_id INT NOT NULL, attribute_id INT NOT NULL, UNIQUE INDEX UNIQ_C526F031B6E62EFA (attribute_id), INDEX IDX_C526F031966F7FB6 (pet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE genus_attribute_value ADD CONSTRAINT FK_C526F031966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE genus_attribute_value ADD CONSTRAINT FK_C526F031B6E62EFA FOREIGN KEY (attribute_id) REFERENCES genus_attribute (id)');
    }
}
