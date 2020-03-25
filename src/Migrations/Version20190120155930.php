<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190120155930 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, chapter_id INT NOT NULL, contents LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_read (user_id INT NOT NULL, message_id INT NOT NULL, seen TINYINT(1) NOT NULL, INDEX IDX_31C2DABEA76ED395 (user_id), INDEX IDX_31C2DABE537A1329 (message_id), PRIMARY KEY(user_id, message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABEA76ED395 FOREIGN KEY (user_id) REFERENCES online_user (id)');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABE537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE story ADD summary LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_read DROP FOREIGN KEY FK_31C2DABE537A1329');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_read');
        $this->addSql('ALTER TABLE story DROP summary');
    }
}
