<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308101653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adherent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE banque_association_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE don_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evenement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parrainage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE photo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projet_humanitaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vente_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adherent (id INT NOT NULL, parrainage_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, don_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90D3F06070F2D188 ON adherent (parrainage_id)');
        $this->addSql('CREATE INDEX IDX_90D3F060FD02F13 ON adherent (evenement_id)');
        $this->addSql('CREATE INDEX IDX_90D3F060FB88E14F ON adherent (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_90D3F0607B3C9061 ON adherent (don_id)');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, utilisateur_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_880E0D76FB88E14F ON admin (utilisateur_id)');
        $this->addSql('CREATE TABLE banque_association (id INT NOT NULL, don_id INT DEFAULT NULL, total_dons DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_72DE6B837B3C9061 ON banque_association (don_id)');
        $this->addSql('CREATE TABLE don (id INT NOT NULL, montant DOUBLE PRECISION DEFAULT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE evenement (id INT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parrainage (id INT NOT NULL, photo_id INT DEFAULT NULL, nom_enfant VARCHAR(255) DEFAULT NULL, prenom_enfant VARCHAR(255) DEFAULT NULL, date_naiss_enfant DATE DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, date_parrainage DATE DEFAULT NULL, ecole VARCHAR(255) DEFAULT NULL, village VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_195BAFB57E9E4C8C ON parrainage (photo_id)');
        $this->addSql('CREATE TABLE photo (id INT NOT NULL, url VARCHAR(2000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produit (id INT NOT NULL, photo_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, quantite INT DEFAULT NULL, disponibilite BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29A5EC277E9E4C8C ON produit (photo_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27FD02F13 ON produit (evenement_id)');
        $this->addSql('CREATE TABLE projet_humanitaire (id INT NOT NULL, photo_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(5000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E7CADBEA7E9E4C8C ON projet_humanitaire (photo_id)');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vente (id INT NOT NULL, produit_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_888A2A4CF347EFB ON vente (produit_id)');
        $this->addSql('CREATE INDEX IDX_888A2A4CFD02F13 ON vente (evenement_id)');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F06070F2D188 FOREIGN KEY (parrainage_id) REFERENCES parrainage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F060FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F060FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F0607B3C9061 FOREIGN KEY (don_id) REFERENCES don (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE banque_association ADD CONSTRAINT FK_72DE6B837B3C9061 FOREIGN KEY (don_id) REFERENCES don (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parrainage ADD CONSTRAINT FK_195BAFB57E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE projet_humanitaire ADD CONSTRAINT FK_E7CADBEA7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adherent DROP CONSTRAINT FK_90D3F0607B3C9061');
        $this->addSql('ALTER TABLE banque_association DROP CONSTRAINT FK_72DE6B837B3C9061');
        $this->addSql('ALTER TABLE adherent DROP CONSTRAINT FK_90D3F060FD02F13');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC27FD02F13');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4CFD02F13');
        $this->addSql('ALTER TABLE adherent DROP CONSTRAINT FK_90D3F06070F2D188');
        $this->addSql('ALTER TABLE parrainage DROP CONSTRAINT FK_195BAFB57E9E4C8C');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC277E9E4C8C');
        $this->addSql('ALTER TABLE projet_humanitaire DROP CONSTRAINT FK_E7CADBEA7E9E4C8C');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4CF347EFB');
        $this->addSql('ALTER TABLE adherent DROP CONSTRAINT FK_90D3F060FB88E14F');
        $this->addSql('ALTER TABLE admin DROP CONSTRAINT FK_880E0D76FB88E14F');
        $this->addSql('DROP SEQUENCE adherent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE banque_association_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE don_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evenement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parrainage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE photo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projet_humanitaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vente_id_seq CASCADE');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE banque_association');
        $this->addSql('DROP TABLE don');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE parrainage');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE projet_humanitaire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vente');
    }
}
