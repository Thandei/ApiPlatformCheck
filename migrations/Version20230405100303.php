<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405100303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genus_attribute_value_genus_attribute (genus_attribute_value_id INT NOT NULL, genus_attribute_id INT NOT NULL, INDEX IDX_22DCB77A85592E12 (genus_attribute_value_id), INDEX IDX_22DCB77ABF6A35BF (genus_attribute_id), PRIMARY KEY(genus_attribute_value_id, genus_attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genus_attribute_value_genus_attribute ADD CONSTRAINT FK_22DCB77A85592E12 FOREIGN KEY (genus_attribute_value_id) REFERENCES genus_attribute_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genus_attribute_value_genus_attribute ADD CONSTRAINT FK_22DCB77ABF6A35BF FOREIGN KEY (genus_attribute_id) REFERENCES genus_attribute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_attribute_value_genus_attribute DROP FOREIGN KEY FK_22DCB77A85592E12');
        $this->addSql('ALTER TABLE genus_attribute_value_genus_attribute DROP FOREIGN KEY FK_22DCB77ABF6A35BF');
        $this->addSql('DROP TABLE genus_attribute_value_genus_attribute');
    }
}
