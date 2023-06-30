<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630121056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added "instance_list" table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE instance_list (uuid UUID NOT NULL, instance_uuid UUID NOT NULL, created_by_uuid UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_6CC2A8D3F975006D ON instance_list (instance_uuid)');
        $this->addSql('CREATE INDEX IDX_6CC2A8D3A17A1B5D ON instance_list (created_by_uuid)');
        $this->addSql('COMMENT ON COLUMN instance_list.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN instance_list.instance_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN instance_list.created_by_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE instance_list ADD CONSTRAINT FK_6CC2A8D3F975006D FOREIGN KEY (instance_uuid) REFERENCES instance (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instance_list ADD CONSTRAINT FK_6CC2A8D3A17A1B5D FOREIGN KEY (created_by_uuid) REFERENCES "user" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER INDEX uniq_4230b1deb03a8386 RENAME TO UNIQ_4230B1DEA17A1B5D');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE instance_list DROP CONSTRAINT FK_6CC2A8D3F975006D');
        $this->addSql('ALTER TABLE instance_list DROP CONSTRAINT FK_6CC2A8D3A17A1B5D');
        $this->addSql('DROP TABLE instance_list');
        $this->addSql('ALTER INDEX uniq_4230b1dea17a1b5d RENAME TO uniq_4230b1deb03a8386');
    }
}
