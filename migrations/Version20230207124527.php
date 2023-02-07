<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207124527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF7083BB4BD27');
        $this->addSql('DROP INDEX UNIQ_F13CF7083BB4BD27 ON proposition_date');
        $this->addSql('ALTER TABLE proposition_date ADD final_date TINYINT(1) DEFAULT NULL, DROP final_date_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date ADD final_date_id INT DEFAULT NULL, DROP final_date');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF7083BB4BD27 FOREIGN KEY (final_date_id) REFERENCES party (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F13CF7083BB4BD27 ON proposition_date (final_date_id)');
    }
}
