<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190201140309 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604385CD9AF2');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604385CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F579F4768');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE message_read DROP FOREIGN KEY FK_31C2DABE537A1329');
        $this->addSql('ALTER TABLE message_read DROP FOREIGN KEY FK_31C2DABEA76ED395');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABE537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABEA76ED395 FOREIGN KEY (user_id) REFERENCES online_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F579F4768');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_read DROP FOREIGN KEY FK_31C2DABEA76ED395');
        $this->addSql('ALTER TABLE message_read DROP FOREIGN KEY FK_31C2DABE537A1329');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABEA76ED395 FOREIGN KEY (user_id) REFERENCES online_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_read ADD CONSTRAINT FK_31C2DABE537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604385CD9AF2');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604385CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
    }
}
