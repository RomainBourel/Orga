<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113100220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE available (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, proposition_date_id INT NOT NULL, is_available TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A58FA485A76ED395 (user_id), INDEX IDX_A58FA4851CC09F84 (proposition_date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', principal TINYINT(1) NOT NULL, INDEX IDX_5E9E89CBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, invitation_token VARCHAR(255) DEFAULT NULL, INDEX IDX_89954EE061220EA6 (creator_id), INDEX IDX_89954EE064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party_user (party_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9230179A213C1059 (party_id), INDEX IDX_9230179AA76ED395 (user_id), PRIMARY KEY(party_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, unity_id INT NOT NULL, category_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', udated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_moderate TINYINT(1) DEFAULT NULL, is_published TINYINT(1) DEFAULT NULL, INDEX IDX_D34A04ADF6859C8C (unity_id), INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04ADA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_user (product_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7BF4E84584665A (product_id), INDEX IDX_7BF4E8A76ED395 (user_id), PRIMARY KEY(product_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_party (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, party_id INT NOT NULL, sharing TINYINT(1) NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_28C935BC4584665A (product_id), INDEX IDX_28C935BC213C1059 (party_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition_date (id INT AUTO_INCREMENT NOT NULL, party_id INT NOT NULL, final_date_id INT DEFAULT NULL, starting_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ending_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', number_max_participant INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F13CF708213C1059 (party_id), UNIQUE INDEX UNIQ_F13CF7083BB4BD27 (final_date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserved_product (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_party_id INT NOT NULL, quantity_reserved INT NOT NULL, quantity_buy INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, INDEX IDX_6A917B6AA76ED395 (user_id), INDEX IDX_6A917B6AEA8C7ACE (product_party_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', shortname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE available ADD CONSTRAINT FK_A58FA485A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE available ADD CONSTRAINT FK_A58FA4851CC09F84 FOREIGN KEY (proposition_date_id) REFERENCES proposition_date (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE061220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179A213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE party_user ADD CONSTRAINT FK_9230179AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF6859C8C FOREIGN KEY (unity_id) REFERENCES unity (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product_user ADD CONSTRAINT FK_7BF4E84584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_user ADD CONSTRAINT FK_7BF4E8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_party ADD CONSTRAINT FK_28C935BC4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_party ADD CONSTRAINT FK_28C935BC213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF708213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposition_date ADD CONSTRAINT FK_F13CF7083BB4BD27 FOREIGN KEY (final_date_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE reserved_product ADD CONSTRAINT FK_6A917B6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reserved_product ADD CONSTRAINT FK_6A917B6AEA8C7ACE FOREIGN KEY (product_party_id) REFERENCES product_party (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE available DROP FOREIGN KEY FK_A58FA485A76ED395');
        $this->addSql('ALTER TABLE available DROP FOREIGN KEY FK_A58FA4851CC09F84');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA76ED395');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE061220EA6');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE064D218E');
        $this->addSql('ALTER TABLE party_user DROP FOREIGN KEY FK_9230179A213C1059');
        $this->addSql('ALTER TABLE party_user DROP FOREIGN KEY FK_9230179AA76ED395');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF6859C8C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA76ED395');
        $this->addSql('ALTER TABLE product_user DROP FOREIGN KEY FK_7BF4E84584665A');
        $this->addSql('ALTER TABLE product_user DROP FOREIGN KEY FK_7BF4E8A76ED395');
        $this->addSql('ALTER TABLE product_party DROP FOREIGN KEY FK_28C935BC4584665A');
        $this->addSql('ALTER TABLE product_party DROP FOREIGN KEY FK_28C935BC213C1059');
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF708213C1059');
        $this->addSql('ALTER TABLE proposition_date DROP FOREIGN KEY FK_F13CF7083BB4BD27');
        $this->addSql('ALTER TABLE reserved_product DROP FOREIGN KEY FK_6A917B6AA76ED395');
        $this->addSql('ALTER TABLE reserved_product DROP FOREIGN KEY FK_6A917B6AEA8C7ACE');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE available');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_user');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_user');
        $this->addSql('DROP TABLE product_party');
        $this->addSql('DROP TABLE proposition_date');
        $this->addSql('DROP TABLE reserved_product');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE unity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
