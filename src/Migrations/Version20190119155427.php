<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119155427 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE story (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, visibility_id INT NOT NULL, status_id INT NOT NULL, universe_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, creation_date DATETIME NOT NULL, start_date DATETIME DEFAULT NULL, end_registration_date DATETIME DEFAULT NULL, INDEX IDX_EB560438F675F31B (author_id), INDEX IDX_EB560438B7157780 (visibility_id), INDEX IDX_EB5604386BF700BD (status_id), INDEX IDX_EB5604385CD9AF2 (universe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, parent_type_id INT DEFAULT NULL, universe_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8CDE5729B704F8D5 (parent_type_id), INDEX IDX_8CDE57295CD9AF2 (universe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, universe_id INT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, physical_description LONGTEXT DEFAULT NULL, personality LONGTEXT DEFAULT NULL, background LONGTEXT DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, INDEX IDX_51E5B69B5CD9AF2 (universe_id), INDEX IDX_51E5B69BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona_characteristic (persona_id INT NOT NULL, characteristic_id INT NOT NULL, INDEX IDX_9E48870CF5F88DB9 (persona_id), INDEX IDX_9E48870CDEE9D12B (characteristic_id), PRIMARY KEY(persona_id, characteristic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universe (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, creation_date DATETIME NOT NULL, INDEX IDX_6135383561220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universe_online_user (universe_id INT NOT NULL, online_user_id INT NOT NULL, INDEX IDX_20E53C75CD9AF2 (universe_id), INDEX IDX_20E53C796F8006B (online_user_id), PRIMARY KEY(universe_id, online_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_support (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, universe_id INT NOT NULL, contents LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_108CD1A9F624B39D (sender_id), INDEX IDX_108CD1A95CD9AF2 (universe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universe_member (member_id INT NOT NULL, universe_id INT NOT NULL, acceptation_date DATETIME NOT NULL, INDEX IDX_71FEB55E7597D3FE (member_id), INDEX IDX_71FEB55E5CD9AF2 (universe_id), PRIMARY KEY(member_id, universe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, parent_location_id INT DEFAULT NULL, universe_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, INDEX IDX_5E9E89CB6D6133FE (parent_location_id), INDEX IDX_5E9E89CB5CD9AF2 (universe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, story_id INT NOT NULL, name VARCHAR(255) NOT NULL, numero INT NOT NULL, end TINYINT(1) NOT NULL, INDEX IDX_F981B52E64D218E (location_id), INDEX IDX_F981B52EAA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universe_application (universe_id INT NOT NULL, applicant_id INT NOT NULL, motivation LONGTEXT NOT NULL, application_date DATETIME NOT NULL, accepted TINYINT(1) DEFAULT NULL, INDEX IDX_210758E95CD9AF2 (universe_id), INDEX IDX_210758E997139001 (applicant_id), PRIMARY KEY(universe_id, applicant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visibility (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characteristic (id INT AUTO_INCREMENT NOT NULL, universe_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, INDEX IDX_522FA9505CD9AF2 (universe_id), INDEX IDX_522FA950C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE online_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, avatar_url VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8752D6EFF85E0677 (username), UNIQUE INDEX UNIQ_8752D6EFE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story_player (story_id INT NOT NULL, player_id INT NOT NULL, acceptation_date DATETIME NOT NULL, INDEX IDX_D71AC897AA5D4036 (story_id), INDEX IDX_D71AC89799E6F5DF (player_id), PRIMARY KEY(story_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story_application (story_id INT NOT NULL, applicant_id INT NOT NULL, motivation LONGTEXT NOT NULL, application_date DATETIME NOT NULL, accepted TINYINT(1) DEFAULT NULL, INDEX IDX_5473B57EAA5D4036 (story_id), INDEX IDX_5473B57E97139001 (applicant_id), PRIMARY KEY(story_id, applicant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438F675F31B FOREIGN KEY (author_id) REFERENCES online_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438B7157780 FOREIGN KEY (visibility_id) REFERENCES visibility (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604386BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604385CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729B704F8D5 FOREIGN KEY (parent_type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE57295CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69B5CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69BA76ED395 FOREIGN KEY (user_id) REFERENCES online_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persona_characteristic ADD CONSTRAINT FK_9E48870CF5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persona_characteristic ADD CONSTRAINT FK_9E48870CDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe ADD CONSTRAINT FK_6135383561220EA6 FOREIGN KEY (creator_id) REFERENCES online_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE universe_online_user ADD CONSTRAINT FK_20E53C75CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe_online_user ADD CONSTRAINT FK_20E53C796F8006B FOREIGN KEY (online_user_id) REFERENCES online_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_support ADD CONSTRAINT FK_108CD1A9F624B39D FOREIGN KEY (sender_id) REFERENCES online_user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE message_support ADD CONSTRAINT FK_108CD1A95CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe_member ADD CONSTRAINT FK_71FEB55E7597D3FE FOREIGN KEY (member_id) REFERENCES online_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe_member ADD CONSTRAINT FK_71FEB55E5CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB6D6133FE FOREIGN KEY (parent_location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB5CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52EAA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe_application ADD CONSTRAINT FK_210758E95CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE universe_application ADD CONSTRAINT FK_210758E997139001 FOREIGN KEY (applicant_id) REFERENCES online_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characteristic ADD CONSTRAINT FK_522FA9505CD9AF2 FOREIGN KEY (universe_id) REFERENCES universe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characteristic ADD CONSTRAINT FK_522FA950C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE story_player ADD CONSTRAINT FK_D71AC897AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE story_player ADD CONSTRAINT FK_D71AC89799E6F5DF FOREIGN KEY (player_id) REFERENCES persona (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE story_application ADD CONSTRAINT FK_5473B57EAA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE story_application ADD CONSTRAINT FK_5473B57E97139001 FOREIGN KEY (applicant_id) REFERENCES persona (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52EAA5D4036');
        $this->addSql('ALTER TABLE story_player DROP FOREIGN KEY FK_D71AC897AA5D4036');
        $this->addSql('ALTER TABLE story_application DROP FOREIGN KEY FK_5473B57EAA5D4036');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729B704F8D5');
        $this->addSql('ALTER TABLE characteristic DROP FOREIGN KEY FK_522FA950C54C8C93');
        $this->addSql('ALTER TABLE persona_characteristic DROP FOREIGN KEY FK_9E48870CF5F88DB9');
        $this->addSql('ALTER TABLE story_player DROP FOREIGN KEY FK_D71AC89799E6F5DF');
        $this->addSql('ALTER TABLE story_application DROP FOREIGN KEY FK_5473B57E97139001');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604385CD9AF2');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE57295CD9AF2');
        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69B5CD9AF2');
        $this->addSql('ALTER TABLE universe_online_user DROP FOREIGN KEY FK_20E53C75CD9AF2');
        $this->addSql('ALTER TABLE message_support DROP FOREIGN KEY FK_108CD1A95CD9AF2');
        $this->addSql('ALTER TABLE universe_member DROP FOREIGN KEY FK_71FEB55E5CD9AF2');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB5CD9AF2');
        $this->addSql('ALTER TABLE universe_application DROP FOREIGN KEY FK_210758E95CD9AF2');
        $this->addSql('ALTER TABLE characteristic DROP FOREIGN KEY FK_522FA9505CD9AF2');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB6D6133FE');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E64D218E');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438B7157780');
        $this->addSql('ALTER TABLE persona_characteristic DROP FOREIGN KEY FK_9E48870CDEE9D12B');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438F675F31B');
        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69BA76ED395');
        $this->addSql('ALTER TABLE universe DROP FOREIGN KEY FK_6135383561220EA6');
        $this->addSql('ALTER TABLE universe_online_user DROP FOREIGN KEY FK_20E53C796F8006B');
        $this->addSql('ALTER TABLE message_support DROP FOREIGN KEY FK_108CD1A9F624B39D');
        $this->addSql('ALTER TABLE universe_member DROP FOREIGN KEY FK_71FEB55E7597D3FE');
        $this->addSql('ALTER TABLE universe_application DROP FOREIGN KEY FK_210758E997139001');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604386BF700BD');
        $this->addSql('DROP TABLE story');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE persona_characteristic');
        $this->addSql('DROP TABLE universe');
        $this->addSql('DROP TABLE universe_online_user');
        $this->addSql('DROP TABLE message_support');
        $this->addSql('DROP TABLE universe_member');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE universe_application');
        $this->addSql('DROP TABLE visibility');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('DROP TABLE online_user');
        $this->addSql('DROP TABLE story_player');
        $this->addSql('DROP TABLE story_application');
        $this->addSql('DROP TABLE status');
    }
}
