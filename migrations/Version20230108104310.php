<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108104310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE available (id INT AUTO_INCREMENT NOT NULL, is_available TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition_date (id INT AUTO_INCREMENT NOT NULL, party_id INT NOT NULL, starting_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ending_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', number_max_participant INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_final_date TINYINT(1) DEFAULT NULL, INDEX IDX_F13CF708213C1059 (party_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF708213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE party ADD final_date_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE03BB4BD27 FOREIGN KEY (final_date_id) REFERENCES proposition_date (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89954EE03BB4BD27 ON party (final_date_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE03BB4BD27');
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF708213C1059');
        $this->addSql('DROP TABLE available');
        $this->addSql('DROP TABLE proposition_date');
        $this->addSql('DROP INDEX UNIQ_89954EE03BB4BD27 ON party');
        $this->addSql('ALTER TABLE party DROP final_date_id');
    }
}
