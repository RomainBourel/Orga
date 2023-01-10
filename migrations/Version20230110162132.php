<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110162132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserved_product (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_party_id INT NOT NULL, quantity_reserved INT NOT NULL, quantity_buy INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6A917B6AA76ED395 (user_id), INDEX IDX_6A917B6AEA8C7ACE (product_party_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserved_product ADD CONSTRAINT FK_6A917B6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reserved_product ADD CONSTRAINT FK_6A917B6AEA8C7ACE FOREIGN KEY (product_party_id) REFERENCES product_party (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserved_product DROP FOREIGN KEY FK_6A917B6AA76ED395');
        $this->addSql('ALTER TABLE reserved_product DROP FOREIGN KEY FK_6A917B6AEA8C7ACE');
        $this->addSql('DROP TABLE reserved_product');
    }
}
