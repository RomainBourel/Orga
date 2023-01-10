<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110131029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE available ADD user_id INT NOT NULL, ADD proposition_date_id INT NOT NULL');
        $this->addSql('ALTER TABLE available ADD CONSTRAINT FK_A58FA485A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE available ADD CONSTRAINT FK_A58FA4851CC09F84 FOREIGN KEY (proposition_date_id) REFERENCES proposition_date (id)');
        $this->addSql('CREATE INDEX IDX_A58FA485A76ED395 ON available (user_id)');
        $this->addSql('CREATE INDEX IDX_A58FA4851CC09F84 ON available (proposition_date_id)');
        $this->addSql('ALTER TABLE proposition_date DROP is_final_date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition_date ADD is_final_date TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE available DROP FOREIGN KEY FK_A58FA485A76ED395');
        $this->addSql('ALTER TABLE available DROP FOREIGN KEY FK_A58FA4851CC09F84');
        $this->addSql('DROP INDEX IDX_A58FA485A76ED395 ON available');
        $this->addSql('DROP INDEX IDX_A58FA4851CC09F84 ON available');
        $this->addSql('ALTER TABLE available DROP user_id, DROP proposition_date_id');
    }
}
