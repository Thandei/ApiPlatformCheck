<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405085628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_policy (id INT AUTO_INCREMENT NOT NULL, keyname VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genus_genus_attribute (genus_id INT NOT NULL, genus_attribute_id INT NOT NULL, INDEX IDX_46ABD18185C4074C (genus_id), INDEX IDX_46ABD181BF6A35BF (genus_attribute_id), PRIMARY KEY(genus_id, genus_attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genus_attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE landing_slide (id INT AUTO_INCREMENT NOT NULL, textcontent VARCHAR(40) NOT NULL, tags VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locale (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, flag VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, systemsdefault TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, uploadedby_id INT DEFAULT NULL, filepath VARCHAR(255) DEFAULT NULL, INDEX IDX_14D43132CF509152 (uploadedby_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, genus_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E4529B857E3C61F9 (owner_id), INDEX IDX_E4529B8585C4074C (genus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E19D9AD25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system_log (id INT AUTO_INCREMENT NOT NULL, priority ENUM(\'LOW\', \'NORMAL\', \'HIGH\') NOT NULL COMMENT \'(DC2Type:system_log_priority)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content LONGTEXT DEFAULT NULL, requestip VARCHAR(255) DEFAULT NULL, relateduserid INT DEFAULT NULL, trace LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, defaultlocale_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, accountname VARCHAR(255) DEFAULT NULL, nickname VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', approvalbadge TINYINT(1) DEFAULT NULL, hasbusiness TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), INDEX IDX_8D93D649CDDDAAFF (defaultlocale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genus_genus_attribute ADD CONSTRAINT FK_46ABD18185C4074C FOREIGN KEY (genus_id) REFERENCES genus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genus_genus_attribute ADD CONSTRAINT FK_46ABD181BF6A35BF FOREIGN KEY (genus_attribute_id) REFERENCES genus_attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D43132CF509152 FOREIGN KEY (uploadedby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B857E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B8585C4074C FOREIGN KEY (genus_id) REFERENCES genus (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CDDDAAFF FOREIGN KEY (defaultlocale_id) REFERENCES locale (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genus_genus_attribute DROP FOREIGN KEY FK_46ABD18185C4074C');
        $this->addSql('ALTER TABLE genus_genus_attribute DROP FOREIGN KEY FK_46ABD181BF6A35BF');
        $this->addSql('ALTER TABLE media_object DROP FOREIGN KEY FK_14D43132CF509152');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B857E3C61F9');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B8585C4074C');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CDDDAAFF');
        $this->addSql('DROP TABLE app_policy');
        $this->addSql('DROP TABLE genus');
        $this->addSql('DROP TABLE genus_genus_attribute');
        $this->addSql('DROP TABLE genus_attribute');
        $this->addSql('DROP TABLE landing_slide');
        $this->addSql('DROP TABLE locale');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE system_log');
        $this->addSql('DROP TABLE user');
    }
}
