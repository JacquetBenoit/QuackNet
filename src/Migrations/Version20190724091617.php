<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724091617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quack ADD author_id INT NOT NULL, DROP author');
        $this->addSql('ALTER TABLE quack ADD CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quack DROP FOREIGN KEY FK_83D44F6FF675F31B');
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B ON quack');
        $this->addSql('ALTER TABLE quack ADD author VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP author_id');
    }
}
