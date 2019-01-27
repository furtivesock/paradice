<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190126142645 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characteristic DROP FOREIGN KEY FK_522FA9505CD9AF2');
        $this->addSql('DROP INDEX IDX_522FA9505CD9AF2 ON characteristic');
        $this->addSql('ALTER TABLE characteristic DROP universe_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characteristic ADD universe_id INT NOT NULL');
        $this->addSql('ALTER TABLE characteristic ADD CONSTRAINT FK_522FA9505CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_522FA9505CD9AF2 ON characteristic (universe_id)');
    }
}
