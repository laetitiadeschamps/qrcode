<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903110020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qr_code (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, expires_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7D8B1FB5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qr_code_user (qr_code_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_771A952512E4AD80 (qr_code_id), INDEX IDX_771A9525A76ED395 (user_id), PRIMARY KEY(qr_code_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE qr_code ADD CONSTRAINT FK_7D8B1FB5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE qr_code_user ADD CONSTRAINT FK_771A952512E4AD80 FOREIGN KEY (qr_code_id) REFERENCES qr_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qr_code_user ADD CONSTRAINT FK_771A9525A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qr_code_user DROP FOREIGN KEY FK_771A952512E4AD80');
        $this->addSql('ALTER TABLE qr_code DROP FOREIGN KEY FK_7D8B1FB5F675F31B');
        $this->addSql('ALTER TABLE qr_code_user DROP FOREIGN KEY FK_771A9525A76ED395');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP TABLE qr_code_user');
        $this->addSql('DROP TABLE user');
    }
}
