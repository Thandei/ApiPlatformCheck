<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323121318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genus_genus_attribute (genus_id INT NOT NULL, genus_attribute_id INT NOT NULL, INDEX IDX_46ABD18185C4074C (genus_id), INDEX IDX_46ABD181BF6A35BF (genus_attribute_id), PRIMARY KEY(genus_id, genus_attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genus_attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genus_genus_attribute ADD CONSTRAINT FK_46ABD18185C4074C FOREIGN KEY (genus_id) REFERENCES genus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genus_genus_attribute ADD CONSTRAINT FK_46ABD181BF6A35BF FOREIGN KEY (genus_attribute_id) REFERENCES genus_attribute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_genus_attribute DROP FOREIGN KEY FK_46ABD18185C4074C');
        $this->addSql('ALTER TABLE genus_genus_attribute DROP FOREIGN KEY FK_46ABD181BF6A35BF');
        $this->addSql('DROP TABLE genus');
        $this->addSql('DROP TABLE genus_genus_attribute');
        $this->addSql('DROP TABLE genus_attribute');
    }
}
