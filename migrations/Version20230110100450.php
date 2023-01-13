<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110100450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party ADD final_date_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE03BB4BD27 FOREIGN KEY (final_date_id) REFERENCES proposition_date (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89954EE03BB4BD27 ON party (final_date_id)');
        $this->addSql('ALTER TABLE proposition_date DROP party_final_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date ADD party_final_id INT NOT NULL');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE03BB4BD27');
        $this->addSql('DROP INDEX UNIQ_89954EE03BB4BD27 ON party');
        $this->addSql('ALTER TABLE party DROP final_date_id');
    }
}