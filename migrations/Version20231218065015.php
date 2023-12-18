<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218065015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_state (user_id INT NOT NULL, state_id INT NOT NULL, INDEX IDX_415129A3A76ED395 (user_id), INDEX IDX_415129A35D83CC1 (state_id), PRIMARY KEY(user_id, state_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_country (user_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_B7ED76CA76ED395 (user_id), INDEX IDX_B7ED76CF92F3E70 (country_id), PRIMARY KEY(user_id, country_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_state ADD CONSTRAINT FK_415129A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_state ADD CONSTRAINT FK_415129A35D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_country ADD CONSTRAINT FK_B7ED76CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_country ADD CONSTRAINT FK_B7ED76CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE age age INT UNSIGNED DEFAULT NULL, CHANGE region region INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_state');
        $this->addSql('DROP TABLE user_country');
        $this->addSql('ALTER TABLE user CHANGE age age INT UNSIGNED DEFAULT NULL, CHANGE region region INT DEFAULT NULL');
    }
}
