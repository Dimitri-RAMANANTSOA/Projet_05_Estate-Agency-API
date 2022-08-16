<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816080559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE options (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_options (property_id INT NOT NULL, options_id INT NOT NULL, INDEX IDX_89F8B0FF549213EC (property_id), INDEX IDX_89F8B0FF3ADB05F1 (options_id), PRIMARY KEY(property_id, options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_options ADD CONSTRAINT FK_89F8B0FF549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_options ADD CONSTRAINT FK_89F8B0FF3ADB05F1 FOREIGN KEY (options_id) REFERENCES options (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_options DROP FOREIGN KEY FK_89F8B0FF549213EC');
        $this->addSql('ALTER TABLE property_options DROP FOREIGN KEY FK_89F8B0FF3ADB05F1');
        $this->addSql('DROP TABLE options');
        $this->addSql('DROP TABLE property_options');
    }
}
