<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218062717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signalement_assoc_ouverture DROP FOREIGN KEY FK_CD0893A9388AF08B');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A393D2FBF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('DROP TABLE signalement_assoc');
        $this->addSql('DROP TABLE signalement_assoc_ouverture');
        $this->addSql('ALTER TABLE user CHANGE age age INT UNSIGNED DEFAULT NULL, CHANGE region region INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD state_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C35D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C35D83CC1 ON ville (state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FBF92F3E70');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C35D83CC1');
        $this->addSql('CREATE TABLE signalement_assoc (id INT AUTO_INCREMENT NOT NULL, association_target_id INT UNSIGNED NOT NULL, ville_id INT UNSIGNED NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, telephone INT DEFAULT NULL, INDEX IDX_F4FE18DFA73F0036 (ville_id), INDEX IDX_F4FE18DFB1690213 (association_target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE signalement_assoc_ouverture (signalement_assoc_id INT NOT NULL, ouverture_id INT UNSIGNED NOT NULL, INDEX IDX_CD0893A9388AF08B (signalement_assoc_id), INDEX IDX_CD0893A9F892AC88 (ouverture_id), PRIMARY KEY(signalement_assoc_id, ouverture_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE signalement_assoc ADD CONSTRAINT FK_F4FE18DFA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE signalement_assoc ADD CONSTRAINT FK_F4FE18DFB1690213 FOREIGN KEY (association_target_id) REFERENCES assoc (id)');
        $this->addSql('ALTER TABLE signalement_assoc_ouverture ADD CONSTRAINT FK_CD0893A9388AF08B FOREIGN KEY (signalement_assoc_id) REFERENCES signalement_assoc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE signalement_assoc_ouverture ADD CONSTRAINT FK_CD0893A9F892AC88 FOREIGN KEY (ouverture_id) REFERENCES ouverture (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE state');
        $this->addSql('ALTER TABLE user CHANGE age age INT UNSIGNED DEFAULT NULL, CHANGE region region INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_43C3D9C35D83CC1 ON ville');
        $this->addSql('ALTER TABLE ville DROP state_id');
    }
}
