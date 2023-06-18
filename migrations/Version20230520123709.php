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
        $this->addSql('CREATE TABLE instance (uuid UUID NOT NULL, created_by_uuid UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4230B1DE5E237E06 ON instance (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4230B1DEB03A8386 ON instance (created_by_uuid)');
        $this->addSql('COMMENT ON COLUMN instance.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN instance.created_by_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE instance ADD CONSTRAINT FK_4230B1DEB03A8386 FOREIGN KEY (created_by_uuid) REFERENCES "user" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE instance DROP CONSTRAINT FK_4230B1DEB03A8386');
        $this->addSql('DROP TABLE instance');
    }
}
