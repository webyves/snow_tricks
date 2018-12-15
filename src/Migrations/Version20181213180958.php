<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213180958 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks ADD user_update_id INT NOT NULL, DROP user_update, CHANGE user_create user_create_id INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1EEFE5067 FOREIGN KEY (user_create_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1D5766755 FOREIGN KEY (user_update_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C1EEFE5067 ON tricks (user_create_id)');
        $this->addSql('CREATE INDEX IDX_E1D902C1D5766755 ON tricks (user_update_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1EEFE5067');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1D5766755');
        $this->addSql('DROP INDEX IDX_E1D902C1EEFE5067 ON tricks');
        $this->addSql('DROP INDEX IDX_E1D902C1D5766755 ON tricks');
        $this->addSql('ALTER TABLE tricks ADD user_create INT NOT NULL, ADD user_update INT DEFAULT NULL, DROP user_create_id, DROP user_update_id');
    }
}
