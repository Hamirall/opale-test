<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126224859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recall (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, language_id INT DEFAULT NULL, uri LONGTEXT NOT NULL, date DATE NOT NULL, ext_url LONGTEXT NOT NULL, import_id VARCHAR(50) NOT NULL, image_uri LONGTEXT DEFAULT NULL, url LONGTEXT NOT NULL, product_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4B300576F92F3E70 (country_id), INDEX IDX_4B30057682F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recall_tag (recall_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_38353D396D931570 (recall_id), INDEX IDX_38353D39BAD26311 (tag_id), PRIMARY KEY(recall_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recall_country (recall_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_3465F15E6D931570 (recall_id), INDEX IDX_3465F15EF92F3E70 (country_id), PRIMARY KEY(recall_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, value VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recall ADD CONSTRAINT FK_4B300576F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE recall ADD CONSTRAINT FK_4B30057682F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE recall_tag ADD CONSTRAINT FK_38353D396D931570 FOREIGN KEY (recall_id) REFERENCES recall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recall_tag ADD CONSTRAINT FK_38353D39BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recall_country ADD CONSTRAINT FK_3465F15E6D931570 FOREIGN KEY (recall_id) REFERENCES recall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recall_country ADD CONSTRAINT FK_3465F15EF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recall DROP FOREIGN KEY FK_4B300576F92F3E70');
        $this->addSql('ALTER TABLE recall DROP FOREIGN KEY FK_4B30057682F1BAF4');
        $this->addSql('ALTER TABLE recall_tag DROP FOREIGN KEY FK_38353D396D931570');
        $this->addSql('ALTER TABLE recall_tag DROP FOREIGN KEY FK_38353D39BAD26311');
        $this->addSql('ALTER TABLE recall_country DROP FOREIGN KEY FK_3465F15E6D931570');
        $this->addSql('ALTER TABLE recall_country DROP FOREIGN KEY FK_3465F15EF92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE recall');
        $this->addSql('DROP TABLE recall_tag');
        $this->addSql('DROP TABLE recall_country');
        $this->addSql('DROP TABLE tag');
    }
}
