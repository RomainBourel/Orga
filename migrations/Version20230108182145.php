<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108182145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF708213C1059');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF708213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF708213C1059');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF708213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
    }
}
