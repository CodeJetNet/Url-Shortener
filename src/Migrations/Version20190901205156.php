<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190901205156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Because we need a table. (╯°□°）╯︵ ┻━┻';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE short_url (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, code VARCHAR(5) NOT NULL, UNIQUE INDEX UNIQ_83360531F47645AE (url), UNIQUE INDEX UNIQ_8336053177153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE short_url');
    }
}
