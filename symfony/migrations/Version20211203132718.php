<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211203132718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create and Initialize "astronauts" table';
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE astronauts_seq INCREMENT BY 1 MINVALUE 1 START 1');
        // phpcs:disable Generic.Files.LineLength.TooLong
        $this->addSql('CREATE TABLE astronaut (id INT NOT NULL, username VARCHAR(50) NOT NULL, planet VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, avatar VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DADB6E5F85E0677 ON astronaut (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DADB6E5E7927C74 ON astronaut (email)');
        $this->addSql('CREATE INDEX username_astronaut_idx ON astronaut (username)');
        $this->addSql('CREATE INDEX planet_astronaut_idx ON astronaut (planet)');
        $this->addSql('CREATE INDEX email_astronaut_idx ON astronaut (email)');
        $this->addSql('CREATE UNIQUE INDEX search_astronaut_idx ON astronaut (username, email)');
        $this->addSql('COMMENT ON COLUMN astronaut.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE astronauts_seq CASCADE');
        $this->addSql('DROP TABLE astronaut');
    }
}
