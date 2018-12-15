<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213182346 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trick_comment (id INT AUTO_INCREMENT NOT NULL, user_create_id INT NOT NULL, trick_id INT NOT NULL, text LONGTEXT NOT NULL, date_create DATETIME NOT NULL, INDEX IDX_F7292B34EEFE5067 (user_create_id), INDEX IDX_F7292B34B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34EEFE5067 FOREIGN KEY (user_create_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34B281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trick_comment');
    }
}
