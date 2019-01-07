<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190107103510 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_tokens (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, value LONGTEXT NOT NULL, type VARCHAR(50) NOT NULL, date_token DATETIME NOT NULL, UNIQUE INDEX UNIQ_CF080AB3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_tokens ADD CONSTRAINT FK_CF080AB3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users DROP token_new_pwd, DROP date_token_new_pwd');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_tokens');
        $this->addSql('ALTER TABLE users ADD token_new_pwd VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD date_token_new_pwd DATETIME DEFAULT NULL');
    }
}
