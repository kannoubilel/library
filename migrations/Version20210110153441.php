<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110153441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunte (user_id INT NOT NULL, livre_id INT NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL, INDEX IDX_F75B7D5CA76ED395 (user_id), INDEX IDX_F75B7D5C37D925CB (livre_id), PRIMARY KEY(user_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunte ADD CONSTRAINT FK_F75B7D5CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE emprunte ADD CONSTRAINT FK_F75B7D5C37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('DROP TABLE livre_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livre_user (livre_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_87F42DC437D925CB (livre_id), INDEX IDX_87F42DC4A76ED395 (user_id), PRIMARY KEY(livre_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE emprunte');
    }
}
