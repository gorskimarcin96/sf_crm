<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520123709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added "instance" table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE instance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE instance (id INT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4230B1DEA76ED395 ON instance (created_by_id)');
        $this->addSql('ALTER TABLE instance ADD CONSTRAINT FK_4230B1DEA76ED395 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4230B1DE5E237E06 ON instance (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE instance_id_seq CASCADE');
        $this->addSql('DROP INDEX UNIQ_4230B1DE5E237E06');
        $this->addSql('ALTER TABLE instance DROP CONSTRAINT FK_4230B1DEA76ED395');
        $this->addSql('DROP TABLE instance');
    }
}
