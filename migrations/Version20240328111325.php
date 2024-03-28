<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328111325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fazenda (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(50) NOT NULL, tamanho DOUBLE PRECISION NOT NULL, responsavel VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fazenda_veterinario (fazenda_id INT NOT NULL, veterinario_id INT NOT NULL, INDEX IDX_4D394109D4A3545F (fazenda_id), INDEX IDX_4D3941091454BD8B (veterinario_id), PRIMARY KEY(fazenda_id, veterinario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gado (id INT AUTO_INCREMENT NOT NULL, fazenda_id INT NOT NULL, codigo VARCHAR(50) NOT NULL, leite DOUBLE PRECISION NOT NULL, racao DOUBLE PRECISION NOT NULL, peso DOUBLE PRECISION NOT NULL, nascimento DATE NOT NULL, INDEX IDX_123C63DBD4A3545F (fazenda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(50) NOT NULL, crmv VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fazenda_veterinario ADD CONSTRAINT FK_4D394109D4A3545F FOREIGN KEY (fazenda_id) REFERENCES fazenda (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fazenda_veterinario ADD CONSTRAINT FK_4D3941091454BD8B FOREIGN KEY (veterinario_id) REFERENCES veterinario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gado ADD CONSTRAINT FK_123C63DBD4A3545F FOREIGN KEY (fazenda_id) REFERENCES fazenda (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fazenda_veterinario DROP FOREIGN KEY FK_4D394109D4A3545F');
        $this->addSql('ALTER TABLE fazenda_veterinario DROP FOREIGN KEY FK_4D3941091454BD8B');
        $this->addSql('ALTER TABLE gado DROP FOREIGN KEY FK_123C63DBD4A3545F');
        $this->addSql('DROP TABLE fazenda');
        $this->addSql('DROP TABLE fazenda_veterinario');
        $this->addSql('DROP TABLE gado');
        $this->addSql('DROP TABLE veterinario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
