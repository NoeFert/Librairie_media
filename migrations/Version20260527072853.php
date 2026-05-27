<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260527072853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, role VARCHAR(200) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE franchise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, cover_url VARCHAR(255) DEFAULT NULL, genre_id INT DEFAULT NULL, INDEX IDX_66F6CE2A4296D31F (genre_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, resume LONGTEXT NOT NULL, numero VARCHAR(255) DEFAULT NULL, cover_url VARCHAR(255) DEFAULT NULL, media_id INT NOT NULL, franchise_id INT NOT NULL, INDEX IDX_AF3C6779EA9FDD75 (media_id), INDEX IDX_AF3C6779523CAB89 (franchise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE publication_auteur (publication_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_E1B1A00D38B217A7 (publication_id), INDEX IDX_E1B1A00D60BB6FE6 (auteur_id), PRIMARY KEY (publication_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE franchise ADD CONSTRAINT FK_66F6CE2A4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchise (id)');
        $this->addSql('ALTER TABLE publication_auteur ADD CONSTRAINT FK_E1B1A00D38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_auteur ADD CONSTRAINT FK_E1B1A00D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchise DROP FOREIGN KEY FK_66F6CE2A4296D31F');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779EA9FDD75');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779523CAB89');
        $this->addSql('ALTER TABLE publication_auteur DROP FOREIGN KEY FK_E1B1A00D38B217A7');
        $this->addSql('ALTER TABLE publication_auteur DROP FOREIGN KEY FK_E1B1A00D60BB6FE6');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE franchise');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE publication_auteur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
